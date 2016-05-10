<?php
	require_once('authenticate.php');
	require_once('mysqlHelper.php');
?>

<html>
<head>
	<title>UMBC CMSC Virtual Advisor</title>
	<link rel='stylesheet' href='index.css' type='text/css'>
</head>
<body>
	<div id="container">
		<div id="content">
			<div id="titleBar">
				<h1>UMBC CMSC Virtual Advisor</h1>
			</div>
			<!-- navigation bar -->
			<div id="navBar">
				<ul>
					<li><div id="titleBar">Logged in as: <?php echo("<b>$_SESSION[id]</b>");?></div></li>
					<li style="float:right"><a href="logout.php">Log Out</a></li>
				</ul>
			</div> <!-- end navBar div -->	
		<h1>Courses you are eligible to take:</h1>
			<div id="scrollbar">
			<a href="http://catalog.umbc.edu/preview_program.php?catoid=3&poid=318&returnto=104" target="_blank">
			To acquire detailed descriptions of each course, click here.
			</a><br /><br />
				<?php
					$allTaken = $_POST['taken'];
					$rec200 = $rec300 = $rec400 = $recMath = $recSci = $recStat = $taken200 = $taken300 = $taken400 = $takenMath =
					$takenSci = $takenStat = array();
					
					/*categorize taken classes into their respective subjects and levels (for CMSC) */
					if (!empty($allTaken)){
						$taken200 = preg_grep ('/(CMSC)\s2[0-9][0-9]/', $allTaken);
						$taken300 = preg_grep ('/(CMSC)\s3[0-9][0-9]/', $allTaken);
						$taken400 = preg_grep ('/(CMSC)\s4[0-9][0-9]/', $allTaken);
						$takenMath = preg_grep ('/MATH/', $allTaken);
						$takenSci = preg_grep ('(CHEM|BIOL|PHYS|GES|SCI)', $allTaken);
						$takenStat = preg_grep ('/STAT/', $allTaken);
					}

					//update all of our tables with the data the user just submittined
					updateCS($_SESSION['id'],$taken200,'cmsc200'); 
					updateCS($_SESSION['id'],$taken300,'cmsc300');
					updateCS($_SESSION['id'],$taken400,'cmsc400');
					updateMath($_SESSION['id'],$takenMath,'math');
					updateSci($_SESSION['id'],$takenSci,'science');
					updateStat($_SESSION['id'],$takenStat,'statistics');

					/*begin generation of courses the student is eligible to take */

					/*CMSC Courses*/
					if (empty($allTaken)){
						//array_push($classChoices, "CMSC 201", "MATH 151", "CHEM 101", "BIOL 141",
									//"PHYS 121", "GES 110", "GES 286", "SCI 100");
						array_push($rec200, "CMSC 201");
						array_push($recMath, "MATH 151");
						array_push($recSci, "CHEM 101", "BIOL 141", "PHYS 121", "GES 110", "GES 286", "SCI 100");
					}
					else if (!in_array ("CMSC 201", $taken200)){
						//array_push($classChoices, "CMSC 201");
						array_push($rec200, "CMSC 201");
					}
					else if (!in_array ("CMSC 202", $taken200)){
						//array_push($classChoices, "CMSC 202", "CMSC 352");
						array_push($rec200, "CMSC 202");
						array_push($rec300, "CMSC 352");
					}
					else if (!in_array ("CMSC 203", $taken200)){
						//array_push($classChoices, "CMSC 203", "CMSC 232", "CMSC 304", "CMSC 352", "CMSC 484");
						array_push($rec200, "CMSC 203", "CMSC 232");
						array_push($rec300, "CMSC 304", "CMSC 352");
						array_push($rec400, "CMSC 484");
					}
					else {
						//array_push($classChoices, "CMSC 232", "CMSC 291", "CMSC 299", "CMSC 304", "CMSC 313", "CMSC 331", 
						//				"CMSC 341", "CMSC 352", "CMSC 391", "CMSC 451", "CMSC 452", "CMSC 484");
						array_push($rec200, "CMSC 232", "CMSC 291", "CMSC 299");
						array_push($rec300, "CMSC 304", "CMSC 313", "CMSC 331","CMSC 341", "CMSC 352", "CMSC 391");
						array_push($rec400, "CMSC 451", "CMSC 452", "CMSC 484");
					}
					
					if (in_array("CMSC 313", $taken300)){
						array_push ($rec400, "CMSC 411");
						if (in_array("CMSC 341", $taken300)){
							array_push ($rec400, "CMSC 421");
						}
					}
					if (in_array("CMSC 331", $taken300)){
						array_push ($rec400, "CMSC 432", "CMSC 433", "CMSC 473");
					}
					if (in_array("CMSC 341", $taken300)){
						array_push ($rec300, "CMSC 345");
						array_push($rec400, "CMSC 427", "CMSC 437", "CMSC 471",
									"CMSC 455", "CMSC 456", "CMSC 476", "CMSC 475", "CMSC 461", "CMSC 481");
					}
					
					if (!empty($taken400)){
						array_push($rec400, "CMSC 447");
					}
					if (in_array("CMSC 421", $taken400)){
						array_push ($rec400, "CMSC 426", "CMSC 483", "CMSC 487");
					}
					if (in_array("CMSC 471", $taken400)){
						array_push ($rec400, "CMSC 478", "CMSC 479");
					}
					if (in_array("CMSC 461", $taken400) && in_array("CMSC 481", $taken400)){
						array_push ($rec400, "CMSC 465", "CMSC 466");
					}
					if (in_array("CMSC 435", $taken400) && in_array("CMSC 471", $taken400)){
						array_push ($rec400, "CMSC 493");
					}
					if (in_array("CMSC 331", $taken300) && in_array("CMSC 341", $taken300)){
						array_push ($rec400, "CMSC 436");
						
						if (in_array("CMSC 313", $taken300)){
							array_push ($rec400, "CMSC 431");
						}
					}
					if (in_array("CMSC 421", $taken400) && in_array("CMSC 481", $taken400)){
						array_push ($rec400, "CMSC 444");
					}
					
					if (in_array("CMSC 447", $taken300)){
						array_push ($rec400, "CMSC 448");
					}
					
					if (in_array("CMSC 471", $taken300)){
						array_push ($rec400, "CMSC 477", "CMSC 478", "CMSC 479");
					}
					
					/* STATISTICS */
					
					if (in_array("MATH 151", $takenMath)){
						array_push ($recStat, "STAT 355");
					}
					
					/* MATH */
					
					if (!in_array("MATH 151", $takenMath)) {
						array_push ($recMath, "MATH 151");
					}
					else {
						array_push ($recMath, "MATH 152", "MATH 221");
					}
					if (in_array("MATH 152", $takenMath)){
						array_push ($rec400, "CMSC 486");
					}
					if (in_array("MATH 221", $takenMath)){
						if (in_array("CMSC 203", $taken200)){
							array_push($rec400, "CMSC 442", "CMSC 457");
						}
						if (in_array("CMSC 341", $taken300) && in_array("STAT 355", $takenStat)){
							array_push($rec400, "CMSC 443");
						}
						if (in_array("CMSC 341", $taken300) && in_array("MATH 152", $takenMath)){
							array_push($rec400, "CMSC 453");
						}
						if (in_array("CMSC 313", $taken300) && in_array("CMSC 341", $taken300)){
							array_push($rec400, "CMSC 435");
						}
						
					}
					if (in_array("STAT 355", $takenStat) && in_array("MATH 152", $takenMath)
						&& in_array("CMSC 341", $taken300)){
							array_push($rec400, "CMSC 441");
					}
					
					/*Science Courses*/
					if (empty($takenSci)){
						array_push($recSci, "CHEM 101", "BIOL 141", "PHYS 121",
									"GES 110", "GES 286", "SCI 100");
					}
					
					if (!in_array("SCI 100", $takenSci)){
						array_push($recSci, "SCI 100");
					}
					
					/*Chemistry */
					if (!in_array("CHEM 101", $takenSci)){
						array_push($recSci, "CHEM 101");
					}
					else if (!in_array("CHEM 102", $takenSci)){
						array_push($recSci, "CHEM 102", "CHEM 102L");
					}
					else {
						array_push($recSci, "CHEM 102L");
					}
					
					/*Biology */
					if (!in_array("BIOL 141", $takenSci)){
						array_push($recSci, "BIOL 141");
					}
					else if (!in_array("BIOL 142", $takenSci)){
						array_push($recSci, "BIOL 142", "BIOL 142L");
					}
					else {
						array_push($recSci, "BIOL 142L");
					}
					
					/*Physics */
					if (!in_array("PHYS 121", $takenSci)){
						array_push($recSci, "PHYS 121");
					}
					else if (!in_array("PHYS 122", $takenSci)){
						array_push($recSci, "PHYS 122", "PHYS 122L");
					}
					else {
						array_push($recSci, "PHYS 122L");
					}
					
					/*Geography and Environmental Science */
					if (!in_array("GES 110", $classChoices)){
						array_push($recSci, "GES 110");
					}
					if (!in_array("GES 286", $classChoices)){
						array_push($recSci, "GES 286");
					}
					
					/*eliminates any redundant course choices*/
					$rec200 = array_unique($rec200);
					$rec300 = array_unique($rec300);
					$rec400 = array_unique($rec400);
					$recMath = array_unique($recMath);
					$recSci = array_unique($recSci);
					$recStat = array_unique($recStat);

					if(!empty($allTaken)){
						/*remove any possibly taken courses that ended up on their choice sheet */
						$rec200 = array_diff($rec200, $allTaken);
						$rec300 = array_diff($rec300, $allTaken);	
						$rec400 = array_diff($rec400, $allTaken);
						$recMath = array_diff($recMath, $allTaken);
						$recSci = array_diff($recSci, $allTaken);
						$recStat = array_diff($recStat, $allTaken);			
					}
					
					/*put classes in alphabetical order */
					sort($rec200);
					sort($rec300);
					sort($rec400);
					sort($recMath);
					sort($recSci);
					sort($recStat);
					
					/*display list of classes*/
					echo "<table>";
					if(!empty($rec200)){
						echo "<tr>";
						echo "<td>";
						echo "<h2 id='200'>200 Level CMSC Classes</h2>\n
							<div id='alignClasses'>
							<div id='course'>";
						foreach ($rec200 as $class1) {
							echo $class1;
							echo ("<br />");
						}
						echo "</div>";
						echo "</div>";
						echo "</td>";
						echo "</tr>";
					}
					if(!empty($rec300)){
						echo "<tr>";
						echo "<td>";
						echo "<h2 id='300'>300 Level CMSC Classes</h2>\n
							<div id='alignClasses'>
							<div id='course'>";
						foreach ($rec300 as $class1) {
							echo $class1;
							echo ("<br />");
						}
						echo "</div>";
						echo "</div>";
						echo "</td>";
						echo "</tr>";
					}
					if(!empty($rec400)){
						echo "<tr>";
						echo "<td>";
						echo "<h2 id='400'>400 Level CMSC Classes</h2>\n
							<div id='alignClasses'>
							<div id='course'>";
						foreach ($rec400 as $class1) {
							echo $class1;
							echo ("<br />");
						}
						echo "</div>";
						echo "</div>";
						echo "</td>";
						echo "</tr>";
					}
					if(!empty($recMath)){
						echo "<tr>";
						echo "<td>";
						echo "<h2 id='math'>Math Classes</h2>\n
							<div id='alignClasses'>
							<div id='course'>";
						foreach ($recMath as $class1) {
							echo $class1;
							echo ("<br />");
						}
						echo "</div>";
						echo "</div>";
						echo "</td>";
						echo "</tr>";
					}
					if(!empty($recSci)){
						echo "<tr>";
						echo "<td>";
						echo "<h2 id='sci'>Science Classes</h2>\n
							<div id='alignClasses'>
							<div id='course'>";
						foreach ($recSci as $class1) {
							echo $class1;
							echo ("<br />");
						}
						echo "</div>";
						echo "</div>";
						echo "</td>";
						echo "</tr>";
					}
					if(!empty($recStat)){
						echo "<tr>";
						echo "<td>";
						echo "<h2 id='stat'>Statistics Classes</h2>\n
							<div id='alignClasses'>
							<div id='course'>";
						foreach ($recStat as $class1) {
							echo $class1;
							echo ("<br />");
						}
						echo "</div>";
						echo "</div>";
						echo "</td>";
						echo "</tr>";
					}


				?>
			<div> <! -- end scrollbar div -->
		</div> <! -- end content div -->
	</div> <! -- end container div -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $("h2").click(function(){
        $(this).next().slideToggle("fast");
    });
});
</script>

</body>
</html>