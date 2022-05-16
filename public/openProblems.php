<?php
include "databaseConnection.php";

if(isset($_POST['probNum'])){	
	$problemNum=$_POST['probNum'];
	$sql = "SELECT * FROM ProblemNumber LEFT JOIN ProblemTypes ON ProblemTypes.ProblemTypeID = ProblemNumber.ProblemTypeID LEFT JOIN OS ON OS.OSID = ProblemNumber.OSID LEFT JOIN Personnel ON Personnel.PersonnelID = ProblemNumber.SpecialistID LEFT JOIN Software ON Software.SoftwareID = ProblemNumber.SoftwareID WHERE ProblemID = '$problemNum'";	
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