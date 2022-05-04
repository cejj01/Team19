<?php

	$userID = $_SESSION['ID'];

	include "../databaseConnection.php";


	
	$sqlLoadProfile = "SELECT UserName, Role, ProfilePic FROM UserAccounts WHERE PersonnelID = '".$userID."'";
	$result = $conn->query($sqlLoadProfile);
	
	if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$profileContents[] = $row;
		}
	}

	$sqlGetName = "SELECT FirstName FROM Personnel WHERE PersonnelID = '".$userID."'";
	$firstName = $conn->query($sqlLoadProfile);

$conn->close();
	
?>

<script>
//loadProfile();

function loadProfile(){
	var profileContents = <?php echo json_encode($profileContents);?>;
	document.getElementById("pfp").src = profileContents[0]['ProfilePic'];
	
	//var fullName = profileContents[0]['FullName'].split(/(\s+)/);
	var firstName = $firstName;

	document.getElementById("firstName").innerHTML = firstName;
	
	document.getElementById("userName").innerHTML = profileContents[0]['UserName'];
}
</script>

