<?php
session_start();

if (empty($_SESSION["admin_username"])) {
    header("Location: index.php");
    exit();
}

include_once("../conn.php");
$con = new connec();

if (!isset($_GET['id'])) {
    header("Location: viewuser.php");
    exit();
}

$id = (int)$_GET['id'];

// Delete user record
$sql = "DELETE FROM user WHERE id = $id";
if ($con->conn->query($sql)) {
    header("Location: viewuser.php");
    exit();
} else {
    echo "Failed to delete user: " . $con->conn->error;
}
