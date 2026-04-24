<?php
session_start();

if (empty($_SESSION["admin_username"])) {
    header("Location: index.php");
    exit();
}

include_once("../conn.php");
$con = new connec();

if (!isset($_GET['id'])) {
    header("Location: viewgenre.php");
    exit();
}

$id = (int)$_GET['id'];

$sql = "DELETE FROM genre WHERE id = $id";

if ($con->conn->query($sql)) {
    header("Location: viewgenre.php");
    exit();
} else {
    echo "Delete failed: " . $con->conn->error;
}
