<?php include 'userHeader.php'?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>New Ticket</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/css/mainStyle.css">


<style>
* {
  box-sizing: border-box;
}
tr:nth-child(even):not(.selected) {
    background-color: mauve;
}
label {
	color: var(--accent-colour);
}

.selected {
    background-color: brown;
    color: #FFF;
}
.filter-dropdown {
width: 20%;
height: 20px;
}
#ticketForm {
	padding: 10px;
	padding-bottom: 15px;
	padding-top: 0px;
}
.formBut {
	width:100px;
}

.p1 {
  text-align: center;
  color: #ffff33;
  font-weight: 700;
}
input, textarea{
  border-width: 1px;
  border-color: black;
  outline: none;
  border-style: solid;
  border-radius: 3px;

}
label {display:block;
font-size:90%;
padding-top:20px;
}

.left-input {
text-align: left;
margin-left: 0; 
margin-right: auto;
}

.right-input {

text-align: left;

margin-left: auto; 
margin-right: 0;
}

right-holder {
text-align: right;
display: inline-block;
}

.square-button {
height:35px;
width:35px;
padding:0px;
border-width:0px;

}

.square-button:hover,
.square-button:focus {
  text-decoration: none;
  cursor: pointer;
}



.square-button-input {
width: calc(90% - 40px);
border-width:0px;
}

.no-padding {
padding: 0px;

}
#problem-type {
padding-bottom:3px;
}

textarea {
width:100%;
}


.container-header {
font-size:175%;
padding:0px;
margin: 8px;
}

.hyper-button {
height: 20px;
  background: none;
  color: #ece3ff;
  font-size: 100%;
  font-weight: 700;
  border-color: #F6D300;
  border-radius: 5px;
  border: none;
}

.hyper-button:hover,
.hyper-button:focus {
  text-decoration: none;
  cursor: pointer;
}

.page-container {
 float: left;
  min-width: 10px !important;
  width: 40% !important;
  padding-right: 15px;
  padding-left: 15px;
  padding-bottom:30px;
  text-align: center;
  background: #444444;
  color: #b4f0c3;
  font-weight: 700;
  font-size: 90%;
  border-style: solid;
  border-color: #444444;
  border-radius: 10px;
  border-width: 1px;


}

.float-container {
}

/* Modal CSS */

.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 300px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

.modal-content {
  position: relative;
  background-color: #444444;
  margin: auto;
  padding: 0;
  border: 1px solid #888;
  width: 60%;
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
  color: white
}
.filter {
width: 200px;
height: 20px;
}
/* The Close Button */
.close {
  color: white;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

.modal-header {
  padding: 2px 16px;
  color: white;
  text-align: center;
}

.modal-body {padding: 2px  24px;}

.modal-footer {
    text-align: center;
  padding: 2px 16px;
  padding-bottom:24px;
  color: white;
}

.modal-input {
width: 100%;

}

.modal-square-input {
width: calc(100% - 40px);
border-width:0px;

}

.dark-table {
    border-collapse: collapse;
    margin: 25px 0;
    font-family: sans-serif;
    min-width: 400px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.50);
}

.dark-table thead tr {
    background-color: #1d1d26;
    color: #ffffff;
    text-align: left;
}
.dark-table th,
.dark-table td {
    padding: 10px 15px;
}

.dark-table th{
	text-align: left;
	color: var(--accent-colour);
}

.dark-table tbody tr:not(.selected){
    border-bottom: thin solid #dddddd;
	background-color: #333344;
	color: #ffffff;
	cursor: pointer;
}

.dark-table tbody tr:nth-child(even):not(.selected) {
    background-color: #111122;
}

.dark-table tbody tr:last-of-type {
    border-bottom: 2px solid #dddd99;
}

.fixPadding th,
.fixPadding td {
    padding: 2px 5px;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php
include '../databaseConnection.php';
include '../logs.php';
?>
</head>
<body>
<!-- MODALS -->
<!-- Record a call modal -->
<div id="RecordCallModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2></h2>
<hr>
    </div>

    <div class="modal-body">
    <form id="logCall" method="post">
      <div class="right-input">
	<label class="no-padding" for="recordCallCallerInput">Caller</label>
	<input class="modal-square-input" id= "recordCallCallerInput" name ="recordCallCallerInput" type = "text" readonly required />

	<button class="square-button" type = "button" id="recordCallCallerButton">+</Button>
	
	
	

</div>
	<div class="right-input">
		<label for="problem-id-log-call">Problem ID</label>
		<input class ="modal-input" name ="problem-id-log-call" type = "text" required />
 	</div>
	<label for="call-description">Details of call</label>
	<textarea id="call-description-text-area" name="call-description" rows="10" style ="resize: none;"></textarea>

    </div>
    <div class="modal-footer">
<hr>
<br>
      <input class="wide-button" type="submit" name="submitCallLog">
    </div>
  </form>
  </div>

</div>



<!-- Add Problem modal -->
<div id="ProblemModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <!-- Form for inputting new problem type info--->
    <form id="newProblemForm" method ="post">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Create new problem type</h2>
<hr>
    </div>

    <div class="modal-body"> 
	<label for="HardOrSoft">Hardware or Software</label>

      <select class="modal-input" name="HardOrSoft" id="HardOrSoft">
			<option hidden disabled selected value> -- Select an option -- </option>
			<option value="Hardware">Hardware</option>
			<option value="software">Software</option>
	</select>
	<label for="ProblemType">Problem Type</label>

	<select class="modal-input" name="ProblemType" id="NewProbType" onchange="UnlockNewProblemType()">
			<?php include 'problemTypeSelection.php'; ?>
	</select>

	<div class="right-input">
		<label for="New-Problem-Type">Enter new problem type if it is not in the above list</label>
		<input class ="modal-input" name ="New-Problem-Type" id="New-Problem-Type" type = "text" required disabled/>
 	</div>

	<div class="right-input">
		<label for="sub-problem">Sub-Problem Type</label>
		<input class ="modal-input" name ="sub-problem" type = "text"/>
 	</div>
    </div> 
    <div class="modal-footer">
<hr>
<br>
      <input class="add-new-problem" type="submit" name="submitProblemType" value="Create new problem type">
    </div>
  </form>
  </div>

</div>


<!-- Add Specialist modal -->
<div id="SpecialistModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Select Specialist</h2>
<hr>
    </div>

    <div class="modal-body">
<div style="text-align: center;">
      <div style="text-align: center; display: inline-block;">
	<label for="specialistNameFilter" style="padding-top:0px;"> Name: </label>
    <input style=" margin-bottom:10px;" name="specialistNameFilter" class="filter" type="text" id="specialistNameFilter" oninput="FilterSpecialists()"></input>
	</div>
<div style="display: inline-block; text-align: center;">
	<label for="specialistSpecialityFilter" style="padding-top:0px;"> Speciality: </label>
    <input style=" margin-bottom:10px; " name="specialistSpecialityFilter" class="filter" type="text" id="specialistSpecialityFilter" oninput="FilterSpecialists()"></input>
</div>
</div>
  


<table border="1" id="SpecialistTable" onclick="SelectSpecialistRow(event)">
  <tr>
	<th>Specialist ID</th>
    <th>Specialist Name</th>
    <th>Specialities</th>
    <th>No. of Open Tickets</th>
  </tr>
  <?php
  //Selects the list of possible specialists from the database.
  //sql statement for getting all specialists
  $sqlSpecialists = "SELECT SpecialistID, UserName, Available FROM Specialist LEFT JOIN UserAccounts 
    ON Specialist.SpecialistID = UserAccounts.PersonnelID";
  //SELECT SpecialistID, UserName FROM `Specialist` INNER JOIN UserAccounts ON Specialist.SpecialistID = UserAccounts.UserID
  //gets result from db
  $resultSpecialists = $conn->query($sqlSpecialists);

  //Displays each specialist in the specialist table.
  if ($resultSpecialists->num_rows > 0){
    while($row = $resultSpecialists->fetch_assoc()) {
      //Ensures only available specialists are shown
      if ($row['Available'] == "Yes") {
        $specID = $row['SpecialistID'];

        echo "<tr>";
        echo "<td>" . $specID . "</td>";
        echo "<td>" . $row['UserName'] . "</td>";

        //sql for getting specialities
        $sqlSpecialities = "SELECT Speciality FROM Specialities
        WHERE SpecialistID = '$specID'";
        //gets result from db
        $resultSpecialities = $conn->query($sqlSpecialities);
        
        
        //Gets each specialist's specialities
        echo "<td>";
        if ($resultSpecialities->num_rows > 0 ) {
          $specialities = "";
          while ($row = $resultSpecialities->fetch_assoc()) {
             $specialities = $specialities . $row['Speciality'] . ',';          
          }
          echo substr_replace($specialities, "", -1);
        }
        echo "</td>";

        
        //sql for getting the number of open tickets assigned to a specialist
        $sqlTicketsAssigned = "SELECT COUNT(ProblemNo) AS 'Tickets' FROM ProblemNumber 
          WHERE SpecialistID = '$specID'";
        $resultTicketsAssigned = $conn->query($sqlTicketsAssigned);

        //Display number of open tickets a specialist has
        if ($resultTicketsAssigned->num_rows > 0) {
          $numTickets = ($resultTicketsAssigned->fetch_assoc())['Tickets'];
          echo "<td>$numTickets</td>";
        }
        echo "</tr>";
      }
    }
  }

  ?>
</table>    </div>
    <div class="modal-footer">
<hr>
<br>
      <button class="select-specialist" onclick="SpecialistSelect()">Select</button>
	<button class="no-specialist" onclick="NoSpecialist()">No Specialist Required</button>
    </div>
  </div>

</div>



<!-- The page -->
<div style="background-image">
<div class = "float-container" >



<div class="page-container" style = "margin: 0% 4% 10% 8%;">
<!--Submit new ticket form-->	
<p class= "container-header"> Ticket Creation </p>
<div/>


<hr>
<form id="createTicket" method="post">
<table>
<tr>
<td>

<br>
	<div class="left-input" id="problem-type">
	<label for="probType">Problem Type:</label>
	<select onchange="ProblemTypeChange()"class="square-button-input" name="probType" id="probType">
		<?php include '../problemTypeSelection.php';?>
	</select>
<button class="square-button" type="button" id="ProblemButton">+</Button>

	</div>


	

<br>
<div class="left-input">
<label  for="serialNum">Serial#</label>
    <input name="serialNum" type="text" id="serialNum" oninput="FilterOpenProblems2()"/>
</div>
<br>
<div class="left-input">	
	<label for="operatingSystem">Operating System</label>
    <select name="operatingSystem" id="OS">
		<option hidden disabled selected value> -- Select an option -- </option>
		<option value="Mac">Mac</option>
		<option value="Window">Windows</option>
		<option value="Linux">Linux</option>
		<option value="Other">Other</option>
		<option value="Other">N/A</option>


	</select>
</div>
<br>

<div class="left-input">
<label for="software">Software</label>
    <input name="software" type="text" id="software" oninput="FilterOpenProblems2()"disabled>
</div>

<br>
<div class="right-input">
<label  for="specialist">Specialist:</label>
<input class="square-button-input" name ="specialist" id="SpecialistName" type = "text" readonly />

<button class="square-button" type="button" id="SpecialistButton">+</Button>

</div>
<br>
<div class="right-input">
<label for="priority">Priority</label>
<select name="priority" id="priority">
		<option hidden disabled selected value> -- Select an option -- </option>
		<option value="High">High</option>
		<option value="Medium">Medium</option>
		<option value="Low">Low</option>
    </select>

</td>
<td>
<label for="description">Description</label>
    <textarea id="description-text-area" name="description" rows="32" style ="resize: none;"></textarea>
</td>
</tr>
</table>
<table>
<td>
<label for="solution">Solution</label>
<textarea id="solution" name="solution" rows="10" style ="resize: none;"></textarea>
</td>
</table>
<br>
<br>
<hr>

<br>
<br>
<input type="submit" name ="submitProblem" value="Create New Ticket">
</form>

</div>
</div>



<!-- Common Problems page container -->
<div class="page-container" style="margin-bottom: 20px;" >
<p class= "container-header"> Common Problems </p>
<hr>
<?php include '../commonProblemsTable.php';?>

<!-- Open Problems page container -->
<div class="page-container" >
<p class= "container-header"> Open Problems </p>
<hr>
<table class="dark-table fixPadding" id="OpenProblemsTable" border='1'>
	<thead>
	<tr>
		<th>Problem#</th>
		<th>Problem Type</th>
		<th>Date Assigned</th>
		<th>Serial Number</th>
		<th>Software</th>
		<th>Description</th>

	</tr></thead>
	<tbody>
	<?php 
	//Gives number of tickets for a problem.
	function getNumTickets($conn, $problemNo) {
		//sql for getting tickets
		$sqlNumTicket = "SELECT COUNT(TicketNo) AS 'Ticks' FROM Tickets WHERE ProblemNo = '$problemNo'";
		$resultNumTicket = $conn->query($sqlNumTicket);

		$numTickets = ($resultNumTicket->fetch_assoc())['Ticks'];
		return $numTickets;
	} 

	//sql for getting open problems
	$sqlOpen = "SELECT * FROM ProblemNumber LEFT JOIN Software ON ProblemNumber.SoftwareID = Software.SoftwareID LEFT JOIN ProblemTypes ON ProblemNumber.ProblemTypeID = ProblemTypes.ProblemTypeID WHERE Accepted = 0" ;
	$resultOpen = $conn->query($sqlOpen);
	
	
	

	if ($resultOpen->num_rows > 0) {
		while ($row = $resultOpen->fetch_assoc()) {
			//Checks if there is a serial number
			if ($row['SerialNumber'] == "") {
				$serialNumber = "N/A";
			} else {
				$serialNumber = $row['SerialNumber'];
			}

			//Checks if there is software
			if ($row['SoftwareID'] == "") {
				$software = "N/A";
			} else {
				$software = $row2['Software'];
			}

			//Gives results in table
			echo "<tr>" .
			"<td>" . $row['ProblemID'] . "</td>" .
			"<td>" . $row['ProblemType'] . ' '. $row[SubProblemType] ."</td>" .
			"<td>" . $row['1stSubmissionDate'] . "</td>" .
			"<td>" . $serialNumber . "</td>" .
			"<td>" . $software . "</td>" .
			"<td>" . $row['ProblemDescription'] . "</td>" .
			"</tr>";
		}
	}
	?>
			
</tbody>
</table>

</div>
<script>
	function FilterOpenProblems2() {
		var filter = document.getElementById("serialNum").value.toUpperCase();
		var table = document.getElementById("OpenProblemsTable");
  		var tr = table.getElementsByTagName("tr");
		var td;
		if (filter == "") {
			for (i = 0; i < tr.length; i++) {
				tr[i].style.display = "";
			}
		} else {
			for (i = 0; i < tr.length; i++) {
				td = tr[i].getElementsByTagName("td")[3];
				if (td) {
					
	      			txtValue = td.textContent || td.innerText;
	      				if (txtValue.toUpperCase().includes(filter)) {											
	      					tr[i].style.display = "";
						console.log("Show" +tr[i].getElementsByTagName("td")[3].textContent);
							if (txtValue.toUpperCase().includes("N/A")) {
								console.log("Hide" + tr[i].getElementsByTagName("td")[3].textContent );
								tr[i].style.display = "none";
							}

	     					 } else {
	    				 		tr[i].style.display = "none";
							console.log("Hide" +tr[i].getElementsByTagName("td")[3].textContent);

	    					 }
				
				
				
	   			}

			}

		//function to filter specialist speciality
		
			var filter = document.getElementById("software").value.toUpperCase();
			var table = document.getElementById("OpenProblemsTable");
	  		var tr = table.getElementsByTagName("tr");
			var td;
	if (filter != "") {


			for (i = 0; i < tr.length; i++) {
				td = tr[i].getElementsByTagName("td")[4];
				if (td) {
					if (tr[i].style.display == "") {
	      				txtValue = td.textContent || td.innerText;
	      					if (txtValue.toUpperCase().includes(filter)) {
	      						tr[i].style.display = "";
console.log("Show" + tr[i].getElementsByTagName("td")[3].textContent);

							if (txtValue.toUpperCase().includes("N/A")) {
console.log("Hide" + tr[i].getElementsByTagName("td")[3].textContent);

								tr[i].style.display = "none";
							}

     				 		} else {
console.log("Hide" +tr[i].getElementsByTagName("td")[3].textContent);

    					 		tr[i].style.display = "none";
    						 }
				}
				
   				}
	
			}
		}
	}
	}
	function ShowAllCommonProblems() {
		var table = document.getElementById("CommonProblemsTable");
		var tr = table.getElementsByTagName("tr");
		for (i = 0; i < tr.length; i++) {
			tr[i].style.display = "";
		}
	}
	function ProblemTypeChange() {
		EnableSoftware();
		//filter common problems
		var filter = document.getElementById("probType").value.toUpperCase();
		var table = document.getElementById("CommonProblemsTable");
		var tr = table.getElementsByTagName("tr");
		var td;
	
		for (i = 0; i < tr.length; i++) {
			td = tr[i].getElementsByTagName("td")[1];
			if (td) {
      			txtValue = td.textContent || td.innerText;
      				if (txtValue.toUpperCase().includes(filter)) {
      					tr[i].style.display = "";
     				 } else {
    				 	tr[i].style.display = "none";
    				 }
   			}

		}

	}
	//function to filter open problems
	function FilterOpenProblems() {
		var filter = document.getElementById("OpenProblemsSearchInput").value.toUpperCase();
		var table = document.getElementById("OpenProblemsTable");
		var tr = table.getElementsByTagName("tr");
		var td;
		if (filter == "") {
			for (i = 0; i < tr.length; i++) {
				tr[i].style.display = "";
			}
		} else {

			for (i = 0; i < tr.length; i++) {
				td = tr[i].getElementsByTagName("td")[document.getElementById("OpenProblemsDropDown").value];
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
	//function to filter callers by name
	function FilterCallerName() {
  		var filter = document.getElementById("callerNameFilter").value.toUpperCase();
		var table = document.getElementById("CallerTable");
  		var tr = table.getElementsByTagName("tr");
		var td;
		for (i = 0; i < tr.length; i++) {
			td = tr[i].getElementsByTagName("td")[1];
			if (td) {
      			txtValue = td.textContent || td.innerText;
      				if (txtValue.toUpperCase().includes(filter)) {
      					tr[i].style.display = "";
     				 } else {
    				 	tr[i].style.display = "none";
    				 }
   			}

		}
	}

	//function to filter specialist names and speciality
	function FilterSpecialists() {
  		var filter = document.getElementById("specialistNameFilter").value.toUpperCase();
		var table = document.getElementById("SpecialistTable");
  		var tr = table.getElementsByTagName("tr");
		var td;
		for (i = 0; i < tr.length; i++) {
			td = tr[i].getElementsByTagName("td")[1];
			if (td) {
      				txtValue = td.textContent || td.innerText;
      				if (txtValue.toUpperCase().includes(filter)) {
      					tr[i].style.display = "";
     				 } else {
    				 	tr[i].style.display = "none";
    				 }
   			}

		}

		//function to filter specialist speciality
	
		var filter = document.getElementById("specialistSpecialityFilter").value.toUpperCase();
		var table = document.getElementById("SpecialistTable");
  		var tr = table.getElementsByTagName("tr");
		var td;
		for (i = 0; i < tr.length; i++) {
			td = tr[i].getElementsByTagName("td")[2];
			if (td) {
				if (tr[i].style.display == "") {
      					txtValue = td.textContent || td.innerText;
      					if (txtValue.toUpperCase().includes(filter)) {
      						tr[i].style.display = "";
     				 	} else {
    				 		tr[i].style.display = "none";
    					 }
				}
   			}

		}
	}

	
        var datamap = new Map([
        	[document.getElementById("ProblemButton"), document.getElementById("ProblemModal")],
		[document.getElementById("SpecialistButton"), document.getElementById("SpecialistModal")]
        ]);

        datamap.forEach((value, key) => {
            makeModal(key, value); //for each modal and button, create the functions for them
        });

        function makeModal(thebutton, themodal) {

         	var span = themodal.getElementsByClassName("close")[0];
		//make the buttons open modals
		thebutton.addEventListener("click", function (event) {
                themodal.style.display = "block";
		});
			
		
            

		//make the X's close the modal
            span.addEventListener("click", function (event) {
                themodal.style.display = "none";
            });

		//make clicking away close the modals
            window.addEventListener("click", function (event) {
                if (event.target == themodal) {
                    themodal.style.display = "none";
                }
            });
        }

	// Enables the new problem type field when newProblem is selected
	function UnlockNewProblemType() {
		
		var x = document.getElementById("NewProbType").value;
		if ( x === "newProblem" ) {
			document.getElementById("New-Problem-Type").disabled = false;
		 } else {
			document.getElementById("New-Problem-Type").disabled = true; }
	}
	
	var spName = "";
	var clrName = "";
	var whichArea // a variable describing where the CallerModal was opened from
	// Function to store the name of the caller when clicked on in the table
	function SelectCallerRow(event) {		
		var row = event.target.parentNode.parentNode.firstChild;
		while (row) {
			row.classList.remove("selected"); //remove all rows from the css class selected			
			row = row.nextElementSibling;
		}
		event.target.parentNode.classList.add("selected"); // make the clicked on row selected
		clrName = event.target.parentNode.firstChild.nextElementSibling.innerText;
	}

	//Function to store the id of the selected common problem when clicked
	function SelectCommonProblemRow(event) {		
		var row = event.target.parentNode.parentNode.firstChild;
		while (row) {
			row.classList.remove("selected"); //remove all rows from the css class selected			
			row = row.nextElementSibling;
		}
		event.target.parentNode.classList.add("selected"); // make the clicked on row selected
		CPRowToDelete = event.target.parentNode.firstChild.innerText;
	}


	// Button to select from the caller table

	
	function CallerSelect() {
		if (clrName != "") {
			if (whichArea == 0) {		
				document.getElementById("CallerName").value = clrName;
			} else if (whichArea == 1) {
				document.getElementById("addCallerToProblemInput").value = clrName;

			} else {
				document.getElementById("recordCallCallerInput").value = clrName;		
			}
		document.getElementById("CallerModal").style.display ="none";
		}
	}

	
	// Function to select common problems
	function SelectCommonRow(event) {
	var row = event.target.parentNode.parentNode.firstChild;
		while (row) {
			row.classList.remove("selected"); //remove all rows from the css class selected			
			row = row.nextElementSibling;
		}
		event.target.parentNode.classList.add("selected"); // make the clicked on row selected
		}
	// Function to store the name of the specialist when clicked on in the table

	function SelectSpecialistRow(event) {		
		var row = event.target.parentNode.parentNode.firstChild;
		while (row) {
			row.classList.remove("selected"); //remove all rows from the css class selected			
			row = row.nextElementSibling;
		}
		event.target.parentNode.classList.add("selected"); // make the clicked on row selected
		spName = event.target.parentNode.firstChild.nextElementSibling.innerText;
	}


	// Button to select from the specialist table
	function SpecialistSelect() {
		if (spName != "") {
			document.getElementById("SpecialistName").value = spName;
	document.getElementById("SpecialistModal").style.display ="none";
	document.getElementById("solution-text-area").disabled = true;
	} else {
	document.getElementById("solution-text-area").disabled = false;
} }

	// Button to select no specialist
	function NoSpecialist() {
		document.getElementById("SpecialistName").value = "";
	document.getElementById("SpecialistModal").style.display ="none";

	document.getElementById("solution-text-area").disabled = false;
}


	function EnableSoftware() {
		var OptionGroup = document.getElementById("probType").options[document.getElementById("probType").selectedIndex].className;
		if (OptionGroup === "SoftwareOption") {
			document.getElementById("software").disabled = false; }
		 else {
			document.getElementById("software").disabled = true;
		}
}
</script>
</body>
<footer>
<?php include 'userFooter.php';

//function for generating next problem number.
function getNextProblem($conn) {    
  $sqlPrevProblem = "SELECT MAX(ProblemNo) AS 'ProblemNo' FROM ProblemNumber";
  $probResult = mysqli_query($conn, $sqlPrevProblem);
  $oldProblemNumStr = ($probResult->fetch_assoc())["ProblemNo"];
  $problemNumInt = intval($oldProblemNumStr) + 1;
  $problemNum = strval($problemNumInt);
  return $problemNum;
}

function getNextProblemType($conn) {    
  $sqlPrevProblem = "SELECT MAX(ProblemTypeID) AS 'ProblemTypeID' FROM ProblemTypes";
  $probResult = mysqli_query($conn, $sqlPrevProblem);
  $oldProblemNumStr = ($probResult->fetch_assoc())["ProblemTypeID"];
  $problemNumInt = intval($oldProblemNumStr) + 1;
  $problemNum = strval($problemNumInt);
  return $problemNum;
}

//function for getting next ticket number.
function getNextTicket($conn) {
  $sqlPrevTicket = "SELECT MAX(TicketNo) AS 'TicketNo' FROM Tickets";
  $tickResult = mysqli_query($conn, $sqlPrevTicket);
  $oldticketNumStr = ($tickResult->fetch_assoc())["TicketNo"];
  $ticketNumInt = intval($oldticketNumStr) + 1;
  $ticketNum = strval($ticketNumInt);
  return $ticketNum;
}

//Gets caller ID from name
function getCallerID($conn,$name) {
  //sql to get caller ID
  $sqlCaller = "SELECT CallerID FROM Personnel WHERE CallerName = '$name'";
  $resultCaller = $conn->query($sqlCaller);
  $callerID = ($resultCaller->fetch_assoc())["CallerID"];
  return $callerID;
}

//Gets specialist ID from name
function getSpecialistID($conn,$name) {
  //sql to get specialist ID
  $sqlSpecialistID = "SELECT UserID FROM UserAccounts WHERE UserName = '$name'";
  $resultSpecialistID = $conn->query($sqlSpecialistID);

  $specialistID = $resultSpecialistID->fetch_assoc()["UserID"];
  return $specialistID;
}

//function for submitting a new ticket
function addTicket($conn, $desc, $callerID, $operator, $problemNo) {
  //Gets date & time of submission
  $callDate = date("Y/m/d"); 
	$callTime = date("H:i:s"); 

  //Gets next ticket number
  $ticketNum = getNextTicket($conn);

  //sql for adding a new ticket
  $sqlNewTicket = "INSERT INTO Tickets VALUES ('$ticketNum', '$desc', '$callerID',
    '$operator', '$callDate', '$callTime', '$problemNo')";

  //Add records to db
  if ($conn->query($sqlNewTicket)) {
    //logs the new ticket submission
	newLog($conn,'New Ticket',$problemNo);
  } else {
    echo "Error" . mysqli_error($conn);
  }
  
}

//Checks new problem type form has been submit and then adds submission to the db
if (isset($_POST["submitProblemType"])) {
  include '../databaseConnection.php';

  //values that represent the new problem type
  $problemID = getNextProblemType($conn);
  $problemArea = $_POST["HardOrSoft"];
  $problemType = $_POST["ProblemType"];
  $subProblemType = $_POST["sub-problem"];

  //Gets entered problem type if applicable
  if ($problemType == "newProblem") {
    $problemType = $_POST["New-Problem-Type"];
  }


  //sql statement for adding new problem type
  $sqlNewProblem = "INSERT INTO ProblemTypes VALUES ('$problemID', '$problemType', '$problemArea', '$subProblemType')";

  //Add problem type to database
  if ($conn->query($sqlNewProblem)) {
    //
  } else {
    echo "Error:" . $conn->error;
  }

  //close db connection.
  $conn->close();
}

//Logs new call with description
if (isset($_POST["submitCallLog"])) {
  include '../databaseConnection.php';

  //values for the new call
  $caller = $_POST["recordCallCallerInput"];
  $operatorID = "F013103";
  $problemNo = $_POST["problem-id-log-call"];
  $description = $_POST["call-description"];

  //Get caller ID from the name
  $callerID = getCallerID($conn,$caller);

  //add ticket to database
  addTicket($conn, $description, $callerID, $operatorID, $problemNo);

  //close db connection.
  $conn->close();
}

//Adds new problem to database
if (isset($_POST["submitProblem"])) {
  include '../databaseConnection.php';

  
  //valuse for the new ticket/problem
  $caller = $_POST["caller"];
  $problemType = $_POST["probType"];
  $serial = $_POST["serialNum"];
  $operatingSys = $_POST["operatingSystem"];
  $software = $_POST["software"];
  $specialistName = $_POST["specialist"];
  $priority = $_POST["priority"];
  $description = $_POST["description"];
  $solution = $_POST["solution"];

  //Auto generated values
  $callDate = date("Y/m/d"); 
	$callTime = date("H:i:s");
  $ticketNum = getNextTicket($conn);
  $problemNum = getNextProblem($conn);
  $operatorID = "F013103";
  $resolved = "No";
  $solutionDate = "0000-00-00";

  //Classifies problem as 'accepted by specialist' if a solution is already given
  if ($solution!=NULL){
    $accepted = "Yes";
  } else {
    $accepted = "No";
  }


  //Get specialist ID and caller ID from the names given
  if (isset($specialistName) && $specialistName != "") {
    $specialistID = getSpecialistID($conn,$specialistName);
  } else {
    $specialistID = $operatorID;
	//logs set solution
	newLog($conn,'Solution Given',$problemNum);
  }
  $callerID = getCallerID($conn,$caller);

  //Add ticket for call
  addTicket($conn, $description, $callerID, $operatorID, $problemNum);

  //sql for adding a new problem
  $sqlProblem = "INSERT INTO ProblemNumber VALUES ('$problemNum','$problemType','$serial',
    '$software','$operatingSys','$description','$solution',NULL,'$specialistID',
    '$accepted','$resolved','$callDate', '$solutionDate', '$priority',Null, 'No')";

  //Add records to db
  if ($conn->query($sqlProblem)){
    //logs new problem
	newLog($conn,'New Problem',$problemNum);
  } else {
    echo "Error" . mysqli_error($conn);
  }
  
  //close db connection.
  $conn->close();
}


?>
<script>
//Ensures the form data is reset upon submission
if (window.history.replaceState) {
    window.history.replaceState (null, null, window.location.href);
}
</script>
</footer>
</html>