<?php
session_start();

if(empty($_SESSION["admin_username"])) {
    header("Location: index.php");
    exit;
} else {
    include("admin_header.php");
    include_once("../conn.php");

    $con = new connec();

    $tbl = "contact";
    $result = $con->conn->query("SELECT * FROM $tbl ORDER BY msg_date DESC");
?>

<section>
    <div class="container" style="padding:0px; margin:0px; left-margin:5px;">
        <div class="row">
            <div class="col-md-2" style="background-color: maroon; min-height: 450px;">
                <?php include("admin_slidenavbar.php"); ?>
            </div>

            <div class="col-md-10">
                <h5 class="text-center" style="color: maroon;">Contact Messages</h5>

                <table class="table mt-5" border="1">
                    <thead style="background-color: maroon; color: white;">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Number</th>
                            <th>Message</th>
                            <th>Date Sent</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($result && $result->num_rows > 0) {
                            $i = 1;
                            while($row = $result->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo htmlspecialchars($row["name"]); ?></td>
                                <td><?php echo htmlspecialchars($row["email"]); ?></td>
                                <td><?php echo htmlspecialchars($row["num"]); ?></td>
                                <td><?php echo nl2br(htmlspecialchars($row["msg"])); ?></td>
                                <td><?php echo $row["msg_date"]; ?></td>
                            </tr>
                        <?php
                                $i++;
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>No contact messages found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha
</body>
</html>

<?php
    include("admin_footer.php");
}
?>