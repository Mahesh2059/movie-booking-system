<?php
session_start();
$_SESSION["admin_username"]="null";
$_error="";

if (isset($_POST["btn_login"])) {
    $email = $_POST["email"];
    $password = md5($_POST["psw"]);

    
        if ("admin@gmail.com"==$email  )  {
            if(md5("1234567")==$password)
            {

            $_SESSION["admin_username"]=$email;
            header("Location: dashboard.php");
        }
        else{
            echo'<script> alert("invallid Password");</script>';
        }
}
else{

    $error="invalid Email";
}
}


?>

<!doctype html>
<html lang="en">
  <head>
    <title>Admin Panel</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
     <style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body, html {
        height: 100%;
        background-color: #f9f9f9;
    }

    /* Full-screen Navbar */
    .navbar {
        width: 100%;
        background-color: maroon;
        color: white;
        padding: 16px 32px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 999;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .navbar h2 {
        margin: 0;
        font-size: 24px;
    }

    .navbar a {
        color: white;
        text-decoration: none;
        font-size: 16px;
        margin-left: 20px;
    }

    .container {
        max-width: 500px;
        margin: 120px auto 40px auto;
        padding: 32px;
        background: white;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    h1 {
        margin-bottom: 20px;
        text-align: center;
        font-size: 28px;
        color: maroon;
    }

    p {
        color: #555;
        font-size: 15px;
        margin-bottom: 15px;
        text-align: center;
    }

    textarea,
    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="tel"] {
        width: 100%;
        padding: 14px 20px;
        margin: 10px 0 20px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        background: #f1f1f1;
        transition: 0.3s ease;
    }

    textarea:focus,
    input:focus {
        background-color: #fff;
        border: 1px solid maroon;
        outline: none;
    }

    button[type="submit"] {
        width: 100%;
        background-color: maroon;
        color: white;
        padding: 14px;
        border: none;
        border-radius: 30px;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s ease;
    }

    button[type="submit"]:hover {
        background-color: darkred;
    }

    .signing {
        text-align: center;
        margin-top: 20px;
        font-size: 15px;
    }

    .signing a {
        color: maroon;
        text-decoration: underline;
    }

    @media (max-width: 600px) {
        .container {
            margin: 100px 20px;
        }

        .navbar {
            flex-direction: column;
            align-items: flex-start;
        }

        .navbar a {
            margin: 10px 0 0 0;
        }
    }
</style>




</head>
  <body>
      

    <div class="contailer">
        <div class="row">
            <div class="col-md-6"style="margin:auto;">
                <form method="post">
                    <div class="container" style="color: maroon;">
                    <center>
                        <h1>Admin login</h1>
                    </center>

                    <label for="email "><b>Email</b></label>
                    <input type="text" style="boarder-radius:30ox;" placeholder="Enter Email" name="email"id="email"Required >

                    <label for="psw "><b>password</b></label>
                    <input type="password" style="boarder-radius:30ox;" placeholder="Enter password" name="psw" id="psw" Required >

                    <button type="submit" name="btn_login" class="btn" style="background-color: maroon;color:white;">Login</button>
                </div>
            </form>
            </div>
        </div>
    </div>





    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>