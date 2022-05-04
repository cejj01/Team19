<?php include 'spheader.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>

<title>Common Problems</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="/css/mainStyle.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body>
<div style="background-image">

<br>


<link rel="stylesheet" href="/css/modalStyle.css">
<link rel="stylesheet" href="/css/probTableStyle.css">
<div class="page-container">
<div class="commonProblemsTable">
<h1>Common Problems</h1>
<hr>

<?php include '../commonProblemsTable.php';?>
</div>

</div>


<script>
// Function to select common problems
function SelectCommonRow(event) {
	var row = event.target.parentNode.parentNode.firstChild;
	while (row) {
		row.classList.remove("selected"); //remove all rows from the css class selected			
		row = row.nextElementSibling;
	}
	event.target.parentNode.classList.add("selected"); // make the clicked on row selected
}
</script>
</body>
</html>
