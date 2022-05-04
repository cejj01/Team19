<?php
  //sql statement for getting commom problems
  $sqlSelectCommon = "SELECT CommonProblemNo, ProblemDescription, Solution, ProblemTypes.ProblemType, ProblemTypes.SubProblemType FROM CommonProblems LEFT JOIN ProblemTypes ON CommonProblems.ProblemTypeID = ProblemTypes.ProblemTypeID";

  //gets result from db
  $resultCommon = $conn->query($sqlSelectCommon);

  //Displays each problem in common problems table.
  if ($resultCommon->num_rows > 0) {
      echo "<table border='1' class='dark-table' id='CommonProblemsTable'>";
      echo "<tr> <th>Num</th> <th>ProblemType</th> <th>Description</th> <th>Solution</th> </tr>";
      while ($row = $resultCommon->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row['CommonProblemNo'] . "</td>";
          echo "<td>" . $row['ProblemType'] . ' ' . $row['SubProblemType'] . "</td>";
          echo "<td>" . $row['ProblemDescription'] . "</td>";
          echo "<td>" . $row['Solution'] . "</td>";
          echo "</tr>";
      }
      echo "</table>";
  }
	
  ?>
<hr>


<!-- Delete Common problem -->
<div id="DeleteCommonProblemModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Delete a common problem</h2>
<hr>
    </div>

    <div class="modal-body">
    <form id="DeleteCommonProblem" method="post">
<?php
      //sql statement for getting commom problems
  $sqlSelectCommon = "SELECT CommonProblemNo, ProblemType, ProblemDescription, Solution FROM CommonProblems";

  //gets result from db
  $resultCommon = $conn->query($sqlSelectCommon);

  //Displays each problem in common problems table.
  if ($resultCommon->num_rows > 0) {
      echo "<table border='1' id='DeleteCommonProblemsTable' class='dark-table fixPadding' onclick='SelectCommonProblemRow(event)'>";
      echo "<tr> <th>Num</th> <th>ProblemType</th> <th>Description</th> <th>Solution</th> </tr>";
      while ($row = $resultCommon->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row['CommonProblemNo'] . "</td>";
          echo "<td>" . $row['ProblemType'] . "</td>";
          echo "<td>" . $row['ProblemDescription'] . "</td>";
          echo "<td>" . $row['Solution'] . "</td>";
          echo "</tr>";
      }
      echo "</table>";
  }
	
  ?>
    <div class="modal-footer">
<hr>
<br>
      <label for="probEnter">Problem Number To Delete:</label>
      <input type="text" name="probEnter" id="probEnter" required>
      <input class="wide-button" type="submit" name="submitDeleteCommon" value="Delete Common Problem">
</div>
</form>
</div>
</div>
</div>  


<!-- Add Common problem -->
<div id="AddCommonProblemModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Add a common problem</h2>
<hr>
    </div>

    <div class="modal-body">
    <form id="AddCommonProblem" method="post">
     <div class="left-input" id="CommonProblemTypeDiv" style="padding-bottom: 20px;">
	<label for="probType">Problem Type:</label>
	<select onchange="ProblemTypeChange()" class="modal-input" name="CommonProblemType" id="CommonProblemType">
		<option hidden disabled selected value> -- Select an option -- </option>
		<optgroup label="----Hardware----">
      <?php
      //sql for getting each hardware problem type
      $sqlHardwareProb = "SELECT DISTINCT ProblemType FROM ProblemTypes WHERE ProblemArea = 'Hardware'
        ORDER BY ProblemType";
      $resultHardwareProb = $conn->query($sqlHardwareProb);

      //Displays each hardware problem and subproblem tpye
      if ($resultHardwareProb->num_rows > 0) {
        while ($row = $resultHardwareProb->fetch_assoc()) {
          $pType = $row['ProblemType'];
          echo "<optgroup label='$pType'>";

          //sql for getting sub problem types
          $sqlHardwareSub = "SELECT SubProblemType FROM ProblemTypes 
            WHERE ProblemArea = 'Hardware' AND ProblemType = '$pType' ORDER BY SubProblemType";
          $resultHardwareSub = $conn->query($sqlHardwareSub);

          if ($resultHardwareSub->num_rows > 0) {
            while ($row = $resultHardwareSub->fetch_assoc()) {
              $subPType = $row["SubProblemType"];
              if ($subPType != "") {
                $value = $pType . "-" . $subPType;
                echo "<option value='$value'>$value</option>";
              }
            }
	    echo "</optgroup>";

          }
        }
      }
      ?>
		</optgroup>
		<optgroup label="----Software----">
      <?php
      //sql for getting each software problem type
      $sqlSoftwareProb = "SELECT DISTINCT ProblemType FROM ProblemTypes WHERE ProblemArea = 'Software'
        ORDER BY ProblemType";
      $resultSoftwareProb = $conn->query($sqlSoftwareProb);

      //Displays each software problem and subproblem tpye
      if ($resultSoftwareProb->num_rows > 0) {
        while ($row = $resultSoftwareProb->fetch_assoc()) {
          $pType = $row['ProblemType'];
          echo "<optgroup label='$pType'>";

          //sql for getting sub problem types
          $sqlSoftwareSub = "SELECT SubProblemType FROM ProblemTypes 
            WHERE ProblemArea = 'Software' AND ProblemType = '$pType' ORDER BY SubProblemType";
          $resultSoftwareSub = $conn->query($sqlSoftwareSub);

          if ($resultSoftwareSub->num_rows > 0) {
            while ($row = $resultSoftwareSub->fetch_assoc()) {
              $subPType = $row["SubProblemType"];
              if ($subPType != "") {
                $value = $pType . "-" . $subPType;
                echo "<option value='$value'>$value</option>";
              }
            }
	   echo "</optgroup>";
          }
        }
      }
      ?>
		</optgroup>
	</select>

</div>
	
	
	


	<label for="problem-description">Description</label><br>
	<textarea id="problem-description-text-area" name="problem-description" rows="10" style ="resize: none;"></textarea><br>

	<label for="problem-solution">Solution</label><br>
	<textarea id="problem-solution-text-area" name="problem-solution" rows="10" style ="resize: none;"></textarea>

    </div>
    <div class="modal-footer">
<hr>
<br>
      <input class="wide-button" type="submit" name="submitCommonProblem" value="Add Common Problem">
</div>
</form>
</div>
</div>
</div>  
<?php
//function for getting the next common problem number
function getNextCPNum($conn) {
  //sql for getting maximum cp number
  $sqlPrevCP = "SELECT MAX(CommonProblemNo) AS 'Number' FROM CommonProblems";
  $resultPrev = $conn->query($sqlPrevCP);

  $maxNum = ($resultPrev->fetch_assoc())['Number'];
  $newNum = $maxNum + 1;
  return $newNum;
}

if (isset($_POST["submitCommonProblem"])) {
  //Create db connection
  include '../databaseConnection.php';

  //Values for new common problem
  $cpNum = getNextCPNum($conn);
  $problemType = $_POST["CommonProblemType"];
  $description = $_POST["problem-description"];
  $solution = $_POST["problem-solution"];

  //sql statement for adding new common problem
  $sqlInsertCommon = "INSERT INTO CommonProblems VALUES ('$cpNum','$problemType','$description','$solution')";
    
  //Add records to db
  if (mysqli_query($conn, $sqlInsertCommon)){
      //
  } else {
      echo "Error" . mysqli_error($conn);
  }



  //Close db connection
  $conn->close();
}

if(isset($_POST["submitDeleteCommon"])) {
  //Create db connection
  include '../databaseConnection.php';

  //value for common problem to be deleted.
  $commonProbNum = $_POST["probEnter"];

  //sql for deleting common problem
  $sqlDelete = "DELETE FROM CommonProblems WHERE CommonProblemNo = '$commonProbNum'";

  if ($conn->query($sqlDelete) === TRUE) {
		//
	} else {
		echo "Error deleting record: " . $conn->error;
	}


  //Close db connection
  $conn->close();
}




?>



