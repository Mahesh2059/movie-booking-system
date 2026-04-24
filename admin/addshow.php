<?php
session_start();

if(empty($_SESSION["admin_username"])) {
    header("Location: index.php");
    exit();
}

include("admin_header.php");
include_once("../conn.php");

$con = new connec();
$message = "";

// Form submission
if (isset($_POST['btn_add'])) {
    $show_time = trim($_POST['show_time']);
    $show_date = trim($_POST['show_date']);
    $screen = trim($_POST['screen']);

    if (!empty($show_time) && !empty($show_date) && !empty($screen)) {
        $stmt = $con->conn->prepare("INSERT INTO shows_time (show_time, show_date, screen) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $show_time, $show_date, $screen);

        if ($stmt->execute()) {
            $message = "<div class='alert alert-success'>Show time added successfully.</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }

        $stmt->close();
    } else {
        $message = "<div class='alert alert-warning'>Please fill all fields.</div>";
    }
}
?>

<!-- Add Show Time Form -->
<section class="container mt-5">
    <h4 style="color: maroon;">Add New Show Time</h4>
    <?= $message; ?>

    <form method="post">
        <div class="mb-3">
            <label for="show_time" class="form-label">Show Time</label>
            <input type="text" name="show_time" id="show_time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="show_date" class="form-label">Show Date</label>
            <input type="date" name="show_date" id="show_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="screen" class="form-label">Screen</label>
            <input type="text" name="screen" id="screen" class="form-control" required>
        </div>

        <button type="submit" name="btn_add" class="btn btn-primary">Add Show</button>
        <a href="viewshow.php" class="btn btn-secondary">Cancel</a>
    </form>
</section>

<?php include("admin_footer.php"); ?>
