<!DOCTYPE html>
<html>
  <body>
    <?php
    // Get values from frontend
    include 'databaseConnection.php';
    $userID = $_SESSION['ID'];
    $description = $_POST['ProblemDescription'];
    $solution = $_POST['Solution'];
    
    // Insert values into the database
    function addCommonProblem ($conn, $userID, $description, $solution) {
      $commonProblemNo = GenerateCommonProblemNo($conn);
      $sqlAddCommonProblem = "INSERT INTO CommonProblems VALUES ('$commonProblemNo', '$description', '$solution', '$userID')";
      $resultAddCommonProblem = $conn->query($sqlAddCommonProblem);
    }

    /* Query the database to save the largest problem number
    Convert this to an integer value
    Add 1 to produce the new common problem number */
    function GenerateCommonProblemNo ($conn){
      $sqlGetMaxCommonProblemNo = "SELECT Max(CommonProblemNo) FROM CommonProblems";
      $resultMaxCommonProblemNo = $conn->query($sqlGetMaxCommonProblemNo);
      $maxCommonProblemNoString = ($resultMaxCommonProblemNo->fetch_assoc())['Max(CommonProblemNo'];
      $maxCommonProblemNoInt = intval($maxCommonProblemNoString);
      $newCommonProblemNo = $maxCommonProblemNoInt + 1;
      return $newCommonProblemNo;

    }
    ?>
  </body>
</html>