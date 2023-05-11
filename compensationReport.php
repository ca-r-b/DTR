<?php
	session_start();
	if(!isset($_SESSION['user_ID'])){
		header("location:login.php");
	} else {
		$user_ID = $_SESSION["user_ID"];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Style Sheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="index.css">
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
	<title>File Record</title>
</head>
<body>
<?php
		require("database.php");
		$db = mysqli_connect("localhost","root","","dbdtr_project"); 
		$sessionID = $_SESSION['user_ID'];
		$sql = "SELECT * FROM users WHERE user_ID ='$sessionID'";
		$sth = $db->query($sql);
		$result=mysqli_fetch_array($sth);
?>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark "> 
    <a class="navbar-brand" href="user.php"><b><i>IT-PROG Inc.</i></b></a>
    <ul class="navbar-nav mr-auto">
      <li class="nav-item ">
        <a class="nav-link" href="user.php">Dashboard</a>
      </li>
      <li class="nav-item dropdown">
      	<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        	DTR
      	</a>
	      <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
	        <a class="dropdown-item" href="dtr/view_dtr.php">View</a>
	        <a class="dropdown-item" href="dtr/file_dtr.php">File</a>
	        <a class="dropdown-item" href="dtr/update_dtr.php">Update</a>
	        <a class="dropdown-item" href="dtr/delete_dtr.php">Delete</a>
	      </div>
      </li>
			<li class="nav-item ">
        <a class="nav-link active" href="compensationReport.php">Compensation Report</a>
			</li>
			<li class="nav-item ">
                    <a class="nav-link" href="chatClient.php">Chat Support</a>
            </li>
    </ul>
    <ul class="navbar-nav ms-auto px-5">
      <li class="nav-item dropdown" id="dp-drop">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<img src="<?php echo $result['image'];?>" class="dp">
        </a>
      <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="view_account.php">View Profile</a>
        <a class="dropdown-item" href="update_account.php">Update Profile</a>
        <a class="dropdown-item" href="logout.php">Logout</a>
      </div>
    </ul>
  </nav>
  <div class="container">
		<h1><b>GENERATE COMPENSATION</b></h1>
		<p><i>Check the estimated compensation (so far) for the month that you will select.</i></p>
		<hr/>
		<form method="post" action="insert.php" enctype="multipart/form-data">
			<?php 
			if($result['position_ID'] != 0){
				echo "<label for='dateHired'><i>Get Month Report:</i></label><br>";
				if(isset($_POST['month'])){
					$month = $_POST['month'];
					echo "<input type='month' name='month' value = $month>";
					echo "<br>";
					echo "<br>";
					echo "<div class='container-fluid'>";
					if($month!=''){
						$month .= "-01";
						$script = "SELECT half	  
														, SUM(netHoursRendered) AS netHoursRendered
														, SUM(standardHours) AS standardHours
														, SUM(OTHours) AS OTHours
														, SUM(standardPay) AS standardPay
														, SUM(OTPay) AS OTPay
														, SUM(restPay) AS restPay
														, SUM(holidayPay) AS holidayPay
														, SUM(netSalary) AS netSalary
												FROM	(
														SELECT	  netHoursRendered
																, netHoursRendered-IF(OTHours < 0, 0, OTHours) AS standardHours
																, IF(OTHours < 0, 0, OTHours) AS OTHours
																, salary * (netHoursRendered-IF(OTHours < 0, 0, OTHours)) AS standardPay
																, OT * IF(OTHours < 0, 0, OTHours) AS OTPay
																, salary * restPay AS restPay
																, salary * holidayPay AS holidayPay
																, (salary * (netHoursRendered - IF(OTHours < 0, 0, OTHours) + restPay + holidayPay)) + (OT * IF(OTHours < 0, 0, OTHours)) AS netSalary
																, if(day(dates)<=15, 1, 2) AS half
														FROM	(
																	SELECT	  p.OT AS OT
																			, p.salary as salary
																			, if(d.dayAttendance='Present', FLOOR((d.timeout-d.timein)/10000) - 1, 0) as netHoursRendered
																			, if(d.dayAttendance='Present', FLOOR((d.timeout-d.timein)/10000) - 9, 0) AS OTHours
																			, if(d.is_restday, 6, 0) AS restPay
																			, if(c.event IS NOT NULL, 6, 0) AS holidayPay
																			, d.date AS dates
																	FROM	dtr d	
																			JOIN users u
																			ON d.user_ID = u.user_ID
																			JOIN position p 
																			ON u.position_ID = p.position_ID
																			LEFT JOIN calendar c 
																			ON d.date = c.date
																	WHERE	1=1 
																			AND d.user_ID=$user_ID
																			AND MONTH(d.date)=".date('m',strtotime($month))."
																			AND YEAR(d.date)=".date('Y',strtotime($month))."
														) as x
												) as t
												GROUP BY half";
												$fetch = mysqli_fetch_all(selectQuery($script));
						if($fetch==null){
							echo "<table class='table table-bordered table-hover table-danger'>";
							echo "<tr>";
							echo "<th>Month Half</th>";
							echo "<th>Total Rendered Hours</th>";
							echo "<th>Total Working Hours</th>";
							echo "<th>Total OT Hours</th>";
							echo "<th>Total Working Pay</th>";
							echo "<th>Total OT Pay</th>";
							echo "<th>Total Rest Pay</th>";
							echo "<th>Total Holiday Pay</th>";
							echo "<th>Net Salary</th>";
							echo "</tr>";
							echo "<tr>";
							echo "<td colspan=9>No Entries Found</td>";
							echo "</tr>";
							echo "</table>";
						}
						elseif(count($fetch)==1){
							echo "<table class='table table-bordered table-hover'>";
							echo "<tr>";
							echo "<th>Month Half</th>";
							echo "<th>Total Rendered Hours</th>";
							echo "<th>Total Working Hours</th>";
							echo "<th>Total OT Hours</th>";
							echo "<th>Total Working Pay</th>";
							echo "<th>Total OT Pay</th>";
							echo "<th>Total Rest Pay</th>";
							echo "<th>Total Holiday Pay</th>";
							echo "<th>Net Salary</th>";
							echo "</tr>";
							echo "<tr>";
								foreach($fetch[0] as $data)
									echo "<td>$data</td>";
							echo "</tr>";
							echo "</table>";
						}
						elseif(count($fetch)==2){
							echo "<table class='table table-bordered table-hover'>";
							echo "<tr>";
							echo "<th>Month Half</th>";
							echo "<th>Total Rendered Hours</th>";
							echo "<th>Total Working Hours</th>";
							echo "<th>Total OT Hours</th>";
							echo "<th>Total Working Pay</th>";
							echo "<th>Total OT Pay</th>";
							echo "<th>Total Rest Pay</th>";
							echo "<th>Total Holiday Pay</th>";
							echo "<th>Net Salary</th>";
							echo "</tr>";
							for($i=0; $i<2; $i++){
								echo "<tr>";
								foreach($fetch[$i] as $data)
									echo "<td>".$data."</td>";
								echo "</tr>";
							}
							echo "</table>";
						}
					}else{
						echo "<table class='table table-bordered table-hover table-danger'>";
						echo "<tr>";
						echo "<th>Month Half</th>";
						echo "<th>Total Rendered Hours</th>";
						echo "<th>Total Working Hours</th>";
						echo "<th>Total OT Hours</th>";
						echo "<th>Total Working Pay</th>";
						echo "<th>Total OT Pay</th>";
						echo "<th>Total Rest Pay</th>";
						echo "<th>Total Holiday Pay</th>";
						echo "<th>Net Salary</th>";
						echo "</tr>";
						echo "<tr>";
						echo "<td colspan=9>No Entries Found</td>";
						echo "</tr>";
						echo "</table>";
					}
				}
				else{
					echo "<input type='month' name='month'>";
					echo "<br>";
					echo "<br>";
					echo "<div class='container-fluid'>";
				}
				
			echo "</div>";
				echo "<input type='submit' class='btn btn-primary' name='xmlSubmit' formaction='compensationReport.php' value='Generate'>";
				echo "</form>";
			echo"</div>";
			}else{
				echo "<p style='color:red'><i>Update your company position first in Update Profile section.</i></p>";
			}
			
			?>

			

</body>
	<script type="text/javascript" src="js/elem.js"></script>
	<script type="text/javascript" src="js/file.js"></script>
</html>
<?php
}
?>