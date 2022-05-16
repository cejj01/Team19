<?php include 'spheader.php'?>

<html lang="en"><head>

<title>Inbox</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="/css/mainStyle.css">
<link rel="stylesheet" href="/css/inboxStyle.css">
<style>
.commonProblemsTable th{
	color: var(--accent-colour);
}
.commonProblemsTable td{
	color: white;
}
.page-container {
	margin-bottom: 30px;
}
.msgFooter {
	height: 30%;
}

</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body>

<?php
include 'loadProfilePage.php';
include 'databaseConnection.php';

		if (isset($_POST['referToExternal'])) {
			$probIdToExtern = $_POST['fooProbID'];
			$externalSpec = $_POST['referToExternal'];
			//echo $availability;
			//echo $_SESSION['ID'];
			$sqlReturnToOperator = "UPDATE ProblemNumber SET Notes = 'sent to external specialist with external id'".$externalSpec.", SpecialistID = 0 WHERE ProblemID = ".$probIdToExtern;;
			//echo $sqlSpecialistAvail;
			$result = $conn->query($sqlSpecialistAvail);
			unset($_POST['avail']);
		}


		$sqlGetExternal = "SELECT Firstname, Surname, Speciality, Company, Email FROM ExternalSpecialists";
		//echo ($sqlGetMySpecialities);
		//echo (strval($_SESSION['ID']));
		$externalQuery = $conn->query($sqlGetExternal);
		$myExternal = array();
		if ($externalQuery->num_rows > 0) {
			while($row = $externalQuery->fetch_assoc()) {
				array_push($myExternal, [$row['Firstname'], $row['Surname'], $row['Speciality'], $row['Company'], $row['Email']]);;
			//echo ($row['ProblemTypeID']);
			}
		} 
	


?>

<br>

<div class="page-container">
<h1>Inbox</h1>
<hr>

<div id="inbox">
	<div id="messages">
		<div id="filters">
			<input name="searchBar" type="text" id="searchBar" placeholder="Search...">
			<select name="sortOption" id="sortOption" onchange="filterProblems()">
				<option value="placeholder">Sort By...</option>
                <option value="probNum">Problem Number</option>
                <option value="probType">Problem Type(A-Z)</option>
                <option value="urgency">Urgency</option>
				<option value="date">Date(Newest)</option>
            </select>
		</div>
		<div id="incoming">
		</div>
	</div><div class="msgContent">
			<table class="msgHeader">
			<col style="width:25%"><!--label-->
			<col style="width:30%"><!--Type-->
			<col style="width:30%"><!--Label-->
			<col style="width:15%"><!--No. of Tickets-->
				<tbody>
				<tr class="hiddenContent" hidden>
					<th>Problem Type:</th>
					<td id="probType"></td>
					<th>No. of Tickets:</th>
					<td id="numOfTickets"></td>
				</tr>
				</tbody>
			</table>
		<hr>
		
		<div class="msgBody">
            <table id="problemInfo" class="hiddenContent" hidden>
				<tbody>
				<tr>
					<th>Problem Number:</th>
					<td id="probNum"></td>
					<th>Priority:</th>
					<td id="priority"></td>
					<th>First Caller ID:</th>
					<td id="personnelID"></td>
				</tr>
				<tr>
					<th>Serial#:</th>
					<td id="serialNum"></td>
					<th>Software:</th>
					<td id="software">N/A</td>
					<th>OS:</th>
					<td id="OSName">N/A</td>
				</tr>
				</tbody>
			</table>
			<br>
			<label for="desc" class="hiddenContent" hidden>Description:</label>
			<br>
			<textarea id="desc" class="hiddenContent" name="desc" rows="4" hidden readonly></textarea>
			<br>
			<label id="notesDescLbl" for="solution" class="returnedProblem" hidden>Notes:</label>
			<br>
			<textarea id="notesDesc" class="returnedProblem" name="solution" rows="2" readonly hidden></textarea>
			<br>
			<button id="viewTickets" class="hiddenContent" onclick="getTickets()" hidden>View Tickets</button>
			
		</div>
    <div class="msgFooter">
		<form action="" method="post" id="curSpecChange">
			<label for="referToExternal">Refer to external specialist:</label>
			<select name = "referToExternal">
				<option> -- </option>;
				<?php
				foreach ($myExternal AS $external) {
					echo "<option value='$specialty[0]'>".$specialty[0]." - ".$specialty[1]." - ".$specialty[2]." - ".$specialty[3]." - ".$specialty[4]."</option>";
				}
				?>

			</select>
			<input type="hidden" name="fooProbID" value= '<script>echo (document.getElementById("probNum").innerText) </script>'/>
		</form>
	<p><input type="submit" value="Refer To Specialist"/></p>
</form>
		<hr>
			<button class="accept hiddenContent" id="solve" name="solve" onclick="solveProblem()" hidden>Solve</button>
			<button class="reject hiddenContent" id="reject" name="reject" onclick="returnProblem()" hidden>Return To Operator</button>
			<br>
			<textarea id="notes" class="hiddenContent" name="notes" rows="3" placeholder="Notes or Solution..." hidden></textarea>
		
		</div>
	</div>
		
</div>

</div>

<?php include 'specialistWorkspace.php' ?>
<?php include 'specialistInbox.php' ?>

<link rel="stylesheet" href="/css/modalStyle.css">
<link rel="stylesheet" href="/css/probTableStyle.css">
<div class="page-container">
<div class="commonProblemsTable">
<h1>Common Problems</h1>
<hr>

<?php include '../commonProblemsTable.php';?>
</div>

</div>
<!-- Modal -->
<div id="TicketModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Related Tickets</h2>
	<hr>
    </div>
	<div id="tableDiv">
		<table class="dark-table" id="viewTicketsTable">
		<col style="width:10%"><!--#-->
		<col style="width:10%"><!--CallerID-->
		<col style="width:20%"><!--Name-->
		<col style="width:20%"><!--Phone#-->
		<col style="width:30%"><!--Description-->
		<col style="width:10%"><!--Dept-->
		<thead>
		<tr>
			<th>Ticket#</th>
			<th>CallerID</th>
			<th>Name</th>
			<th>Phone#</th>
			<th>Description</th>
			<th>Department</th>
		</tr></thead>
		<tbody id="ticketTableBody">
				
		</tbody>
		</table>
	</div>
	<br><br>
  </div>
</div>

<script>
loadMessages();

/* Modal Javascript */

 var datamap = new Map([
		[document.getElementById("viewTickets"), document.getElementById("TicketModal")],
		[document.getElementById("DeleteCommonProblemButton"), document.getElementById("DeleteCommonProblemModal")],
		[document.getElementById("AddCommonProblemButton"), document.getElementById("AddCommonProblemModal")]
        	        ]);

        datamap.forEach((value, key) => {
            makeModal(key, value); //for each modal and button, create the functions for them
        });

        function makeModal(thebutton, themodal) {

         	var span = themodal.getElementsByClassName("close")[0];
		//make the buttons open modals

				thebutton.addEventListener("click", function (event) {
                		themodal.style.display = "block";
				whichArea = 0;
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

/* AJAX JavaScript */
function loadMessages(){
	var inboxThumbnail = <?php echo json_encode($inboxThumbnail);?>;
	var numberOfProblems = inboxThumbnail.length;
	var inbox = document.getElementById('incoming');
	for (var i=0; i < numberOfProblems; i++) {
		var newMsg = document.createElement("button");
		newMsg.classList.add("msg");
		if (inboxThumbnail[i]['ProblemPriority']==2){
			newMsg.classList.add("med");
		}
		else if (inboxThumbnail[i]['ProblemPriority']==3){
			newMsg.classList.add("high");
		}
		newMsg.innerHTML = '<label>Problem ID: '+inboxThumbnail[i]['ProblemID']+'</label> <br> <label>Problem Type ID: '+inboxThumbnail[i]['ProblemTypeID']+'</label> <br> <label>Urgency: '+inboxThumbnail[i]['ProblemPriority']+'</label> </tr>';
		newMsg.setAttribute('onclick', "loadInbox('"+inboxThumbnail[i]['ProblemID']+"')");
		inbox.appendChild (newMsg);
	}
}

async function loadInbox(probNum){
	var inboxContents;
	//use ajax here?
	const xhr = new XMLHttpRequest();
	xhr.onload = await function(){
		inboxContents = JSON.parse(this.responseText);

		document.getElementById("probType").innerHTML = inboxContents[0]['ProblemType'];
		document.getElementById("probNum").innerHTML = inboxContents[0]['ProblemNo'];
		document.getElementById("priority").innerHTML = inboxContents[0]['problemPriority'];
		document.getElementById("callerID").innerHTML = inboxContents[0]['X'];
		document.getElementById("serialNum").innerHTML = inboxContents[0]['SerialNumber'];
		document.getElementById("software").innerHTML = inboxContents[0]['SoftwareName'];
		document.getElementById("OSName").innerHTML = inboxContents[0]['OS'];
		document.getElementById("desc").innerHTML = inboxContents[0]['ProblemDescription'];
		
		getTickets();
		
		var notesHidden = document.getElementsByClassName("returnedProblem");

		if (inboxContents[0]['Notes']!=null){
			for(var x=0; x<notesHidden.length; x++){
				notesHidden[x].hidden = false;
			}
			document.getElementById("desc").rows = '2';
			document.getElementById("notesDesc").innerHTML = inboxContents[0]['Notes'];
		}
		else {
			for(var x=0; x<notesHidden.length; x++){
				notesHidden[x].hidden = true;
			}
			document.getElementById("desc").rows = '4';
		}
	}
	//xhr.onerror
	xhr.open('POST', 'specialistWorkspace.php');
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send('probNum='+probNum);
		
		var hidden = document.getElementsByClassName("hiddenContent");
		for(var x=0; x<hidden.length; x++){
			hidden[x].removeAttribute("hidden");
		}
	
}

async function solveProblem(){
	const xhr = new XMLHttpRequest();
	var probNum = document.getElementById("probNum").innerText;
	var solution = document.getElementById("notes").value;
	xhr.onload = await function(){;
		
		alert("Solution sent");
		window.location.reload();
	}
	//xhr.onerror
	xhr.open('POST', 'specialistWorkspace.php');
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send('probNum='+probNum+'&solution='+solution);
}

async function returnProblem(){
	const xhr = new XMLHttpRequest();
	var probNum = document.getElementById("probNum").innerText;
	var rejectNotes = document.getElementById("notes").value;
	xhr.onload = await function(){;
		
		alert("Returned to Operator");
		window.location.reload();
	}
	//xhr.onerror
	xhr.open('POST', 'specialistWorkspace.php');
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send('probNum='+probNum+'&rejectNotes='+rejectNotes);
}

async function getTickets(){
	var ticketList;
	const xhr = new XMLHttpRequest();
	var probNum = document.getElementById("probNum").innerText;
	xhr.onload = await function(){;
		ticketList = JSON.parse(this.responseText);
		
		document.getElementById("ticketTableBody").innerHTML =  "";
		var table = document.getElementById("ticketTableBody");
		
		var numberOfTickets = ticketList.length;
		for(var y=0; y<numberOfTickets; y++){
			var row = table.insertRow(-1);
		
			var ticketNumColumn = row.insertCell(0);
			var callerIDColumn = row.insertCell(1);
			var nameColumn = row.insertCell(2);
			var phoneColumn = row.insertCell(3);
			//var descriptionColumn = row.insertCell(4);
			var deptColumn = row.insertCell(4);
			
			ticketNumColumn.innerHTML = ticketList[y]['TicketID'];
			callerIDColumn.innerHTML = ticketList[y]['PersonnelID'];
			nameColumn.innerHTML = ticketList[y]['FirstName'] + ' ' + ticketList[y]['Surname'];
			phoneColumn.innerHTML = ticketList[y]['Telephone'];
			//descriptionColumn.innerHTML = ticketList[y]['CallDescription'];
			deptColumn.innerHTML = ticketList[y]['Department'];
		}
		document.getElementById("personnelID").innerHTML = ticketList[0]['PersonnelID'];
		document.getElementById("numOfTickets").innerHTML = numberOfTickets;
	}
	//xhr.onerror
	xhr.open('POST', 'specialistWorkspace.php');
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send('probNum='+probNum+'&getTickets="1"');
}

//Ensures the form data is reset upon submission
if (window.history.replaceState) {
    window.history.replaceState (null, null, window.location.href);
}
</script>

</body></html>