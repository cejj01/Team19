<!DOCTYPE html>
<html lang="en">
<head>

<title>Common Problems</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="/css/mainStyle.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<?php include 'opheader.php' ?>

<body>
<div style="background-image">

<br>


<div class="page-container">
<!--Submit new ticket form-->
	
	<h1>Common Problems</h1>


</div>

</body>

<?php
    //function for getting next common problem number.
    function getNextCPNum($conn) {
        $sqlPrevCP = "SELECT MAX(CommonProblemNo) AS 'ProblemNo' FROM CommonProblems";
        $probResult = mysqli_query($conn, $sqlPrevCP);
        $oldProblemNumStr = ($probResult->fetch_assoc())["ProblemNo"];
        $problemNumInt = intval($oldProblemNumStr) + 1;
        $problemNum = strval($problemNumInt);
        return $problemNum;
    }

    //db connection variables
    include 'databaseConnection.php';

    //Create db connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    //Check db connection
    if ($conn->connect_error) {
        die("Connection to database failed" . $conn->connect_error);
    }

    //sql statement for getting commom problems
    $sqlSelectCommon = "SELECT CommonProblemNo, ProblemDescription, Solution FROM CommonProblems";

    //gets result from db
    $resultCommon = $conn->query($sqlSelectCommon);

    //Displays each problem in common problems table.
    if ($resultCommon->num_rows > 0) {
        echo "<table>";
        echo "<tr> <td>Num</td> <td>Description<td> <td>Solution</td>";
        while ($row = $resultCommon->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['CommonProblemNo'] . "</td>";
            echo "<td>" . $row['ProblemDescription'] . "</td>";
            echo "<td>" . $row['Solution'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }


    //close db connection.
    $conn->close();
?>

<!-- test form for new common problems -->
<form id="cpForm" method="post">
    <label for="description">Description</label>
    <input name="description" id="description"><br>

    <label for="solution">Solution</label>
    <input name="solution" id="solution"><br>

    <input type="submit" name="submitcp">
</form>


<?php
    //submitting a new common problem
    if (isset($_POST["submitcp"])) {
        //Create db connection
        $connIns = new mysqli($servername, $username, $password, $dbname);
        //Check db connection
        if ($connIns->connect_error) {
            die("Connection to database failed" . $connIns->connect_error);
        }

        //Gets details for new common problem submission
        $cpNum = getNextCPNum($connIns);
        $description = $_POST['description'];
        $solution = $_POST['solution'];

        //sql statement for adding new common problem
        $sqlInsertCommon = "INSERT INTO CommonProblems VALUES ('$cpNum','$description','$solution',)";
    
        //Add records to db
        if (mysqli_query($connIns, $sqlInsertCommon)){
            //
        } else {
            echo "Error" . mysqli_error($connIns);
        }

        $connIns->close();
    }
?>
</html>
