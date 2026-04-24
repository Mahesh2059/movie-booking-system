<?php
session_start();
if (empty($_SESSION["admin_username"])) {
    header("Location: index.php");
    exit();
}

include_once("conn.php");
$con = new connec();

if (!isset($_GET['id'])) {
    header("Location: viewslider.php");
    exit();
}

$id = (int)$_GET['id'];

// Get slider to delete image file
$result = $con->conn->query("SELECT img_path FROM slider WHERE id=$id");
if ($result && $result->num_rows > 0) {
    $slider = $result->fetch_assoc();
    if (file_exists('../'.$slider['img_path'])) {
        unlink('../'.$slider['img_path']);
    }
}

// Delete from database
$sql = "DELETE FROM slider WHERE id=$id";
if ($con->conn->query($sql)) {
    header("Location: viewslider.php");
    exit();
} else {
    echo "Error deleting slider: " . $con->conn->error;
}
