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

if(isset($_POST['btn_insert'])) {
    $industry_name = trim($_POST['industry_name']);
    if(!empty($industry_name)) {
        $check = "SELECT * FROM industry WHERE industry_name = '$industry_name'";
        $res = $con->conn->query($check);
        if($res->num_rows > 0) {
            $message = "Industry already exists.";
        } else {
            $sql = "INSERT INTO industry (industry_name) VALUES ('$industry_name')";
            if($con->conn->query($sql)) {
                $message = "Industry added successfully!";
            } else {
                $message = "Error: " . $con->conn->error;
            }
        }
    } else {
        $message = "Industry name is required.";
    }
}
?>

<div class="container mt-5">
    <h3 style="color: maroon;">Add New Industry</h3>

    <?php if($message): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group mb-3">
            <label>Industry Name</label>
            <input type="text" name="industry_name" class="form-control" required>
        </div>
        <button type="submit" name="btn_insert" class="btn btn-success">Add</button>
        <a href="viewindustry.php" class="btn btn-secondary">Back</a>
    </form>
</div>

<?php include("admin_footer.php"); ?>
