<?php
session_start();
if(empty($_SESSION["admin_username"])) {
    header("Location: index.php");
    exit();
}

include("admin_header.php");
include_once("../conn.php");

$con = new connec();
$message = "";

if(!isset($_GET['id'])) {
    header("Location: viewmovie.php");
    exit();
}

$id = intval($_GET['id']);

// Fetch movie data
$result = $con->conn->query("SELECT * FROM movie WHERE id=$id");
if($result->num_rows == 0) {
    echo "<div class='alert alert-danger'>Movie not found.</div>";
    include("admin_footer.php");
    exit();
}
$row = $result->fetch_assoc();

// Fetch related dropdown data for Industry, Genre, Language
$industries = $con->select_all("industry");
$genres = $con->select_all("genre");
$languages = $con->select_all("language");

// Handle form submission
if(isset($_POST['btn_update'])) {
    $name = trim($_POST['name']);
    $rel_date = $_POST['rel_date'];
    $industry_id = intval($_POST['industry_id']);
    $genre_id = intval($_POST['genre_id']);
    $lang_id = intval($_POST['lang_id']);
    $duration = trim($_POST['duration']);
    
    // File upload handling for banner
    $banner_path = $row['movie_banner']; // default old banner
    
    if(isset($_FILES['movie_banner']) && $_FILES['movie_banner']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if(in_array($_FILES['movie_banner']['type'], $allowed_types)) {
            $upload_dir = "../uploads/movie_banners/";
            if(!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $filename = uniqid() . "_" . basename($_FILES['movie_banner']['name']);
            $target_file = $upload_dir . $filename;
            
            if(move_uploaded_file($_FILES['movie_banner']['tmp_name'], $target_file)) {
                $banner_path = "uploads/movie_banners/" . $filename; // relative path for DB
                
                // Optionally delete old image file if exists and is different
                if($row['movie_banner'] != "" && file_exists("../" . $row['movie_banner'])) {
                    unlink("../" . $row['movie_banner']);
                }
            } else {
                $message = "Error uploading banner image.";
            }
        } else {
            $message = "Invalid image type. Only JPG, PNG, GIF allowed.";
        }
    }

    // If no upload errors, update DB
    if(empty($message)) {
        $sql = "UPDATE movie SET 
                name=?, 
                movie_banner=?, 
                rel_date=?, 
                industry_id=?, 
                genre_id=?, 
                lang_id=?, 
                duration=?
                WHERE id=?";
        $stmt = $con->conn->prepare($sql);
        $stmt->bind_param("sssiiisi", $name, $banner_path, $rel_date, $industry_id, $genre_id, $lang_id, $duration, $id);
        if($stmt->execute()) {
            header("Location: viewmovie.php?updated=1");
            exit();
        } else {
            $message = "Database update error: " . $stmt->error;
        }
    }
}
?>

<style>
    .form-label { font-weight: 600; }
    .banner-preview {
        max-width: 250px;
        max-height: 150px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        padding: 5px;
    }
</style>

<div class="container mt-5">
    <h3 class="text-maroon mb-4">Edit Movie</h3>

    <?php if(!empty($message)): ?>
        <div class="alert alert-warning"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Movie Name</label>
            <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($row['name']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Current Banner</label><br>
            <?php if(!empty($row['movie_banner'])): ?>
                <img src="../<?= htmlspecialchars($row['movie_banner']) ?>" alt="Banner" class="banner-preview">
            <?php else: ?>
                <p>No banner uploaded.</p>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">Change Banner (optional)</label>
            <input type="file" name="movie_banner" accept="image/*" class="form-control">
            <small class="form-text text-muted">Allowed types: JPG, PNG, GIF</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Release Date</label>
            <input type="date" name="rel_date" class="form-control" required value="<?= $row['rel_date'] ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Industry</label>
            <select name="industry_id" class="form-control" required>
                <option value="">-- Select Industry --</option>
                <?php while($industry = $industries->fetch_assoc()): ?>
                    <option value="<?= $industry['id'] ?>" <?= ($industry['id'] == $row['industry_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($industry['industry_name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Genre</label>
            <select name="genre_id" class="form-control" required>
                <option value="">-- Select Genre --</option>
                <?php while($genre = $genres->fetch_assoc()): ?>
                    <option value="<?= $genre['id'] ?>" <?= ($genre['id'] == $row['genre_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($genre['genre_name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Language</label>
            <select name="lang_id" class="form-control" required>
                <option value="">-- Select Language --</option>
                <?php while($lang = $languages->fetch_assoc()): ?>
                    <option value="<?= $lang['id'] ?>" <?= ($lang['id'] == $row['lang_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($lang['lang_name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Duration</label>
            <input type="text" name="duration" class="form-control" placeholder="e.g. 120 min" required value="<?= htmlspecialchars($row['duration']) ?>">
        </div>

        <button type="submit" name="btn_update" class="btn btn-primary">Update Movie</button>
        <a href="viewmovie.php" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>

<?php include("admin_footer.php"); ?>
