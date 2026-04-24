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

$sql="SELECT 
    movie.id,
    movie.name,
    movie.movie_banner,
    movie.rel_date,
    industry.industry_name,
    genre.genre_name,
    language.lang_name,
    movie.duration 
FROM 
    movie,
    genre,
    industry,
    language 
WHERE 
    movie.industry_id = industry.id AND
    movie.genre_id = genre.id AND
    movie.lang_id = language.id;";
$result=$con->select_by_query($sql);


?>


<section>
    <div class="container" style="padding:0px; margin:0px ;left-margin:5px;">
        <div class="row">
            <div class="col-md-2" style="background-color:maroon;min-height:450px;">
                <?php include("admin_slidenavbar.php"); ?>
            </div>
            <div class="col-md-10">
                <h5 class="text-center">Movie details</h5>
                <a href="addmovie.php">Add Movie<a>

                <table class="table mt-5" border='1' >
                    <thead style="background-color:maroon;color:white;">
                        <tr>
                            <th>Name</th>
                            <th>Banner</th>
                            <th>Release Date</th>
                              <th>Industry</th>
                                <th>Genre</th>
                                  <th>language</th>
                                    <th>Duration</th>
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
                            
                            <td><?php echo $row["name"]; ?></td>
                             <td><img src="../<?php echo $row["movie_banner"]; ?>" style="height:100px" ></td>
                              <td><?php echo $row["rel_date"]; ?></td>
                               <td><?php echo $row["industry_name"]; ?></td>
                                <td><?php echo $row["genre_name"]; ?></td>
                                 <td><?php echo $row["lang_name"]; ?></td>
                                  <td><?php echo $row["duration"]; ?></td>
                                  <td><a href="editmovie.php?id=<?php echo $row["id"]; ?>" class="btn btn-primary">Edit</a>
                                  <a href="deletemovie.php?id= <?php echo $row["id"]; ?>" class="btn btn-danger">Delete</a>
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