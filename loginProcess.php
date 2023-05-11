<?php	
	if(isset($_POST["login"])){
		$user = $_POST["username"];
		$pass = md5($_POST["password"]);
		$pass = substr($pass, 0, 25);
		require("database.php");
		$script = "SELECT username, password, user_ID, fName FROM users WHERE username='$user' AND password='$pass'";
		$fetch = mysqli_fetch_array(selectQuery($script));
		
		if($user==$fetch["username"] && $pass==$fetch["password"]){
			session_start();
			$_SESSION['username'] = $user;
			$_SESSION['user_ID'] = $fetch['user_ID'];
			$_SESSION['fName'] = $fetch['fName'];
			header("location:user.php");
		} else{
			header("location:login.php?error=1");
		}
	}
?>