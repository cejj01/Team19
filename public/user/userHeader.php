<?php  
  session_start();
  if (!isset($_SESSION['ID'])) {
    header("location: /log-in.html");
  }
  ?>
<header>
<link rel="stylesheet" href="/css/headerStyle.css">
<title>Make-It-All Helpdesk</title>

<div id="Head">


<!-- Links to each page -->

<div id="headLinks">


<table>
	<col style="width:8%"><!--Logo-->
	<col style="width:13%"><!--Links-->
	<col style="width:13%">
	<col style="width:13%">
	<col style="width:13%">
	<col style="width:13%">
	<col style="width:2%"><!--Notif-->
	<col style="width:10%"><!--Account-->
	<td><a href="http://teamb019.sci-project.lboro.ac.uk:5019/log-in.php"><img src="/src/Make-It-AllTextWhite.png" alt="Make-It-All Logo" class="logo"></a></td>
<div class="pageLinks">
	<td><a href="/user/userHome.php">Home</a></td>
	<td><a href="/user/userTickets.php">My Tickets</a></td>
	<td><a href="/account-settings.php">My Account</a></td>
	<td><a></a></td>
	<td><a href="http://teamb019.sci-project.lboro.ac.uk:5019/log-in.php">Logout</a> </td>
<td>
<!-- Notification Button -->
<div id="notif_button" onclick="toggleNotifications()"> <img src="/src/notification-bell.png" alt="img"></div>
<div id="notif_container">
    <h5>Notifications</h5>
    <hr>
		<div id="notifDiv">
		</div>
</div>
</td>
<td id="user_account" onclick="toggleAccountDrop()">
<img src="https://imgur.com/C2pZ3OV.jpg" alt="Dion B)" id="pfp"><text id="firstName">Dion</text>
<div id="acc_container">
    <h5 id="userName">Dion6.9</h5>
    <hr>
    <div class="choice">
        <h6><a href="/account-settings.php">Account Settings</a></h6>
    </div>
    <hr>
	<div class="choice">
        <h6><a href="/log-in.html">Logout</a></h6>
    </div>
</div>
</td>

</table>	
	


</div>
</div>
<br>
<br>
<br>
<br>
</header>

<?php include '../loadProfile.php'?>

<?php include '../notifications.php'?>

<?php include '../showNotifications.php'?>

<script src="/js/headerScript.js"></script>