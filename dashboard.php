<!DOCTYPE html>
<html lang="en">
<?php
// this includes the header to  display which is created
require 'header.php';
?>
<body>
<style>
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    footer {
      background-color: #f2f2f2;
      padding: 25px;
    }

    .glyphicon.glyphicon-send {
    font-size: 150px;
    }

    .glyphicon.glyphicon-bookmark {
    font-size: 150px;
    }

    .glyphicon.glyphicon-remove-circle {
    font-size: 150px;
    }

    .glyphicon.glyphicon-list-alt {
    font-size: 150px;
    }

    .glyphicon.glyphicon-user {
    font-size: 150px;
    }

    .glyphicon.glyphicon-edit {
    font-size: 150px;
    }
    .glyphicon.glyphicon-bullhorn {
    font-size: 150px;
    }
    .glyphicon.glyphicon-qrcode {
    font-size: 150px;
    }
  </style>
  <!-- this includes the navigation bar from navbar.php -->
<?php require 'navbar.php';require 'seatPopulate.php'; ?>



</div><br><br>
<div class="container-fluid bg-3 text-center">

  <h2><i class="fas fa-ticket-alt"></i>&nbsp;Ticket Window&nbsp;<i class="fas fa-ticket-alt"></i></h2><br>
  <div class="row">

    <div class="col-sm-3">
      <!-- booking Ticket -->
      <h3>Book Ticket</h3><br>
      <!-- Button to book ticket -->
      <button type = "button" class = "btn btn-link btn-block">
        <!-- when button is clicked navigates to bookticket.php  -->
        <a href="bookTicket.php"><span class="glyphicon glyphicon-send"></span></a>
      </button>

    </div>
    <div class="col-sm-3">
      <!-- viewing Ticket -->
      <h3>View Ticket</h3><br>
      <!-- Button to view ticket -->
      <button type = "button" class = "btn btn-link btn-block">
        <!-- when button is clicked navigates to viewticket.php  -->
        <a href="view_tickets.php"><span class="glyphicon glyphicon-qrcode"></span></a>
      </button>
    </div>

    <div class="col-sm-3">
      <!-- Cancelling ticket -->
      <h3>Cancel Ticket</h3><br>
      <!-- Button to cancel tickets -->
      <button type = "button" class = "btn btn-link btn-block">
        <!-- when button is clicked it navigates to canceltickets.php  -->
        <a href="cancelTicket.php"><span class="glyphicon glyphicon-remove-circle"></span></a>
      </button>
    </div>

    <div class="col-sm-3">
      <!-- To view the bus Schedule -->
      <h3>Weekly Bus Schedule</h3><br>
      <!-- Button to view Schedule -->
      <button type = "button" class = "btn btn-link btn-block">
        <!-- when button is clicked it navigates to schedule.php  -->
        <a href="schedule.php"><span class="glyphicon glyphicon-list-alt"></span></a>
      </button>
    </div>

  </div>
</div><br><br>



<div class="container-fluid bg-3 text-center">

  <div class="col-sm-3">
    <!-- Viewing the profile of user -->
      <h3>Your Profile</h3><br>
      <!-- button to show the profile -->
      <button type = "button" class = "btn btn-link btn-block">
        <!-- When the button is clicked it navigates to profile.php -->
        <a href="profile.php"><span class="glyphicon glyphicon-user"></span></a>
      </button>
    </div>
  
  <div class="row">
    <div class="col-sm-3">
      <!-- to show information about the project -->
      <h3>About The Project</h3><br>
      <!-- button to show about us page -->
      <button type = "button" class = "btn btn-link btn-block">
        <!-- When the button is clicked it navigated to aboutus.php -->
        <a href="../aboutus.php"><span class="glyphicon glyphicon-bookmark"></span></a>
      </button>
    </div>
    
   
  </div>
</div><br><br>

<!-- for viewing the footer for every page -->
<?php require 'footer.php';?>

</body>
</html>
