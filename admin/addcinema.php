<?php
session_start();


if(empty($_SESSION["admin_username"]))
{
    header("Location: index.php");
}

else
{
    
include("admin_header.php");


   
}

if (isset($_POST["btn_insert"])) {
    $name = $_POST["cinema_name_text"];
    $location = $_POST["cinema_location_text"];
    $city = $_POST["cinema_city_text"];

    $con = new connec();

    // Escape input
    $name = mysqli_real_escape_string($con->conn, $name);
    $location = mysqli_real_escape_string($con->conn, $location);
    $city = mysqli_real_escape_string($con->conn, $city);

    $sql = "INSERT INTO cinema (name, location, city) VALUES ('$name', '$location', '$city')";

    if ($con->insert($sql, "Cinema added.")) {
        // Redirect to viewcinema.php after successful insertion
        header("Location: viewcinema.php");
        exit();
    } else {
        echo "<script>alert('Insertion failed.');</script>";
    }
}


?>



<section>
    <div class="container" style="padding:0px; margin:0px ;left-margin:5px;">
        <div class="row">
            <div class="col-md-2" style="background-color:maroon;min-height:450px;">
                <?php include("admin_slidenavbar.php"); ?>
            </div>
            <div class="col-md-10">
                <h5 class="text-center" style="color:maroon;">Add details</h5>

                <form method="post">
                <div class="container" style="color: maroon;">
            

                    <label for="email "><b>Cinema name</b></label>
                    <input type="text" style="boarder-radius:30ox;" placeholder="Enter cinema name" name="cinema_name_text"Required >

                    
                    <label for="email "><b>Cinema location</b></label>
                    <input type="text" style="boarder-radius:30ox;" placeholder="Enter cinema location" name="cinema_location_text"Required >

                    
                    <label for="email "><b>Cinema city</b></label>
                    <input type="text" style="boarder-radius:30ox;" placeholder="Enter  city" name="cinema_city_text"Required >
  

                    <button type="submit" name="btn_insert" class="btn" style="background-color: maroon;color:white;">Add</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</section>
      

    <?php
include("admin_footer.php");



?>