<!DOCTYPE html>
<html lang="en">
<?php
require 'dbconn.php'; //Sql connection php file
require 'header.php'; //The main outline of the project
?>

<body>
	<?php require 'navbar.php' ;
	
	//Make sure that after login the same user will be there for multiple pages ,else logout of the software
	if(!$_SESSION['UserID'] )
		header('location: logout.php') ;
	//If the hash 
	//elseif(!((md5($_SESSION['UserID']))==$_SESSION['CheckID'])){
		//header('location: logout.php') ;
	//}
	
	//Keeping a limit on the number of tickets bought
	if(isset($_GET['alert']))
	{
		echo '<div class = container><div class="alert alert-danger">
		  <strong>You\'re off limits! </strong> Remember, you can only book six tickets over a span of two days
		</div></div>';
	}?>
	
	<!A sidenav for easy navigation. Kept as part of most php files/>
	<div id="mySidenav" class="sidenav">
		<a href="dashboard.php" id="dashboard">Go Home<span class="glyphicon glyphicon-home"></span></a>
  		<a href="view_tickets.php" id="view">View Tickets<span class="glyphicon glyphicon-qrcode"></span></a>
  		<a href="cancelTicket.php" id="cancel">Cancel Tickets<span class="glyphicon glyphicon-remove-circle"></span></a>
  		<a href="profile.php" id="profile">Your Profile<span class="glyphicon glyphicon-user"></span></a>
	</div>

	<!The page where you see all bus details(just kept today's and tomorrow's)/>
	<div class="container">
		<h2>Available Buses</h2>
		<p>Kindly Select The Bus You Wish To Book Tickets For:</p>
		<ul class="nav nav-tabs">
		  	<li class="active"><a data-toggle="tab" href="#today">Today</a></li>
	  		<li><a data-toggle="tab" href="#tomorrow">Tomorrow</a></li>
		</ul>
		<div class="tab-content">
			<div id="today" class="tab-pane fade in active">
			<h4>Buses Leaving Today...</h4>
	
	    <?php
	    	createTable();
			function createTable() {
					require 'db_init.php';
					$userID = $_SESSION['UserID'];
			    $sql="SELECT Type FROM busDB.passenger WHERE ID='$userID';"; //Get the userid and type(student here)
	        $result = $conn->query($sql);
	        $row=$result->fetch_assoc();
	        $userType=$row['Type'];
	        $sql_instance="SELECT * FROM busDB.bus_instances JOIN busDB.routes ON busDB.routes.RID=busDB.bus_instances.RID WHERE BusDate = CURDATE() ORDER BY DepTime ASC;";
	        $result = $conn->query($sql_instance);
			//Show the column names for bus details
		    	if ($result->num_rows > 0) {
		    		echo ' <table class="table table-hover">
							    <thead>
							      <tr>
							        <th>Bus ID</th>
							        <th>Route ID</th>
							        <th>Seats Left</th>
							        <th>Departure Time</th>
							        <th>Source</th>
							        <th>Destination</th>
							        <th>Arrival Time</th>
							        <th>Book Tickets</th>
							      </tr>
							    </thead>
							    <tbody>';

				   //Display all bus details
				    while($row = $result->fetch_assoc()) {
				        echo '<tr>
						        <td>'.$row["BID"].'</td>
						        <td>'.$row["RID"].'</td>
						        <td>'.$row["Seats_Left"].'</td>
						        <td>'.$row["DepTime"].'</td>
						        <td>'.$row["Src"].'</td>
						        <td>'.$row["Dst"].'</td>
						        <td>'.$row["DTime"].'</td>';
									//If the number of seats is >15 then only send to a ticket_request php from where we update to our db
									if($row['Seats_Left']>15){
										echo '<td><a href="ticket_request.php?bid='.$row["BID"].'" class="btn btn-success" role="button">Book Now</a></td>
						      </tr>';}
									elseif($row['Seats_Left']>0){
										echo '<td><a href="ticket_request.php?bid='.$row["BID"].'" class="btn btn-warning" role="button">Book Now</a></td>
						      </tr>';}
									//If all seats are booked return 'Sold out'
									else{
										echo '<td><a href="ticket_request.php?bid='.$row["BID"].'" class="btn btn-danger disabled" role="button">Sold Out!</a></td>
						      </tr>';}

				    }
				    echo '</tbody> </table>';
				}
			}
	    ?>

		//Simple thought we added where there is schedule for tomorrow's busses
	    </div>
	    <div id="tomorrow" class="tab-pane fade">
    		<h4>Buses Leaving Tomorrow...</h4>
    	<?php
	    	createTable1();
			function createTable1() {
				require('db_init.php');
				$userID = $_SESSION['UserID'];
			    $sql="SELECT Type FROM busDB.passenger WHERE ID='$userID';";
		        $result = $conn->query($sql);
		        $row=$result->fetch_assoc();
		        $userType=$row['Type'];
		        $sql_instance="SELECT * FROM busDB.bus_instances JOIN busDB.routes ON busDB.routes.RID=busDB.bus_instances.RID WHERE BusDate = CURDATE() + INTERVAL 1 DAY ORDER BY DepTime ASC;";
		        $result = $conn->query($sql_instance);
		    	if ($result->num_rows > 0) {
		    		echo ' <table class="table table-hover">
							    <thead>
							      <tr>
							      	<th>Bus ID</th>
							        <th>Route ID</th>
							        <th>Seats Left</th>
							        <th>Departure Time</th>
							        <th>Source</th>
							        <th>Destination</th>
							        <th>Arrival Time</th>
							        <th>Book Tickets</th>
							      </tr>
							    </thead>
							    <tbody>';

				 //NO need of handling the seats part here
				    while($row = $result->fetch_assoc()) {
				        echo '<tr>
				        		<td>'.$row["BID"].'</td>
						        <td>'.$row["RID"].'</td>
						        <td>'.$row["Seats_Left"].'</td>
						        <td>'.$row["DepTime"].'</td>
						        <td>'.$row["Src"].'</td>
						        <td>'.$row["Dst"].'</td>
						        <td>'.$row["DTime"].'</td>
										<td><a href="ticket_request.php?bid='.$row["BID"].'" class="btn btn-success" role="button">Book Now</a></td>
						      </tr>';
				    }
				    echo '</tbody> </table>';
				}
			}
	    ?>
    	</div>
	</div>
	<?php require 'footer.php'; ?>
</body>
