<?php include 'analheader.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>All Tickets</title>


<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="/css/mainStyle.css">
<link rel="stylesheet" href="/css/modalStyle.css">
<link rel="stylesheet" href="/css/probTableStyle.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<?php
include "../databaseConnection.php";
include '../logs.php';
?>

<body>

<div class="page-container">
<h1>All Tickets</h1>
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
		<th>Problem#</th>
		<th>Problem Type</th>
		<th>Date Assigned</th>
		<th>Serial Number</th>
		<th>Software</th>
		<th>OS</th>
		<th>Description</th>
	</tr></thead>
	<tbody>
	<?php
	include '../databaseConnection.php';
	//Gives number of tickets for a problem.
	function getNumTickets($conn, $problemNo) {
		//sql for getting tickets
		$sqlNumTicket = "SELECT COUNT(TicketID) AS 'Ticks' FROM Tickets WHERE ProblemID = '$problemNo'";
		$resultNumTicket = $conn->query($sqlNumTicket);

		$numTickets = ($resultNumTicket->fetch_assoc())['Ticks'];
		return $numTickets;
	} 

	//sql for getting open problems
	$sqlOpen = "SELECT ProblemNumber.ProblemID, ProblemNumber.ProblemDescription, ProblemTypes.ProblemType, ProblemNumber.1stSubmissionDate, ProblemNumber.SerialNumber, Software.Software, OS.OS 
	FROM ProblemNumber LEFT JOIN ProblemTypes ON ProblemTypes.ProblemTypeID = ProblemNumber.ProblemTypeID 
	LEFT JOIN Software ON Software.SoftwareID = ProblemNumber.SoftwareID LEFT JOIN OS ON OS.OSID = ProblemNumber.OSID";
	//$sqlOpen = "SELECT * FROM ProblemNumber";
	$resultOpen = $conn->query($sqlOpen);

	if ($resultOpen->num_rows > 0) {
		while ($row = $resultOpen->fetch_assoc()) {
			//Gets the number of tickets a problem has
			$tickets = getNumTickets($conn,$row['ProblemID']);

			//Checks if there is a serial number
			/*if ($row['SerialNumber'] == "") {
				$serialNumber = "N/A";
			} else {
				$serialNumber = $row['SerialNumber'];
			}*/

			//Checks if there is software
			/*if ($row['SoftwareID'] == 0) {
				$software = "N/A";
			} else {
				$sqlSoftware = "SELECT * FROM Software WHERE SoftwareID = $row['SoftwareID']";
				$resultSoftware = mysqli_query($sqlSOftware);
				$rowSoftware = mysqli_fetch_assoc($result);
				$software = $rowSoftware['Software'];
			}*/

			//Gives results in table
			echo "<tr>" .
			"<td>" . $row['ProblemID'] . "</td>" .
			"<td>" . $row['ProblemType'] . "</td>" .
			"<td>" . $row['1stSubmissionDate'] . "</td>" .
			"<td>" . $row['SerialNumber'] . "</td>" .
			"<td>" . $row['Software'] ."</td>" .
			"<td>" . $row['OS'] ."</td>" .
			"<td>" . $row['ProblemDescription'] ."</td>" .
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
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Problem Details</h2>
	<hr>
    </div>

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
	<input type="submit" name="submitUpdateProblem" value="Update Problem">
    </div>
	</form>
	<div class="dark-table" id="callerTable2"></div>
		<br><br>
  </div>

</div>


</body>
<?php include '../openProblems.php'; ?>
<?php include '../openProblemsCallerTable.php'; ?>
<script src="/js/probTableScript.js"></script>
<?php
//Close db connection
$conn->close();

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
?>

<script>
//Ensures the form data is reset upon submission
if (window.history.replaceState) {
    window.history.replaceState (null, null, window.location.href);
}
</script>
</html>