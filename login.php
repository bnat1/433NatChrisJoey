<!DOCTYPE html>
<html lang="en">
<head>
	<title>UMBC CMSC Virtual Advisor</title>
	<link rel='stylesheet' href='index.css' type='text/css'>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<meta name="description" content="Advising Help for UMBC Computer Science Students">
	<meta name="keywords" content="computer,science,433,UMBC,project,advising,help,classes">

</head>
<body>
	<div id="container">
		<div id="header">
		<p class="headerText">Computer Science Virtual Advisor</p>
		</div> <! -- close header -->
		<div id="content">
			<div id="titleBar"><h1 id="classes">LOGIN</h1></div><br><br>
			
			
<?php
        session_start();
	$err = 0;
	//make umbc id uppercase
        if(isset($_POST['id']) && preg_match('/[a-zA-Z]{2}\d{5}/',$_POST['id'])==0) {
		echo("Please enter a valid id<br>");
		$err+=1;
        }
	if(isset($_POST['email']) && preg_match('/\w*@umbc\.edu/',$_POST['email'])==0) {
		echo("Please enter a valid umbc email<br>");
		$err+=1;
	}
	if(isset($_POST['name']) && preg_match('/\w*\s\w*/',$_POST['name'])==0) {
                echo("Please enter a valid name<br>");
                $err+=1;
        }
	if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['email']) && $err==0) {
		$_POST['id'] = strtoupper($_POST['id']);
		$_SESSION['id'] = $_POST['id'];
		require_once('mysqlHelper.php');
		$res = updateUser($_POST['name'],$_POST['id'], $_POST['email']);
		if($res) {
			header('Location: courses.php');
		}
		else {
			echo("Error logging in");
		}
	}



?>


			<form action="" method="POST">
				<b>Full Name</b><br>
				<input class="login" type="text" name="name" placeholder="Enter your full name" required="requried"/><br><br>
                        	<b>UMBC ID</b><br>
				<input class="login" type="text" name="id" placeholder="Enter your UMBC ID" required="required"/><br><br>
				<b>UMBC E-Mail</b><br>
                        	<input class="login" type="email" name="email" placeholder="Enter your UMBC email" required="required"/><br><br>
				<input class="login" type="submit" value="Login"/>
			</form>
			</div>
		</div> <! -- close content -->
	</div>  <! -- closer container -->
	
</body>
</html>
