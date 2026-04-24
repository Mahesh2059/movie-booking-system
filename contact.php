<?php
include("header.php");
include_once("conn.php");


if(isset($_POST["btn_submit"]))
{
    $name=$_POST["name"];
    $email=$_POST["email"];
    $no=$_POST["number"];
    $messg=$_POST["message"];

    $sql="insert into contact values(0,'$name','$email','$no','$messg',now())";
   $con=new connec();
   $con->insert($sql); 
}
?>

<section style="min-height: 100vh;">
  <div class="container-fluid" style="color: maroon;">
    <!-- Title -->
    <div class="row">
      <div class="col-12 text-center my-4">
        <h1>Contact Us</h1>
        <h5>Get in touch</h5>
        <p>we are expecting a good suggestion from you.Send us a message about any queries and we will respond.</p>
      </div>
    </div>

    <!-- Content Row -->
    <div class="row">
      <!-- Left Side (Colored Panel) -->
    <div class="col-md-6 mb-5" style="background-color: maroon; border-radius: 30px; min-height: 500px;">
        <h2 class="mt-5 pl-5" style="color:white">Contact Information </h2>
        <p class="mt-1 pl-5" style="color: white;">
            we will get back you with in 24 hours.
        </p>
            <p class="mt-5" style="color: white;"><i class="fa fa-phone mt-3"></i>087530456</p>
            <p class="mt-3" style="color: white;"><i class="fa fa-envelope  mt-3"></i>&nbsp;moviehouse@gmail.com</p>
            <p class="mt-3" style="color: white;"><i class="fa fa-marker  mt-3"></i>&nbsp;moviehouse@gmail.com</p>

         <h2 class="mt-1 " style="color:white">join us </h2>
        <div class="mt-5">
            <a href="#" class="me-3" style="color: white;"><i class="fa fa-facebook-square fa-2x"></i></a>
            <a href="#" class="me-3 ml-3" style="color: white;"><i class="fa fa-instagram fa-2x"></i></a>
        
        </div>
             <!-- You can add image or icons here if needed -->

      </div>

      <!-- Right Side (Form) -->
      <div class="col-md-6 d-flex align-items-center p-4">
        <form method="post" style="width: 100%; max-width: 500px; margin: auto;">
          
          <label for="username"><b>Your Name</b></label>
          <input type="text" name="name" id="username" required 
                 placeholder="Enter name"
                 style="border-radius: 30px; width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc;">

          <label for="email"><b>Email</b></label>
          <input type="email" name="email" id="email" required 
                 placeholder="Enter Email"
                 style="border-radius: 30px; width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc;">

          <label for="number"><b>Number</b></label>
          <input type="tel" name="number" id="number" required 
                 placeholder="Enter number"
                 style="border-radius: 30px; width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc;">

          <label for="message"><b>Message</b></label>
          <textarea name="message" id="message" rows="6" required
                    placeholder="Enter your message"
                    style="resize: none; width: 100%; border-radius: 15px; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc;"></textarea>

          <button type="submit" name="btn_submit" class="btn"
                  style="background-color: maroon; color: white; border: none; padding: 12px 30px;
                  border-radius: 10px; width: 100%;">Send Message</button>
        </form>
      </div>
    </div>
  </div>
</section>

<?php
include("footer.php");
?>