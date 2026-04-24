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

if(isset($_POST['btn_save'])) {
    $lang_name = trim($_POST['lang_name']);
    if(!empty($lang_name)) {
        // Insert new language with prepared statement
        $stmt = $con->conn->prepare("INSERT INTO language (lang_name) VALUES (?)");
        $stmt->bind_param("s", $lang_name);
        if($stmt->execute()) {
            header("Location: viewlanguage.php?added=1");
            exit();
        } else {
            $message = "Error adding language: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Language name cannot be empty.";
    }
}
?>

<div class="container mt-5">
    <h3 style="color: maroon;">Add Language</h3>
    <?php if($message): ?>
        <div class="alert alert-warning"><?= $message ?></div>
    <?php endif; ?>
    <form method="post">
        <div class="form-group mb-3">
            <label>Language Name</label>
            <input type="text" name="lang_name" class="form-control" required>
        </div>
        <button type="submit" name="btn_save" class="btn btn-success">Save</button>
        <a href="viewlanguage.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include("admin_footer.php"); ?>
