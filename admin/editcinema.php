<?php
session_start();
include("admin_header.php");
include_once("../conn.php");
$con = new connec();

if (!isset($_GET['id'])) {
    header("Location: viewcinema.php");
    exit();
}

$id = (int)$_GET['id'];

// Fetch cinema data
$res = $con->conn->query("SELECT * FROM cinema WHERE id = $id");
if ($res->num_rows == 0) {
    echo "Cinema not found.";
    exit();
}
$cinema = $res->fetch_assoc();

if (isset($_POST['btn_update'])) {
    $name = mysqli_real_escape_string($con->conn, $_POST['cinema_name_text']);
    $location = mysqli_real_escape_string($con->conn, $_POST['cinema_location_text']);
    $city = mysqli_real_escape_string($con->conn, $_POST['cinema_city_text']);

    $sql = "UPDATE cinema SET name='$name', location='$location', city='$city' WHERE id=$id";

    if ($con->conn->query($sql)) {
        header("Location: viewcinema.php");
        exit();
    } else {
        echo "Update failed: " . $con->conn->error;
    }
}
?>

<h3 class="text-center mt-3">Edit Cinema</h3>

<form method="post" class="container mt-4" style="max-width: 500px; color: maroon;">
    <label><b>Cinema Name</b></label>
    <input type="text" name="cinema_name_text" class="form-control mb-3" required
           value="<?= htmlspecialchars($cinema['name']) ?>">

    <label><b>Cinema Location</b></label>
    <input type="text" name="cinema_location_text" class="form-control mb-3" required
           value="<?= htmlspecialchars($cinema['location']) ?>">

    <label><b>Cinema City</b></label>
    <input type="text" name="cinema_city_text" class="form-control mb-3" required
           value="<?= htmlspecialchars($cinema['city']) ?>">

    <button type="submit" name="btn_update" class="btn btn-success">Update</button>
    <a href="viewcinema.php" class="btn btn-secondary">Cancel</a>
</form>

<?php include("admin_footer.php"); ?>
