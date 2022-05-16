
<?php
$userID = $_SESSION['ID'];
include 'databaseConnection.php';

viewNotifications($userID, $conn);
		
	if (isset($_POST['dismissNotification'])) {
		$notificationNo = $_POST['notificationNo'];
		dismissNotification($userID, $notificationNo, $conn);
	}

/* functions */	 
	function viewNotifications($userID, $conn) {
		//UPDATE Notifications SET Solved='False'
		$notifications = array();
		//Getting notifications for user
		$sqlViewNotifications = "SELECT NotificationNo, SenderID, DateTime, NotificationsType.Type FROM Notifications LEFT JOIN NotificationsType ON NotificationsType.TypeID = Notifications.TypeID WHERE RecipientID = '".$userID."' AND Solved = 0 ORDER BY NotificationNo DESC";
		$resultViewNotifications = $conn->query($sqlViewNotifications);
    
		if ($resultViewNotifications->num_rows > 0) {
			 while ($row = $resultViewNotifications->fetch_assoc()) {
			   $notifications[] = $row;
			 }
		}
		return ($notifications);
	}

	function dismissNotification($userID, $notificationNo, $conn) {
		$sqlDismissNotification = "UPDATE Notifications SET Solved = 1 WHERE NotificationNo = '".$notificationNo."'";
		$resultDismissNotification = $conn->query($sqlDismissNotification);
		}

	function generateNotification($conn, $userID, $recipientID, $typeID) {
		$notificationNo = generateNewNotificationNo($conn);
		$todaysDateTime = date('Y-m-d H:i:s');
		$sqlGenerateNotification = "INSERT INTO Notifications (RecipientID, SenderID, DateTime, TypeID, NotificationNo) Values ('".$recipientID."', '".$userID."', '".$todaysDateTime."', '".$typeID."', '".$notificationNo."')";
		$resultGenerateNotification = $conn->query($sqlGenerateNotification);
		}

	function generateNewNotificationNo ($conn) {
		$sqlGenerateNewNotificationNo = "SELECT MAX(NotificationNo) FROM Notifications";
		$resultGenerateNewNotificationNo = $conn->query($sqlGenerateNewNotificationNo);
		$MaxNotificationsNo = ($resultGenerateNewNotificationNo->fetch_assoc())['MAX(NotificationNo)'];
		$newNotificationNo = $MaxNotificationsNo + 1;
		return $newNotificationNo;
		}


?> 
