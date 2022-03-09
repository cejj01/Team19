<?php

	$userID = $_SESSION['ID'];

	include "../databaseConnection.php";


	
	$sqlLoadProfile = "SELECT UserName, FullName, Role, ProfilePic FROM UserAccounts WHERE UserID = '".$userID."'";
	$result = $conn->query($sqlLoadProfile);
	
	if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$profileContents[] = $row;
		}
	}
	
	
//}

$conn->close();
	
?>

<script>
loadProfile();

function loadProfile(){
	var profileContents = <?php echo json_encode($profileContents);?>;
	document.getElementById("pfp").src = profileContents[0]['ProfilePic'];
	
	var fullName = profileContents[0]['FullName'].split(/(\s+)/);
	document.getElementById("firstName").innerHTML = fullName[0];
	
	document.getElementById("userName").innerHTML = profileContents[0]['UserName'];
}
</script>

