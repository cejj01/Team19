<?php
	session_start();
	$userID = $_SESSION['ID'];
  	include "../databaseConnection.php";
	$inboxThumbnail = array();
	$sql = "SELECT ProblemID, ProblemTypeID, SpecialistID, ProblemPriority FROM ProblemNumber WHERE SpecialistID = $userID ORDER BY ProblemID ASC";
	//$sql = "SELECT ProblemID, ProblemTypes.ProblemType, ProblemPriority FROM ProblemNumber 
	//LEFT JOIN ProblemTypes ON ProblemTypes.ProblemID = ProblemNumber.ProblemID WHERE 
	//SpecialistID = '".$userID."' AND Accepted = '0' AND ReturnToOperator == '0' ORDER BY ProblemID ASC";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	  while($row = $result->fetch_assoc()) {
		$inboxThumbnail[] = $row;
	  }
	}
?>