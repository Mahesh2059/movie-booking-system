<?php
session_start();
if (empty($_SESSION["username"])) {
    header("Location:index.php");
    exit();
}
include("header.php");
include_once("conn.php");
$con = new connec();
?>

<section class="mt-5">
    <h5 class="text-center">Book Your Ticket Now</h5>
    <div class="d-flex justify-content-center align-items-start gap-4 flex-wrap">
        <!-- Seat Map -->
        <div id="seat-map" style="flex: 1; max-width: 500px;">
            <h6 class="text-center" id="screen-name"></h6>
            <div class="screen bg-dark text-white text-center mb-3">SCREEN</div>
            <div id="seats-container" class="d-flex flex-column"></div>
        </div>

        <!-- Booking Form -->
        <form method="post" action="process_booking.php" style="flex: 1; max-width: 500px;">
            <div class="container" style="color:maroon;">
                <p class="text-center">Please fill this form to book your ticket.</p>
                <hr>

                <label><b>Customer ID</b></label>
                <input type="text" name="customer_id" value="<?php echo $_SESSION['user_id']; ?>" readonly class="form-control" required>

                <label><b>Show Time</b></label>
                <select name="shows_time" id="show-time-select" required class="form-control">
                    <option value="">Select Show</option>
                    <?php
                    $result = $con->select_all("shows_time");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['id']}' data-screen='{$row['screen']}'>Time: " . htmlspecialchars($row['show_time']) .
                            " | Date: " . htmlspecialchars($row['show_date']) .
                            " | Screen: " . htmlspecialchars($row['screen']) . "</option>";
                    }
                    ?>
                </select>

                <label><b>Username</b></label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" readonly class="form-control" required>

                <label><b>Email</b></label>
                <input type="email" name="email" required class="form-control">

                <label><b>Phone Number</b></label>
                <input type="tel" name="phone" required class="form-control">

                <input type="hidden" name="seat_list" id="selected_seats" required>
                <input type="hidden" name="total_price" id="total_price" required>
                <input type="hidden" name="ticket_count" id="ticket_count" required>
                <input type="hidden" name="booking_date" value="<?php echo date('Y-m-d'); ?>">

                <p>Total Seats Selected: <span id="total">0</span></p>
                <p>Total Price: Rs. <span id="price">0</span></p>

                <button type="submit" class="btn btn-success" onclick="return validateSeats()">Confirm Booking</button>
                <hr>
            </div>
        </form>
    </div>
</section>

<style>
/* Same CSS as before for seats and layout */
.btn.seat {
    width: 50px;
    height: 40px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 5px;
    transition: transform 0.2s ease, background-color 0.2s ease;
    cursor: pointer;
    user-select: none;
}

.btn.seat:hover {
    transform: scale(1.05);
}

.btn.seat.selected {
    background-color: #28a745 !important;
    color: #fff;
    border-color: #28a745;
}

.btn.seat.booked {
    background-color: #dc3545 !important;
    color: #fff;
    border-color: #dc3545;
    cursor: not-allowed;
}

#seats-container > div {
    margin-bottom: 5px;
    display: flex;
    justify-content: center;
}
</style>

<script>
const showTimeSelect = document.getElementById('show-time-select');
const seatsContainer = document.getElementById('seats-container');
const screenName = document.getElementById('screen-name');
const selectedSeatsInput = document.getElementById('selected_seats');
const totalSpan = document.getElementById('total');
const priceSpan = document.getElementById('price');
const priceInput = document.getElementById('total_price');
const ticketCountInput = document.getElementById('ticket_count');
let selectedSeats = [];
const pricePerSeat = 200;

// Function to create seat buttons dynamically
function createSeatMap(bookedSeats, screen) {
    seatsContainer.innerHTML = '';  // Clear previous seats
    selectedSeats = [];
    selectedSeatsInput.value = '';
    totalSpan.textContent = '0';
    priceSpan.textContent = '0';
    priceInput.value = '0';
    ticketCountInput.value = '0';

    screenName.textContent = "Screen: " + screen;

    const rows = 'ABCDEFGHIJ'.split('');
    const cols = Array.from({length: 10}, (_, i) => i + 1);

    rows.forEach(r => {
        const rowDiv = document.createElement('div');
        cols.forEach(c => {
            const seatId = r + c;
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'btn seat m-1';
            btn.textContent = seatId;
            btn.dataset.seat = seatId;

            if (bookedSeats.includes(seatId)) {
                btn.classList.add('booked');
                btn.disabled = true;
            }

            btn.addEventListener('click', () => {
                if (btn.classList.contains('selected')) {
                    btn.classList.remove('selected');
                    selectedSeats = selectedSeats.filter(s => s !== seatId);
                } else {
                    btn.classList.add('selected');
                    selectedSeats.push(seatId);
                }
                updateSelection();
            });

            rowDiv.appendChild(btn);
        });
        seatsContainer.appendChild(rowDiv);
    });
}

// Update selected seats and prices
function updateSelection() {
    selectedSeatsInput.value = selectedSeats.join(',');
    totalSpan.textContent = selectedSeats.length;
    const totalCost = selectedSeats.length * pricePerSeat;
    priceSpan.textContent = totalCost;
    priceInput.value = totalCost;
    ticketCountInput.value = selectedSeats.length;
}

// Validate before submitting
function validateSeats() {
    if (selectedSeats.length === 0) {
        alert("Please select at least one seat!");
        return false;
    }
    if (showTimeSelect.value === "") {
        alert("Please select a show time!");
        return false;
    }
    return true;
}

// Load booked seats and screen when show time changes
showTimeSelect.addEventListener('change', () => {
    const showId = showTimeSelect.value;
    if (!showId) {
        seatsContainer.innerHTML = '';
        screenName.textContent = '';
        return;
    }

    fetch('get_booked_seats.php?show_id=' + showId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                createSeatMap(data.bookedSeats, data.screen);
            } else {
                alert('Failed to load seats');
            }
        })
        .catch(() => {
            alert('Error fetching seat data');
        });
});
</script>

<?php include("footer.php"); ?>
