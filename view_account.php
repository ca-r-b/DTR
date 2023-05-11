
<?php
  session_start();
  if(!isset($_SESSION['username'])){
    header("location:login.php");
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
  <title>View Record</title>
</head>

<body>
<?php
        include("database.php");
        include("updateProcess.php");

        $sessionID = $_SESSION['user_ID'];
        $script = "SELECT * FROM users WHERE user_ID ='$sessionID'";
        $fetch = mysqli_fetch_array(selectQuery($script));

        $pos = $fetch['position_ID'];
          $script = "SELECT * FROM position WHERE position_ID=$pos";
          $fetchPos = mysqli_fetch_array(selectQuery($script));

    ?>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark "> 
            <a class="navbar-brand" href="user.php"><b><i>IT-PROG Inc.</i></b></a>
            <ul class="navbar-nav mr-auto">
              <li class="nav-item ">
                    <a class="nav-link" href="user.php">Dashboard</a>
                </li>
                <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                DTR
              </a>
              <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="dtr/view_dtr.php">View</a>
                <a class="dropdown-item" href="dtr/file_dtr.php">File</a>
                <a class="dropdown-item" href="dtr/update_dtr.php">Update</a>
                <a class="dropdown-item" href="dtr/delete_dtr.php">Delete</a>
              </div>
                </li>
                <li class="nav-item ">
                      <a class="nav-link" href="compensationReport.php">Compensation Report</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="chatClient.php">Chat Support</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto px-5">
              <li class="nav-item dropdown" id="dp-drop">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <img src="<?php echo $fetch['image'];?>" class="dp">
                </a>
              <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="view_account.php">View Profile</a>
                <a class="dropdown-item" href="update_account.php">Update Profile</a>
                <a class="dropdown-item" href="logout.php">Logout</a>
              </div>
            </ul>
        </nav>
  
  <div class="container">
    <h1><b>Employee Record</b></h1>
    <p><i>View your employee information and company credentials.</i></p>
    <hr>
    <div class="container-sm">
    <table class="table">
  <tbody>
    <tr>
      <th scope="row">First Name</th>
      <td><?php echo $fetch['fName'];?></td>
    </tr>
    <tr>
      <th scope="row">Middle Name</th>
      <td><?php echo  $fetch['mName']?></td>

    </tr>
    <tr>
      <th scope="row">Last Name</th>
      <td colspan="2"><?php echo  $fetch['lName']?></td>
    </tr>
    <tr>
      <th scope="row">Username</th>
      <td colspan="2"><?php echo  $fetch['username']?></td>
    </tr>
    <tr>
      <th scope="row">Password</th>
      <td colspan="2"><input type='password' name='password' placeholder='Password' value='<?php echo  $fetch['password']?>' disabled/></td>
    </tr>
    <tr>
      <th scope="row">Gender</th>
      <td colspan="2"><?php echo  $fetch['gender']?></td>
    </tr>
    <tr>
      <th scope="row">Status</th>
      <td colspan="2"><?php echo  $fetch['status']?></td>
    </tr>
    <tr>
      <th scope="row">Date Hired</th>
      <td colspan="2"><?php echo  $fetch['dateHired']?></td>
    </tr>
    <tr>
      <th scope="row">Position</th>
      <td colspan="2"><?php echo $fetchPos['position']?></td>
    </tr>
    <tr>
      <th scope="row">Profile Picture</th>
      <td colspan="2"><img src="<?php echo $fetch['image'];?>" class="view"></td>
    </tr>
  </tbody>
</table>

</div>
<a href="user.php"><button class="btn btn-secondary" style="margin-top: 50px; margin-bottom: 50px;">Go back to Main Page</button></a>

</div>

  </body>
</html>
<?php } ?>