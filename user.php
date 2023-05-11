<?php
	session_start();
	if(!isset($_SESSION['username'])){
		header("location:login.php");
	} else {
?>

<html>
    <head>
    <style>
    /* Stackoverflow preview fix, please ignore */
    .navbar-nav {
      flex-direction: row;
    }
    
    .nav-link {
      padding-right: .5rem !important;
      padding-left: .5rem !important;
    }
    
    /* Fixes dropdown menus placed on the right side */
    .ml-auto .dropdown-menu {
      left: auto !important;
      right: 0px;
    }

  </style>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Style Sheets -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="index.css">
        <!-- Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
        <title>User Profile</title>
    </head>
	<body>
		<?php
			$script = "SELECT * FROM users WHERE user_ID='".$_SESSION['user_ID']."'";
			include("database.php");

			$fetch = mysqli_fetch_array(selectQuery($script));
			$logID = $fetch['user_ID'];
			$logUser = $fetch['username'];
			$logStat = $fetch['status'];
			$logDate = $fetch['dateHired'];
			$logFName = $fetch['fName'];
      $logLName = $fetch['lName'];
      $logImage = $fetch['image'];
		?>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark "> 
            <a class="navbar-brand" href="user.php"><b><i>IT-PROG Inc.</i></b></a>
            <ul class="navbar-nav mr-auto">
              <li class="nav-item ">
                    <a class="nav-link active" href="user.php">Dashboard</a>
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
                    <a class="nav-link" href="compensationReport.php">Compensation Report</a>
            </li>
            <li class="nav-item ">
                    <a class="nav-link" href="chatClient.php">Chat Support</a>
            </li>
            </ul>
           
            <ul class="navbar-nav ms-auto px-5">
              <li class="nav-item dropdown" id="dp-drop">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?php echo "<img src='$logImage' class='dp'>"?>
                </a>
              <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="view_account.php">View Profile</a>
                <a class="dropdown-item" href="update_account.php">Update Profile</a>
                <a class="dropdown-item" href="logout.php">Logout</a>
              </div>
            </ul>
        </nav>
		<div class="container">
            <div class="jumbotron jumbotron-fluid">
            <div class="container">
            <h1 class="display-4">Dashboard</h1>
            <hr>
            <h4> <?php echo "<p>Good day, ". $logFName ." ".$logLName."!</p>";?></h4>
            <p><i>What would you like to do?</i></p>
            </div>
		</div>
        <div class="row">
          <div class="col">
            <div class="card border-dark mb-3">
              <div class="card-body">
                <h5 class="card-title"><b>DTR</b></h5>
                <p class="card-text">Check, file, update, delete or generate a report of Daily Time Record.</p>
                <a href="dtr/view_dtr.php" class="btn btn-outline-primary btn-sm">View</a>
                <a href="dtr/file_dtr.php" class="btn btn-outline-primary btn-sm">File</a>
                <a href="dtr/update_dtr.php" class="btn btn-outline-primary btn-sm">Update</a>
                <a href="dtr/delete_dtr.php" class="btn btn-outline-primary btn-sm">Delete</a>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card border-dark mb-3">
              <div class="card-body">
                <h5 class="card-title"><b>Report</b></h5>
                <p class="card-text">Know your estimated salary for the month.</p>
                <a href="compensationReport.php" class="btn btn-outline-primary btn-sm">Compensation Report</a>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
        <div class="col">
            <div class="card border-dark mb-3">
              <div class="card-body">
                <h5 class="card-title"><b>Account</b></h5>
                <p class="card-text">View or Edit your employee information. Here, you can also update your company position and upload your display picture.</p>
                <a href="view_account.php" class="btn btn-outline-primary btn-sm ">View</a>
                <a href="update_account.php" class="btn btn-outline-primary btn-sm">Update</a>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card border-dark mb-3">
              <div class="card-body">
                <h5 class="card-title"><b>IT-PROG Inc. Support</b></h5>
                <p class="card-text">Hello! This is the IT-PROG Inc. chat support. If you are experiencing difficulty in our website, we are here to help. </p>
                <a href="chatClient.php" class="btn btn-outline-primary btn-sm">Go --></a>
              </div>
            </div>
          </div>
        </div>

        
    </div>
	</body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

</html>

<?php } ?>