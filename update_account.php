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
  <title>Update Record</title>
</head>

<body>
  <?php
        include("database.php");
        include("updateProcess.php");

        $sessionID = $_SESSION['user_ID'];
        $script = "SELECT * FROM users WHERE user_ID ='$sessionID'";
        $fetch = mysqli_fetch_array(selectQuery($script));
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
    <h1><b>Update Record</b></h1>
    <p><i>Edit your company credentials.</i></p>
    <form method='post' action='update_account.php' autocomplete='off' enctype="multipart/form-data">
      <table class="table">
        <?php
          if(isset($nameError))
            echo "<p>" . $nameError . "</p>";
          else if(isset($_POST["updateCred"]))
            echo "<p>" . "Account updated successfully!" . "</p>";
        ?>
        <tr>
          <td><label for="fName" class="form-label">First Name:</label> </td>
          <td><input type='text' name='fName' placeholder='First Name' value='<?php echo $fetch['fName'];?>' class="form-control"required/></td>
        </tr>
        <tr>
          <td>Middle Name: </td>
          <td><input type='text' name='mName' class="form-control"placeholder='Middle Name (Optional)' value='<?php echo  $fetch['mName']?>'/></td>
        </tr>
        <tr>
          <td>Last Name: </td>
          <td><input type='text' name='lName' class="form-control"placeholder='Last Name' value='<?php echo  $fetch['lName']?>' required/></td>
        </tr>
        <tr>
          <td>Username: </td>
          <td><input type='text' name='username' class="form-control"placeholder='Username' value='<?php echo  $fetch['username']?>' required/></td>
        </tr>
        <tr>
          <td>Password: </td>
          <td><input type='password' name='password'class="form-control" placeholder='Password' value='<?php echo  $fetch['password']?>' required/></td>
        </tr>
        <tr>
          <td>Gender: </td>
          <?php
          if($fetch['gender'] == 'Male')
            echo "    <td>
                        <input type='radio' name='gender' value='Male' checked='checked'/><label>Male</label>
                        <input type='radio' name='gender' value='Female'/><label>Female</label>
                      </td>";
          if($fetch['gender'] == 'Female')
            echo "    <td>
                        <input type='radio' name='gender' value='Male'/><label>Male</label>
                        <input type='radio' name='gender' value='Female' checked='checked'/><label>Female</label>
                      </td>";
        ?>
        </tr>
        <tr>
          <td>Status: </td>
          <?php
          if($fetch['status'] == 'Regular')
            echo "    <td>
                        <input type='radio' name='status' value='Regular' checked='checked'/><label>Regular</label>
                        <input type='radio' name='status' value='Probation'/><label>Probation</label>
                      </td>";
          if($fetch['status'] == 'Probation')
            echo "    <td>
                        <input type='radio' name='status' value='Regular'/><label>Regular</label>
                        <input type='radio' name='status' value='Probation' checked='checked'/><label>Probation</label>
                      </td>";
        ?>
        </tr>
        <tr>
          <td>Current Position: </td>
          <?php
          // Get current position of user
          $pos = $fetch['position_ID'];
          $script = "SELECT * FROM position WHERE position_ID=$pos";
          $fetchPos = mysqli_fetch_array(selectQuery($script));

          echo "      <td>". $fetchPos['position'] . "</td>";
        ?>
        </tr>
        <tr>
          <td>New Position: </td>
          <td><select name='position_ID' class="form-select form-select"required>
              <option disabled selected value>Select Position</option>
              <option value='1'>Manager</option>
              <option value='2'>Programmer</option>
              <option value='3'>Encoder</option>
              <option value='4'>Secretary</option>
              <option value='5'>Network Admin</option>
            </select></td>
        </tr>
        <tr>
          <td>Date Hired: </td>
          <td><input type='date' name='dateHired'class="form-control" value='<?php echo $fetch['dateHired']; ?>'/></td>
        </tr>
        <tr>
          <td>Profile Picture: </td>
          <td><input type='file' class="form-control" name='image' accept='.jpg, .jpeg, .png' placeholder='Upload Picture' value="default.jpg"/></td>
        </tr>
      </table>
      <div class="d-grid gap-2">
      <input type="submit" class = "btn btn-primary" name="updateCred" value="Update Credentials">
  
      </div>
      
    </form>
    <a href="user.php"><button class="btn btn-secondary" style="margin-top: 50px;">Go back to Main Page</button></a>
  </div>
</body>

</html>
<?php } ?>