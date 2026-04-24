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

// Check if id is valid
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
} else {
    echo "<div class='alert alert-danger'>Invalid ID.</div>";
    include("admin_footer.php");
    exit();
}

// Fetch the language
$sql = "SELECT * FROM language WHERE id = $id";
$result = $con->conn->query($sql);
if(!$result || $result->num_rows == 0) {
    echo "<div class='alert alert-danger'>Language not found.</div>";
    include("admin_footer.php");
    exit();
}
$row = $result->fetch_assoc();

if(isset($_POST['btn_update'])) {
    $lang_name = trim($_POST['lang_name']);
    if(empty($lang_name)) {
        $message = "Language name cannot be empty.";
    } else {
        $stmt = $con->conn->prepare("UPDATE language SET lang_name=? WHERE id=?");
        $stmt->bind_param("si", $lang_name, $id);
        if($stmt->execute()) {
            header("Location: viewlanguage.php?updated=1");
            exit();
        } else {
            $message = "Error updating language: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<div class="container mt-5">
    <h3 style="color: maroon;">Edit Language</h3>
    <?php if($message): ?>
        <div class="alert alert-warning"><?= $message ?></div>
    <?php endif; ?>
    <form method="post">
        <div class="form-group mb-3">
            <label>Language Name</label>
            <input type="text" name="lang_name" class="form-control" required value="<?= htmlspecialchars($row['lang_name']); ?>">
        </div>
        <button type="submit" name="btn_update" class="btn btn-primary">Update</button>
        <a href="viewlanguage.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include("admin_footer.php"); ?>
