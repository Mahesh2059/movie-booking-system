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
    header("Location: viewuser.php");
    exit();
}

$id = (int)$_GET['id'];

// Fetch user data
$result = $con->conn->query("SELECT * FROM user WHERE id = $id");
if (!$result || $result->num_rows == 0) {
    die("User not found");
}

$user = $result->fetch_assoc();
$error = "";

if (isset($_POST['btn_update'])) {
    $username = $con->conn->real_escape_string($_POST['username']);
    $email = $con->conn->real_escape_string($_POST['email']);
    $password = $_POST['password']; // Hash later
    $number = $con->conn->real_escape_string($_POST['number']);
    $is_verified = isset($_POST['is_verified']) ? 1 : 0;

    // Hash password if changed
    if (!empty($password)) {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
    } else {
        $password_hashed = $user['password']; // keep old
    }

    $sql = "UPDATE user SET
            username='$username',
            email='$email',
            password='$password_hashed',
            number='$number',
            is_verified=$is_verified
            WHERE id=$id";

    if ($con->conn->query($sql)) {
        header("Location: viewuser.php");
        exit();
    } else {
        $error = "Update failed: " . $con->conn->error;
    }
}
?>

<section class="container mt-4" style="max-width: 600px;">
    <h3 style="color: maroon;">Edit User</h3>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post">
        <div class="form-group mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required value="<?= htmlspecialchars($user['username']) ?>">
        </div>
        <div class="form-group mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($user['email']) ?>">
        </div>
        <div class="form-group mb-3">
            <label>Password (leave blank to keep unchanged)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="form-group mb-3">
            <label>Phone Number</label>
            <input type="text" name="number" class="form-control" value="<?= htmlspecialchars($user['number']) ?>">
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" name="is_verified" id="verified" class="form-check-input" <?= $user['is_verified'] ? 'checked' : '' ?>>
            <label for="verified" class="form-check-label">Verified</label>
        </div>
        <button type="submit" name="btn_update" class="btn btn-success">Update User</button>
        <a href="viewuser.php" class="btn btn-secondary">Cancel</a>
    </form>
</section>

<?php include("admin_footer.php"); ?>
