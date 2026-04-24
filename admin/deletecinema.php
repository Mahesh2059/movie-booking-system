<?php
session_start();
include_once("../conn.php");
$con = new connec();

if (!isset($_GET['id'])) {
    header("Location: viewcinema.php");
    exit();
}

$id = (int)$_GET['id'];

// Delete cinema
$sql = "DELETE FROM cinema WHERE id = $id";

if ($con->conn->query($sql)) {
    header("Location: viewcinema.php");
    exit();
} else {
    echo "Delete failed: " . $con->conn->error;
}
