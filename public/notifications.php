
<?php
$userID = $_SESSION['ID'];
include 'databaseConnection.php';

viewNotifications($userID, $conn);
		
	if (isset($_POST['dismissNotification'])) {
		$notificationNo = $_POST['notificationNo'];
		dismissNotification($userID, $notificationNo, $conn);
	}

		
/*          functions                      */	 
	function viewNotifications($userID, $conn) {
		//UPDATE Notifications SET Solved='False'
		$notifications = array();
		//Getting notifications for user
		$sqlViewNotifications = "SELECT NotificationNo, SenderID, Date, Type, Details FROM Notifications WHERE RecipientID = '".$userID."' AND Solved = 'False' ORDER BY NotificationNo DESC";
		$resultViewNotifications = $conn->query($sqlViewNotifications);
    
		if ($resultViewNotifications->num_rows > 0) {
			 while ($row = $resultViewNotifications->fetch_assoc()) {
			   $notifications[] = $row;
			 }
		}
		
		return ($notifications);
	}

	function dismissNotification($userID, $notificationNo, $conn) {
		$sqlDismissNotification = "UPDATE Notifications SET Solved = 'True' WHERE NotificationNo = '".$notificationNo."'";
		$resultDismissNotification = $conn->query($sqlDismissNotification);
		}

	function generateNotification($conn, $userID, $recipientID, $type) {
		$notificationNo = generateNewNotificationNo($conn);
		$todaysDate = date('y-m-d');
		$sqlGenerateNotification = "INSERT INTO Notifications (RecipientID, SenderID, Date, Type, NotificationNo) Values ('".$recipientID."', '".$userID."', '".$todaysDate."', '".$type."', '".$notificationNo."')";
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
