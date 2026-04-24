<?php
session_start();

if (empty($_SESSION["admin_username"])) {
    header("Location: index.php");
    exit();
}

include_once("../conn.php");
$con = new connec();

if (!isset($_GET['id'])) {
    header("Location: view_contacts.php");
    exit();
}

$id = (int)$_GET['id'];

$sql = "DELETE FROM contact WHERE id = $id";

if ($con->conn->query($sql)) {
    header("Location: view_contacts.php");
    exit();
} else {
    echo "Delete failed: " . $con->conn->error;
}
?>
