<?php include 'analheader.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<title>Analytics</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="/css/mainStyle.css">
<style>
/* Styles the tab */
.tab {
	overflow: hidden;
	border: 1px solid #ccc;
	background-color: #333333;
}

/* Styles the buttons that are used to open the tab content */
.tab button {
	background-color: inherit;
	color: #fff;
	float: left;
	border: none;
	outline: none;
	cursor: pointer;
	padding: 14px 16px;
	transition: 0.3s;
}

/* Changes color of buttons when hovering and active */
.tab button:hover {
	background-color: #444;
}
.tab button.active {
	background-color: #555;
}

/* Styles the tab content */
.tabContent {
	display: none;
	padding: 6px 12px;
	border: 1px solid #ccc;
	border-top: none;
}

/* Opens Stats tab by default */
#Stats {
		display: block;
}

/* Stat table CSS */
#Stats table { 
	border: 1px solid #777777;
	
}

#Stats th { 
	background-color: #101010;
	font-size: 20px;
	font-weight: bold;
	color: #ffffff;
}

#Stats td{
	background-color: #202020;
	font-size: 30px;
	font-weight: normal;
	color: var(--accent-colour);
}




</style>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body>
<br>

<div class="page-container">
<h1>Analytics</h1>
<hr>

<!-- Buttons for switching tabs -->
<div class="tab">
	<button class="tabButton active" onclick="openTabs(event, 'Stats')">Stats</button>
	<button class="tabButton" onclick="openTabs(event, 'Graphs')">Graphs</button>
</div>

<!-- Stats about tickets and problems -->
<div id="Stats" class="tabContent active">
	<h2>Stats (All Time)</h2>
	<hr>
	
	<table>
	<col style="width:50%">
	<col style="width:50%">
	<tr>
		<th>Avg. Solve Time (Days)</th>
		<th>Most Common Problem Type</th>
	</tr>
	<tr>
		<td id="AverageSolveTime">28</td>
		<td>Printer</td>
	</tr>
	<tr>
		<th>Current Open Tickets</th>
		<th>Solved Tickets</th>
	</tr>
	<tr>
		<td id="noCurrentlyOpenProblems">10</td>
		<td id="noSolvedTickets">32</td>
	</tr>
	<tr>
		<th>Avg. Tickets per Specialist</th>
		<th>% Solved without Specialist</th>
	</tr>
	<tr>
		<td>6</td>
		<td id="nonSpecialistSolved">27%</td>
	</tr>
	</table>
</div>
<script>
	generateAnalyticsData();
	function generateAnalyticsData() {
		<?php
		include "../databaseConnection.php";
		$analyticsData = array();

		// Get average time to solve from the database
		$sqlAverageSolveTime = "SELECT ROUND(AVG(DATEDIFF(SolutionDate,1stSubmissionDate))) AS 'avgSolveTime' FROM ProblemNumber WHERE Accepted = 'Yes'";
		$resultAverageSolveTime = $conn->query($sqlAverageSolveTime);
		if ($resultAverageSolveTime->num_rows > 0) {
			while ($row = $resultAverageSolveTime->fetch_assoc()) {
				// Save this row into the analytics data array
				$analyticsData[] = $row;
			}
		}

		// Get number of unsolved problems from the database
		$sqlNoCurrentlyOpenTickets = "SELECT COUNT(ProblemNo) AS 'probCount' FROM ProblemNumber WHERE Solution = ''";
		$resultNoCurrentlyOpenTickets = $conn->query($sqlNoCurrentlyOpenTickets);
		if ($resultNoCurrentlyOpenTickets->num_rows > 0) {
			while ($row = $resultNoCurrentlyOpenTickets->fetch_assoc()) {
				// Save this row into the analytics data array
				$analyticsData[] = $row;
			}
		}

		// Get the number of solved problems from the database
		$sqlNoSolvedTickets = "SELECT COUNT(ProblemNo) AS 'noSolvedTickets' FROM ProblemNumber WHERE Accepted = 'Yes'";
		$resultNoSolvedTickets = $conn->query($sqlNoSolvedTickets);
		if ($resultNoSolvedTickets->num_rows > 0) {
			while ($row = $resultNoSolvedTickets->fetch_assoc()) {
				// Save this row into the analytics data array
				$analyticsData[] = $row;
			}
		}
		
		// Get the number of solved problems without using a specialist from the database
		$sqlOperatorSolved = "SELECT COUNT(ProblemNo) AS 'operatorSolved' FROM ProblemNumber WHERE Accepted = 'Yes' AND SpecialistID = 'F013103'";
		$resultOperatorSolved = $conn->query($sqlOperatorSolved);
		if ($resultOperatorSolved->num_rows > 0) {
			while ($row = $resultOperatorSolved->fetch_assoc()) {
				// Save this row into the analytics data array
				$analyticsData[] = $row;
			}
		}
		
		?>
		// Encode the array into json and echo it, save this to a javascript variable
		var analyticsContent = <?php echo json_encode($analyticsData);?>;
		// Set the appropriate html forms to have the value outputted by the database
		document.getElementById('AverageSolveTime').innerHTML = analyticsContent[0]['avgSolveTime'];
		document.getElementById('noCurrentlyOpenProblems').innerHTML = analyticsContent[1]['probCount'];
		document.getElementById('noSolvedTickets').innerHTML = analyticsContent[2]['noSolvedTickets'];
		
		var percentSolvedNoSpec = (analyticsContent[3]['operatorSolved']/analyticsContent[2]['noSolvedTickets'])*100;
		document.getElementById('nonSpecialistSolved').innerHTML = percentSolvedNoSpec+'%';
	}
</script>

<!-- Graphs based on the stats -->
<div id="Graphs" class="tabContent">
	<h2>Graphs</h2>
	<hr>
	<div id="chart_div" class="hidden"></div>
	<div id="ProblemType" style="width:100%; max-width:700px; height:500px;"></div>
    <script>
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawPieChart);
  
      function drawPieChart() {
        var data = google.visualization.arrayToDataTable([ ['Problem Type', '%'],
  
        /*This populates the chart with appropriate data from the database
				It queries the database and echos the data in an appropriate format for google charts
				Note COUNT(ProblemType) must be an integer
				*/
        <?php include '../databaseConnection.php';
				getProblemTypeData($conn);
        function getProblemTypeData ($conn) {
          $sqlGetProblemTypeData = "SELECT ProblemNumber.ProblemTypeID, ProblemTypes.ProblemType, COUNT(ProblemNumber.ProblemTypeID) FROM ProblemNumber LEFT JOIN ProblemTypes ON ProblemTypes.ProblemTypeID = ProblemNumber.ProblemTypeID GROUP BY ProblemNumber.ProblemTypeID";
          $resultGetProblemTypeData = $conn->query($sqlGetProblemTypeData);
          if ($resultGetProblemTypeData->num_rows > 0) {
            while ($row = $resultGetProblemTypeData->fetch_assoc()) {
              echo "['".$row['ProblemType']."',".$row['COUNT(ProblemTypeID)']."],";
            }
          }
      }?> 
  
  
        ]);
  
        var options = {
    title:'Percentage of problems by Problem Type',
						'width':900,
						'height':500};
  
  var chart = new google.visualization.PieChart(document.getElementById('ProblemType'));
    chart.draw(data, options);
  }
  </script>


<div id="Software" style="width:100%; max-width:700px; height:500px;"></div>
<script>
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawSoftwareDataChart);

      function drawSoftwareDataChart() {
        var data = google.visualization.arrayToDataTable([ ['Software Name', '%'],

          <?php include '../databaseConnection.php';
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

        var options = {title:'Percentage of Software problems by Software Type',
						'width':900,
						'height':500};

        var chart = new google.visualization.PieChart(document.getElementById('Software'));
        chart.draw(data, options);
      }
</script>

<div id="OS" style="width:100%; max-width:700px; height:500px;"></div>
<script>
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawOSDataChart);

      function drawOSDataChart() {
        var data = google.visualization.arrayToDataTable([ ['OS', '%'],

          <?php include '../databaseConnection.php';
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

        var options = {title:'Percentage of Software problems by Operating System',
						'width':900,
						'height':500};

        var chart = new google.visualization.PieChart(document.getElementById('OS'));
        chart.draw(data, options);
      }
</script>

<div id="SerialNumbers" style="width:100%; max-width:700px; height:500px;"></div>
<script>
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawSerialNumbersChart);

      function drawSerialNumbersChart() {
        var data = google.visualization.arrayToDataTable([ ['SerialNumber', 'No. Problems'],

          <?php include '../databaseConnection.php';
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

        var options = {title:'Number of problems per hardware device',
						'width':900,
						'height':500};

        var chart = new google.visualization.BarChart(document.getElementById('SerialNumbers'));
        chart.draw(data, options);
      }
</script>

<div id="avgTimeOpen" style="width:100%; max-width:700px; height:500px;"></div>
<script>
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawAverageTimeOpenChart);

      function drawAverageTimeOpenChart() {
        var data = google.visualization.arrayToDataTable([ ['Time Interval Open', 'No. Problems'],

          <?php include '../databaseConnection.php';
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

        var options = {title:'Number of problems by time interval',
						'width':900,
						'height':500};

        var chart = new google.visualization.BarChart(document.getElementById('avgTimeOpen'));
        chart.draw(data, options);
      }
</script>
</div>


</div>
</body>

<script>
function openTabs(event, currentTab) {
	var i, tabContent, tabButton;

	//Hides all tab contents
	tabContent = document.getElementsByClassName("tabContent");
	for (i = 0; i < tabContent.length; i++) {
		tabContent[i].style.display = "none";
	}

	//Removes active class from tab buttons
	tabButton = document.getElementsByClassName("tabButton");
	for (i = 0; i < tabButton.length; i++) {
		tabButton[i].className = tabButton[i].className.replace(" active", "");
	}

	//Shows the chosen tab and adds an "active" class to the button
	document.getElementById(currentTab).style.display = "block";
	event.currentTarget.className += " active";
}


</script>
</html>
