<?php
session_start();
include("header.php");

if (empty($_SESSION['booking_ref'])) {
    echo "<script>alert('No active booking'); window.location.href='index.php';</script>";
    exit;
}

$booking_ref = $_SESSION['booking_ref'];
?>

<div class="container mt-5">
    <h4 class="text-center text-success">Complete Your Payment</h4>
    <p class="text-center">Scan the QR Code below to make the payment. Then upload the receipt.</p>

    <div class="text-center my-4">
        <img src="images/WhatsApp Image 2025-07-21 at 08.11.41_4659dead.jpg" alt="QR Code" style="display: block; margin: 20px auto; width: 250px; max-width: 100%; border: 2px solid #ccc; border-radius: 10px; padding: 10px; background-color: #f9f9f9;">
        <p class="mt-2">Amount: Rs. <?php echo $_SESSION['total_price'] ?? 'your seat selected price'; ?></p>
    </div>

    <div class="mx-auto" style="max-width: 500px;">
        <form method="post" action="upload_receipt.php" enctype="multipart/form-data">
            <input type="hidden" name="booking_ref" value="<?php echo $booking_ref; ?>">

            <label><b>Upload Payment Receipt</b> (PDF, JPG, PNG only)</label>
            <input type="file" name="receipt" class="form-control mb-3" accept=".pdf,.jpg,.jpeg,.png" required>

            <button type="submit" class="btn btn-primary w-100">Submit Receipt</button>
        </form>
    </div>
</div>

<?php include("footer.php"); ?>
