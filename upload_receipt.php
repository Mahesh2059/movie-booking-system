<?php
session_start();
include_once("conn.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["receipt"])) {
    $booking_ref = $_POST["booking_ref"];
    $file = $_FILES["receipt"];
    $upload_dir = "receipts/";

    // Validate file type
    $allowed_types = ['pdf', 'jpg', 'jpeg', 'png'];
    $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed_types)) {
        echo "<script>alert('Invalid file format.'); window.history.back();</script>";
        exit;
    }

    // Move uploaded file
    $new_filename = $booking_ref . "." . $ext;
    $destination = $upload_dir . $new_filename;

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    if (move_uploaded_file($file["tmp_name"], $destination)) {
        $con = new connec();

        // Update booking record with receipt file and change status
        $stmt = $con->conn->prepare("UPDATE bookings SET payment_status = 'Submitted', receipt_file = ? WHERE booking_ref = ?");
        $stmt->bind_param("ss", $new_filename, $booking_ref);
        $stmt->execute();
        $stmt->close();

        unset($_SESSION['booking_ref']);
        echo "<script>alert('Receipt uploaded successfully. Your booking is under review.'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Upload failed. Try again.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='index.php';</script>";
}
?>
