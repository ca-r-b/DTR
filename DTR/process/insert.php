<html>
<?php
	session_start();
	if(!isset($_SESSION['user_ID'])){
		header("location:login.php");
	} else {
		$user_ID=$_SESSION['user_ID'];
		$script="INSERT INTO `dtr` (`dtr_ID`, `dayAttendance`, `user_ID`, `date`, `timein`, `timeout`, `is_restday`) VALUES";
		$final_Date;
		if(isset($_POST['rest'])){
			$rest = $_POST['rest'];
			$date = $_POST['date'];
			$in = $_POST['in'];
			$out = $_POST['out'];

			for($i=0; $i<count($in); $i++){
				$isabsent=isset($_POST['absent'.($i+1)]) ? 'Absent': 'Present';
				$isrest=($rest-1)==$i ? 1 : 0;
				if(!isset($_POST['absent'.($i+1)])&&!(($rest-1)==$i)){
					$script.=" (NULL, '$isabsent', '$user_ID', '$date[$i]', '$in[$i]', '$out[$i]', '$isrest'),";
				}else{
					if(($rest-1)==$i)
						$script.=" (NULL, 'Absent', '$user_ID', '$date[$i]', NULL, NULL, '$isrest'),";
					else
						$script.=" (NULL, '$isabsent', '$user_ID', '$date[$i]', NULL, NULL, '0'),";
				}
				$final_Date = $date[$i];
			}
			$final_Date="SELECT user_ID from dtr where user_ID='$user_ID' and date='$final_Date';";
			$script=substr($script, 0, strlen($script)-1).";";
		}
		require("../../connect.php");
		$query = mysqli_query($DBConnect, $final_Date);
		$fetch = mysqli_fetch_array($query, MYSQLI_BOTH);
		if($fetch==null){
			if (mysqli_query($DBConnect, $script)) {
			  echo "<script>alert('New record created successfully.');</script>";
			} else {
			  echo "<script>alert('Error: " .  $script . "<br>" . mysqli_error($DBConnect)."');</script>";
			}
		}else{
			echo "<script>alert('DTR for this week has already been filed.');</script>";
		}
	}
?>
<script type="text/javascript">window.location = ('../file_dtr.php') </script>
</html>