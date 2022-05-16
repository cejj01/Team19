<!DOCTYPE html>
<html>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<body>
<div id="ProblemType" style="width:100%; max-width:600px; height:500px;"></div>
    <script>
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawPieChart);
  
      function drawPieChart() {
        var data = google.visualization.arrayToDataTable([ ['Problem Type', '%'],
  
        
        <?php include 'databaseConnection.php';
        getProblemTypeData($conn);
        function getProblemTypeData ($conn) {
          $sqlGetProblemTypeData = "SELECT ProblemType, COUNT(ProblemType) FROM ProblemNumber GROUP BY ProblemType";
          $resultGetProblemTypeData = $conn->query($sqlGetProblemTypeData);
          if ($resultGetProblemTypeData->num_rows > 0) {
            while ($row = $resultGetProblemTypeData->fetch_assoc()) {
              echo "['".$row['ProblemType']."',".$row['COUNT(ProblemType)']."],";
            }
          }
      }?> 
  
  
        ]);
  
        var options = {
    title:'Romano is GAYYYYYYYYYYY'
  };
  
  var chart = new google.visualization.BarChart(document.getElementById('ProblemType'));
    chart.draw(data, options);
  }
  </script>


<div id="Software" style="width:100%; max-width:600px; height:500px;"></div>
<script>
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawSoftwareDataChart);

      function drawSoftwareDataChart() {
        var data = google.visualization.arrayToDataTable([ ['Software Name', '%'],

          <?php include 'databaseConnection.php';
          getSoftwareData($conn);
          function getSoftwareData ($conn) {
            $sqlGetSoftwareData = "SELECT SoftwareName, COUNT(SoftwareName) AS noSoftware FROM ProblemNumber WHERE SoftwareName != '' GROUP BY SoftwareName";
            $resultGetSoftwareData = $conn->query($sqlGetSoftwareData);
            if ($resultGetSoftwareData->num_rows > 0) {
              while ($row = $resultGetSoftwareData->fetch_assoc()) {
                echo "['".$row['SoftwareName']."',".$row['noSoftware']."],";
              }
            }
          } ?>


        ]);

        var options = {title:'Damon is GAYYYYYYYYYYY'};

        var chart = new google.visualization.BarChart(document.getElementById('Software'));
        chart.draw(data, options);
      }
</script>

<div id="OS" style="width:100%; max-width:600px; height:500px;"></div>
<script>
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawOSDataChart);

      function drawOSDataChart() {
        var data = google.visualization.arrayToDataTable([ ['OS', '%'],

          <?php include 'databaseConnection.php';
          getOSData($conn);
          function getOSData ($conn) {
            $sqlGetOSData = "SELECT OS, COUNT(OS) as 'noOS' FROM ProblemNumber WHERE OS != '' GROUP BY OS";
            $resultGetOSData = $conn->query($sqlGetOSData);
            if ($resultGetOSData->num_rows > 0) {
              while ($row = $resultGetOSData->fetch_assoc()) {
                echo "['".$row['OS']."',".$row['noOS']."],";
              }
            }
          } ?>


        ]);

        var options = {title:'Miles is GAYYYYYYYYYYY'};

        var chart = new google.visualization.BarChart(document.getElementById('OS'));
        chart.draw(data, options);
      }
</script>

<div id="SerialNumbers" style="width:100%; max-width:600px; height:500px;"></div>
<script>
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawSerialNumbersChart);

      function drawSerialNumbersChart() {
        var data = google.visualization.arrayToDataTable([ ['SerialNumber', 'No. Problems'],

          <?php include 'databaseConnection.php';
          getSerialNumberData($conn);
          function getSerialNumberData ($conn) {
            $sqlGetSerialNumberData = "SELECT SerialNumber, COUNT(SerialNumber) AS noSerialNumber FROM ProblemNumber WHERE SerialNumber != '' GROUP BY SerialNumber";
            $resultGetSerialNumberData = $conn->query($sqlGetSerialNumberData);
            if ($resultGetSerialNumberData->num_rows > 0) {
              while ($row = $resultGetSerialNumberData->fetch_assoc()) {
                echo "['".$row['SerialNumber']."',".$row['noSerialNumber']."],";
              }
            }
          } ?>


        ]);

        var options = {title:'Vlad is GAYYYYYYYYYYY'};

        var chart = new google.visualization.BarChart(document.getElementById('SerialNumbers'));
        chart.draw(data, options);
      }
</script>

<div id="avgTimeOpen" style="width:100%; max-width:600px; height:500px;"></div>
<script>
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawAverageTimeOpenChart);

      function drawAverageTimeOpenChart() {
        var data = google.visualization.arrayToDataTable([ ['Time Interval Open', 'No. Problems'],

          <?php include 'databaseConnection.php';
          getProblemsSolvedinFive($conn);
          getProblemsSolvedinTen($conn);
          getProblemsSolvedinMoreThanTen($conn);

          function getProblemsSolvedinFive ($conn) {
            $sqlGetLessThanFive = "SELECT COUNT(ProblemNo) FROM ProblemNumber WHERE DATEDIFF(SolutionDate, 1stSubmissionDate) <= 5 AND Accepted = 'Yes'";
            $resultGetLessThanFive = $conn->query($sqlGetLessThanFive);
            if ($resultGetLessThanFive->num_rows > 0) {
              while ($row = $resultGetLessThanFive->fetch_assoc()) {
                echo "['<5 days open',".$row['COUNT(ProblemNo)']."],";
              }
            }
          } 
          function getProblemsSolvedinTen ($conn) {
            $sqlGetLessThanTen = "SELECT COUNT(ProblemNo) FROM ProblemNumber WHERE DATEDIFF(SolutionDate, 1stSubmissionDate) > 5 AND DATEDIFF(SolutionDate, 1stSubmissionDate) <= 10 AND Accepted = 'Yes'";
            $resultGetLessThanTen = $conn->query($sqlGetLessThanTen);
            if ($resultGetLessThanTen->num_rows > 0) {
              while ($row = $resultGetLessThanTen->fetch_assoc()) {
                echo "['>5days open<10',".$row['COUNT(ProblemNo)']."],";
              }
            }
          }
          function getProblemsSolvedinMoreThanTen($conn) {
            $sqlGetGreaterThanTen = "SELECT COUNT(ProblemNo) FROM ProblemNumber WHERE DATEDIFF(SolutionDate, 1stSubmissionDate) > 10 AND Accepted = 'Yes'";
            $resultGetGreaterThanTen = $conn->query($sqlGetGreaterThanTen);
            if ($resultGetGreaterThanTen->num_rows > 0) {
              while ($row = $resultGetGreaterThanTen->fetch_assoc()) {
                echo "['>10 days open',".$row['COUNT(ProblemNo)']."],";
              }
            }
          }
          ?>


        ]);

        var options = {title:'Aneirin is NOT GAYYYYYYYYYYY'};

        var chart = new google.visualization.BarChart(document.getElementById('avgTimeOpen'));
        chart.draw(data, options);
      }
</script>




  </body>
</html>