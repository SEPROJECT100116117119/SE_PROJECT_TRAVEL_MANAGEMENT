<?php
require('dbconn.php');
?>


<!DOCTYPE html>
<html>

<!-- Head -->
<head>

	<title>
	PES University Transport Management System</title>

	<!-- Meta-Tags -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="keywords" content="busDB, 24x7 Institute Bus Booking Portal" />
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<!-- //Meta-Tags -->

	<!-- Style --> <link rel="stylesheet" href="css/style.css" type="text/css" media="all">

	<!-- Fonts -->
		<link href="//fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
	<!-- //Fonts -->
	<!-- JQuery -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

</head>
<!-- //Head -->

<!-- Body -->
<body>

	<h1> PES University Transport Management System</h1>
	

	<br>
<!--    creating the input form-->
	<div class="container">

		<div class="login">
			<h2>Sign In</h2>
			<form action="index.php" method="post">
			<p> Sign In As </p>
				<select name="Type" id="type">
					<option value="Student">Student</option>
					<option value="Faculty">Faculty</option>
					<option value="Staff">Staff</option>

				</select>
				<br>
				<br>
				<input type="text" Name="UserID" placeholder="User ID" required="">
				<input type="password" Name="Password" placeholder="Password" required="">


			<div class="send-button">
				<!--<form>-->
					<input type="submit" name="signin"; value="Sign In">
				</form>
			</div>

			<div class="clear"></div>
		</div>

		<div class="register">
			<h2>Sign Up</h2>
			<form action="index.php" method="post">
				<p> Sign Up As </p>
				<select name="Type" id="Type">
					<option value="Student">Student</option>
					<option value="Faculty">Faculty</option>
					<option value="Staff">Staff</option>
					<!--<option value="Guest">Guest</option>-->
				</select>
				<br> <br>
				<script type="text/javascript">
					$(document).ready(function(){
						$('#Type').on('change', function(){
							if(this.value == 'Faculty'){
								$("#batch").hide();//hiding the element
								$("#dept").show();//showing the faculty
							}
							else if(this.value == 'Staff'){
								$("#batch").hide();
								$("#dept").hide();
							}
							else if(this.value == 'Student'){
								$("#batch").show();
								$("#dept").show();
							}
						});
					});
				</script>
				<input type="text" Name="UserID" placeholder="User ID" required="">
				<input type="text" Name="Name" placeholder="Name" required>
				<input type="password" Name="Password" placeholder="Password" required>
			

				<br><br>

			<div class="send-button">
			    <input type="submit" name="signup" value="Sign Up">
			    </form>
			</div>
			<p>Hope you have fun :)</a></p>
			<div class="clear"></div>
		</div>

		<div class="clear"></div>

	</div>

	<div class="footer w3layouts agileits">
		<p> SE Project UE20CS302 </a></p>
		<p><a class="underline" href="aboutus.php">About the Project</a></p>
	</div>

<?php
if(isset($_POST['signin']))
{$u=$_POST['UserID'];
 $p=md5($_POST['Password']);
 $c=$_POST['Type'];
//we are getting the details from the post function

 $sql="SELECT * FROM busDB.passenger WHERE ID='$u' AND Type='$c'";

 $result = $conn->query($sql);
$row = $result->fetch_assoc();
$x=$row['Pwd'];//fetching the password and type  from the database
$y=$row['Type'];

//mapping the passwords(x,p) and also checking if user and password fields are not empty then only allowing
if(strcasecmp($x,$p)==0 && !empty($u) && !empty($p))
  {//echo "Login Successful";
   	$_SESSION['UserID']=$u;
		$_SESSION['CheckID']=md5($u);
  	header('location:passenger/dashboard.php');
  }//we have logged in and have also ensured that
else
 { echo "<script type='text/javascript'>alert('Failed to Login! Incorrect RollNo or Password')</script>";
}


}

if(isset($_POST['signup']))
{
	$userID=$_POST['UserID'];
	$password=md5($_POST['Password']);
	$name=$_POST['Name'];
	$batch=1;
	$dept='CSE';// we are assuming certain default values
	$bloodG='A';
	$type=$_POST['Type'];

	$conn->query('SET autocommit = OFF;');
    //we are not auto commiting but manually commiting
    //this is the insertion stage
	$sql0 = "START TRANSACTION;";
	$sql1="INSERT INTO busDB.passenger (ID,Type,Pwd) VALUES ('$userID','$type','$password');";
	if($type=='Student')
	{
		$sql2="INSERT INTO busDB.student (RollNo, SName, Batch, Branch, BloodG) VALUES ('$userID','$name', '$batch', '$dept', '$bloodG');";
	}
	else if($type=='Faculty')
		$sql2="INSERT INTO busDB.faculty (FID, FName, Dept, BloodG) VALUES ('$userID','$name', '$dept', '$bloodG');";
	else if($type=='Staff')
		$sql2="INSERT INTO busDB.staff (EID, EName, BloodG) VALUES ('$userID','$name','$bloodG');";

	if (($conn->query($sql0) === TRUE) && ($conn->query($sql1) === TRUE) && ($conn->query($sql2) === TRUE) ){
		echo "<script type='text/javascript'>alert('Registration Successful')</script>";
		$conn->query('COMMIT;');//will be executed only if the prev queries are successful
	} else {
		$conn->query('ROLLBACK;');
		echo "Error: " . $sql . "<br>" . $conn->error;
		echo "<script type='text/javascript'>alert('User Exists ".$conn->error."')</script>";
	}//this is to check if user already exists
}

?>

</body>
<!-- //Body -->

</html>
