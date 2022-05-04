<?php include 'opheader.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Closed Problems</title>


<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="/css/mainStyle.css">
<link rel="stylesheet" href="/css/modalStyle.css">
<link rel="stylesheet" href="/css/probTableStyle.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<?php
include '../databaseConnection.php';
include '../logs.php';
?>

<body>

<div class="page-container">
<h1>Closed Problems</h1>
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
		<th>Date Solved</th>
		<th>Description</th>
		<th>Solution</th>
	</tr></thead>
	<tbody>
	<?php
	include '../databaseConnection.php';
	//sql for getting open problems
	$sqlClosed = "SELECT * FROM ProblemNumber WHERE Accepted = 'Yes'";
	$resultClosed = $conn->query($sqlClosed);

	if ($resultClosed->num_rows > 0) {
		while ($row = $resultClosed->fetch_assoc()) {
			//Gives results in table
			echo "<tr>" .
			"<td>" . $row['ProblemNo'] . "</td>" .
			"<td>" . $row['ProblemType'] . "</td>" .
			"<td>" . $row['1stSubmissionDate'] . "</td>" .
			"<td>" . $row['SolutionDate'] . "</td>" .
			"<td>" . $row['ProblemDescription'] . "</td>" .
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
	<input type ="text" name="probType" id="probType" readonly>
	<hr>
	
	<label for="callDate">Original Call Date</label>
    <input name="callDate" type="date" id="callDate" readonly>
	<label for="solutionDate">Solution Date</label>
    <input name="solutionDate" type="date" id="solutionDate" readonly>
	<hr>
	
	<label for="serialNum">Serial#</label>
    <input name="serialNum" type="text" id="serialNum" readonly>
    <label for="operatingSystem">Operating System</label>
	<input type="text" name="operatingSystem" id="OS">

	<label for="software">Software</label>
    <input name="software" type="text" id="software">
	<hr>
	
	<label  for="specialist">Specialist:</label>
	<input class="square-button-input" name ="specialist" id="SpecialistName" type = "text" readonly />
	
	<label for="Priority">Last Priority</label>
	<input type="text" name="Priority" id="priority" readonly>
	<hr>
	
	<label for="notes">Description</label>
	<br>
    <textarea id="notes" name="notes" rows="5"></textarea>
	<br>
	<label for="solution">Solution</label>
	<br>
    <textarea id="solution" name="solution" rows="5"></textarea>
	</div>

    <div class="modal-footer">
	<hr>
	<br>
	<input type="submit" name="submitReopen" value="Reopen Problem">
    </div>
	</form>
	<div class="dark-table" id="callerTable2">
			<br><br>
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

<script src="/js/probTableScript.js"></script>
<?php
$conn->close();

if (isset($_POST["submitReopen"])) {
	//open db connection
	include "../databaseConnection.php";

	//Gets problem number
	$problemNo = $_POST["problemNum"];

	//sql for reopening problem
	$sqlReopen = "UPDATE ProblemNumber SET Accepted = 'No', returnToOperator='No',
		SolutionDate = '0000-00-00' WHERE ProblemNo = '$problemNo'";

	if ($conn->query($sqlReopen) === TRUE) {
		//logs problem reopening
		newLog($conn,'Reopened',$problemNo);
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
