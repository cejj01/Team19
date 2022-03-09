<?php include 'analheader.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>

<title>Common Problems</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/css/modalStyle.css">
<link rel="stylesheet" href="/css/mainStyle.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>


<body>

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
 var datamap = new Map([
		[document.getElementById("DeleteCommonProblemButton"), document.getElementById("DeleteCommonProblemModal")],
		[document.getElementById("AddCommonProblemButton"), document.getElementById("AddCommonProblemModal")]
        	        ]);

        datamap.forEach((value, key) => {
            makeModal(key, value); //for each modal and button, create the functions for them
        });

        function makeModal(thebutton, themodal) {

         var span = themodal.getElementsByClassName("close")[0];
		//make the buttons open modals
					thebutton.addEventListener("click", function (event) {
                		themodal.style.display = "block";
				whichArea = 0;
        	}); 			
		
            

		//make the X's close the modal
            span.addEventListener("click", function (event) {
                themodal.style.display = "none";
            });

		//make clicking away close the modals
            window.addEventListener("click", function (event) {
                if (event.target == themodal) {
                    themodal.style.display = "none";
                }
            });
        }

</script>
</body>
</html>
