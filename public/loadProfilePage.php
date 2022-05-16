<?php
	$userID = $_SESSION['ID'];
	include "databaseConnection.php";
	
	//$sqlLoadProfile = "SELECT UserName, FullName, Role, ProfilePic FROM UserAccounts WHERE UserID = '".$userID."'";
	$sqlLoadProfile = "SELECT UserName, Role, ProfilePic, Personnel.FirstName FROM UserAccounts LEFT JOIN Personnel ON Personnel.PersonnelID = UserAccounts.PersonnelID WHERE UserAccounts.PersonnelID = '$userID'";
	$result = $conn->query($sqlLoadProfile);
	
	if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$profileContents[] = $row;
		}
	}
$conn->close();
?>

<script>
loadProfile();

function loadProfile(){
	var profileContents = <?php echo json_encode($profileContents);?>;
	document.getElementById("pfp").src = profileContents[0]['ProfilePic'];
	document.getElementById("fullName").value = profileContents[0]['FirstName'];
	document.getElementById("pfpLink").value = profileContents[0]['ProfilePic'];
	document.getElementById("userName").value = profileContents[0]['UserName'];
	document.getElementById("userNameHead").innerHTML = profileContents[0]['UserName'];
	document.getElementById("roleName").innerHTML = profileContents[0]['Role'];
}
</script>

