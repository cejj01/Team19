<?php
	include "../databaseConnection.php";

	$inboxThumbnail = array();

	$sql = "SELECT ProblemNo, ProblemType, problemPriority, specialistID FROM ProblemNumber WHERE returnToOperator = 'Yes' AND Accepted = 'No' ORDER BY ProblemNo ASC";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {

	  while($row = $result->fetch_assoc()) {
		$inboxThumbnail[] = $row;
	  }

	}

?>

