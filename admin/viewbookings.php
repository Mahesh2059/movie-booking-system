<?php
session_start();

if(empty($_SESSION["admin_username"])) {
    header("Location: index.php");
    exit();
}

include("admin_header.php");
include_once("../conn.php");

$con = new connec();

// SQL JOIN to get show details along with booking
$sql = "
    SELECT 
        bookings.*, 
        shows_time.show_time, 
        shows_time.show_date, 
        shows_time.screen 
    FROM bookings
    JOIN shows_time ON bookings.show_id = shows_time.id
    ORDER BY bookings.booking_date DESC
";

$result = $con->conn->query($sql);
?>

<section>
    <div class="container" style="padding:0px; margin:0px;">
        <div class="row">
            <div class="col-md-2" style="background-color:maroon; min-height:450px;">
                <?php include("admin_slidenavbar.php"); ?>
            </div>
            <div class="col-md-10">
                <h5 class="text-center" style="color:maroon;">Booking Details</h5>
                
                <table class="table mt-5" border="1">
                    <thead style="background-color:maroon; color:white;">
                        <tr>
                            <th>ID</th>
                            <th>Customer ID</th>
                            <th>Show Date</th>
                            <th>Show Time</th>
                            <th>Screen</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Seat List</th>
                            <th>Ticket Count</th>
                            <th>Total Price</th>
                            <th>Booking Date</th>
                            <th>Payment Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $row['id']; ?></td>
                                    <td><?= htmlspecialchars($row['customer_id']); ?></td>
                                    <td><?= htmlspecialchars($row['show_date']); ?></td>
                                    <td><?= htmlspecialchars($row['show_time']); ?></td>
                                    <td><?= htmlspecialchars($row['screen']); ?></td>
                                    <td><?= htmlspecialchars($row['username']); ?></td>
                                    <td><?= htmlspecialchars($row['email']); ?></td>
                                    <td><?= htmlspecialchars($row['phone']); ?></td>
                                    <td><?= htmlspecialchars($row['seat_list']); ?></td>
                                    <td><?= htmlspecialchars($row['ticket_count']); ?></td>
                                    <td><?= htmlspecialchars($row['total_price']); ?></td>
                                    <td><?= htmlspecialchars($row['booking_date']); ?></td>
                                    <td>
                                        <?php if (!empty($row['receipt_file'])): ?>
                                            <img src="../<?= htmlspecialchars($row['receipt_file']); ?>" style="height:100px" alt="Payment Image">
                                        <?php else: ?>
                                            <span style="color:gray;">Not uploaded</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="deletebooking.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete this booking?');">Delete</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='14' class='text-center'>No bookings found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</section>

<?php include("admin_footer.php"); ?>
