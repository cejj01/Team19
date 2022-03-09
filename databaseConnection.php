<?php
    // Create connection to database
    $servername = "localhost";
    $username = "newuser";
    $password = "password";
    $dbname = "Team24";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);


    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
?>

