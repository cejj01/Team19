
    <?php
	/*
    // Create connection to database
    $dbname = "coa123cdb";
    $username = "coa123cycle";
    $password = "bgt87awx";
    $servername = "localhost";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
    $problemNo = $_POST['problemNo'];

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Get information about this problem from the database
    $sql = "SELECT ProblemType, SerialNumber, SpecialistID, SoftwareName, OS, ProblemDescription FROM ProblemNumber WHERE ProblemNo = '$problemNo'";
    $result = $conn->query($sql);

    // Save problem information in variables and echo to frontend
    if ($result->num_rows > 0) {
      echo $problemType = ($result->fetch_assoc())['ProblemType'];
      echo $serialNumber = ($result->fetch_assoc())['SerialNumber'];
      echo $softwareName = ($result->fetch_assoc())['SoftwareName'];
      echo $OS = ($result->fetch_assoc())['OS'];
      echo $problemDesciption = ($result->fetch_assoc())['ProblemDescription'];
    }

    // Get information about specialists so operators can select the correct one
    $sqlGetSpecialistInfo = "SELECT Specialist.SpecialistID, Specialist.Availability, Specialities.Speciality FROM Specialist INNER JOIN Specialities ON Specialist.SpecialistID = Specialities.SpecialistID";
    $resultGetSpecialistInfo =  $conn->query($sql);

    $arrayOfSpecialists = array();

    if ($resultGetSpecialistInfo->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $arrayOfSpecialists[] = $row;
      }
    }

    /* Needs updating so that the following query is run when a submit button is pressed */
	/*
    echo json_encode($arrayOfSpecialists);

    $specialistID = $_POST['SpecialistID'];

    $sqlReassignToNewSpecialist = "UPDATE ProblemNumber SET SpecialistID = '$specialistID', returnToOperator = NULL WHERE ProblemNo = '$problemNo'";

    $conn->close();



	*/
    ?>

<?php
include "../databaseConnection.php";



if(isset($_POST['probNum'])){
	$problemNum=$_POST['probNum'];
	
	
	if (isset($_POST['rejectNotes'])) {
		$rejectNotes = $_POST['rejectNotes'];
		$sqlReturnToOperator = "UPDATE ProblemNumber SET Notes = '".$rejectNotes."', returnToOperator = 'No' WHERE ProblemNo = ".$problemNum;
		$resultReturnToOperator = $conn->query($sqlReturnToOperator);
    newLog($conn,'Operator Rejection',$problemNum);
	}
	
	else if (isset($_POST['accepted'])) {
		$sqlAcceptSolution = "UPDATE ProblemNumber SET Accepted = 'Yes' WHERE ProblemNo = ".$problemNum;
		$resultAcceptSolution = $conn->query($sqlAcceptSolution);
    newLog($conn,'Solution Accepted', $problemNum);
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

		$sql = "SELECT ProblemNo, ProblemType, problemPriority, SerialNumber, SoftwareName, OS, ProblemDescription, SpecialistID, Solution, Notes, Resolved FROM ProblemNumber WHERE ProblemNo = ".$problemNum;
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
