<html>
	<head><title>Edit Module Component</title></head>
	<body>
		<?php
			if(isset($_POST["updateCred"])){
				$user_ID = $_SESSION['user_ID'];
				$fName = $_POST["fName"];
				$mName = $_POST["mName"];
				$lName = $_POST["lName"];
				$username = $_POST["username"];
				$password = md5($_POST["password"]);
				$gender = $_POST["gender"];
				$status = $_POST["status"];
				$dateHired = $_POST["dateHired"];
				$position_ID = $_POST["position_ID"];

				$image = $_FILES["image"]["name"];
				$tempname = $_FILES["image"]["tmp_name"];
				$folder ="./" . $image;

				
				$script = "SELECT * FROM users WHERE username ='$username' AND user_id!=$user_ID";

				if(mysqli_num_rows(selectQuery($script))>0){
					echo "<script>alert('It seems that the USERNAME that you have entered is already in use!')</script>";
				}else{
					$script = "SELECT * FROM users WHERE user_id=$user_ID";
					$fetch = mysqli_fetch_array(selectQuery($script));
					
					$script = "UPDATE users SET fName='" . $fName .  
											"', mName='" . $mName .
											"', lName='" . $lName . 
											"', username='" . $username .
											"', gender='" . $gender .
											"', status='" . $status . 
											"', dateHired='" . $dateHired . 
											"', position_ID='" . $position_ID ."' WHERE user_id=$user_ID";
					runQuery($script);

					if(isset($_FILES["image"]) && !empty($_FILES["image"]["name"])) { 
						$scriptimg = "UPDATE users SET image='" . $image ."' WHERE user_id=$user_ID";
						runQuery($scriptimg);
						if (move_uploaded_file($tempname, $folder)) {
							echo "<script>alert('Image uploaded successfully!')</script>";
						}
					}
					if($fetch['password'] != $_POST["password"]){
						$script="UPDATE users SET password='" . $password . "' WHERE user_id=$user_ID";
						runQuery($script);
					}
				}
			}
			
		?>
	</body>
</html>