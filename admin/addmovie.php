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

$industries = $con->select_all("industry");
$genres = $con->select_all("genre");
$languages = $con->select_all("language");

if(isset($_POST['btn_add'])) {
    $name = trim($_POST['name']);
    $rel_date = $_POST['rel_date'];
    $industry_id = intval($_POST['industry_id']);
    $genre_id = intval($_POST['genre_id']);
    $lang_id = intval($_POST['lang_id']);
    $duration = trim($_POST['duration']);

    // Validate required fields
    if(empty($name) || empty($rel_date) || empty($industry_id) || empty($genre_id) || empty($lang_id) || empty($duration)) {
        $message = "Please fill in all fields.";
    } else {
        // Handle file upload
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
                    $banner_path = "uploads/movie_banners/" . $filename;

                    // Insert into database
                    $sql = "INSERT INTO movie (name, movie_banner, rel_date, industry_id, genre_id, lang_id, duration)
                            VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $con->conn->prepare($sql);
                    $stmt->bind_param("sssiiis", $name, $banner_path, $rel_date, $industry_id, $genre_id, $lang_id, $duration);

                    if($stmt->execute()) {
                        $message = "Movie added successfully.";
                    } else {
                        $message = "Database error: " . $stmt->error;
                        // Delete uploaded file if DB insert failed
                        unlink($target_file);
                    }
                } else {
                    $message = "Failed to upload banner image.";
                }
            } else {
                $message = "Invalid banner image type. Allowed types: JPG, PNG, GIF.";
            }
        } else {
            $message = "Please upload a banner image.";
        }
    }
}
?>

<style>
    .form-label { font-weight: 600; }
    .container { max-width: 700px; }
</style>

<div class="container mt-5">
    <h3 class="text-maroon mb-4">Add New Movie</h3>

    <?php if(!empty($message)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" novalidate>
        <div class="mb-3">
            <label class="form-label" for="name">Movie Name</label>
            <input type="text" id="name" name="name" class="form-control" required value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">
        </div>

        <div class="mb-3">
            <label class="form-label" for="movie_banner">Movie Banner (JPG, PNG, GIF)</label>
            <input type="file" id="movie_banner" name="movie_banner" class="form-control" accept="image/*" required>
        </div>

        <div class="mb-3">
            <label class="form-label" for="rel_date">Release Date</label>
            <input type="date" id="rel_date" name="rel_date" class="form-control" required value="<?= isset($_POST['rel_date']) ? htmlspecialchars($_POST['rel_date']) : '' ?>">
        </div>

        <div class="mb-3">
            <label class="form-label" for="industry_id">Industry</label>
            <select id="industry_id" name="industry_id" class="form-select" required>
                <option value="">-- Select Industry --</option>
                <?php while($industry = $industries->fetch_assoc()): ?>
                    <option value="<?= $industry['id'] ?>" <?= (isset($_POST['industry_id']) && $_POST['industry_id'] == $industry['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($industry['industry_name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label" for="genre_id">Genre</label>
            <select id="genre_id" name="genre_id" class="form-select" required>
                <option value="">-- Select Genre --</option>
                <?php while($genre = $genres->fetch_assoc()): ?>
                    <option value="<?= $genre['id'] ?>" <?= (isset($_POST['genre_id']) && $_POST['genre_id'] == $genre['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($genre['genre_name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label" for="lang_id">Language</label>
            <select id="lang_id" name="lang_id" class="form-select" required>
                <option value="">-- Select Language --</option>
                <?php while($lang = $languages->fetch_assoc()): ?>
                    <option value="<?= $lang['id'] ?>" <?= (isset($_POST['lang_id']) && $_POST['lang_id'] == $lang['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($lang['lang_name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label" for="duration">Duration (e.g., 120 min)</label>
            <input type="text" id="duration" name="duration" class="form-control" required value="<?= isset($_POST['duration']) ? htmlspecialchars($_POST['duration']) : '' ?>">
        </div>

        <button type="submit" name="btn_add" class="btn btn-success">Add Movie</button>
        <a href="viewmovie.php" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>

<?php include("admin_footer.php"); ?>
