<!DOCTYPE html>
<html lang="en">
  <?php
  // connect to the database and include the header
      require 'dbconn.php';
      require 'header.php';
  ?>
<body>
	<?php
  // include the navigation bar
    require 'navbar.php';
    // initilize the database
    require 'db_init.php';
    // ghet the userid from present login session
    $userID = $_SESSION['UserID'];
    // get the details of ticket to be deleted
    $bid = $_GET['bid'];
    $seat = $_GET['seat'];
    // turning off the autocommit feature
    $sql_start="SET AUTOCOMMIT = OFF;";
    $result = $conn->query($sql_start); 
    // updating the database tables
    // 1.first delete the user from the seat matrix using the info of the ticket
    $sql_instance="UPDATE busDB.seat_matrix SET Passenger = NULL WHERE Passenger=".$userID." AND BID=".$bid." AND SeatNo=".$seat.";";
    // 2.updating the seats in that particular bus
    $sql_seat="UPDATE busDB.bus_instances SET Seats_Left = Seats_Left + 1 WHERE BID=".$bid.";";
    
    //only if both queries executed successfully it will commit to the database else it shows an error to the user
    if(($conn->query($sql_instance) == TRUE)&&($conn->query($sql_seat) == TRUE))
    {
      $sql_commit = "COMMIT;";
      $result = $conn->query($sql_commit);
      header('Location: cancelTicket.php?alert=1');
    }
    else
    {
      echo $conn->error;
      $sql_rollback = "ROLLBACK;";
      $result = $conn->query($sql_rollback);
      echo 'Sorry, there was a problem ';
    }
  ?>
</body>
