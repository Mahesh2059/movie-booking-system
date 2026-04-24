<?php
session_start();

if (empty($_SESSION["admin_username"])) {
    header("Location: index.php");
    exit();
}

include("admin_header.php");
include_once("../conn.php");

$con = new connec();
$message = "";

if (isset($_POST['btn_insert'])) {
    $genre_name = trim($_POST['genre_name']);

    if (!empty($genre_name)) {
        // Check for duplicates
        $check = "SELECT * FROM genre WHERE genre_name = '$genre_name'";
        $res = $con->conn->query($check);

        if ($res->num_rows > 0) {
            $message = "Genre already exists.";
        } else {
            $sql = "INSERT INTO genre (genre_name) VALUES ('$genre_name')";
            if ($con->conn->query($sql)) {
                $message = "Genre added successfully!";
            } else {
                $message = "Failed to add genre: " . $con->conn->error;
            }
        }
    } else {
        $message = "Genre name cannot be empty.";
    }
}
?>

<section class="container mt-5" style="max-width: 600px;">
    <h3 style="color: maroon;">Add New Genre</h3>

    <?php if ($message): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group mb-3">
            <label for="genre_name">Genre Name</label>
            <input type="text" name="genre_name" id="genre_name" class="form-control" required placeholder="Enter genre name">
        </div>
        <button type="submit" name="btn_insert" class="btn btn-success">Add Genre</button>
        <a href="viewgenre.php" class="btn btn-secondary">Back to Genre List</a>
    </form>
</section>

<?php include("admin_footer.php"); ?>
