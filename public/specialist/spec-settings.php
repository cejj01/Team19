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

<form action="" method="post">
	<label for="avail">Availability?</label>

	<select name="avail" id="avail">
		<option value="Yes">Available</option>
		<option value="No">Unavailable</option>
	</select> 

    <p><input type="submit"/></p>

	<button id="saveChanges">Save Changes</button>
</form>

<?php 
include 'loadProfilePage.php';
include '../databaseConnection.php';

if (isset($_POST['avail'])) {
    $availability = $_POST['avail'];

	$sqlSpecialistAvail = "UPDATE Specialist SET Available = '"+$_POST['avail']+"' WHERE SpecialistID = '"+$_SESSION['id']+"'";
	echo $sqlSpecialistAvail;
	$conn->query($sqlSpecialistID);
}
?>

</html>
