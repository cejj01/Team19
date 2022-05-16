<!DOCTYPE html>
<html>
  <body>
    <?php
    /*This page retrieves all users from the database and echos these to the frontend so that the current user can select the user they wish to chat with
    - Aneirin Horvath
    */

    include 'databaseConnection.php';
    $currentUserID = 'F013103';

    $sql = "SELECT UserID, FullName FROM UserAccounts WHERE UserID != '$currentUserID'";
    $result = $conn->query($sql);

    $users = array();

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()){
        $users[] =  $row;
      }
    }



    ?>
  </body>
</html>