<?php
session_start();
if(empty($_SESSION["admin_username"])) {
    header("Location: index.php");
    exit();
}
include_once("../conn.php");

$con = new connec();

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM industry WHERE id=$id";
    if($con->conn->query($sql)) {
        header("Location: viewindustry.php");
        exit();
    } else {
        echo "Failed to delete industry: " . $con->conn->error;
    }
} else {
    header("Location: viewindustry.php");
    exit();
}
?>
