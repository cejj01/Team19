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
	<col style="width:40%"><!--Links-->
	<col style="width:2%"><!--Notif-->
	<col style="width:10%"><!--Account-->
<td><a href="http://35.242.175.222"><img src="/src/Make-It-All Text White.png" alt="Make-It-All Logo" class="logo"></a></td>
<div class="pageLinks">
	<td><a href="http://35.242.175.222/admin/admin-logs.php">Logs</a></td>
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
    <h5 id="userName">Dionnnn6.9</h5>
    <hr>
    <div class="choice">
        <h6><a href="http://35.242.175.222/account-settings.php">Account Settings</a></h6>
    </div>
    <hr>
	<div class="choice">
        <h6><a href="http://35.242.175.222/log-in.html">Logout</a></h6>
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