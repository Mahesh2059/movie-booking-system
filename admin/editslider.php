<?php
session_start();
if (empty($_SESSION["admin_username"])) {
    header("Location: index.php");
    exit();
}

include("admin_header.php");
include_once("../conn.php");
$con = new connec();

if (!isset($_GET['id'])) {
    header("Location: viewslider.php");
    exit();
}

$id = (int)$_GET['id'];

// Fetch existing slider
$result = $con->conn->query("SELECT * FROM slider WHERE id=$id");
if (!$result || $result->num_rows === 0) {
    die("Slider not found");
}

$slider = $result->fetch_assoc();
$error = "";

if (isset($_POST['btn_update'])) {
    $alt = $con->conn->real_escape_string($_POST['alt_text']);
    $img_path = $slider['img_path'];

    if (isset($_FILES['slider_image']) && $_FILES['slider_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['slider_image']['tmp_name'];
        $fileName = $_FILES['slider_image']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif'];

        if (in_array($fileExtension, $allowed)) {
            $newFileName = md5(time().$fileName).'.'.$fileExtension;
            $uploadDir = '../uploads/sliders/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $destPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                // Delete old image
                if (file_exists('../'.$slider['img_path'])) {
                    unlink('../'.$slider['img_path']);
                }
                $img_path = 'uploads/sliders/'.$newFileName;
            } else {
                $error = "Error uploading file.";
            }
        } else {
            $error = "Invalid file type.";
        }
    }

    if (!$error) {
        $sql = "UPDATE slider SET alt='$alt', img_path='$img_path' WHERE id=$id";
        if ($con->conn->query($sql)) {
            header("Location: viewslider.php");
            exit();
        } else {
            $error = "Database error: " . $con->conn->error;
        }
    }
}
?>

<section class="container mt-4" style="max-width: 600px;">
    <h3 style="color: maroon;">Edit Slider</h3>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data">
        <p>Current Image:</p>
        <img src="../<?= htmlspecialchars($slider['img_path']) ?>" style="height:150px;" alt="<?= htmlspecialchars($slider['alt']) ?>">
        <div class="form-group mt-3">
            <label for="slider_image">Change Image (optional):</label>
            <input type="file" name="slider_image" id="slider_image" class="form-control">
        </div>
        <div class="form-group mt-3">
            <label for="alt_text">Alt Text:</label>
            <input type="text" name="alt_text" id="alt_text" class="form-control" required value="<?= htmlspecialchars($slider['alt']) ?>">
        </div>
        <button type="submit" name="btn_update" class="btn btn-success mt-3">Update Slider</button>
        <a href="viewslider.php" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</section>

<?php include("admin_footer.php"); ?>
