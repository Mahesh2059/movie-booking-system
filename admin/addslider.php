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

if (isset($_POST['btn_insert'])) {
    $alt = $con->conn->real_escape_string($_POST['alt_text']);

    // Handle file upload
    if (isset($_FILES['slider_img']) && $_FILES['slider_img']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $fileName = $_FILES['slider_img']['name'];
        $fileTmp = $_FILES['slider_img']['tmp_name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (in_array($fileExt, $allowed)) {
            $newFileName = 'uploads/sliders/' . uniqid() . '.' . $fileExt;

            // Make sure upload directory exists
            if (!is_dir('uploads/sliders')) {
                mkdir('uploads/sliders', 0777, true);
            }

            if (move_uploaded_file($fileTmp, $newFileName)) {
                // Insert into DB
                $sql = "INSERT INTO slider (img_path, alt) VALUES ('$newFileName', '$alt')";
                if ($con->conn->query($sql)) {
                    $message = "Slider added successfully.";
                } else {
                    $message = "Database insert failed: " . $con->conn->error;
                }
            } else {
                $message = "Failed to move uploaded file.";
            }
        } else {
            $message = "Invalid file type. Allowed types: jpg, jpeg, png, gif.";
        }
    } else {
        $message = "Please select an image to upload.";
    }
}
?>

<section class="container mt-4" style="max-width: 600px;">
    <h3 style="color: maroon;">Add New Slider</h3>

    <?php if ($message): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="form-group mb-3">
            <label for="slider_img">Slider Image</label>
            <input type="file" id="slider_img" name="slider_img" accept="image/*" required class="form-control">
        </div>
        <div class="form-group mb-3">
            <label for="alt_text">Alt Text</label>
            <input type="text" id="alt_text" name="alt_text" class="form-control" required placeholder="Enter image alt text">
        </div>
        <button type="submit" name="btn_insert" class="btn btn-success">Add Slider</button>
        <a href="viewslider.php" class="btn btn-secondary">Back to Slider List</a>
    </form>
</section>

<?php include("admin_footer.php"); ?>
