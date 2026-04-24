<?php
include_once("conn.php");
$con = new connec(); // Database connection

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Handle registration
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Registration
    if (isset($_POST["username"])) {
        $username = $_POST["username"];
        $email = $_POST["reg_email"];
        $password = $_POST["re_psw"];
        $number = $_POST["number_text"];

        $password = md5($password); // or password_hash() for more security

        $query = "INSERT INTO user (username, email, password, number) 
                  VALUES ('$username', '$email', '$password', '$number')";

        $con->insert($query);
    }

    // Login
    if (isset($_POST["btn_login"])) {
    $email = $_POST["email"];
    $password = md5($_POST["psw"]);

    $sql = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
    $result = $con->conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($row['is_verified'] == 1) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION["username"] = $row["username"];

            echo "<script>location.href='index.php';</script>";
            exit();
        } else {
            echo "<script>alert('Your account is not verified by the admin. Please wait for approval.');</script>";
        }
    } else {
        echo "<script>alert('Invalid login credentials');</script>";
    }
}

}
?>


<!doctype html>
<html lang="en">
  <head>
    <title>Movie Ticket booking</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="icon" href="images/logo.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

   <style>
     *{box-sizing:border-box}
    

        .container {
        
            padding: 16px;
           
        }
        h1 {
            margin-bottom: 10px;
        }

        p {
            color: #555;
        }

        textarea,input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"] {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            border: none;
            display: inline-block;
            background: #f1f1f1;
        }

        button[type="submit"] {
            width: 100%;
            background-color: maroon;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: darkred;
        }

        .signing {
            text-align: center;
            margin-top: 20px;
        }

        .signing a {
            color: grey;
        }

        a {
            text-decoration: none;
        }
    </style>

</head>
  <body>
      
<nav class="navbar navbar-expand-md navbar-dark" style="background-color: maroon;">
    <a class="navbar-brand" href="index.php"><img src="images/logo.png" style="width: 70px;"></a>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse"
        data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">Movie</a>
                <div class="dropdown-menu" aria-labelledby="dropdownId">
                    <a class="dropdown-item" href="nowshowing.php">Now Showing</a>
                    <a class="dropdown-item" href="commingsoon.php">Coming Soon</a>
                </div>
            </li>

        
            <li class="nav-item"><a class="nav-link" href="booking.php">Book Ticket</a></li>
            <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
            <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
        </ul>

        <ul class="navbar-nav">
            <?php if (!isset($_SESSION['username'])): ?>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="modal" data-target="#modelId">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="modal" data-target="#modelId1">Login</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link disabled" style="color:white;">
                        Welcome, <?= htmlspecialchars($_SESSION['username']) ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?logout=true">Logout</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
  
  <!-- Register Modal -->
  <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: maroon;color:white;">
                
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="container" style="color:maroon;">

                    <center>
                        <h1>Register</h1>
                        <p>Please fill tge form to create an account.</p>
                    </center>
                        <hr>

                        <label for="username "><b>Username</b></label>
                        <input type="text" style="boarder-radius:30ox;" placeholder="Enter username" name="username"id="username"Required >

                         <label for="email "><b>Email</b></label>
                        <input type="text" style="boarder-radius:30ox;" placeholder="Enter Email" name="reg_email"id="email"Required >

                         <label for="psw "><b>password</b></label>
                        <input type="password" style="boarder-radius:30ox;" placeholder="Enter password" name="re_psw" id="psw" Required >

                         <label for="psw-repeat "><b>Repeat password</b></label>
                        <input type="password" style="boarder-radius:30ox;" placeholder="Repeat password" name="psw_repeat"id="psw-repeat"Required >

                         <label for="number "><b>Number</b></label>
                        <input type="tel" style="boarder-radius:30ox;" placeholder="Enter number" name="number_text"id="number"Required >
                         <button type="submit" class="btn_reg" style="background-color: maroon;color:white">Register</button>
                        
                        <hr>
                        <center>
                            <p>By creating an account you agree to our <a href="#" style="color:gray">Terms and privacy></a>.</p>

                           
                        </center>
                    </div>

                    <div class="container signing">
                        <p>Already have an account <a style="color:grey" data-toggle="modal" data-target="#modelId1" data-dismiss="modal">Log in </a>.</p>

                    </div>
              
                </form>
                
            </div>
           <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>-->
        </div>
    </div>
  </div>


<!-- login Modal -->
<div class="modal fade" id="modelId1" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: maroon;color:white;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                
            <form method="post">
                <div class="container" style="color: maroon;">
                    <center>
                        <h1>login</h1>
                    </center>

                    <label for="email "><b>Email</b></label>
                    <input type="text" style="boarder-radius:30ox;" placeholder="Enter Email" name="email"id="email"Required >

                    <label for="psw "><b>password</b></label>
                    <input type="password" style="boarder-radius:30ox;" placeholder="Enter password" name="psw" id="psw" Required >

                    <button type="submit" name="btn_login" class="btn" style="background-color: maroon;color:white;">Login</button>
                </div>
            </form>
            </div>
           <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn" style="background-color: maroon;color:white;">Login</button>
            </div>-->
        </div>
    </div>
</div>
  