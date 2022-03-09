<?php
include "../databaseConnection.php";



if(isset($_POST['probNum'])){
	$problemNum=$_POST['probNum'];


	if (isset($_POST['rejectNotes'])) {
		$rejectNotes = $_POST['rejectNotes'];
		$sqlReturnToOperator = "UPDATE ProblemNumber SET Notes = '".$rejectNotes."', returnToOperator = 'Yes' WHERE ProblemNo = ".$problemNum;
		$resultReturnToOperator = $conn->query($sqlReturnToOperator);
		newLog($conn,'Specialist Rejection',$problemNum);		
	}
	
	else if (isset($_POST['solution'])) {
		$solution = $_POST['solution'];
		$sqlAddSolution = "UPDATE ProblemNumber SET Solution = '".$solution."', Resolved = 'Yes', returnToOperator = 'Yes' WHERE ProblemNo = ".$problemNum;
		$resultAddSolution = $conn->query($sqlAddSolution);
		newLog($conn,'Solution',$problemNum);
	}
	
	else if (isset($_POST['getTickets'])) {
		$tickets = array();
		
		$sqlGetTickets = "SELECT Tickets.TicketNo, Tickets.CallerID, Tickets.CallDescription, Personnel.CallerName, Personnel.Telephone, Personnel.JobTitle, Personnel.Department FROM Tickets INNER JOIN Personnel ON Tickets.CallerID = Personnel.CallerID WHERE Tickets.ProblemNo = ".$problemNum;
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

		$sqlGetProblemDetails = "SELECT ProblemNo, ProblemType, problemPriority, SerialNumber, SoftwareName, OS, ProblemDescription, Notes FROM ProblemNumber WHERE ProblemNo = ".$problemNum;
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