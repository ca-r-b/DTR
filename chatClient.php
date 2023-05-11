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
	    <!-- Font Awesome -->
  		<script src="https://kit.fontawesome.com/f3347210b3.js" crossorigin="anonymous"></script>
	    <title>IT-PROG Inc. Support</title>
		<style>
			.chatbox{
				resize: none;
				height: 400px;
	        	width: 500px;
			}
		</style>
	</head>
	<body>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			 <ul class="navbar-nav mr-auto">
              <li class="nav-item ">
				<button class="btn btn-outline-light"><a class="navbar-brand" href="login.php"><i class="fa fa-arrow-left"></i> Go Back</a></button>
              </li>
            </ul>
		</nav>
		<div class="container">
			<h1>How can we help you?</h1>
			<p>Have any concerns? Talk with one of our personnel so we can assist you!</p>
			<form method="POST">
			<div class="form-floating">
				<textarea class="form-control" name="txtMessage"  placeholder="Enter message here" id="floatingTextarea" style="height: 100px"></textarea>
				<label for="floatingTextarea">Enter Message:</label>
			</div>
			
				<input type="submit" name="btnSend" value="Send" class="btn btn-primary" style="margin-top: 20px;"><br/><br/>

				<?php
					$host = "127.0.0.1";
					$port = 4999;
					set_time_limit(0);
					if (isset($_POST["btnSend"])){
						$msg = $_REQUEST["txtMessage"];
						$sock = socket_create(AF_INET, SOCK_STREAM, 0);

						socket_connect($sock, $host, $port);
						socket_write($sock, $msg, strlen($msg));

						$reply = socket_read($sock, 1924);
						$reply = trim($reply);
						$reply = "Client: " . $msg . "\nServer: ". $reply;
					}
				?>

	  		<textarea class="chatbox"><?php echo @$reply; ?></textarea>
			</form>
		</div>	
	</body>
</html>