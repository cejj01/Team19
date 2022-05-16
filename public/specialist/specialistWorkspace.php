<?php
include "../databaseConnection.php";

if(isset($_POST['probNum'])){
	$ProblemID=$_POST['probNum'];

	if (isset($_POST['rejectNotes'])) {
		$rejectNotes = $_POST['rejectNotes'];
		$Number = 1
		$sqlReturnToOperator = "UPDATE ProblemNumber SET Notes = '".$rejectNotes."', ReturnToOperator = 1 WHERE ProblemID = ".$ProblemID;
		$resultReturnToOperator = $conn->query($sqlReturnToOperator);
		newLog($conn,'Specialist Rejection',$ProblemID);		
	}
	else if (isset($_POST['solution'])) {
		$solution = $_POST['solution'];
		$sqlAddSolution = "UPDATE ProblemNumber SET Solution = '".$solution."', Resolved = 1, ReturnToOperator = 1 WHERE ProblemID = ".$ProblemID;
		$resultAddSolution = $conn->query($sqlAddSolution);
		newLog($conn,'Solution',$ProblemID);
	}
	else if (isset($_POST['getTickets'])) {
		$tickets = array();
		
		$sqlGetTickets = "SELECT Tickets.TicketID, Tickets.PersonnelID, Personnel.FirstName, Personnel.Surname, Personnel.Telephone, JobTitle.JobTitle, Department.Department 
		FROM Tickets INNER JOIN Personnel ON Tickets.PersonnelID = Personnel.PersonnelID LEFT JOIN JobTitle ON JobTitleID = Personnel.JobTitleID LEFT JOIN Department.DepartmentID = JobTitle.DepartmentID
		WHERE Tickets.ProblemID = ".$ProblemID;
		$resultGetTickets = $conn->query($sqlGetTickets);
		if ($resultGetTickets->num_rows > 0) {
			while ($row = $resultGetTickets->fetch_assoc()) {
				$tickets[] = $row;
			}
		}
		echo json_encode($tickets);
	}
	else {		
		$inboxContents = array();

		$sqlGetProblemDetails = "SELECT ProblemID, ProblemTypes.ProblemType, ProblemPriority, SerialNumber, Software.Software, OS.OS, ProblemDescription, SpecialistID, Solution, Notes, Resolved 
    	FROM ProblemNumber LEFT JOIN ProblemTypes ON ProblemTypes.ProblemTypeID = ProblemNumber.ProblemTypeID LEFT JOIN Software ON Software.SoftwareID = ProblemNumber.SoftwareID 
    	LEFT JOIN OS ON OS.OSID = ProblemNumber.OSID WHERE ProblemNumber.ProblemID = $ProblemID";
		$result = $conn->query($sqlGetProblemDetails);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$inboxContents[] = $row;
			}
		}
		echo json_encode($inboxContents);
	}
}

$conn->close();
?>