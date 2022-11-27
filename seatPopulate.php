<?php
	require 'db_init.php';
	
	//Handling invalid data cases where deleting some old data if busdate is less than today's date
	$sql="DELETE FROM busDB.bus_instances WHERE BusDate < CURDATE()";
	$result = $conn->query($sql);
    	echo $conn->error;
	
	//Handling all data based on date

	//This will be for the current days booking
	$sql_instance="SELECT * FROM busDB.bus_instances WHERE BusDate = CURDATE() ORDER BY DepTime ASC;";
    	$result = $conn->query($sql_instance);
    	$row=$result->fetch_assoc();

	if ($result->num_rows == 0) {
		$sql_instance="SELECT * FROM busDB.routes ORDER BY STime ASC;";
	    $result = $conn->query($sql_instance);
		
		//Auto-increment value for bus-id
	    $ind = 0;
	    while($row = $result->fetch_assoc()) {
	    	if ($result->num_rows > 0) {
	        $result2 = $conn->query("INSERT INTO busDB.bus_instances VALUES
	        				(DAYOFWEEK(CURDATE())*10+'".$ind."','".$row["RID"]."','".$row["Capacity"]."',CURDATE(),'".$row["STime"]."');");
	       	$ind = $ind + 1;
	       	echo $conn->error;
	   		}
	   		else break;
	    }
	}
	
	//Handling for next day
    $sql_instance="SELECT * FROM busDB.bus_instances WHERE BusDate = CURDATE() + INTERVAL 1 DAY ORDER BY DepTime ASC;";
    $result = $conn->query($sql_instance);
    $row=$result->fetch_assoc();
	if ($result->num_rows == 0) {
	    $sql_instance="SELECT * FROM busDB.routes ORDER BY STime ASC;";
	    $result = $conn->query($sql_instance);
	    $ind = 0;
	    while($row = $result->fetch_assoc()) {
	    	if ($result->num_rows > 0) {
	        $result2 = $conn->query("INSERT INTO busDB.bus_instances VALUES
	        				(DAYOFWEEK(CURDATE() + INTERVAL 1 DAY)*10+'".$ind."','".$row["RID"]."','".$row["Capacity"]."',CURDATE() + INTERVAL 1 DAY,'".$row["STime"]."');");
	       	$ind = $ind + 1;
	       	echo $conn->error;
	   		}
	   		else break;
	    }
	}

	$sql = "DELETE FROM busDB.seat_matrix WHERE BusDate < CURDATE() - INTERVAL 2 DAY";
	$result = $conn->query($sql);
    echo $conn->error;
	
	//Insert bus specific and user-specific information in seat_matrix table
    $sql = "SELECT * FROM busDB.seat_matrix WHERE BusDate = CURDATE()";
    $result = $conn->query($sql);
    echo $conn->error;
    if($result->num_rows == 0)
    {
    	$sql1="SELECT BID, RID, Seats_Left FROM busDB.bus_instances WHERE BusDate = CURDATE()";
    	$result1 = $conn->query($sql1);
    	echo $conn->error;
    	if($result1->num_rows > 0)
    	{
    		while($row = $result1->fetch_assoc())
    		{
    			for($i = 1; $i <= $row["Seats_Left"]; $i++)
    			{
    				$sql2="INSERT INTO busDB.seat_matrix VALUES (".$row["BID"].",".$row["RID"].",".$i.",NULL,CURDATE());";
    				$result2= $conn->query($sql2);
    				echo $conn->error;
    			}
    		}
    	}
    }

    $sql = "SELECT * FROM busDB.seat_matrix WHERE BusDate = CURDATE() + INTERVAL 1 DAY";
    $result = $conn->query($sql);
    echo $conn->error;
    if($result->num_rows == 0)
    {
    	$sql1="SELECT BID, RID, Seats_Left FROM busDB.bus_instances WHERE BusDate = CURDATE() + INTERVAL 1 DAY";
    	$result1 = $conn->query($sql1);
    	echo $conn->error;
    	if($result1->num_rows > 0)
    	{
    		while($row = $result1->fetch_assoc())
    		{
    			for($i = 1; $i <= $row["Seats_Left"]; $i++)
    			{
    				$sql2="INSERT INTO busDB.seat_matrix VALUES (".$row["BID"].",".$row["RID"].",".$i.",NULL,CURDATE() + INTERVAL 1 DAY);";
    				$result2= $conn->query($sql2);
    				echo $conn->error;
    			}
    		}
    	}
    }
?>
 