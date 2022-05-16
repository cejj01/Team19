<?php include 'userHeader.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Open Problems</title>


<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="/css/mainStyle.css">
<link rel="stylesheet" href="/css/modalStyle.css">
<link rel="stylesheet" href="/css/probTableStyle.css">
<style>
.left-input {
text-align: left;
margin-left: 0; 
margin-right: auto;
float: left;
}

.right-input {

text-align: left;
float: left;
margin-left: auto; 
margin-right: 0;
}

#chatheader {
text-align:center;
}
#chatbox {
width: 100%;
height:50%;
}
#messagebox {
width: 100%;
}
#specialistID {
display: none;
}

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<?php
include "../databaseConnection.php";
include '../logs.php';
?>

<body>
<?php
include "../databaseConnection.php";
$sqlOpen = "SELECT * FROM Chat";
$resultOpen = $conn->query($sqlOpen);

	if ($resultOpen->num_rows > 0) {
		while ($row = $resultOpen->fetch_assoc()) {
		$chatContents[] = $row;
	}
	}

$a = json_encode($chatContents);
echo "<script>var chat = $a</script>";

?>

<div class="page-container">
<h1>My Tickets</h1>
<hr>

<div id="ticketTable">


<div id="searchSettings">
<label for="searchBar">Search: </label>
<input name="searchBar" type="text" id="searchBar" oninput="FilterProblems()" placeholder="Search">
<label for="searchType">Search By:</label>
	<select name="searchType" id="searchType">
	 <option value = 0> Problem No. </option>
	<option value = 1> Problem Type </option>
	<option value = 3> Serial No. </option>
	<option value = 4> Software. </option>
	</select>
</div>	
	
<table class="dark-table" id="ProblemTable" onclick="SelectRow(event)">
	<thead>
	<tr>
		<th>ProblemID</th>
		<th>Serial Number</th>
		<th>Software ID</th>
		<th>Problem Description</th>
		<th>Accepted</th>
		<th>Solution</th>
	</tr></thead>
	<tbody>
	<?php
	include '../databaseConnection.php';
	//Gives number of tickets for a problem.
	function getNumTickets($conn, $problemID) {
		//sql for getting tickets
		$sqlNumTicket = "SELECT COUNT(TicketNo) AS 'Ticks' FROM Tickets WHERE ProblemID = '$problemID'";
		$resultNumTicket = $conn->query($sqlNumTicket);

		$numTickets = ($resultNumTicket->fetch_assoc())['Ticks'];
		return $numTickets;
	} 

	//sql for getting open problems
	$userID = $_SESSION['ID'];
	$sqlOpen = "SELECT					ProblemNumber.ProblemID as 'ProblemID', 
    				ProblemNumber.SerialNumber as 'SerialNumber',
    				ProblemNumber.SoftwareID as 'SoftwareID', 
    				ProblemNumber.Solution as 'Solution', 
    				ProblemNumber.Accepted as 'Accepted',
					ProblemNumber.ProblemDescription as 'ProblemDescription'
				FROM ProblemNumber 
				INNER JOIN Tickets ON Tickets.ProblemID=ProblemNumber.ProblemID 
				WHERE Tickets.PersonnelID = $userID";

	$resultOpen = $conn->query($sqlOpen);

	if ($resultOpen->num_rows > 0) {
		while ($row = $resultOpen->fetch_assoc()) {
			//Gets the number of tickets a problem has
		
			

			//Checks if there is a serial number
			if ($row['SerialNumber'] == "") {
				$serialNumber = "N/A";
			} else {
				$serialNumber = $row['SerialNumber'];
			}

			//Checks if there is software
			if ($row['SoftwareID'] == "0") {
				$software = "N/A";
			} else {
				$software = $row['SoftwareID'];
			}

			//Gives results in table
			echo "<tr>" .
			"<td>" . $row['ProblemID'] . "</td>" .
			"<td>" . $serialNumber . "</td>" .
			"<td>" . $software . "</td>" .
			"<td style = 'word-wrap: break-word;' >" . $row['ProblemDescription'] . "</td>" .
			"<td>" . $row['Accepted'] . "</td>" .
			"<td>" . $row['Solution'] . "</td>" .
			
			"</tr>";
			
		}
	}
	?>
			
</tbody>
</table>
</div>

</div>

<!-- Update Problem Modal  -->
<div id="AddCallerModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content" style="overflow:hidden;">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Problem Details</h2>
	<hr>
    </div>

<div class="left-input" style="width:50%;">
<h2 id="chatheader"> Info </h2>
	<form id="updateProblem" method="post">
    <div class="modal-body">
	<label for="problemNum">Problem#</label>
    <input name="problemNum" type="text" id="problemNum" value="0" size="4" readonly>
	<label for="probType">Problem Type:</label>
	<select name="probType" id="probType" required>
		<?php include '../problemTypeSelection.php';?>
	</select>
	<hr>
	
	<label for="callDate">Original Call Date</label>
    <input name="callDate" id="callDate" readonly>
	<hr>
	
	<label for="serialNum">Serial#</label>
    <input name="serialNum" type="text" id="serialNum"/>
    <label for="operatingSystem">Operating System</label>
    <select name="operatingSystem" id="OS">
		<option value=""></option>
		<option value="Mac">Mac</option>
		<option value="Window">Windows</option>
		<option value="Linux">Linux</option>
		<option value="Other">Other</option>
	</select>

	<label for="software">Software</label>
    <input name="software" type="text" id="software">
	<hr>
	
	<label  for="specialist">Specialist:</label>
	<input class="square-button-input" name ="specialist" id="SpecialistName" type = "text" readonly />
	
	<label for="Priority">Priority</label>
	<select name="Priority" id="priority" required>
		<option value="High">High</option>
		<option value="Medium">Medium</option>
		<option value="Low">Low</option>
    </select>
	<hr>
	
	<label for="notes">Description</label>
	<br>
    <textarea id="notes" name="notes" rows="5"></textarea>
	</div>

    <div class="modal-footer">
	<hr>
	<br>
	<input type="submit" name="submitUpdateProblem" value="Update Problem"/>
    </div>
	</form>
</div>
<div class="left-input" style="width:45%;">
<form method ="post">
<h2 id="chatheader">Chat</h2>
<input name="specialistID" type="text" id="specialistID"/>
<textarea id="chatbox" name = "chatbox">
</textarea>
<textarea id="messagebox" name="messagebox" >
</textarea>
<div style="text-align:center;">
<input type="submit" name="submitMessage" id="submitMessage" value="Send Message"/>
</form>
</div>
</div>

</div>
<script>

function FilterProblems() {
		var filter = document.getElementById("searchBar").value.toUpperCase();
		var table = document.getElementById("ProblemTable");
		var tr = table.getElementsByTagName("tr");
		var td;
		
		if (filter == "") {
			for (i = 0; i < tr.length; i++) {
				tr[i].style.display = "";
			}
		} else {

			for (i = 0; i < tr.length; i++) {
				td = tr[i].getElementsByTagName("td")[document.getElementById("searchType").value];
				if (td) {
      				txtValue = td.textContent || td.innerText;
				
      					if (txtValue.toUpperCase().includes(filter)) {
      						tr[i].style.display = "";
						if (txtValue.toUpperCase().includes("N/A")) {
							tr[i].style.display = "none";
						}
     					 } else {
    					 	tr[i].style.display = "none";
    					 }
				
   				}

			}
			}
	}

</script>
</body>
<?php include '../openProblems.php'; ?>
<?php include '../openProblemsCallerTable.php'; ?>
<script src="/js/probTableScript.js"></script>
<?php
//Close db connection
$conn->close();

//load all chat




//Gets specialist ID from name
function getSpecialistID($conn,$name) {
	//sql to get specialist ID
	$sqlSpecialistID = "SELECT UserID FROM UserAccounts WHERE UserName = '$name'";
	$resultSpecialistID = $conn->query($sqlSpecialistID);
  
	$specialistID = $resultSpecialistID->fetch_assoc()["UserID"];
	return $specialistID;
  }

if (isset($_POST["submitUpdateProblem"])) {


	//open db connection
	include "../databaseConnection.php";

	//values from form
	$problemNo = $_POST["problemNum"];
	$probType = $_POST["probType"];
	$serial = $_POST["serialNum"];
	$opSystem = $_POST["operatingSystem"];
	$software = $_POST["software"];
	$priority = $_POST["Priority"];
	$description = $_POST["notes"];
	$specialist = $_POST["specName"];

	//gets specialist id
	$specialistID = getSpecialistID($conn,$specialist);

	//sql for updating the problem
	$sqlUpdateProb = "UPDATE ProblemNumber SET ProblemType='$probType', SerialNumber='$serial', SoftwareName='$software', OS='$opSystem', 
		ProblemDescription='$description', SpecialistID='$specialistID', problemPriority='$priority' WHERE ProblemNo = '$problemNo'";
	
	if ($conn->query($sqlUpdateProb) === TRUE) {
		//logs updated problem
		newLog($conn,'Updated',$problemNo);
	} else {
		echo "Error updating record: " . $conn->error;
	}

	//close db connection
	$conn->close();
}

if (isset($_POST["submitMessage"])) {
include '../databaseConnection.php';

  $sqlPrevProblem = "SELECT MAX(ChatID) AS 'ChatID' FROM Chat";
  $probResult = mysqli_query($conn, $sqlPrevProblem);
  $oldProblemNumStr = ($probResult->fetch_assoc())["ChatID"];
  $problemNumInt = intval($oldProblemNumStr) + 1;
  $problemNum = strval($problemNumInt);
$chatID = $problemNum;


$senderID = $_SESSION['ID'];

$recipientID = $_POST['specialistID'];
$chatContents = $_POST['messagebox'];
$chatStatus = 1;
$date = date("Y/m/d H:i:s");
$sqlNewChat = "INSERT INTO Chat VALUES ('$chatID', '$senderID', '$recipientID', '$chatContents', '$chatStatus', '$date')";	
	if ($conn->query($sqlNewChat)) {
  } else {
    echo "Error" . mysqli_error($conn);
  }

 //close db connection.
  $conn->close();

}

//Adds new problem to database

?>

<script>
//Ensures the form data is reset upon submission
if (window.history.replaceState) {
    window.history.replaceState (null, null, window.location.href);
}
</script>
</html>
