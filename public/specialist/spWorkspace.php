<?php
include "../databaseConnection.php";

if(isset($_POST['probNum'])){
	$ProblemID=$_POST['probNum'];
	
	if (isset($_POST['rejectNotes'])) {
		$rejectNotes = $_POST['rejectNotes'];
		$sqlReturnToOperator = "UPDATE ProblemNumber SET Notes = '".$rejectNotes."', ReturnToOperator = 0 WHERE ProblemID = ".$ProblemID;
		$resultReturnToOperator = $conn->query($sqlReturnToOperator);
    newLog($conn,'Operator Rejection',$ProblemID);
	}
	else if (isset($_POST['accepted'])) {
		$sqlAcceptSolution = "UPDATE ProblemNumber SET Accepted = 'Yes' WHERE ProblemID = ".$ProblemID;
		$resultAcceptSolution = $conn->query($sqlAcceptSolution);
    newLog($conn,'Solution Accepted', $ProblemID);
	}
	else if (isset($_POST['getTickets'])) {
		$tickets = array();
		
		$sqlGetTickets = "SELECT Tickets.TicketID, Tickets.PersonnelID, Personnel.FirstName, Personnel.Surname, Personnel.Telephone, JobTitle.JobTitle
		FROM Tickets INNER JOIN Personnel ON Tickets.PersonnelID = Personnel.PersonnelID LEFT JOIN JobTitle ON JobTitle.JobTitleID = Personnel.JobTitleID
		WHERE Tickets.ProblemID = ".$ProblemID;
		$resultGetTickets = $conn->query($sqlGetTickets);
		if ($resultGetTickets->num_rows > 0) {
			while ($row = $resultGetTickets->fetch_assoc()) {
				$tickets[] = $row;
			}
		}
		echo json_encode($tickets);
	}o
	else {
		$inboxContents = array();

		$sql = "SELECT Tickets.ProblemID, ProblemTypes.ProblemType, Tickets.PersonnelID, Personnel.FirstName, ProblemNumber.ProblemPriority, ProblemNumber.SerialNumber, Software.Software, OS.OS, ProblemNumber.ProblemDescription, ProblemNumber.SpecialistID, ProblemNumber.Solution, ProblemNumber.Notes, ProblemNumber.Resolved 
    	FROM Tickets LEFT JOIN ProblemNumber ON ProblemNumber.ProblemID = Tickets.ProblemID LEFT JOIN Personnel ON Tickets.PersonnelID = Personnel.PersonnelID LEFT JOIN ProblemTypes ON ProblemTypes.ProblemTypeID = ProblemNumber.ProblemTypeID LEFT JOIN Software ON Software.SoftwareID = ProblemNumber.SoftwareID 
    	LEFT JOIN OS ON OS.OSID = ProblemNumber.OSID WHERE Tickets.ProblemID = $ProblemID";
		/*$sql = "SELECT ProblemID, ProblemTypes.ProblemType, ProblemPriority, SerialNumber, Software.Software, OS.OS, ProblemDescription, SpecialistID, Solution, Notes, Resolved 
    	FROM ProblemNumber LEFT JOIN ProblemTypes ON ProblemTypes.ProblemTypeID = ProblemNumber.ProblemTypeID LEFT JOIN Software ON Software.SoftwareID = ProblemNumber.SoftwareID 
    	LEFT JOIN OS ON OS.OSID = ProblemNumber.OSID WHERE ProblemNumber.ProblemID = $ProblemID";*/
    	$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$inboxContents[] = $row;
		  }
		}
		echo json_encode($inboxContents);
	}
    $conn->close();
}
?>