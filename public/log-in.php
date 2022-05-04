<?php
    // Create connection to database
    $servername = "localhost";
    $username = "teamb019";
    $password = "lrf5vFbpTh";
    $dbname = "teamb019";

    // Create connection
    //$conn = mysqli_connect($servername, $username, $password, $dbname);


    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Make-It-All Login</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/css/mainStyle.css">
<style>
* {
  box-sizing: border-box;
}

.p1 {
  text-align: center;
  color: var(--accent-colour)
  font-weight: 700;
}

.form-container {
  width: 500px;
  height: 280px;
  padding: 30px;
  text-align: center;
  background: #444444;
  color: var(--accent-colour);
  font-weight: 700;
  margin: auto;
  font-size: 90%;
  border-style: solid;
  border-color: black;
  border-radius: 10px;
  border-width: 1px;
}

.login-text-box {
  border-width: 1px;
  border-color: black;
  outline: none;
  border-style: solid;
  border-radius: 5px;
  width: 100%;
  height: 40px;
  font-size: 120%;
}

.submit-button {
  width: 100%;
  height: 40px;
  background-color: var(--accent-colour);
  color:black;
  font-size: 110%;
  font-weight: 700;
  border-color: #F6D300;
  border-radius: 5px;
  border: none;
}  
.logo {
	width: 125px;
	align:center;
    display: block;
    margin-left: auto;
    margin-right: auto;}

body {
background-image: url('/src/Make-It-AllBackground.png');
  background-size: cover;
  font-family: Arial, Helvetica, sans-serif;
  margin: 0;
  background-repeat: no-repeat;
  background-attachment: fixed;
}

label{float:left;
padding-bottom:2px;}


.make-it-all-text {
    width: 800px;
	align:center;
    display: block;
    margin-left: auto;
    margin-right: auto;
    }
</style>
</head>
<body>
<div style="background-image"
<br>

 <img src="/src/Make-It-AllText.png" alt="make-it-all helpdesk.png" class="make-it-all-text"> 

<br>


<div class="form-container">
  <form action="/login.php" method="post" class="login-form">
  <div class="label-container">
  
  <label for="username">Username</label><br>
  <input type="text" class="login-text-box" id="username" name="username"><br><br>
  <label for="password">Password</label><br>
  <input type="password" class="login-text-box" id="password" name="password"><br><br>
  <input class="submit-button" id = "submit" name="submit" type="submit" value="Sign in">
  </div>
</form> 
<br>
<p class ="p1"> Forgot your password? </p>
</div>


</body>
</html>
