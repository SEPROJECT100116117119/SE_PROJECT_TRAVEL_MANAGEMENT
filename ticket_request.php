<!DOCTYPE html>
<html lang="en">
  <?php
      require 'dbconn.php';
      require 'header.php';
  ?>
<body>
	<?php
    require 'navbar.php';
    require 'db_init.php';
    $userID = $_SESSION['UserID'];
    $bid = $_GET['bid'];
	
	//Get the userid and busid based on which we carry out further operations
    $sql_instance="SELECT * FROM busDB.seat_matrix WHERE Passenger=".$userID." AND (BusDate = CURDATE() OR BusDate = CURDATE() + INTERVAL 1 DAY);";
    $result = $conn->query($sql_instance);


    if($result->num_rows < 6)
    {
      $sql_instance="SELECT * FROM busDB.seat_matrix WHERE BID=".$bid." AND Passenger IS NULL;";
      $result = $conn->query($sql_instance);
      echo $conn->error;
      $row = $result->fetch_assoc();
      $sql_start="SET AUTOCOMMIT = OFF;";
      $result = $conn->query($sql_start);
	
	//We take the userid and his name after which update our seat_matrix table where we also decrease the seat_no by 1
      $sql_entry="UPDATE busDB.seat_matrix SET Passenger = ".$userID." WHERE BID=".$bid." AND SeatNo=".$row['SeatNo'].";";
      $sql_seat="UPDATE busDB.bus_instances SET Seats_Left = Seats_Left - 1 WHERE BID=".$bid.";";

	//After updating we have to commit our changes
      if(($conn->query($sql_entry) == TRUE)&&($conn->query($sql_seat) == TRUE))
      {
        $sql_commit = "COMMIT;";
        $result = $conn->query($sql_commit);
        $redurl = "ticket.php?seat=".$row['SeatNo']."&bid=".$row['BID'];
        redirect($redurl);
      }

	//Handling condition when there is a error and you rollback to the last commit
      else
      {
        echo $conn->error;
        $sql_rollback = "ROLLBACK;";
        $result = $conn->query($sql_rollback);
        echo 'Sorry, there was a problem :(';
        Fail();
      }
    }
	//When we reach daily limit just take back to booking page
    else
    {
      $redurl="bookTicket.php?alert=0";
      redirect($redurl);
      Limit();
    }
    function redirect($url) {
        ob_start();
        header('Location: '.$url);
        ob_end_flush();
        die();
    }
    function Fail() {
      echo 'Sorry, there was a problem :(';
    }
    function Limit() {
      echo 'Sorry, you have exceeded the daily ticket limit!';
    }
  ?>
</body>
