<?php
    if(isset($_POST["register"])){
        require("connect.php");

        $user_ID = $_POST["user_ID"];
        $fName = $_POST["fName"];
        $mName = $_POST["mName"];
        $lName = $_POST["lName"];
        $username = $_POST["username"];
        $password = md5($_POST["password"]);
        $gender = $_POST["gender"];
        $status = $_POST["status"];
        $dateHired = $_POST["dateHired"];
        
        $IDQuery = "SELECT * FROM users WHERE user_ID ='$user_ID'";
        $IDCheck = mysqli_query($DBConnect, $IDQuery);

        $usernameQuery = "SELECT * FROM users WHERE username ='$username'";
        $usernameCheck = mysqli_query($DBConnect, $usernameQuery);

        if(mysqli_num_rows($IDCheck) > 0 || mysqli_num_rows($usernameCheck) > 0){
            $nameError = "It seems that the ID and/or USERNAME that you have entered is already in use!";
        } else {
            $insert = mysqli_query($DBConnect, "INSERT INTO users
            VALUES('$user_ID', '$fName', '$lName', '$mName', '$username', '$password', '$gender', '$status', '$dateHired', '0', 'default.jpg')");
        }
    }
?>