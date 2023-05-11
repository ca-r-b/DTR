
<html>
<?php
	session_start();
	if(!isset($_SESSION['user_ID'])){
		header("location:login.php");
	} else {
		$user_ID=$_SESSION['user_ID'];
		$script=array();
		if(isset($_POST['rest'])){
			$rest = $_POST['rest'];
			$date = $_POST['date'];
			$in = $_POST['in'];
			$out = $_POST['out'];

			for($i=0; $i<count($in); $i++){
				$isabsent=isset($_POST['absent'.($i+1)]) ? 'Absent': 'Present';
				$isrest=($rest-1)==$i ? 1 : 0;
				if(!isset($_POST['absent'.($i+1)])&&!(($rest-1)==$i)){
					array_push($script,"UPDATE dtr SET dayAttendance='$isabsent', timein='$in[$i]', timeout='$out[$i]', is_restday='$isrest' WHERE date='$date[$i]' and user_ID=$user_ID;");
				}else{
					if(($rest-1)==$i){
						array_push($script,"UPDATE dtr SET dayAttendance='Absent', timein=NULL, timeout=NULL, is_restday='$isrest' WHERE date='$date[$i]' and user_ID=$user_ID;");
					}else{
						array_push($script,"UPDATE dtr SET dayAttendance='$isabsent', timein=NULL, timeout=NULL, is_restday='0' WHERE date='$date[$i]' and user_ID=$user_ID;");
					}
				}
			}
		}
		
		require("../../connect.php");
		$valid=true;
		for($i=0; $i<count($script); $i++)
			if (!mysqli_query($DBConnect, $script[$i])) 
				$valid=false;

		if($valid)
			echo "<script>alert('Record updated successfully.');</script>";
		else
			echo "<script>alert('Error: " .  $script . "<br>" . mysqli_error($DBConnect)."');</script>";
		
	}
?>
<script type="text/javascript">window.location = ('../update_dtr.php') </script>
</html>