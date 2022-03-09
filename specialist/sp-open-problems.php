<?php include 'spheader.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Open Problems</title>


<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="/css/mainStyle.css">
<link rel="stylesheet" href="/css/modalStyle.css">
<link rel="stylesheet" href="/css/probTableStyle.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>


<body>

<div class="page-container">
<h1>Open Problems</h1>
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
		<th>Tickets Assigned</th>
		<th>Description</th>
		<th>Urgency</th>
	</tr></thead>
	<tbody>
	<?php
	include '../databaseConnection.php';
	//Gives number of tickets for a problem.
	function getNumTickets($conn, $problemNo) {
		//sql for getting tickets
		$sqlNumTicket = "SELECT COUNT(TicketNo) AS 'Ticks' FROM Tickets WHERE ProblemNo = '$problemNo'";
		$resultNumTicket = $conn->query($sqlNumTicket);

		$numTickets = ($resultNumTicket->fetch_assoc())['Ticks'];
		return $numTickets;
	} 

	//sql for getting open problems
	$sqlOpen = "SELECT * FROM ProblemNumber WHERE Accepted = 'No'";
	$resultOpen = $conn->query($sqlOpen);

	if ($resultOpen->num_rows > 0) {
		while ($row = $resultOpen->fetch_assoc()) {
			//Gets the number of tickets a problem has
			$tickets = getNumTickets($conn,$row['ProblemNo']);

			//Checks if there is a serial number
			if ($row['SerialNumber'] == "") {
				$serialNumber = "N/A";
			} else {
				$serialNumber = $row['SerialNumber'];
			}

			//Checks if there is software
			if ($row['Software'] == "") {
				$software = "N/A";
			} else {
				$software = $row['Software'];
			}

			//Gives results in table
			echo "<tr>" .
			"<td>" . $row['ProblemNo'] . "</td>" .
			"<td>" . $row['ProblemType'] . "</td>" .
			"<td>" . $row['1stSubmissionDate'] . "</td>" .
			"<td>" . $serialNumber . "</td>" .
			"<td>" . $software . "</td>" .
			"<td>" . $tickets . "</td>" . 
			"<td>" . $row['ProblemDescription'] . "</td>" .
			"<td>" . $row['Urgency'] . "</td>" .
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
    </div>
	</form>
	<div class="dark-table" id="callerTable2"></div>
		<br><br>
  </div>

</div>

<script src="/js/probTableScript.js"></script>
</html>
