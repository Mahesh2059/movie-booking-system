<?php
session_start();
if (empty($_SESSION["admin_username"])) {
    header("Location: viewshow.php.php");
    exit();
}

include_once("../conn.php");
$con = new connec();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "DELETE FROM shows_time WHERE id = $id";
    if ($con->conn->query($sql) === TRUE) {
        header("Location: viewshow.php?deleted=1");
        exit();
    } else {
        echo "Error deleting record: " . $con->conn->error;
    }
} else {
    echo "Invalid ID.";
}
?>
