
<?php include 'opheader.php' ?>
<html lang="en"><head>

<title>Inbox</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="/css/mainStyle.css">
<link rel="stylesheet" href="/css/inboxStyle.css">
<style>
#solution {
	background-color: #444444;
	color: white;
}
#followUp {
	width: auto;
	height: auto;
}
.viewTickets {
	margin: 5px;
}
.msgFooter {
	height: 30%;
}
</style>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body>

<script>

function SearchFilter() {
    var input, filter, table, tr, td, i, userInput;
    input = document.getElementById("searchBar");
    filter = input.value.toLowerCase();
    table = document.getElementById("incoming");
    tr = table.getElementsByTagName("button");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("label")[0];
        if (td) {
            userInput = td.textContent || td.innerText;
            if (userInput.toLowerCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

function filterProblems() {
	var value;
	value = document.getElementById("sortOption");
	if (value == "placeholder") {

	} else if (value == "probNum") {
		
	} else if (value == "probType") {

	} else if (value == "urgency") {

	} else if (value == "date") {

	}
}

</script>

<br>


<div class="page-container">
<h1>Inbox</h1>
<hr>

<div id="inbox">
	<div id="messages">
		<div id="filters">
			<input name="searchBar" type="text" id="searchBar" placeholder="Search..." onkeyup="SearchFilter()">
			<select name="sortOption" id="sortOption" onchange="filterProblems()">
				<option value="placeholder">Sort By ...</option>
                <option value="probNum">Problem Number</option>
                <option value="probType">Problem Type (A-Z)</option>
                <option value="urgency">Urgency</option>
				<option value="date">Date (Newest)</option>
            </select>
		</div>
		<div id="incoming">
		</div>
	</div><div class="msgContent">
			<table class="msgHeader">
			<col style="width:15%"><!--label-->
			<col style="width:30%"><!--Type-->
			<col style="width:15%"><!--Label-->
			<col style="width:40%"><!--Specialist-->
				<tbody>
				<tr class="hiddenContent" hidden>
					<th>Problem Type:</th>
					<td id="probType"></td>
					<th>Specialist:</th>
					<td id="spName"></td>
				</tr>
				</tbody>
			</table>
		<hr>
		
		
		<div class="msgBody">
            <table class="hiddenContent" hidden>
				<tbody>
				<tr>
					<th>Problem Number:</th>
					<td id="probNum"></td>
					<th>Priority:</th>
					<td id="priority"></td>
					<th>First Caller ID:</th>
					<td id="callerID"></td>
				</tr>
				<tr>
					<th>Serial#:</th>
					<td id="serialNum"></td>
					<th>Software:</th>
					<td id="software"></td>
					<th>OS:</th>
					<td id="OSName"></td>
				</tr>
				</tbody>
			</table>
			<br>
			<label for="desc" class="hiddenContent" hidden>Description:</label>
			<br>
			<textarea id="desc" class="hiddenContent" name="desc" rows="2" hidden readonly></textarea>			
			<br>
			
			<label id="solutionLbl" for="solution" class="hiddenContent" hidden>Solution:</label>
			<br>
			<textarea id="solution" class="hiddenContent" name="solution" rows="2" readonly hidden></textarea>
			
			<br>
			<button id="viewTickets" class="hiddenContent" onclick="getTickets()" hidden>View Tickets</button>
		</div>
    <div class="msgFooter">
		<hr>
			<!--Operator must confirm the problem is solved before marking a specialist ticket as solve. Should not be able to solve without confirming-->
			<label for="followUp" class="hiddenContent" hidden>Confirmed with caller?:</label>
			<input type="checkbox" id="followUp" name="followUp" onclick="allowSolve()" class="hiddenContent" hidden>
			<br>
			<button class="accept hiddenContent" id="solveBtn" onclick="solveProblem()" hidden disabled>Mark Solved</button>
			<button class="reject hiddenContent" onclick="returnProblem()" hidden>Reject</button>
			<br>
			
			<!--Operator can write notes if the problem solution is rejected for some reason. This should then send the problem back to the specialist-->
			<textarea id="notes" class="hiddenContent" name="notes" rows="2" placeholder="Notes" hidden></textarea>
		</div>
</div>
		
		
		
	</div>
 </div>
 

<?php include 'operatorInbox.php' ?>

<link rel="stylesheet" href="/css/modalStyle.css">
<link rel="stylesheet" href="/css/probTableStyle.css">

<!--                 Modal                 -->
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


function allowSolve(){
	var chkSolve =  document.getElementById("followUp");
	var solveBtn = document.getElementById("solveBtn");
	if (chkSolve.checked == true){
		solveBtn.disabled = false;
	}
	else {
		solveBtn.disabled = true;
	}	
}

/*                    Modal Javascript                       */

 var datamap = new Map([
		[document.getElementById("viewTickets"), document.getElementById("TicketModal")]]);

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
		if (inboxThumbnail[i]['ProblemPriority']=="Medium"){
			newMsg.classList.add("med");
		}
		else if (inboxThumbnail[i]['ProblemPriority']=="High"){
			newMsg.classList.add("high");
		}
		//newMsg.innerHTML = '<label id="problemIDInput">Problem ID: '+inboxThumbnail[i]['ProblemID']+'</label> <br> <label id="problemTypeInput">Problem Type: '+inboxThumbnail[i]['ProblemTypeID']+'</label> <br> <label id="problemPriorityInput">Urgency: '+inboxThumbnail[i]['problemPriority']+'</label>';
		//newMsg.innerHTML = '<tr> <td><label>Problem ID: '+inboxThumbnail[i]['ProblemID']+'</label></td> <td><label>Problem Type: '+inboxThumbnail[i]['ProblemTypeID']+'</label></td> <td><label>Urgency: '+inboxThumbnail[i]['problemPriority']+'</label></td> </tr>';
		newMsg.innerHTML = '<label>Problem ID: '+inboxThumbnail[i]['ProblemID']+'</label> <br> <label>Problem Type: '+inboxThumbnail[i]['ProblemTypeID']+'</label> <br> <label>Urgency: '+inboxThumbnail[i]['problemPriority']+'</label> </tr>';
		
		//newMsg.innerHTML = '<p>Problem#: '+inboxThumbnail[i]['ProblemID']+'<br>Type: '+inboxThumbnail[i]['ProblemTypeID']+' <br>Urgency: '+inboxThumbnail[i]['problemPriority']+' </p>';
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
		
		document.getElementById("probType").innerHTML = inboxContents[0]['ProblemTypeID'];
		document.getElementById("spName").innerHTML = inboxContents[0]['SpecialistID'];
		document.getElementById("probNum").innerHTML = inboxContents[0]['ProblemID'];
		document.getElementById("priority").innerHTML = inboxContents[0]['problemPriority'];
		document.getElementById("callerID").innerHTML = inboxContents[0]['X'];
		document.getElementById("serialNum").innerHTML = inboxContents[0]['SerialNumber'];
		document.getElementById("software").innerHTML = inboxContents[0]['SoftwareName'];
		document.getElementById("OSName").innerHTML = inboxContents[0]['OS'];
		document.getElementById("desc").innerHTML = inboxContents[0]['ProblemDescription'];
		document.getElementById("solution").innerHTML = inboxContents[0]['Solution'];
		
		document.getElementById("followUp").checked = false;
		document.getElementById("solveBtn").disabled = true;
		
		getTickets();
		
		if (inboxContents[0]['Resolved']=='Yes'){
			document.getElementById("solutionLbl").innerHTML = 'Solution:';
			document.getElementById("solution").innerHTML = inboxContents[0]['Solution'];
		}
		else {
			document.getElementById("solutionLbl").innerHTML = 'Notes:';
			document.getElementById("solution").innerHTML = inboxContents[0]['Notes'];
		}
	}
	//xhr.onerror
	xhr.open('POST', 'operatorWorkspace.php');
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
	xhr.onload = await function(){;

		alert("Solution accepted");
		window.location.reload();
	}
	//xhr.onerror
	xhr.open('POST', 'operatorWorkspace.php');
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send('probNum='+probNum+'&accepted="1"');
}

async function returnProblem(){
	const xhr = new XMLHttpRequest();
	var probNum = document.getElementById("probNum").innerText;
	var rejectNotes = document.getElementById("notes").value;
	xhr.onload = await function(){;

		alert("Returned to Specialist");
		window.location.reload();
	}
	//xhr.onerror
	xhr.open('POST', 'operatorWorkspace.php');
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
			var descriptionColumn = row.insertCell(4);
			var deptColumn = row.insertCell(5);
			
			ticketNumColumn.innerHTML = ticketList[y]['TicketNo'];
			callerIDColumn.innerHTML = ticketList[y]['CallerID'];
			nameColumn.innerHTML = ticketList[y]['CallerName'];
			phoneColumn.innerHTML = ticketList[y]['Telephone'];
			descriptionColumn.innerHTML = ticketList[y]['CallDescription'];
			deptColumn.innerHTML = ticketList[y]['Department'];
		}
		
		document.getElementById("callerID").innerHTML = ticketList[0]['CallerID'];

	}
	//xhr.onerror
	xhr.open('POST', 'operatorWorkspace.php');
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send('probNum='+probNum+'&getTickets="1"');
}
</script>

</body></html>