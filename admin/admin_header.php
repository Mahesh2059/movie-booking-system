<?php

include("../conn.php")


?>

<!doctype html>
<html lang="en">
  <head>
    <title>Admin-panel -online movie ticket booking system </title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="icon" href="images/logo.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    
   <style>
    .btn-cancel {
        margin-top: 10px;
    }
     *{box-sizing:border-box}
    
     
     

       /* Cinema Screen Styles */
.screen-container {
  margin: 2rem auto;
  max-width: 800px;
}

.screen {
  background: #333;
  color: white;
  text-align: center;
  padding: 1rem 0;
  margin-bottom: 2rem;
  border-radius: 4px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  position: relative;
}

.screen:after {
  content: "";
  position: absolute;
  bottom: -15px;
  left: 0;
  right: 0;
  height: 15px;
  background: linear-gradient(to bottom, rgba(0,0,0,0.4), transparent);
}

/* Seating Grid with Stable Layout */
.seating-grid {
  display: grid;
  grid-template-columns: repeat(10, 1fr);
  gap: 8px;
  margin: 0 auto;
  width: fit-content;
}

.seat {
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #e0e0e0;
  border-radius: 4px;
  cursor: pointer;
  transition: all 0.2s ease;
  font-size: 12px;
  font-weight: 500;
  user-select: none;
}

.seat:hover {
  background: #d0d0d0;
  transform: scale(1.05);
}

.seat.selected {
  background: #4CAF50;
  color: white;
}

.seat.booked {
  background: #f44336;
  color: white;
  cursor: not-allowed;
}

/* Legend for Seat Status */
.seat-legend {
  display: flex;
  justify-content: center;
  gap: 1rem;
  margin-top: 2rem;
}

.legend-item {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.legend-color {
  width: 20px;
  height: 20px;
  border-radius: 3px;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
  .seating-grid {
    grid-template-columns: repeat(10, 30px);
    gap: 5px;
  }
  
  .seat {
    width: 30px;
    height: 30px;
    font-size: 10px;
  }
}
        a {
            text-decoration: none;
        }
    </style>

  </head>
  <body>

  <nav class="navbar navbar-expand-md navbar-dark" style="background-color: maroon;">
    <a class="navbar-brand" href="dashboard.php"><img src="..//images/logo.png" style="width: 70px;"></a>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse"
        data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
           <h5> <li class="nav-item"><a class="nav-link" href="dashboard.php">Admin page for online ticket booking system</a></li></h5>

        </ul>

        <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link" href="../admin/index.php">Logout</a>
                </li>
            <?php  ?>
        </ul>
    </div>
</nav>
