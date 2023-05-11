<?php
    session_start();
    if(isset($_SESSION['username'])){
        header("location:user.php");
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
        <title>Login</title>
    </head>
    <body>
        <div class="container">
            <h1><b><i>Welcome to IT-PROG Inc.</i></b></h1><br/>
            <?php
                if(isset($_GET["error"])) {
                    $error=$_GET["error"];
                    if ($error==1) {
                        echo "<p style='color:red'><b>USERNAME and/or PASSWORD inputted is invalid!<br/></b></p>"; 
                    }
                }
            ?>
    		<form method="post" action="loginProcess.php" autocomplete="off">
                <table class="table">
                    <tr>
                        <td>Username: </td>
                        <td><input type='text' name='username' placeholder='Username' size='25' required/></td>
                    </tr>
                    <tr>
                        <td>Password: </td>
                        <td><input type='password' name='password' placeholder='Password' size='25' required/></td>
                    </tr>
                </table>
                <input class="btn btn-dark" type='submit' name='login' value='Log In'>
    		</form>
             <hr>
            <a class="company-support" href="chatClient.php"><button class="btn btn-outline-primary">IT-PROG Inc. Support</button></a>
            <a class="company-support" href="register.php"><button class="btn btn-outline-primary">Don't have an account? Register here.</button></a>
        </div>
    </body>
</html>

<?php } ?>