<?php
session_start();
include_once("conn.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $con = new connec();

    // Sanitize and fetch POST data
    $customer_id   = $_POST['customer_id'] ?? '';
    $show_id       = (int) ($_POST['shows_time'] ?? 0);
    $username      = trim($_POST['username'] ?? '');
    $email         = trim($_POST['email'] ?? '');
    $phone         = trim($_POST['phone'] ?? '');
    $seat_list     = trim($_POST['seat_list'] ?? '');
    $ticket_count  = (int) ($_POST['ticket_count'] ?? 0);
    $total_price   = (float) ($_POST['total_price'] ?? 0);
    $booking_date  = $_POST['booking_date'] ?? date('Y-m-d');

    if (empty($customer_id) || !$show_id || empty($username) || empty($email) || empty($phone) || empty($seat_list)) {
        echo "<script>alert('All fields are required.'); window.history.back();</script>";
        exit;
    }

    // Create booking reference
    $booking_ref = "BOOK" . time() . rand(1000, 9999);

    $selected_seats = array_map('trim', explode(',', $seat_list));
    
    $mysqli = $con->conn;

    // Start transaction
    $mysqli->begin_transaction();

    try {
        // Step 1: Check if any seat in $selected_seats is already booked for this show_id
        $placeholders = implode(',', array_fill(0, count($selected_seats), '?'));
        $types = str_repeat('s', count($selected_seats));
        $params = $selected_seats;

        // Prepare query to fetch all booked seats for this show that match selected seats
        $sql_check = "SELECT seat_list FROM bookings WHERE show_id = ?";

        $stmt_check = $mysqli->prepare($sql_check);
        if (!$stmt_check) throw new Exception($mysqli->error);
        $stmt_check->bind_param('i', $show_id);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        $already_booked = [];
        while ($row = $result->fetch_assoc()) {
            $booked_seats = array_map('trim', explode(',', $row['seat_list']));
            foreach ($booked_seats as $bs) {
                if (in_array($bs, $selected_seats)) {
                    $already_booked[] = $bs;
                }
            }
        }
        $stmt_check->close();

        if (count($already_booked) > 0) {
            // Seats already booked by someone else — rollback and inform user
            $mysqli->rollback();
            $seats_str = implode(', ', $already_booked);
            echo "<script>alert('Seats already booked: $seats_str. Please select different seats.'); window.history.back();</script>";
            exit;
        }

        // Step 2: Insert booking
        $sql_insert = "INSERT INTO bookings 
            (booking_ref, customer_id, show_id, username, email, phone, seat_list, ticket_count, total_price, booking_date, payment_status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";

        $stmt_insert = $mysqli->prepare($sql_insert);
        if (!$stmt_insert) throw new Exception($mysqli->error);

        $stmt_insert->bind_param(
            "siissssids",
            $booking_ref,
            $customer_id,
            $show_id,
            $username,
            $email,
            $phone,
            $seat_list,
            $ticket_count,
            $total_price,
            $booking_date
        );

        if (!$stmt_insert->execute()) {
            throw new Exception($stmt_insert->error);
        }

        $stmt_insert->close();

        // Commit transaction - all good
        $mysqli->commit();

        $_SESSION['booking_ref'] = $booking_ref;
        header("Location: payment_qr_upload.php");
        exit;

    } catch (Exception $e) {
        $mysqli->rollback();
        echo "<script>alert('Booking failed: " . htmlspecialchars($e->getMessage()) . "'); window.history.back();</script>";
        exit;
    }
} else {
    echo "<script>alert('Invalid request'); window.location.href='index.php';</script>";
    exit;
}
?>
