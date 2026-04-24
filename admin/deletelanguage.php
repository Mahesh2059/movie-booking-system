<?php
session_start();
if(empty($_SESSION["admin_username"])) {
    header("Location: index.php");
    exit();
}

include_once("../conn.php");
$con = new connec();

if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $con->conn->prepare("DELETE FROM language WHERE id=?");
    $stmt->bind_param("i", $id);
    if($stmt->execute()) {
        $stmt->close();
        header("Location: viewlanguage.php?deleted=1");
        exit();
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
} else {
    echo "Invalid ID.";
}

?>
