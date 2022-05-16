<!DoCTYPE HTML>
<html>
  <body>
    <?php
    
    //include 'databaseConnection.php';

    //getProblemTypeData($conn);
    //getSoftwareData($conn);

    function getProblemTypeData ($conn) {
      $sqlGetProblemTypeData = "SELECT ProblemType, COUNT(ProblemType) FROM ProblemNumber GROUP BY ProblemType";
      $resultGetProblemTypeData = $conn->query($sqlGetProblemTypeData);
      if ($resultGetProblemTypeData->num_rows > 0) {
        while ($row = $resultGetProblemTypeData->fetch_assoc()) {
          echo "['".$row['ProblemType']."',".$row['COUNT(ProblemType)']."],";
        }
      }
    }

    function getSoftwareData ($conn) {
      $softwareTypes = array();
      $sqlGetSoftwareData = "SELECT SoftwareName, COUNT(SoftwareName) FROM ProblemNumber WHERE SoftwareName != '' GROUP BY SoftwareName";
      $resultGetSoftwareData = $conn->query($sqlGetSoftwareData);
      if ($resultGetSoftwareData->num_rows > 0) {
        while ($row = $resultGetSoftwareData->fetch_assoc()) {
          $softwareTypes[] = $row;
        }
        echo json_encode($softwareTypes);
      }
    }

    function getOSData ($conn) {
      $OSTypes = array();
      $sqlGetOSData = "SELECT OS, COUNT(OS) FROM ProblemNumber GROUP BY OS WHERE OS != NULL";
      $resultGetOSData  = $conn->query($sqlGetOSData);
      if ($resultGetOSData->num_rows > 0) {
        while ($row = $resultGetOSData->fetch_assoc()) {
          $OSTypes[] = $row;
        }
        echo json_encode($OSTypes);
      }
    }

    function getSerialNumberData ($conn) {
      $SerialNumbers = array();
      $sqlGetSerialNumberData = "SELECT SerialNumber, COUNT(SerialNumber) FROM ProblemNumber GROUP BY SerialNumber WHERE SerialNumber != NULL";
      $resultGetSerialNumberData = $conn->query($sqlGetSerialNumberData);
      if ($resultGetSerialNumberData->num_rows > 0) {
        while ($row = $resultGetSerialNumberData->fetch_assoc()) {
          $SerialNumbers = $row;
        }
        echo json_encode($SerialNumbers);
      }
    }



    ?>
  </body>
</html>