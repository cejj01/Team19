//Calls modal based on clicked row
function SelectRow(event) {		
		var row = event.target.parentNode.parentNode.firstChild;
		probNum = event.target.parentNode.firstChild.innerText;
		loadTable(probNum);
		loadData(probNum);
		
		openAddCallerModal();
	}

//Opens modal
function openAddCallerModal() {
var JSAddCallerModal = document.getElementById("AddCallerModal");
  JSAddCallerModal.style.display = "block";
}

// Close modals if you click away
window.onclick = function(event) {
    var JSAddCallerModal = document.getElementById("AddCallerModal");
  if (event.target == JSAddCallerModal) {
    JSAddCallerModal.style.display = "none";
  }
}

//Loads data into modal using AJAX
async function loadData(probnum) {
	var dataContents;
	const xhr = new XMLHttpRequest();
	xhr.onload = await function(){
		dataContents = JSON.parse(this.responseText);

		document.getElementById("problemNum").value = dataContents[0]['ProblemID'];
		document.getElementById("probType").value = dataContents[0]['ProblemType'] + " " + dataContents[0]['SubProblemType'];	
		document.getElementById("serialNum").value = dataContents[0]['SerialNumber'];	
		if (document.getElementById("serialNum").value == "") {
			document.getElementById("serialNum").value = "N/A";
		}
		document.getElementById("software").value = dataContents[0]['Software'];
		if (document.getElementById("software").value == "") {
			document.getElementById("software").value = "N/A";
		}
		document.getElementById("callDate").value = dataContents[0]['1stSubmissionDate'];

		document.getElementById("OS").value = dataContents[0]['OS'];
		document.getElementById("notes").innerHTML = dataContents[0]['ProblemDescription'];	
		if (dataContents[0]['ProblemPriority'] == 3) {
			document.getElementById("priority").value = "High";	
		}
		if (dataContents[0]['ProblemPriority'] == 2) {
			document.getElementById("priority").value = "Medium";	
		}

		if (dataContents[0]['ProblemPriority'] == 1) {
			document.getElementById("priority").value = "Low";	
		}
		document.getElementById('specialistID').value = dataContents[0]['SpecialistID'];
		document.getElementById("SpecialistName").value = dataContents[0]['FirstName'] + " " + dataContents[0]['Surname'];
		
		//fill chat
document.getElementById("chatbox").value = "";
		//alert(JSON.stringify(chat));
		
		for(var key in chat) {
			
			if (document.getElementById('specialistID').value == chat[key]['SenderID']) {
			document.getElementById("chatbox").value += document.getElementById("SpecialistName").value + ": " + chat[key]['ChatContents'] + '\n';
			}
			if (document.getElementById('specialistID').value == chat[key]['RecipientID']) {
				document.getElementById("chatbox").value += "Me: " + chat[key]['ChatContents'] + '\n';

			}
		}
		


	}


	xhr.open('POST', '/openProblems.php');
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send('probNum='+probnum);

}

//Loads call details using AJAX
async function loadTable(probnum) {
	var JSONrows = [];
	var rows = [];
	const xhr = new XMLHttpRequest();
	xhr.onload = await function(){
		JSONrows = (this.responseText).split('¬');
		var table = "<table border = '1'> <thead><tr><th>Call Date</th><th>Call Time</th><th>Caller Name</th><th>Caller ID</th><th>Operator Name</th><th>Call Details</th></tr></thead><tbody>";
		var row;
		for (i = 0; i < JSONrows.length - 1; i++) {
			row = (JSON.parse(JSONrows[i]));

			table+="<tr>"
		  for (let key in row) {
			table+="<td>"+row[key]+"</td>"
					}
		table+="</tr>"
		}
		document.getElementById("callerTable2").innerHTML = table;
	}
	

	xhr.open('POST', '/openProblemsCallerTable.php');
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send('probNum='+probnum);

}
