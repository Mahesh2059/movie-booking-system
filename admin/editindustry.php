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

// Check if 'id' exists and is a number
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
} else {
    echo "<div class='alert alert-danger'>Invalid ID.</div>";
    include("admin_footer.php");
    exit();
}

// Fetch industry data for the given id
$sql = "SELECT * FROM industry WHERE id = $id";
$result = $con->conn->query($sql);

if(!$result || $result->num_rows == 0) {
    echo "<div class='alert alert-danger'>Industry not found.</div>";
    include("admin_footer.php");
    exit();
}

$row = $result->fetch_assoc();

// Handle form submission
if(isset($_POST['btn_update'])) {
    $industry_name = trim($_POST['industry_name']);
    if(empty($industry_name)) {
        $message = "Industry name cannot be empty.";
    } else {
        // Use prepared statement for update
        $stmt = $con->conn->prepare("UPDATE industry SET industry_name=? WHERE id=?");
        $stmt->bind_param("si", $industry_name, $id);
        if($stmt->execute()) {
            header("Location: viewindustry.php?updated=1");
            exit();
        } else {
            $message = "Error updating record: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<div class="container mt-5">
    <h3 style="color: maroon;">Edit Industry</h3>
    <?php if($message): ?>
        <div class="alert alert-warning"><?php echo $message; ?></div>
    <?php endif; ?>
    <form method="post">
        <div class="form-group mb-3">
            <label>Industry Name</label>
            <input type="text" name="industry_name" class="form-control" value="<?php echo htmlspecialchars($row['industry_name']); ?>" required>
        </div>
        <button type="submit" name="btn_update" class="btn btn-success">Update</button>
        <a href="viewindustry.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include("admin_footer.php"); ?>
