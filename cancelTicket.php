<!DOCTYPE html>
<html lang="en">
  <?php
  // for connecting the database
    require 'dbconn.php';
    require 'header.php';
  ?>
<body>
  <!-- get the navigation bar -->
	<?php require 'navbar.php';

	if(isset($_GET['alert']))
	{
		echo '<div class = container><div class="alert alert-success">
		  <strong>Your ticket is cancelled!</strong> 
		</div></div>';
	}?>
  <!-- display navigation elements in side bar -->
	<div id="mySidenav" class="sidenav">
	<a href="dashboard.php" id="dashboard">Go Home<span class="glyphicon glyphicon-home"></span></a>
	<a href="bookTicket.php" id="cancel">Book Tickets<span class="glyphicon glyphicon-send"></span></a>
  <a href="view_tickets.php" id="view">View Tickets<span class="glyphicon glyphicon-qrcode"></span></a>
  <a href="profile.php" id="profile">Your Profile<span class="glyphicon glyphicon-user"></span></a>
	</div>

  <div class="container">
    <h2>Cancel Booked Tickets</h2>

    <table class="table table-hover">
      <!-- show the different tickets booked by the user to cancel a particular ticket -->
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
              <th>Cancel Ticket</th>
            </tr>
          </thead>

          <tbody>
          <?php
            // initilize the database by connecting it
            require 'db_init.php';
            // get user id from the username of the user from login from current session 
            $userID = $_SESSION['UserID'];
            // get type of the user for testing purpose
            $sql="SELECT Type FROM busDB.passenger WHERE ID='$userID';";
            $result = $conn->query($sql);
            $row=$result->fetch_assoc();
            $userType=$row['Type'];
            // for displaying the tickets booked
            $sql1 = "SELECT * FROM busDB.seat_matrix JOIN busDB.routes ON busDB.seat_matrix.RID = busDB.routes.RID WHERE Passenger = '$userID' ORDER BY BusDate DESC;";
            $result1 = $conn->query($sql1);
            while($row = $result1->fetch_assoc()) {
              // display all the details of the ticket
				        echo '<tr>
						        <td>'.$row["BID"].'</td>
						        <td>'.$row["RID"].'</td>
						        <td>'.$row["BusDate"].'</td>
						        <td>'.$row["STime"].'</td>
						        <td>'.$row["Src"].'</td>
						        <td>'.$row["Dst"].'</td>
						        <td>'.$row["DTime"].'</td>
										<td>'.$row["SeatNo"].'</td>
										<td><a href="cancel_request.php?bid='.$row["BID"].'&seat='.$row["SeatNo"].'" class="btn btn-danger" role="button">Cancel</a></td>
						      </tr>';
                  // cancel the ticket frm the database code for ehich is written in cancel_request.php
				    }
          ?>
          </tbody>
      </table>
    </div>
    
    <!-- include the footer -->
    <?php require 'footer.php' ?>
</body>
 
