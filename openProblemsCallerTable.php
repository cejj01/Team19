<?php
include "databaseConnection.php";
if(isset($_POST['probNum'])){	
	$problemNum=$_POST['probNum'];

	/*$sqlCallers = "SELECT Tickets.CallDate, Tickets.CallTime, Personnel.CallerName, Personnel.CallerID,
		Tickets.OperatorID, Tickets.CallDescription
		FROM Tickets INNER JOIN Personnel ON Tickets.CallerID = Personnel.CallerID 
		WHERE Tickets.ProblemNo = '$problemNum'";*/
	$sqlCallers = "SELECT Tickets.CallDate, Tickets.CallTime, Personnel.CallerName, Personnel.CallerID,
			UserAccounts.FullName , Tickets.CallDescription
		FROM Tickets INNER JOIN Personnel ON Tickets.CallerID = Personnel.CallerID INNER JOIN UserAccounts 
		WHERE Tickets.ProblemNo = '$problemNum' 
			AND UserAccounts.UserID = Tickets.OperatorID";
			
	$resultCallers = $conn->query($sqlCallers);
	if($resultCallers->num_rows > 0) {
		while($row = $resultCallers->fetch_assoc()) {
			echo json_encode($row).'¬';
		}
	}
}

?>