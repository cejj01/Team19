<?php
	session_start();
	$userID = $_SESSION['ID'];
	include "../databaseConnection.php";
	$inboxThumbnail = array();
	$sql = "SELECT ProblemID, ProblemTypeID, SpecialistID, ProblemPriority FROM ProblemNumber 
	WHERE SpecialistID = $userID ORDER BY ProblemID ASC";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	  while($row = $result->fetch_assoc()) {
		$inboxThumbnail[] = $row;
	  }
	}
?>