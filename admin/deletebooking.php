<?php
session_start();
if(empty($_SESSION["admin_username"])) {
    header("Location: viewbookings.php");
    exit();
}

include_once("../conn.php");
$con = new connec();

if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $con->conn->prepare("DELETE FROM bookings WHERE id = ?");
    $stmt->bind_param("i", $id);

    if($stmt->execute()) {
        // Redirect properly - adjust path as needed
        header("Location:viewbookings.php?deleted=1");
        exit();
    } else {
        echo "Error deleting booking: " . $stmt->error;
    }
} else {
    echo "Invalid booking ID.";
}
?>
