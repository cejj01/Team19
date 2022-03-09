<?php include 'adminheader.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Logs</title>


<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="/css/mainStyle.css">
<link rel="stylesheet" href="/css/modalStyle.css">
<link rel="stylesheet" href="/css/probTableStyle.css">
<style>
.showTicket {
	vertical-align: middle;
	width: 15px;
}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>


<body>

<div class="page-container">
<h1>Logs</h1>
<hr>

<div id="ticketTable">

<div id="searchSettings">
<label for="searchBar">Search: </label>
<input name="searchBar" type="text" id="searchBar" placeholder="Search">
<label for="logType">Log Type:</label>
	<select name="logType" id="logType">
		<option value="all">All</option>
		<optgroup label="Ticket">
			<option value="ticketCreate">Created Ticket</option>
			<option value="ticketUpdate">Updated Ticket</option>
			<option value="ticketClose">Closed Ticket</option>
		</optgroup>
		<optgroup label="Problem">
			<option value="probCreate">Created Problem</option>
			<option value="probUpdate">Updated Problem</option>
			<option value="probSolve">Solved Problem</option>
		</optgroup>
	</select>
</div>

<table class="dark-table" >
<thead>
	<tr>
		<th>Log#</th>
		<th>Log Type</th>
		<th>Date</th>
		<th>Time</th>
		<th>Problem#</th>
	</tr>
</thead>
<tbody>
<?php
include '../databaseConnection.php';
//sql for getting log type 
$sqlLogging = "SELECT * FROM Log";
$resultLogging = $conn->query($sqlLogging);

if ($resultLogging->num_rows > 0) {
	while ($row = $resultLogging->fetch_assoc()) {
		echo "<tr>";
		echo "<td>" . $row['LogID'] . "</td>";
		echo "<td>" . $row['Type'] . "</td>";
		echo "<td>" . $row['Date'] . "</td>";
		echo "<td>" . $row['Time'] . "</td>";
		echo "<td>" . $row['ProblemNo'] . "</td>";
		echo "<tr>";
	}
}
?>
</tbody>
</table>
</div>

</div>

<!-- Add caller to existing call modal -->
<div id="AddCallerModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Problem Details</h2>
<hr>
    </div>
    <div class="modal-body">
	<label for="probNum">Problem#</label>
    <input name="probNum" type="text" id="probNum" value="57" size="4" readonly>
	<label for="probType">Problem Type:</label>
    <input name="probType" type="text" id="probType" value="Printer" readonly>
	
	<hr>
	<label for="opName">Operator Name</label>
    <input name="opName" type="text" id="opName" required readonly>
	<label for="callName">Caller Name</label>
    <input name="callName" type="text" id="callName" required readonly>
	<label for="callID">Caller ID</label>
    <input name="callID" type="text" id="callID" size="4" required readonly>
	<hr>
	
	<label for="callDate">Call Date</label>
    <input name="callDate" type="date" id="callDate" required readonly>
	<label for="callTime">Call Time</label>
    <input name="callTime" type="time" id="callTime" required readonly>
	<hr>
	
	<label for="serialNum">Serial#</label>
    <input name="serialNum" type="text" id="serialNum" onkeyup="check()"/readonly>
    <label for="operatingSystem">Operating System</label>
    <input name="operatingSystem" type="text" id="operatingSystem" value="Windows" readonly>

	<label for="software">Software</label>
    <input name="software" type="text" id="software" readonly>
	<hr>
	
	<label for="specID">Specialist ID</label>
    <input name="specID" type="text" id="specID" size="4" readonly>
	<label for="specName">Specialist Name</label>
    <input name="specName" type="text" id="specName" readonly>
	<hr>
	
	<label for="notes">Description</label>
	<br>
    <textarea id="notes" name="notes" rows="5" readonly></textarea>
	<hr>
	
	<label for="solution">Solution</label>
	<br>
    <textarea id="solution" name="solution" rows="3" readonly></textarea>
	</div>
    <div class="modal-footer">
<hr>
<br>
      <button class="update-ticket">Update problem</button>
    </div>
  </div>

</div>


</body>

<script src="/js/probTableScript.js"></script>
<?php 
$conn->close();
?>
</html>

