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

// Validate and fetch record
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $con->conn->prepare("SELECT * FROM shows_time WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
        echo "<div class='alert alert-danger'>Show time not found.</div>";
        include("admin_footer.php");
        exit();
    }
    $show = $res->fetch_assoc();
    $stmt->close();
} else {
    echo "<div class='alert alert-danger'>Invalid show time ID.</div>";
    include("admin_footer.php");
    exit();
}

// Handle form submission
if (isset($_POST['btn_update'])) {
    $show_time = trim($_POST['show_time']);
    $show_date = trim($_POST['show_date']);
    $screen    = trim($_POST['screen']);

    if (empty($show_time) || empty($show_date) || empty($screen)) {
        $message = "All fields are required.";
    } else {
        $upd = $con->conn->prepare(
            "UPDATE shows_time SET show_time=?, show_date=?, screen=? WHERE id=?"
        );
        $upd->bind_param("sssi", $show_time, $show_date, $screen, $id);
        if ($upd->execute()) {
            header("Location: viewshowtime.php?updated=1");
            exit();
        } else {
            $message = "Error updating: " . $upd->error;
        }
        $upd->close();
    }
}
?>

<div class="container mt-5">
  <h3 style="color: maroon;">Edit Show Time #<?= $show['id']; ?></h3>
  <?php if ($message): ?>
    <div class="alert alert-warning"><?= htmlspecialchars($message); ?></div>
  <?php endif; ?>

  <form method="post">
    <div class="form-group mb-3">
      <label>Show Time (e.g., 10:00 – 12:30)</label>
      <input type="text" name="show_time" class="form-control" required 
             value="<?= htmlspecialchars($show['show_time']); ?>">
    </div>

    <div class="form-group mb-3">
      <label>Show Date</label>
      <input type="date" name="show_date" class="form-control" required 
             value="<?= htmlspecialchars($show['show_date']); ?>">
    </div>

    <div class="form-group mb-3">
      <label>Screen</label>
      <input type="text" name="screen" class="form-control" required 
             value="<?= htmlspecialchars($show['screen']); ?>">
    </div>

    <button type="submit" name="btn_update" class="btn btn-primary">Update</button>
    <a href="viewshowtime.php" class="btn btn-secondary btn-cancel">Cancel</a>
  </form>
</div>

<?php include("admin_footer.php"); ?>
