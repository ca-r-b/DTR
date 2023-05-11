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
	<link rel="stylesheet" type="text/css" href="index.css">
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
	<title>Generated Report</title>
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
            <li class="nav-item">
                      <a class="nav-link" href="compensationReport.php">Compensation Report</a>
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
    <div class='container'>
    <br/><h1><b>Generated Report</b></h1>
    <?php
        require("connect.php"); 
        $user_ID = $_SESSION['user_ID'];   
        
        // Get selected date
        $dateGen = $_POST['monthGen'];

        // Convert selected date to month and year
        $year = substr($dateGen, 0, 4);
    	  $month = substr($dateGen, 5);
        
        // Variables for separating days that go beyond the 15th of the month
        $past15 = false;
        $closed15 = false;
        $created = false;

        // Query for retrieving DTR record
        $getQuery = mysqli_query($DBConnect, "  SELECT  date, 
                                                        day(date) as day,
                                                        timein, 
                                                        timeout,
                                                        dayAttendance, 
                                                        is_restday,
                                                        (timeout-timein)/10000.0 * if(is_restday, 0, 1) * if(dayAttendance='Present', 1, 0) as hrsRendered 
                                                        from dtr
                                                        WHERE month(date)=$month AND year(date)=$year AND user_ID=$user_ID");   

        echo "<p><i>Here is the report for " . $dateGen . " in XML format.</i></p><hr/>";

        // Generate XML
        $xml = new DOMDocument("1.0", "UTF-8");

        // Root element + 1st Children of Root
        $rootTag = $xml->createElement("report");
        $halfMonthTag = $xml->createElement("halfOfMonth");
        
        while($fetch = mysqli_fetch_array($getQuery)){
            // Insert data
            $dayAtt = $fetch["date"];
            $timein = $fetch["timein"];
            $timeout = $fetch["timeout"];
            if($fetch["dayAttendance"] == 'Present'){
              $is_absent = 0;
            }else{
              $is_absent = 1;
            }
            $is_restDay = $fetch["is_restday"];
            $hrsRendered = $fetch["hrsRendered"];

            $dayTag = $xml->createElement("day");
            $dayTag->setAttribute("date", $dayAtt);
            $timeinTag = $xml->createElement("timein", $timein);
            $timeoutTag = $xml->createElement("timeout", $timeout);
            $is_absentTag = $xml->createElement("is_absent", $is_absent);
            $is_restDayTag = $xml->createElement("is_restDay", $is_restDay);
            $hrsRendered = $xml->createElement("hrsRendered", $hrsRendered);
        
            $dayTag->appendChild($timeinTag);
            $dayTag->appendChild($timeoutTag);
            $dayTag->appendChild($is_absentTag);
            $dayTag->appendChild($is_restDayTag);
            $dayTag->appendChild($hrsRendered);
        
            $halfMonthTag->appendChild($dayTag);

            if($fetch["day"] >= 15){
                $past15 = true;
                if($past15 == true && $closed15 == false){
                    //create closing tag
                    $rootTag->appendChild($halfMonthTag);
                    $closed15 = true;
                }
                if ($closed15 == true && $created == false){
                    //create new open tag for halfOfMonth
                    $halfMonthTag = $xml->createElement("halfOfMonth");
                    $created = true;
                }
            }
        }

        $rootTag->appendChild($halfMonthTag);
        $xml->appendChild($rootTag);
        $xml->save("report.xml");

        if(@$xml->schemaValidate('report.xsd')){
          echo "  <div class='form-floating'>";
    	    echo "      <textarea class='form-control' id='floatingTextarea' style='height: 500px'>" . htmlspecialchars($xml->saveXML()) . "</textarea>";
          echo "  </div>";
        }else{
          echo "<p style='color:red'><b>Report could not be generated. Kindly double check if there is data for the selected month.</b></p>";
        }

        echo "<a href='dtr/view_dtr.php'><button class='btn btn-secondary' style='margin-top: 50px; margin-bottom: 50px;'>Go back to View DTR</button></a>";
        echo "</div>";    
    ?>
</body>

<?php } ?>