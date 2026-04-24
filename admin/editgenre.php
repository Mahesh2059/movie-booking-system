<?php
session_start();

if (empty($_SESSION["admin_username"])) {
    header("Location: index.php");
    exit();
}

include("admin_header.php");
include_once("../conn.php");
$con = new connec();

if (!isset($_GET['id'])) {
    header("Location: viewgenre.php");
    exit();
}

$id = (int)$_GET['id'];

// Fetch genre record
$result = $con->conn->query("SELECT * FROM genre WHERE id = $id");
if (!$result || $result->num_rows === 0) {
    die("Genre not found");
}

$genre = $result->fetch_assoc();
$error = "";

if (isset($_POST['btn_update'])) {
    $name = $con->conn->real_escape_string($_POST['genre_name']);

    $sql = "UPDATE genre SET genre_name='$name' WHERE id=$id";

    if ($con->conn->query($sql)) {
        header("Location: viewgenre.php");
        exit();
    } else {
        $error = "Update failed: " . $con->conn->error;
    }
}
?>

<section class="container mt-4" style="max-width: 600px;">
    <h3 style="color: maroon;">Edit Genre</h3>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group mb-3">
            <label for="genre_name">Genre Name</label>
            <input type="text" id="genre_name" name="genre_name" class="form-control" required value="<?= htmlspecialchars($genre['genre_name']) ?>">
        </div>

        <button type="submit" name="btn_update" class="btn btn-success">Update Genre</button>
        <a href="viewgenre.php" class="btn btn-secondary">Cancel</a>
    </form>
</section>

<?php include("admin_footer.php"); ?>
