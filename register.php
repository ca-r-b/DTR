<?php include("registerProcess.php")?>
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
        <title>Registration Form</title>
    </head>
    <body>
        <div class= "container">
            <h1><b>Registration Form</b></h1>
            <?php
                if(isset($_POST["register"])){
                    if(isset($nameError)){
                        echo "<p>" . $nameError . "</p>";
                    }else if(mysqli_affected_rows($DBConnect)){
                        echo "<p style='color:green'><b>" . "Account created successfully!" . "</b></p>";
                    }
                }
            ?>
            <form method="post" action="register.php" autocomplete="off">
                
                <table class="table">
                    <tr>
                        <td>ID Number: </td>
                        <td><input type='number' class="form-control" name='user_ID' placeholder='ID Number' size='11' required/></td>
                    </tr>
                    <tr>
                        <td>First Name: </td>
                        <td><input type='text' class="form-control" name='fName' placeholder='First Name' size='25' required/></td>
                    </tr>
                    <tr>
                        <td>Middle Name: </td>
                        <td><input type='text' class="form-control" name='mName' placeholder='Middle Name' size='25'/></td>
                    </tr>
                    <tr>
                        <td>Last Name: </td>
                        <td><input type='text' class="form-control" name='lName' placeholder='Last Name' size='25' required/></td>
                    </tr>
                    <tr>
                        <td>Username: </td>
                        <td><input type='text' class="form-control" name='username' placeholder='Username' size='25' required/></td>
                    </tr>
                    <tr>
                        <td>Password: </td>
                        <td><input type='password' class="form-control" name='password' placeholder='Password' size='25' required/></td>
                    </tr>
                    <tr>
                        <td>Gender: </td>
                        <td>
                            <input type='radio' name='gender'class="form-check-input" value='Male' required/><label>Male</label>
                            <input type='radio' name='gender' class="form-check-input"value='Female'/><label>Female</label>
                        </td>
                    </tr>
                    <tr>
                        <td>Status: </td>
                        <td>
                            <input type='radio' class="form-check-input"name='status' value='Regular'/><label>Regular</label>
                            <input type='radio' class="form-check-input"name='status' value='Probation'/><label>Probation</label>
                        </td>
                    </tr>
                    <tr>
                        <td>Date Hired: </td>
                        <td><input type='date' class="form-control" name='dateHired' required></td>
                    </tr>
                </table>
                <div class="d-grid gap-2">
                  <input class="btn btn-primary" type='submit' name='register' value='Register'>   
                </div>
                <input type='hidden' name='position_ID'>       
            </form>
            <hr>
            <a href='login.php'><button class="btn btn-secondary" style="margin-top: 50px;">Go Back to Login Screen</button></a>
            <a class="company-support" href="chatClient.php"><button class="btn btn-outline-primary"style="margin-top: 50px;">IT-PROG Inc. Support</button></a>
        </div>
    </body>
</html>