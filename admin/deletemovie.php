<?php
session_start();
if(empty($_SESSION["admin_username"])) {
    header("Location: index.php");
    exit();
}
include_once("../conn.php");
$con = new connec();

if(!isset($_GET['id'])) {
    header("Location: viewmovie.php");
    exit();
}

$id = intval($_GET['id']);

// Before deleting, check for foreign key constraints if any

$sql = "DELETE FROM movie WHERE id=$id";
if($con->conn->query($sql)) {
    header("Location: viewmovie.php?deleted=1");
    exit();
} else {
    echo "Error deleting movie: " . $con->conn->error;
}
