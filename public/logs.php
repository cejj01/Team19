<?php
//function for getting next log number
function getNextLogNum($conn) {
    $sqlPrevLog = "SELECT MAX(LogID) AS 'LogID' FROM Log";
    $resultPrevLog = $conn->query($sqlPrevLog);
    $lastLogNo = ($resultPrevLog->fetch_assoc())["LogID"];
    $newLogNo = $lastLogNo + 1;
    return $newLogNo;
}

//function for adding a new log to the db
function newLog($conn,$type,$problemNo) {
    //date and time of log
    $logDate = date("Y/m/d"); 
	$logTime = date("H:i:s");
    $LogID = getNextLogNum($conn);

    //sql for adding a log to the database
    $sqlLog = "INSERT INTO Log VALUES ('$LogID','$type','$logDate','$logTime','$problemNo')";

    //insert log
    if ($conn->query($sqlLog)) {
        //
    } else {
        echo "Error" . mysqli_error($conn);
    }
}
?>

