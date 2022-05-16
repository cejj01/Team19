<?php
    // Create connection to database
    $servername = "localhost";
    $username = "teamb019";
    $password = "lrf5vFbpTh";
    $dbname = "teamb019";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);


    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
?>

