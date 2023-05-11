<?php
    $DBConnect = mysqli_connect("localhost", "root", "") or die ("Unable to Connect" . mysqli_error($DBConnect));
    $db = mysqli_select_db($DBConnect, 'dbdtr_project');
?>