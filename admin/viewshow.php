<?php
session_start();

if(empty($_SESSION["admin_username"])) {
    header("Location: index.php");
    exit();
}

include("admin_header.php");
include_once("../conn.php");

$con = new connec();

// Fetch shows
$sql = "SELECT * FROM shows_time ORDER BY id DESC";
$result = $con->conn->query($sql);
?>

<section>
    <div class="container" style="padding:0px; margin:0px;">
        <div class="row">
            <div class="col-md-2" style="background-color:maroon; min-height:450px;">
                <?php include("admin_slidenavbar.php"); ?>
            </div>
            <div class="col-md-10">
                <h5 class="text-center" style="color:maroon;">Show Time Details</h5>
                <a href="addshow.php" class="btn btn-success mb-3">Add Show Time</a>

                <table class="table table-bordered table-striped">
                    <thead style="background-color:maroon; color:white;">
                        <tr>
                            <th>ID</th>
                            <th>Show Time</th>
                            <th>Show Detail</th>
                            <th>Screen</th>
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
                                    <td><?= htmlspecialchars($row['show_time']); ?></td>
                                    <td><?= htmlspecialchars($row['show_date']); ?></td>
                                    <td><?= htmlspecialchars($row['screen']); ?></td>
                                    <td>
                                        <a href="editshowtime.php?id=<?= $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="deleteshowtime.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete this show time?');">Delete</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center'>No show times found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php include("admin_footer.php"); ?>
