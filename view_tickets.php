<!DOCTYPE html>
<html lang="en">
  <?php
  // for the connection to database
    require 'dbconn.php';
  // showing the header
    require 'header.php';
  ?>

<body>
  <!-- includes the navigation bar -->
	<?php require 'navbar.php';?>
  <!-- shows all the navigation options in sidebar -->
  <div id="mySidenav" class="sidenav">
  <a href="dashboard.php" id="dashboard">Go Home<span class="glyphicon glyphicon-home"></span></a>
	<a href="cancelTicket.php" id="cancel">Cancel Tickets<span class="glyphicon glyphicon-remove-circle"></span></a>
  <a href="bookTicket.php" id="view">Book Tickets<span class="glyphicon glyphicon-send"></span></a>
  <a href="profile.php" id="profile">Your Profile<span class="glyphicon glyphicon-user"></span></a>

</div>
  <div class="container">
    <h2>Booked Ticket history</h2>
    <table class="table table-hover">
      <!-- Displays the information of the ticket booked -->
          <thead>
            <tr>
              <th>Bus ID</th>
              <th>Route ID</th>
              <th>Journey Date</th>
              <th>Departure Time</th>
              <th>Source</th>
              <th>Destination</th>
              <th>Arrival Time</th>
              <th>Seat Number</th>
              <th>Digital Ticket</th>
            </tr>
          </thead>

          <tbody>
          <?php
            // initializes database by running thde db_init.php
            require 'db_init.php';
            // this will store the userid of the user from present session and store it in userID
            $userID = $_SESSION['UserID'];
            // get the type of the user that has login for testing purpose
            $sql="SELECT Type FROM busDB.passenger WHERE ID='$userID';";
            $result = $conn->query($sql); 
            $row=$result->fetch_assoc();//fetch the values of queries which has run
            $userType=$row['Type'];

            // get the details of tickets that has been booked by the user
            $sql1 = "SELECT * FROM busDB.seat_matrix JOIN busDB.routes ON busDB.seat_matrix.RID = busDB.routes.RID WHERE Passenger = '$userID' ORDER BY BusDate DESC;";
            $result1 = $conn->query($sql1);
            // get the details of all the values of the tickets bookes
            while($row = $result1->fetch_assoc()) {
				        echo '<tr>
						        <td>'.$row["BID"].'</td>
						        <td>'.$row["RID"].'</td>
						        <td>'.$row["BusDate"].'</td>
						        <td>'.$row["STime"].'</td>
						        <td>'.$row["Src"].'</td>
						        <td>'.$row["Dst"].'</td>
						        <td>'.$row["DTime"].'</td>
										<td>'.$row["SeatNo"].'</td>
                    <td><a href="ticket.php?seat='.$row['SeatNo'].'&bid='.$row['BID'].'" class="btn btn-info" role="button">View</a></td>
						      </tr>';
				    }
          ?>
          </tbody>
      </table>
    </div>
    <!-- for including footer in the project -->
    <?php require 'footer.php' ?>
</body>
