<?php
echo "<option hidden disabled selected value> -- Select an option -- </option>";
echo '<optgroup label="----Hardware----">';

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
                $value = $pType . " " . $subPType;
                echo "<option value='$value'>$value</option>";
              }
            }
	    echo "</optgroup>";
        }
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
        echo "<optgroup label='$pType'>";

        //sql for getting sub problem types
        $sqlSoftwareSub = "SELECT SubProblemType FROM ProblemTypes 
            WHERE ProblemArea = 'Software' AND ProblemType = '$pType' ORDER BY SubProblemType";
        $resultSoftwareSub = $conn->query($sqlSoftwareSub);

        if ($resultSoftwareSub->num_rows > 0) {
            while ($row = $resultSoftwareSub->fetch_assoc()) {
                $subPType = $row["SubProblemType"];
                if ($subPType != "") {
                    $value = $pType . " " . $subPType;
                    echo "<option class = 'SoftwareOption' value='$value'>$value</option>";
                }
            }
	   		echo "</optgroup>";
        }
    }
}
    
echo "</optgroup>";
?>