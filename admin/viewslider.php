<?php
session_start();

if(empty($_SESSION["admin_username"]))
{
    header("Location: index.php");
}

else
{
    
include("admin_header.php");
$con=new connec();

$tbl="slider";
$result=$con->select_all($tbl);   




?>


<section>
    <div class="container" style="padding:0px; margin:0px ;left-margin:5px;">
        <div class="row">
            <div class="col-md-2" style="background-color:maroon;min-height:450px;">
                <?php include("admin_slidenavbar.php"); ?>
            </div>
            <div class="col-md-10">
                <h5 class="text-center" style="color:maroon;">slider details</h5>
                <a href="addslider.php">Add Industry<a>

                <table class="table mt-5" border='1' >
                    <thead style="background-color:maroon;color:white;">
                        <tr>
                            <th>Id</th>
                            <th>Image path</th>
                            <th>Alt</th>
                            
                                    <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($result->num_rows>0)
                            {
                                while($row=$result->fetch_assoc())
                                {
                                    ?>
                                               <tr>
                            
                            
                            
                                <td><?php echo $row["id"]; ?></td>
                                <td><img src="../<?php echo $row["img_path"]; ?>" style="height:100px;"></td>
                                 <td><?php echo $row["alt"]; ?></td>
                                 

                                  <td><a href="editslider.php?id=<?php echo $row["id"]; ?>" class="btn btn-primary">Edit</a>
                                  <a href="deleteslider.php?id= <?php echo $row["id"]; ?>" class="btn btn-danger">Delete</a>
                                </td>
                                   
                        </tr>

                                    <?php

                                }

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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>

    <?php
include("admin_footer.php");
}


?>