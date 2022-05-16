<?php
include "../databaseConnection.php";

if(isset($_POST['probNum'])){
	$ProblemID=$_POST['probNum'];
	
	if (isset($_POST['rejectNotes'])) {
		$rejectNotes = $_POST['rejectNotes'];
		$sqlReturnToOperator = "UPDATE ProblemID SET Notes = '".$rejectNotes."', ReturnToOperator = 0 WHERE ProblemID = ".$ProblemID;
		$resultReturnToOperator = $conn->query($sqlReturnToOperator);
    newLog($conn,'Operator Rejection',$ProblemID);
	}
	
	else if (isset($_POST['accepted'])) {
		$sqlAcceptSolution = "UPDATE ProblemID SET Accepted = 'Yes' WHERE ProblemID = ".$ProblemID;
		$resultAcceptSolution = $conn->query($sqlAcceptSolution);
    newLog($conn,'Solution Accepted', $ProblemID);
	}
	
	else if (isset($_POST['getTickets'])) {
		$tickets = array();
		
		#$sqlGetTickets = "SELECT Tickets.TicketNo, Tickets.CallerID, Tickets.CallDescription, Personnel.CallerName, Personnel.Telephone, Personnel.JobTitle, Personnel.Department FROM Tickets INNER JOIN Personnel ON Tickets.CallerID = Personnel.CallerID WHERE Tickets.ProblemNo = ".$problemNum;
    $sqlGetTickets = "SELECT Tickets.TicketID, Tickets.PersonnelID, Personnel.FirstName, Personnel.Surname, Personnel.Telephone, Personnel.JobTitleID FROM Tickets INNER JOIN Personnel ON Tickets.CallerID = Personnel.PersonnelID WHERE Tickets.ProblemID = ".$ProblemID;
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

		#$sql = "SELECT ProblemID, ProblemTypeID, ProblemPriority, SerialNumber, SoftwareID, OSID, ProblemDescription, SpecialistID, Solution, Notes, Resolved, ProblemTypes.ProblemType FROM ProblemNumber LEFT JOIN ProblemTypes ON ProblemTypes.ProblemTypeID WHERE ProblemNumber.ProblemTypeID = ".$ProblemID;
		$sql = "SELECT ProblemID, ProblemTypes.ProblemType, ProblemPriority, SerialNumber, Software.Software, OS.OS, ProblemDescription, SpecialistID, Solution, Notes, Resolved 
    FROM ProblemNumber LEFT JOIN ProblemTypes ON ProblemTypes.ProblemTypeID = ProblemNumber.ProblemTypeID LEFT JOIN Software ON Software.SoftwareID = ProblemNumber.SoftwareID 
    LEFT JOIN OS ON OS.OSID = ProblemNumber.OSID WHERE ProblemNumber.ProblemID = $ProblemID";
    $result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$inboxContents[] = $row;
        #$ProblemTypeID = $row["ProblemTypeID"];
        #$sqlGetProblemType = "SELECT ProblemType FROM ProblemTypes WHERE ProblemTypeID = $ProblemTypeID";
        #$resultGetProblemType = $conn->query($sqlGetPRoblemType);
        #$inboxContents["ProblemType"] = $resultGetProblemType;

		  }
		}
		echo json_encode($inboxContents);
	}
    $conn->close();
	
}
    ?>
