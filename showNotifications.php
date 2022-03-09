<script>
loadNotifs();

function loadNotifs(){
	var notifications = <?php echo json_encode(viewNotifications($userID, $conn));?>;

	var notifInbox = document.getElementById('notifDiv');
	notifInbox.innerHTML = "";
	if (notifications!=null){
		var numberOfNotifs = notifications.length;
		
		
		for (var i=0; i < numberOfNotifs; i++) {
			var newNotif = document.createElement("div");
			newNotif.classList.add("notification");

			newNotif.innerHTML = '<h6>'+notifications[i]['Type']+'</h6><p>'+notifications[i]['Details']+'</p><button class="dismissBtn" onclick="dismissNotif('+notifications[i]['NotificationNo']+')">×</button><hr>';
			//newNotif.setAttribute('onclick', "loadInbox('"+inboxThumbnail[i]['ProblemNo']+"')");
			notifInbox.appendChild (newNotif);
		}
	}
}

async function dismissNotif(notifNum){
	const xhr = new XMLHttpRequest();
	xhr.onload = await function(){;

		window.location.reload();
	}
	//xhr.onerror
	xhr.open('POST', '/notifications.php');
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send('notificationNo='+notifNum+'&dismissNotification=1');
}
</script>