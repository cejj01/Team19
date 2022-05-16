<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <body>
  
    <?php
      include 'databaseConnection.php';

      // Create connection to the database
      $conn = new mysqli($servername, $username, $password, $dbname);
      
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Query ProblemNumber table to get ProblemNo, Priority and 1st Submission Date of Problems where there is not an accepted solution from the problem number table
      $sql1 = "SELECT ProblemNo, problemPriority, 1stSubmissionDate FROM ProblemNumber WHERE (Accepted = 'No')";
      $result1 = $conn->query($sql1);


      if ($result1->num_rows > 0) {

        while($row = $result1->fetch_assoc()) {
          // Save values to variables
          $problemNo = $row['ProblemNo'];
          $problemPriority = $row['problemPriority'];
          $submissionDate = $row['1stSubmissionDate'];
          //Convert submission date to Unix timestamp
          $submissionDateTime= strtotime($submissionDate);
          // Save today's date as a Unix timestamp
          $todaysDateTime = time();

          // Calculate time problem has been unresolved
          $daysOpenUnixTimestamp = $todaysDateTime - $submissionDateTime;
          $daysOpen = round($daysOpen/(60*60*24));
          
          // Query Tickets table to get the number of tickets for each problem number
          $sql2 = "SELECT COUNT(TicketNo) FROM Tickets WHERE ProblemNo = '$problemNo'";
          $result2 = $conn->query($sql2);

          $noTickets = ($result2->fetch_assoc())['COUNT(TicketNo'];
          // Calculate a numerical value for priority 
          $problemPriorityNumerical;
          if ($problemPriority == "Low") {
            $problemPriorityNumerical = 5;
          } else if ($problemPriority == "Medium") {
            $problemPriorityNumerical = 10;
          } else {
            $problemPriorityNumerical = 15;
          }

          // Calculate urgency taking the time open, problem priority and the number of tickets into account
          $urgency =  $daysOpen + $problemPriorityNumerical + $noTickets;

          // Insert the value for urgency into the ProblemNumber table
          $sqlInsertUrgency = "UPDATE ProblemNumber SET Urgency = '$urgency' WHERE ProblemNo = '$problemNo'";
        }
      } else {
        echo "No open problems";
      }
      $conn->close();
    ?>
  </body>


</html>