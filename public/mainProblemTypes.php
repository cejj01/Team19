<?php
echo "<option hidden disabled selected value> -- Select an option -- </option>";
echo '<optgroup label="----New Problem----">';
echo '<option value="newProblem" >New Problem</option>';
echo "</optgroup>";
echo '<optgroup label="----Hardware----">';

//sql for getting each hardware problem type
$sqlHardwareProb = "SELECT DISTINCT ProblemType FROM ProblemTypes WHERE ProblemArea = 'Hardware'
    ORDER BY ProblemType";
$resultHardwareProb = $conn->query($sqlHardwareProb);

//Displays each hardware problem and subproblem tpye
if ($resultHardwareProb->num_rows > 0) {
    while ($row = $resultHardwareProb->fetch_assoc()) {
        $pType = $row['ProblemType'];
        echo "<option label='$pType'>$pType</option>";

           }
}
echo "</optgroup>";
echo '<optgroup label="----Software----">';
//sql for getting each software problem type
$sqlSoftwareProb = "SELECT DISTINCT ProblemType FROM ProblemTypes WHERE ProblemArea = 'Software'
    ORDER BY ProblemType";
$resultSoftwareProb = $conn->query($sqlSoftwareProb);

//Displays each software problem and subproblem tpye
if ($resultSoftwareProb->num_rows > 0) {
    while ($row = $resultSoftwareProb->fetch_assoc()) {
        $pType = $row['ProblemType'];
        echo "<option label='$pType'>$pType</option>";

           }
}
    
echo "</optgroup>";
?>