<?php
include "databaseConnection.php";

if(isset($_POST['probNum'])){	
	$problemNum=$_POST['probNum'];
	$sql = "SELECT * FROM ProblemNumber INNER JOIN UserAccounts ON  ProblemNumber.SpecialistID = UserAccounts.UserID 
		WHERE ProblemNo = '$problemNum'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$dataContents[] = $row;
		}
	}
	echo json_encode($dataContents);

}

$conn->close();
	
?>