<?php
	session_start();
	if(!isset($_SESSION['user_ID'])){
		header("location:login.php");
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
	<title>File Record</title>
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
                <a class="dropdown-item active" href="file_dtr.php">File</a>
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
	<h1><b>FILE DTR</b></h1>
	<hr/>
	<form method="post" action="process/insert.php" enctype="multipart/form-data">
		<label for="dateHired"><i>Start filing by selecting a date on a specific week: </i></label>
    </p><p style="color:red"><i>NOTE: Select ONE rest day with the radio button on the left side. Also, if you selected a day as a rest day, but contained time-in and time-out or absent, it will still be recorded as a rest day.</i></p>
		<input type="date">
		<div class='xml'>
		    <p><i><b>or</b> Upload an XML file:</i></p>
			<input type="file" class="form-control" accept="text/xml" name="xml"><br><br>
			<p><i><b>If you uploaded an XML file, but still opted to do the manual input - the XML file will be the one to be filed.</i></p>
			<input type="submit" class="btn btn-primary" name="xmlSubmit" formaction="../dtrFileXML.php">
      
		</div>
	</form>
	</div>
</body>
	<script type="text/javascript" src="js/elem.js"></script>
	<script type="text/javascript" src="js/file.js"></script>
</html>
<?php
}
?>