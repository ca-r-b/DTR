<?php
	session_start();
	if(!isset($_SESSION['user_ID'])){
		header("location:user.php");
	} else {
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Style Sheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../index.css">
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
	<title>View Record</title>
</head>

<body>
	<?php
		require("../database.php");
		$db = mysqli_connect("localhost","root","","dbdtr_project"); 
		$sessionID = $_SESSION['user_ID'];
		$sql = "SELECT * FROM users WHERE user_ID ='$sessionID'";
		$sth = $db->query($sql);
		$result=mysqli_fetch_array($sth);
		if(isset($_POST['month']) && $_POST['month']!=''){
			$monthYear = $_POST['month'];
			echo "<input type='hidden' id='month'value=".$monthYear."> </div>";
			$year = substr($monthYear,0,4);
			$month = substr($monthYear,5);
			$user_ID=$_SESSION['user_ID'];
			
			$script = " SELECT 	day(d.date),
								dayAttendance, 
								timein, 
								timeout, 
								is_restday, 
								event 
						FROM dtr d 
						LEFT JOIN calendar c ON month(d.date) = month(c.date) AND 
												day(d.date) = day(c.date) 
						WHERE 	month(d.date)=$month and 
								year(d.date)=$year and 
								user_ID=$user_ID 
						ORDER BY d.date";

			$fetch = mysqli_fetch_all(selectQuery($script));
			
			for($i=0; $i<count($fetch);$i++){
				echo "<div class='d".$fetch[$i][0]."'>";
					echo "<input type='hidden' 	class='attendance' 	value='".$fetch[$i][1]."'>";
					echo "<input type='hidden' 	class='timein' 		value='".$fetch[$i][2]."'>";
					echo "<input type='hidden' 	class='timeout' 	value='".$fetch[$i][3]."'>";
					echo "<input type='hidden' 	class='restday' 	value='".$fetch[$i][4]."'>";
					echo "<input type='hidden' 	class='event' 		value='".$fetch[$i][5]."'>";
				echo "</div>";
			}
		}
	?>

	<nav class="navbar navbar-expand-lg navbar-dark bg-dark "> 
        <a class="navbar-brand" href="../user.php"><b><i>IT-PROG Inc.</i></b></a>
        <ul class="navbar-nav mr-auto">
          <li class="nav-item ">
                <a class="nav-link" href="../user.php">Dashboard</a>
            </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            DTR
          </a>
          <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
            <a class="dropdown-item active" href="view_dtr.php">View</a>
            <a class="dropdown-item" href="file_dtr.php">File</a>
            <a class="dropdown-item" href="update_dtr.php">Update</a>
            <a class="dropdown-item" href="delete_dtr.php">Delete</a>
          </div>
            </li>
						<li class="nav-item ">
							<a class="nav-link" href="../compensationReport.php">Compensation Report</a>
            </li>
						<li class="nav-item ">
                    <a class="nav-link" href="../chatClient.php">Chat Support</a>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto px-5">
          <li class="nav-item dropdown" id="dp-drop">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<img src="../<?php echo $result['image'];?>" class="dp">
            </a>
          <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="../view_account.php">View Profile</a>
            <a class="dropdown-item" href="../update_account.php">Update Profile</a>
            <a class="dropdown-item" href="../logout.php">Logout</a>
          </div>
        </ul>
    </nav>
	
	<div class="container">
		<h1><b>VIEW DTR</b></h1>
		<p><i>View the DTRs that you have filed for the month by selecting a date.</i></p>
		<hr/>
		<div class="legend">
			<h3><b><u>Legend</u></b></h3>
			<ul>
				<li>
					<b>Absent</b>
					<ul>
						<li>Work Day <div class="color t-absent"></div></li>
						<li>Holiday/Rest Day <div class="color t-rest"></div></li>
					</ul>
				</li>
				<li><b>Present</b>
					<ul>
						<li>Work Day <div class="color t-present"></div></li>
						<li>Holiday <div class="color t-extra"></div></li>
					</ul>
				</li>
			</ul>

		</div>
		<form method="post">
			<label>Month For:</label>
			<input type="month" name="month" <?php 
				if(isset($_POST['month'])) 
				echo "value = '".$_POST['month']."'";
			?>>
			<br/><br/>
			<div class="calendar">
				<div class="week"><div class="day">---</div></div>
				<div class="week">
					<div class="day">Sunday</div>
					<div class="day">Monday</div>
					<div class="day">Tuesday</div>
					<div class="day">Wednesday</div>
					<div class="day">Thursday</div>
					<div class="day">Friday</div>
					<div class="day">Saturday</div>
				</div>
				<?php
					for($i=0; $i<6; $i++){
						echo "<div class='week week-".($i + 1)."'>";
						for($j=1; $j<=7; $j++){
							echo "<div class='day day-".($i * 7 +$j)."'>";
								echo "<div class='date day-".($i * 7 +$j)."-date'></div>";
								echo "<div class='in day-".($i * 7 +$j)."-in'></div>";
								echo "<div class='out day-".($i * 7 +$j)."-out'></div>";
								echo "<div class='event day-".($i * 7 +$j)."-event'></div>";	
							echo "</div>";			
						}
						echo "</div>";
					}
					$k=0;
				?>
			</div>
			<input id="invi" type="submit" name="invi" formaction="view_dtr.php">
		</form>
		<?php
			if(isset($_POST['month']) && $_POST['month']!=''){
				echo "<form method='post' action='../generateRep.php'>";
				echo "	<input type='submit' name='reportSbt' class='btn btn-primary' value='Generate Report for the Month in XML'>";
				echo "	<input type='hidden' name='monthGen' target='_blank' value='" . $monthYear . "'>";
				//echo "  "
				echo "</form>";
			}
		?>
	</div>
</body>
<script src="js/view_DTR.js"></script>
</html>
<?php
}
?>