<?php
	session_start();
	if(!isset($_SESSION['user_ID'])){
		header("location:login.php");
	} else {
		$user_ID = $_SESSION['user_ID'];
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
	<title>Update Record</title>
</head>

<body>
<?php
		require("../database.php");
		$db = mysqli_connect("localhost","root","","dbdtr_project"); 
		$sessionID = $_SESSION['user_ID'];
		$sql = "SELECT * FROM users WHERE user_ID ='$sessionID'";
		$sth = $db->query($sql);
		$result=mysqli_fetch_array($sth);
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
                <a class="dropdown-item" href="view_dtr.php">View</a>
                <a class="dropdown-item" href="file_dtr.php">File</a>
                <a class="dropdown-item active" href="update_dtr.php">Update</a>
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
	<h1><b>UPDATE DTR</b></h1>
	<p><i>Start updating your DTR by selecting a date.</i></p><p style="color:red"><i>NOTE: Select ONE rest day with the radio button on the left side. Also, if you selected a day as a rest day, but contained time-in and time-out or absent, it will still be recorded as a rest day.</i></p>
	<hr/>
	<form method="post" action="process/update.php"
		
		<label>Week of:</label>
		<input type="date"  name="i_date" <?php 
			if(isset($_POST['i_date'])) 
			echo "value = '".$_POST['i_date']."'";
		?>><br>
		<?php
			if(isset($_POST['i_date'])&&$_POST['i_date']!=''){
				$startDate = $_POST['startDate'];
				$endDate = $_POST['endDate'];
				$script = "SELECT date,dayAttendance, timein, timeout, is_restday FROM dtr WHERE user_ID=$user_ID and date BETWEEN '$startDate' and '$endDate' order by date;";

				$rs=selectQuery($script);
				$fetch = mysqli_fetch_all($rs, MYSQLI_BOTH);
				echo "<div>";
				
				if(!count($fetch))
					echo "No Entry on this week.";
				for($i=0; $i<count($fetch);$i++){
					echo "<div class='parent day".($i+1)."'>";
					echo "<div class='div1'>";
					if($fetch[$i][4]==1)
						echo "<input type='radio' class='r".($i+1)."' name='rest' value='".($i+1)."' checked>";
					else
						echo "<input type='radio' class='r".($i+1)."' name='rest' value='".($i+1)."'>";
					echo "</div>";
					echo "<div class='div2'>";//date
					echo "<input type='hidden' name='date[]' value='".$fetch[$i][0]."'>";
					echo "Date: ".$fetch[$i][0];
					echo "</div>";
					echo "<div class='div3'>";
					if($fetch[$i][1]=="Absent" && ($fetch[$i][4])!=1)
						echo "<input class='cb".($i+1)."' name='absent".($i+1)."' type='checkbox' value='absent' checked>Absent";
					else if(($fetch[$i][4])==1)
						echo "<input class='cb".($i+1)."' name='absent".($i+1)."' type='checkbox' value='absent' onclick='return false;'>Absent";
					else
						echo "<input class='cb".($i+1)."' name='absent".($i+1)."' type='checkbox' value='absent'>Absent";
					echo "</div>";
					echo "<div class='div4'>Time</div>";
					echo "<div class='div5'>IN</div>";
					echo "<div class='div6'>OUT</div>";
					echo "<div class='div7'>";
					if($fetch[$i][1]!="Absent" && ($fetch[$i][4])!=1)
						echo "<input type='time' class='in".($i+1)."' name='in[]' value='".$fetch[$i][2]."' required'>";
					else
						echo "<input type='time' class='in".($i+1)."' name='in[]' readOnly>";
					echo "</div>";
					echo "<div class='div8'>";
					if($fetch[$i][1]!="Absent" && ($fetch[$i][4])!=1)
						echo "<input type='time' class='out".($i+1)."' name='out[]' value='".$fetch[$i][3]."' required'>";
					else
						echo "<input type='time' class='out".($i+1)."' name='out[]' readOnly>";
					echo "</div>";
					echo "<div class='div9'>";
					echo "</div>";
					echo "</div>";
				}
				echo "</div>";
			}else{
				echo "<br/>Select a Day.";
			}
		?>
		<input id="invi" type="submit" name="invi" class="btn btn-primary"  formaction="update_dtr.php"><!-- change to update if wrong -->
	</form>
	
	</div>
</body>
<script type="text/javascript" src="js/elem.js"></script>
<script type="text/javascript" src="js/update.js"></script>
</html>
<?php
}
?>