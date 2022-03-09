<?php
	session_start();

	$userID = $_SESSION['ID'];
	

	
  
  include "../databaseConnection.php";

	$inboxThumbnail = array();

	$sql = "SELECT ProblemNo, ProblemType, problemPriority FROM ProblemNumber WHERE SpecialistID = '".$userID."' AND Accepted = 'No' AND returnToOperator != 'Yes' ORDER BY ProblemNo ASC";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {

	  while($row = $result->fetch_assoc()) {
		$inboxThumbnail[] = $row;
	  }

	}

?>
