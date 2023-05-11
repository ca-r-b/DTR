<?php
	session_start();
	if(!isset($_SESSION['user_ID'])){
		header("location:login.php");
	} else {
?>
<html>
<?php
    require('database.php');
    $xml = simplexml_load_file($_FILES['xml']['name']);

    $xmlReader = new \XMLReader();
    $xmlReader->open($_FILES['xml']['name']);
    $xmlReader->setParserProperty(\XMLReader::VALIDATE, true);
    $xmlReader->setSchema('DTR.xsd');

    \libxml_use_internal_errors(true);

    //Check if XML is valid
    $isValid = true;
    while ($xmlReader->read()) {
        if (!$xmlReader->isValid()) {
            // Prompt user that it is invalid
            $isValid = false;
            break;
        }
    }
    
	if($isValid)
	{
		$xmlFile = file_get_contents($_FILES['xml']['tmp_name']);
		$xml = simplexml_load_string($xmlFile) or die("cant load xml");
		$startDate = $xml->week->attributes(); //Gets Start Date from filed DTR
		
		$user_ID = $_SESSION['user_ID'];
		$select = "SELECT user_ID FROM dtr WHERE user_ID='$user_ID' AND date='".date('Y-m-d',strtotime($startDate. ' + 1 days'))."'"; 
		$fetch = mysqli_fetch_array(selectQuery($select), MYSQLI_BOTH);
		if(!date('w',strtotime($startDate))){
			if(is_null($fetch)){
				$rest = 0;
				$restrict = 0; 
				$notVal = 0;
				$outTotal = 0;
				$script = "INSERT INTO `dtr` (`dtr_ID`, `dayAttendance`, `user_ID`, `date`, `timein`, `timeout`, `is_restday`) VALUES";
				foreach ($xml->week->day as $day){ //loops each day
					$date = $day->attributes();
					$isAbsent = $day->is_absent;
					$isRestDay = $day->is_restDay;
					$inTime = $day->inTime;
					$outTime = $day->outTime;
					$totalTime = $outTime - $inTime;
					$startDate = date('Y-m-d',strtotime($startDate. ' + 1 days'));

					if($startDate!=date('Y-m-d', strtotime($date)))
						$notVal++;

					if ($isRestDay == 1)
						$rest++;
					
					if (($inTime < '07:00:00' || $inTime > '15:00:00') && ($isAbsent == 'Present' && $isRestDay == 0))
						$restrict++; 
					
					if (($isRestDay == 1 || $isAbsent == 'Absent') && ($inTime > '00:00:00' && $outTime > '00:00:00'))
						$notVal++;
					
					if (($isRestDay == 0 && $isAbsent == 'Present') && ($inTime == '00:00:00' && $outTime == '00:00:00'))
						$notVal++;
					
					if ((($totalTime < 7) || ($totalTime > 14)) && ($isAbsent == 'Present' && $isRestDay == 0))
						$outTotal++;
					
					$script .= " (NULL, '$isAbsent', '$user_ID', '$date', '$inTime', '$outTime', '$isRestDay'),"; //adds elements
				}
			
				$script = substr($script, 0, strlen($script)-1).";";
				if ($notVal==0){ //checks if absent or rest day is applied/not applied but there is/is no intime/outtime
					if ($rest == 1){ //checks if more than 1 rest day
						if (!$restrict){ //checks if not valid in time
							if (!$outTotal){
								if(runQuery($script)){
									echo "<script>alert('New record created successfully.');</script>";
								}else{
									echo "<script>alert('Error: " .  $script . "<br>" . mysqli_error($DBConnect)."');</script>";
								}
							}else{
								echo "<script>alert('Under/Over Time of Work!');</script>";
							}
						}else{
						echo "<script>alert('Invalid In Time!');</script>";
						}
					}else{
						echo "<script>alert('One (1) Rest Day Only!');</script>";
					}
				}
				else{
					echo "<script>alert('Inconsistent Data!');</script>";
				}	
			}else{
				echo "<script>alert('DTR for this week has already been filed!');</script>";
			}
		}else{
			echo "<script>alert('Invalid Start Date! Start Date should be Sunday.');</script>";
		}
		
	}
	else
	{
		echo "<script>alert('DTR is not valid!');</script>";
	}
?>
	<script type="text/javascript">window.location = ('dtr/file_dtr.php') </script>

</html>
<?php } ?>