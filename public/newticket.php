
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" /> 
<title></title>
<style></style>
</head>


<body>
<!-- Test form for testing inputting data -->
<form id="ticketForm" method="post"> 
	<label for="probNum">Problem#</label>
    <input name="probNum" type="text" id="probNum" value="57" size="4"> 
	
	<label for="probType">Problem Type:</label>
	<select name="probType" id="probType">
		<optgroup label="Hardware">
			<option value="printer">Printer</option>
			<option value="printEmpty">-Printer Empty</option>
		</optgroup>
		<optgroup label="Software">
			<option value="excel">Excel</option>
			<option value="excelTables">-Excel tables</option>
		</optgroup>
		<optgroup label="------">
			<option value="newHard">New hardware problem</option>
			<option value="newSoft">New software problem</option>
			<option value="other">Other</option>
		</optgroup>
	</select>
	
	<!--Allows input of a new problem type, not from the list-->	
	<input name="newProbType" type="text" id="newProbType" placeholder="New problem type" disabled>
	<hr>
	
	<label for="opID">Operator ID</label>
    <input name="opID" type="text" id="opID" required>
	<label for="callID">Caller ID</label>
    <input name="callID" type="text" id="callID" size="4" required>
	<hr>
	
	<label for="Priority">Priority</label>
    <select name="Priority" id="priority">
		<option value="1">High</option>
		<option value="2">Medium</option>
		<option value="3">Low</option>
    </select>
	<hr>
	
	<label for="serialNum">Serial#</label>
    <input name="serialNum" type="text" id="serialNum"/>
    <label for="operatingSystem">Operating System</label>
    <select name="operatingSystem" id="OS">
        <option value="Null">Null</option>
		<option value="Mac">Mac</option>
		<option value="Window">Windows</option>
		<option value="Linux">Linux</option>
		<option value="Other">Other</option>
	</select>

	<label for="software">Software</label>
    <input name="software" type="text" id="software">
	<hr>
	
	<label for="specCheck">Assign Specialist</label>
    <input name="specCheck" type="checkbox" id="specCheck" checked>
	<label for="specID">Specialist ID</label>
    <input name="specID" type="text" id="specID" size="4">
	<label for="specName">Specialist Name</label>
    <input name="specName" type="text" id="specName">
	<hr>
	
	<label for="notes">Description</label>
	<br>
    <textarea id="notes" name="notes" rows="5" cols="100"></textarea>
	<br>

	<div id="solutionBox" >
	<hr>
	<label for="solution">Solution</label>
	<br>
	<textarea id="solution" name="solution" rows="5" cols="100"></textarea>
	</div>
	<input type="submit" name="submitnew">
    <input type="submit" name="submitexisting">
</form>	

</body>

<?php
    include "Notifications.php";
    //function for generating next problem number.
    function getNextProblem($conn) {    
        $sqlPrevProblem = "SELECT MAX(ProblemNo) AS 'ProblemNo' FROM ProblemNumber";
        $probResult = mysqli_query($conn, $sqlPrevProblem);
        $oldProblemNumStr = ($probResult->fetch_assoc())["ProblemNo"];
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

	//Getting the values for each field from the form.
	$probType = $_POST["probType"];
	//$newProbType = $_POST["newProbType"]; add later.
	$opID = $_POST["opID"]; //remove later
	$callerName = $_POST["callName"];
	$callerID = $_POST["callID"];
	$priority = $_POST["Priority"];
	$serialNum = $_POST["serialNum"]; //opt
    $operatingSys = $_POST["operatingSystem"]; //opt
	$software = $_POST["software"]; //opt
	$specID = $_POST["specID"]; //opt
	$specName = $_POST["specName"]; //opt
	$desc = $_POST["notes"];
    $solution = $_POST["solution"]; //opt

    //Autogenerated fields:
    $callDate = date("Y/m/d"); 
	$callTime = date("h:i:s"); 
    //$opID  from current user
    //If the operator has input a solution, counts the problem as solved.
    if ($solution != NULL) {
        $solved = "Yes";
    } else {
        $solved = "No";
    }
    $accepted = "No";

	//test for variables entered in test form:
	echo "tNum = $ticketNum \npNum = $problemNum \npType = $probType \nopName = $opName \ncallName = $callerName
	\ncallID = $callerID \ndate = $callDate \ntime = $callTime \npriority = $priority \nserial = $serialNum 
	\nsoftware = $software \nspecID = $specID \ndesc = $desc \nsolution = $solution \n right/wrong = $accepted";

    //db connection variables
    include 'databaseConnection.php';
    //test
    //Checks form has been submitted and then adds submission to db
    if (isset($_POST["submitnew"]) or isset($_POST["submitexisting"])) {
        //Create db connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        //Check db connection
        if ($conn->connect_error) {
            die("Connection to database failed" . $conn->connect_error);
        }

        //differentiates wheter a new problem is being submitted or a ticket is being added to an existing problem.
        if (isset($_POST["submitnew"])) {
            $problemNum = getNextProblem($conn);
        } else if (isset($_POST["submitexisting"])) {
            $problemNum = $_POST["probNum"];
        }

        //Generates ticket number
        $ticketNum = getNextTicket($conn);

        //sql statement for new ticket
        $sqlTicket = "INSERT INTO Tickets(TicketNo, CallerID, OperatorID, CallDate, CallTime, ProblemNo)
        VALUES ('$ticketNum', '$callerID', '$opID', '$callDate', '$callTime', '$problemNum')";

        //sql statement for problem
        $sqlProblem = "INSERT INTO ProblemNumber(ProblemNo, ProblemType, SerialNumber, SoftwareName, OS, ProblemDescription,
            Solution, Urgency, SpecialistID, Accepted, Resolved, 1stSubmissionDate)
        VALUES ('$problemNum', '$probType', '$serialNum', '$software', '$operatingSys', '$desc', '$solution', NULL, '$specID',
            '$accepted', '$solved', '$callDate')"; 
        
        // Check that opID is the correct variable to use!! Also is this in the correct place??
        generateNotification($conn, $opID, $specID, 'New Problem');


        //Add records to db
        if (mysqli_query($conn, $sqlTicket)){
            //
        } else {
            echo "Error" . mysqli_error($conn);
        }
        if (isset($_POST["submitnew"])) {
            if (mysqli_query($conn, $sqlProblem)){
                //
            } else {
                echo "Error" . mysqli_error($conn);
            }
        }

        //close db connection.
        $conn->close();
    }  
?>

<footer>
<script>
//Ensures the form data is reset upon submission
if (window.history.replaceState) {
    window.history.replaceState (null, null, window.location.href);
}
</script>
</footer>
</html>