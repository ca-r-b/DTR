<?php
	session_start();
	if(!isset($_SESSION['user_ID'])){
		header("location:login.php");
	}else{
		if($_POST['date']!=""){
			$dates=$_POST['dates'];
			$last=count($dates)-1;
			$script="DELETE FROM dtr WHERE date BETWEEN '$dates[0]' and '$dates[$last]';";
			require("../../database.php");
			if(!runQuery($script)){
				echo "<script>alert('No records found.'); </script>";
			}else{
				echo "<script>alert('Records Successfully deleted.'); </script>";
			}
			
		}else{
			echo "<script>alert('Form incomplete'); </script>";
		}
		
	}
?>
<script type="text/javascript">window.location = ('../delete_dtr.php') </script>
