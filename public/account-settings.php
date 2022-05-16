<?php
	session_start();
	if (!isset($_SESSION['ID'])) {
    header("location: /log-in.html");
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>

<title>Account Settings</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="/css/mainStyle.css">
<style>
#pfp {
	text-align: center;
	width: 256px;
	height: 256px;
	margin: 10px;
	border: 5px solid #aaaaaa;
}

input{
	width: auto;
	margin: 10px;
	padding: 5px;
}

.names {
	margin: 20px;
}

.security {
	border: 1px solid #ffffff;
	margin: 10px;
}

button {
	margin: 10px;
}
#saveChanges {
	font-size: 20px;
	background-color: blue;
	color: white;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>


<body>
<br>
<div class="page-container">
<img src="" alt="Pic" id="pfp">
<h1 id="userNameHead">FFFred</h1>
<h3 id="roleName">Analyst<h3>
<hr>

<div class="names">
	<label for="username">Username: </label>
	<input name="username" type="text" id="userName" value="">
	<label for="name">Name: </label>
	<input name="name" type="text" id="fullName" value="">
</div>

<div class="pfpChange">
	<label for="pfpLink">Profile Picture Link: </label>
	<input name="pfpLink" type="text" id="pfpLink" value="">
</div>

<div class="security">
	<label for="currentPass">Current Password: </label>
	<input name="currentPass" type="password" id="currentPass" placeholder="Current">
	<br>
	<label for="newPass">New Password: </label>
	<input name="newPass" type="password" id="newPass" placeholder="New">
	<label for="confirmPass">Confirm Password: </label>
	<input name="confirmPass" type="password" id="confirmPass" placeholder="Confirm">
	<br>
	<button id="changePass">Update Password</button>
</div>

<button id="saveChanges">Save Changes</button>

<form action="" method="post" id="availChange">
	<label for="avail">Availability?</label>

	<select name="avail" id="avail">
		<option value=1>Available</option>
		<option value=0>Unavailable</option>
	</select> 

    <p><input type="submit" value="Save availablity"/></p>

</form>

<?php
include 'loadProfilePage.php';
include 'databaseConnection.php';

		if (isset($_POST['avail'])) {
			$availability = $_POST['avail'];
			//echo $availability;
			//echo $_SESSION['ID'];
			$sqlSpecialistAvail = "UPDATE Specialist SET Available = ". strval($_POST['avail']) ." WHERE SpecialistID = ". strval($_SESSION['ID']);
			//echo $sqlSpecialistAvail;
			$result = $conn->query($sqlSpecialistAvail);
			unset($_POST['avail']);
		}

		if (isset($_POST['CurrentSpecialities'])) {
			$specToRemove = $_POST['CurrentSpecialities'];
			//echo $specToRemove;
			if ($specToRemove != "--"){
				$sqlSpecialityRemove = "DELETE FROM Specialities WHERE ProblemTypeID = ".$specToRemove." AND SpecialistID = ".  strval($_SESSION['ID']);
				//echo $sqlSpecialityRemove;
				$result = $conn->query($sqlSpecialityRemove);
			}
			unset($_POST['CurrentSpecialities']);
		}

		if (isset($_POST['Unassignedspecialities'])) {
			$specToAdd = $_POST['Unassignedspecialities'];
			//echo $specToAdd;
			if ($specToAdd != "--"){
				$sqlSpecialityAdd = "INSERT INTO Specialities(SpecialistID, ProblemTypeID) VALUES(".strval($_SESSION['ID']).",".strval($specToAdd).")";
				//echo $sqlSpecialityAdd;
				$result = $conn->query($sqlSpecialityAdd);
			}
			unset($_POST['Unassignedspecialities']);
		}

		$sqlGetMySpecialities = "SELECT ProblemTypeID FROM Specialities WHERE SpecialistID = ".(strval($_SESSION['ID']));
		//echo ($sqlGetMySpecialities);
		//echo (strval($_SESSION['ID']));
		$specialtyQuery = $conn->query($sqlGetMySpecialities);
		$mySpecialities = array();
		if ($specialtyQuery->num_rows > 0) {
			while($row = $specialtyQuery->fetch_assoc()) {
			array_push($mySpecialities, $row['ProblemTypeID']);
			//echo ($row['ProblemTypeID']);
			}
		} 


		$sqlGetSpecialities = "SELECT ProblemTypeID, ProblemType, SubProblemType FROM ProblemTypes";
		$specialtyQuery = $conn->query($sqlGetSpecialities);
		//echo $sqlGetSpecialities;
		//echo $specialtyList;
		$specialtiesArray = array(array());
		if ($specialtyQuery->num_rows > 0) {
			while($row = $specialtyQuery->fetch_assoc()) {
			array_push($specialtiesArray, [$row['ProblemTypeID'], $row['ProblemType'], $row['SubProblemType']]);
			//echo ([$row['ProblemTypeID'], $row['ProblemType']]);
			}
		};
		//echo $specialtiesArray;

	


?>

<form action="" method="post" id="curSpecChange">
	<label for="CurrentSpecialities">Current specialities:</label>
	<select name = "CurrentSpecialities">
		<option> -- </option>;
		<?php
		foreach ($specialtiesArray AS $specialty) {
			if (in_array($specialty[0], $mySpecialities)){
				echo "<option value='".$specialty[0]."'>".$specialty[1]." - ".$specialty[2]."</option>";
			}
		}
		?>

	</select>
	<p><input type="submit" value="Remove speciality"/></p>
</form>

<form action="" method="post" id ="unassSpecChange">
<label for="Unassignedspecialities">Unassigned specialities:</label>
	<select name = "Unassignedspecialities">
		<option> -- </option>;
		<?php
		foreach ($specialtiesArray AS $specialty) {
			if (!in_array($specialty[0], $mySpecialities)){
				echo "<option value='".$specialty[0]."'>".$specialty[1]." - ".$specialty[2]."</option>";
			}
		}
		?>

	</select>
	<p><input type="submit" value="Add speciality"/></p>
</form>


<?php
include 'loadProfilePage.php';
include 'databaseConnection.php';
	if ($_SESSION['Role'] != "specialist"){
		//echo "non specialist detected";
		echo"<script type='text/javascript'>document.getElementById('availChange').style.display = 'none';</script>";
		echo"<script type='text/javascript'>document.getElementById('curSpecChange').style.display = 'none';</script>";
		echo"<script type='text/javascript'>document.getElementById('unassSpecChange').style.display = 'none';</script>";
	}
?>



</body>
<footer>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</footer>
</html>
