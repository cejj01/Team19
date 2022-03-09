<?php
  session_start();
  if (!isset($_SESSION['ID'])) {
    header("location: /log-in.html");
  }
?>
<html lang="en">

<body>

<?php
// Save values into php variables
include 'databaseConnection.php';
$userID = $_SESSION['ID'];
$messages = array();
$message = $GET['message'];
$recipientName = $GET['target'];
$recipientID = convertRecipientNameToID($conn, $recipientName);
if ($_POST['submit'] == "Yes") {
  inputNewMessage($conn, $message, $userID, $recipientID);
}

displayAllMessages($conn, $userID, $otherUserID);
// Check if the send button is set- if true enter the message into the database
if (isset($GET['send'])) {
  $message = $GET['message'];
  inputNewMessage($conn, $message, $userID, $otherUserID);
}

// Query the database and save all messages, the sender id and the recipient id into an array
function displayAllMessages($conn, $userID, $otherUserID) {
  $sqlDisplayMessages = "SELECT chatContents, SenderID, RecipientID FROM Chat WHERE SenderID='$userID' OR RecipientID='$userID' ORDER BY chatID ASC";
  $resultDisplayMessages = $conn->query($sqlDisplayMessages);
  
  if ($resultDisplayMessages->num_rows > 0) {
    while($row = $resultDisplayMessages->fetch_assoc()) {
      global $messages;
      $messages[] = $row;
	
    }
  }
}

function inputNewMessage($conn, $message, $userID, $otherUserID) {
  $messageID = GenerateNewChatID($conn);
  $sqlInsertNewMessage = "INSERT INTO Chat (SenderID, RecipientID, ChatContents, chatID) VALUES ('$userID', '$otherUserID', '$message', '$messageID')";
  if ($conn->query($sqlInsertNewMessage) === TRUE) {
  } else {
    echo "Error: " . $sqlInsertNewMessage . "<br>" . $conn->error;
  }
}

function GenerateNewChatID($conn) {
  $sqlGetMaxChatID = "SELECT Max(ChatID) FROM Chat";
  $resultMaxChatID = $conn->query($sqlGetMaxChatID);
  $maxChatID = ($resultMaxChatID->fetch_assoc())['Max(ChatID)'];
  $newChatID = $maxChatID + 1;
  return $newChatID;
}

function convertRecipientNameToID ($conn, $recipientName) {
  $sqlGetRecipientID = "SELECT UserID FROM UserAccounts WHERE FullName = '$recipientName'";
  $resultGetRecipientID = $conn->query($sqlGetRecipientID);
  $recipientID = ($resultGetRecipientID->fetch_assoc())['UserID'];
  return $recipientID;
}

?>
</body>
</html>