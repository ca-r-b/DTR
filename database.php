<?php
	function runQuery($script){
		require("connect.php");
		$query = mysqli_query($DBConnect, $script);
		return mysqli_affected_rows ($DBConnect);
	}

	function selectQuery($script){
		require("connect.php");
		$query = mysqli_query($DBConnect, $script);
		return $query;
	}
?>