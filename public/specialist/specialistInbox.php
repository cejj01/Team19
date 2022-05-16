<?php
	session_start();
	$userID = $_SESSION['ID']; //Stores the PersonnelID of whoever is currently logged in.
  	include "../databaseConnection.php";
	$inboxThumbnail = array();
	//To be used to display all problems the specialist has to do.
	$sql = "SELECT ProblemNumber.ProblemID, ProblemNumber.ProblemTypeID, Tickets.DateTime, Tickets.PersonnelID FROM ProblemNumber LEFT JOIN Tickets ON ProblemNumber.ProblemID = Tickets.ProblemID WHERE ProblemNumber.SpecialistID = $userID ORDER BY ProblemNumber.ProblemID ASC";
	//$sql = "SELECT ProblemID, ProblemTypeID, SpecialistID, ProblemPriority FROM ProblemNumber WHERE SpecialistID = $userID ORDER BY ProblemID ASC";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	  while($row = $result->fetch_assoc()) {
		$inboxThumbnail[] = $row;
	  }
	}
?>