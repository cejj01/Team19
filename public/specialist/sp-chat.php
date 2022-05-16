<?php include 'spheader.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>

<title>Chat</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="/css/mainStyle.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>


function submitChatUsingAjax() {
	// Instantiate XMLHttpRequest
	var httpRequest = new XMLHttpRequest;

	// Save the message and the recipient id to variables
	var target = document.getElementById('target').innerHTML;
	var message =  document.getElementById('message').innerHTML;

	// Asynchronously send the data to the backend
	httpRequest.open("GET", "../chatBackend.php?message=" + message + "&target=" + target, true);
	httpRequest.send();
}

/*When a chat preview is clicked it will display a message history */
function showFullChat() {
var previewMessages = document.getElementsByClassName("message-preview");
   for (var i = 0; i < previewMessages.length; i++) {
	previewMessages[i].style.display='none';
   }
var fullChat = document.getElementById("full-chat");
fullChat.style.display='block';

var backArrow = document.getElementById("back-arrow");
backArrow.style.color="#b4f0c3";


}

/*When the back arrow is clicked hide all of the message histories and display all of the message previews and disable the back arrow */
function clickBackArrow() {
var previewMessages = document.getElementsByClassName("message-preview");
   for (var i = 0; i < previewMessages.length; i++) {
	previewMessages[i].style.display='block';
   }
var fullChats = document.getElementsByClassName("full-chat");
for (var i = 0; i < fullChats.length; i++) {
	fullChats[i].style.display='none';   
}
var backArrow = document.getElementById("back-arrow");
backArrow.style.color="#919294";


}

</script>   

<style>
#back-arrow {
text-align:left;
font-size: 200%;
color: #919294;
}

#back-arrow:hover,
#back-arrow:focus {
  color: #919294;
  text-decoration: none;
  cursor: pointer;
}


#forward-arrow {
text-align:left;
font-size: 200%;
}

#forward-arrow:hover,
#forward-arrow:focus {
  color: #F6D300;
  text-decoration: none;
  cursor: pointer;
}

#arrows {
text-align:left;
}
p {
margin:0;
padding:0px;
}
.full-chat {
  position:relative;
  width: 90%;
  height: 70vh;
  padding-top:10px;
  padding-right: 15px;
  padding-left: 15px;
  padding-bottom:30px;
  text-align: center;
  background: white;
  color: black;
  font-weight: 700;
  margin: auto;
  margin-bottom: 10px;
  font-size: 90%;
  border-style: solid;
  border-color: #919294;
  border-radius: 10px;
  border-width: 1px;
  display:none;


}

.chat-input-div {
  width: 99%;
  height: 6vh;
  position:absolute;
  bottom:3vh;
}

.input-area {
 width: 99%;
  height: 100%;
}
.send-button {
width: 10%;


}
.message-preview {
  width: 90%;
  padding-top:10px;
  padding-right: 15px;
  padding-left: 15px;
  padding-bottom:30px;
  text-align: center;
  background: white;
  color: black;
  font-weight: 700;
  margin: auto;
  margin-bottom: 10px;
  font-size: 90%;
  border-style: solid;
  border-color: #919294;
  border-radius: 10px;
  border-width: 1px;
}

.message-preview:hover,
.message-preview:focus {
  color: #919294;
  text-decoration: none;
  cursor: pointer;
}


.name {
float:left;
font-size:150%;

}

.last-message-date{
float:right;
}

.last-message-content {
text-align: left;

}

</style>

</head>


<body>
<div style="background-image">
<br>
<form hidden id="hiddenForm" action="../chatBackend.php" method="GET">
<input name="target" id="hiddenTarget"> </input>
<input name="message" id="hiddenMessage"> </input>
<input name="submit" id="hiddenSubmit"></input>

</form>

<div class="page-container" id="main">
<!--Submit new ticket form-->
	

	<h1>Chat</h1>
	<hr>
	<p id="arrows"> <span id="back-arrow" onclick="clickBackArrow()">&#129092;</span></p>

</div>
<?php 
include "../databaseConnection.php";
// Use sessions to get the userID
$userID = $_SESSION['ID'];
// Get the username from the userID
$sqlGetUserName = "SELECT FullName from UserAccounts WHERE UserID = '$userID'";
$resultGetUserName = $conn->query($sqlGetUserName);
if ($resultGetUserName->num_rows > 0) {
	$userName = ($resultGetUserName->fetch_assoc())['FullName'];
}
  $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= "/chatLoadUsers.php";
    include $path;
	$path2 = $_SERVER['DOCUMENT_ROOT'];
    $path2 .= "/chatBackend.php";
    include $path2;?>
<script>
/*Construct dynamically the message previews and message histories  */  
	var Users = <?php echo json_encode($users);?>;
	var AllMessages = <?php echo json_encode($messages);?>;
	var NumberOfUsers = Users.length;
	var currentUser = "<?php echo $userName;?>";
	const ChatPreviews = [];
	const FullChats = [];
	const Names = [];
	const Divs = [];
	const Inputs = [];
	const Buttons = [];
	const Messages = [];
	const Forms = [];

	/*Loop through every user that the person chats with and created the message preview and the message history */
	for (var i=0; i < NumberOfUsers; i++) {

		//create message preview divs
		ChatPreviews.push(document.createElement("div"));		
		ChatPreviews[i].classList.add("message-preview");
		Names.push(document.createElement("div"));
		Names[i].innerHTML = Users[i]['FullName'];
		Names[i].classList.add("name");
		ChatPreviews[i].appendChild(Names[i]);
		document.getElementById("main").appendChild(ChatPreviews[i]);

		//create a full chat for each message preview
		FullChats.push(document.createElement("div"));
		FullChats[i].classList.add("full-chat");
		Divs.push(document.createElement("div"));
		Divs[i].classList.add("chat-input-div");
		FullChats[i].appendChild(Divs[i]);
		//add messages to full chat

		for (var j=0; j < AllMessages.length; j++) {
			if (AllMessages[j]['RecipientID'] == Users[i]['UserID']) {				
				Messages.push(document.createElement("div"));
				Messages[Messages.length - 1].style.textAlign = "left";
								Messages[Messages.length - 1].innerHTML = currentUser.concat(": ", AllMessages[j]['chatContents']);
				FullChats[i].appendChild(Messages[Messages.length - 1]); 
			}
			if (AllMessages[j]['RecipientID'] == currentUser) {				
				Messages.push(document.createElement("div"));
				Messages[Messages.length - 1].style.textAlign = "left";
				Messages[Messages.length - 1].innerHTML = Users[i]['FullName'].concat(": ", AllMessages[j]['chatContents']);
				FullChats[i].appendChild(Messages[Messages.length - 1]); 
			}

		}
		/*Create the send button and the area to type the message */
		Inputs.push(document.createElement("textarea")); 
		Inputs[i].classList.add("input-area");
		Divs[i].appendChild(Inputs[i]);
		Buttons.push(document.createElement("button"));
		Buttons[i].classList.add("send-button");
		Buttons[i].innerHTML = "Send";
		Divs[i].appendChild(Buttons[i]);
		document.getElementById("main").appendChild(FullChats[i]);
		
		
	}
	// Create functions that link every message preview to message history
	var datamap = new Map([])

	for (var i=0; i < ChatPreviews.length; i++) {
		datamap.set(ChatPreviews[i], FullChats[i]);
	}
 	

 	datamap.forEach((value, key) => {
            makeChats(key, value); //for each chat and chat preview, make them link to each other
        });
	function makeChats(thebutton, thechat) {

// This opens message history
	thebutton.addEventListener("click", function (event) {
	   	for (var i = 0; i < ChatPreviews.length; i++) {
			ChatPreviews[i].style.display='none';
		   }
		thechat.style.display = 'block';
		var backArrow = document.getElementById("back-arrow");
		backArrow.style.color="#b4f0c3";
	})
	
	thechat.firstChild.firstChild.nextSibling.addEventListener("click", function(event) {
		var nextMessage = document.createElement("div");
		nextMessage.style.textAlign = "left";
		nextMessage.innerHTML = currentUser + ": " + thechat.firstChild.firstChild.value;
		thechat.appendChild(nextMessage);
			document.getElementById("hiddenTarget").value = thebutton.firstChild.innerHTML;
		document.getElementById("hiddenMessage").value = thechat.firstChild.firstChild.value; 
		document.getElementById("hiddenSubmit").value = "Yes";
		document.getElementById("hiddenForm").requestSubmit();
		submitChatUsingAjax();
	
	})
}
</script>
</body>
</html>