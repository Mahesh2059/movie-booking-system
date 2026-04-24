<?php
// get_booked_seats.php
header('Content-Type: application/json');
include_once("conn.php");
$con = new connec();


if (!isset($_GET['show_id']) || !is_numeric($_GET['show_id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid show id']);
    exit;
}

$show_id = (int)$_GET['show_id'];

// Get booked seats for this show
$sql = "SELECT seat_list FROM bookings WHERE show_id = ?";
$stmt = $con->conn->prepare($sql);
$stmt->bind_param('i', $show_id);
$stmt->execute();
$result = $stmt->get_result();

$bookedSeats = [];
while ($row = $result->fetch_assoc()) {
    $seats = explode(',', $row['seat_list']);
    foreach ($seats as $seat) {
        $seat = trim($seat);
        if ($seat !== '') {
            $bookedSeats[] = $seat;
        }
    }
}

$stmt->close();

// Get screen info for the show
$sql2 = "SELECT screen FROM shows_time WHERE id = ?";
$stmt2 = $con->conn->prepare($sql2);
$stmt2->bind_param('i', $show_id);
$stmt2->execute();
$stmt2->bind_result($screen);
$stmt2->fetch();
$stmt2->close();

echo json_encode([
    'success' => true,
    'bookedSeats' => $bookedSeats,
    'screen' => $screen ?? 'Unknown',
]);
