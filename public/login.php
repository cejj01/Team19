<?php
  session_start();
  include 'databaseConnection.php';
?>

<!DOCTYPE html>
<html>
<body>
  <?php

    // POST the username and password from log-in.html
    $employeeUserName = $_POST['username'];
    $userPassword = $_POST['password'];


    $passwordHash = hash('sha256', $userPassword);

    // Wait until the user clicks the submit button
    if (isset($_POST['submit'])) {
      
      // Create connection to the database
      $conn = new mysqli($servername, $username, $password, $dbname);

      // Test connection to the database
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Prepare and execute the SQL query
      // $result stores the USERID of the user if the UserName and UserPassword are correct
      $sql = "SELECT * FROM UserAccounts WHERE UserPassword = '$passwordHash' && UserName = '$employeeUserName'"; 
      $result = $conn->query($sql);
      
      if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          // Save the PersonnelID to a session variable
          $_SESSION['ID'] = $row['PersonnelID'];

          // Save the user role to $userRole
          $userRole = $row['Role'];
          $_SESSION['Role'] = $userRole;

          // Depending on the user role redirect the user to the appropriate landing page
          switch ($userRole) {
            case "operator":
              echo '<script type="text/javascript"> window.open("operator/op-new-ticket.php", "_self");</script>';
            break;
            case "specialist":
              echo '<script type="text/javascript"> window.open("specialist/sp-inbox.php", "_self");</script>';
            break;
            case "admin":
              echo '<script type="text/javascript"> window.open("admin/admin-logs.php", "_self");</script>';
            break;
            case "analyst":
              echo '<script type="text/javascript"> window.open("analyst/anal-analytics.php", "_self");</script>';
            break;
            case "user":
              echo '<script type="text/javascript"> window.open("user/userHome.php", "_self");</script>';
            break;
          }
          
        }
      } else {
        echo "Invalid username or password";
      }
      
      $conn->close();
    }

  ?>

</body>
</html>
