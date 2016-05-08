<?php
	require_once('authenticate.php'); 
	require_once('mysqlHelper.php');
	//get a list for all of the classes the user has taken. See bottom of this file for using this
	$cmsc200 = getSelectedClasses($_SESSION['id'],'cmsc200')->fetch_assoc();
	$cmsc300 = getSelectedClasses($_SESSION['id'],'cmsc300')->fetch_assoc();
	$cmsc400 = getSelectedClasses($_SESSION['id'],'cmsc400')->fetch_assoc();
	$math = getSelectedClasses($_SESSION['id'],'math')->fetch_assoc();
	$sci = getSelectedClasses($_SESSION['id'],'science')->fetch_assoc();
	$stat = getSelectedClasses($_SESSION['id'],'statistics')->fetch_assoc();
?>

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
		<div id="content">
			<div id="titleBar">
				<h1>UMBC CMSC Virtual Advisor</h1>
			</div>
			<!-- navigation bar -->
			<div id="navBar">
			<form action="landing.php" method="post" onsubmit="return confirm('Are you sure you want to submit?')">
				<ul>
					<li><div id="titleBar">Logged in as: <?php echo("<b>$_SESSION[id]</b>");?></div></li>
					<li style="float:right"><a href="logout.php">Log Out</a></li>
				</ul>
				<div id="lineBreak"><hr></div>
				<ul>
					<li><a href="#top">Classes</a>
							<li><a href="#200">CMSC-200</a></li>
							<li><a href="#300">CMSC-300</a></li>
							<li><a href="#400">CMSC-400</a></li>
							<li><a href="#math">Math</a></li>
							<li><a href="#sci">Science</a></li>
							<li><a href="#stat">Statistics</a></li>
					</li>
					<li style="float:right"><a href="#"><input type="submit" id="submit" value="Submit Classes"></a></li>
				</ul>
			</div> <!-- end navBar div -->

<!-- begin vertical scrollbar section -->
<div id="scrollbar">
<table>
<tr>
<td>
<div id="top"></div>

<!-- introduction section -->
<p>
Welcome to the <i>Computer Science Virtual Advisor</i>. The goal of this page is to help you find courses that you are eligible to take next semester. Fill out the form below by selecting all courses that you have already taken, including the ones you expect to pass this semester. If you cannot select a class, hover over it to find out why. Once you are done, hit <b>"Submit Classes"</b> to view the list of classes you may take next semester. The classes you select will be saved for when you return to this page and you may change your selections at any time. Be sure to hit submit to save your selections.
</p>
<a href="../cmsc433/cmsc_major_worksheet.pdf" target="_blank">Click here to view UMBC's major requirements for CMSC students.</a><br/>

<!-- begin class listings -->
<!-- cmsc 200 section -->
<h2 id="200">200 Level CMSC Classes</h2>
<div id="alignClasses">
<div id="course">
<span><input type="checkbox" id="csgw" name="taken[]" value="" onchange="gateway(this)"><label for="csgw">Passed CS Gateway</label></span>
<span><input type="checkbox" id="cs201" name="taken[]" value="CMSC 201" onchange="rd(this)"><label for="cs201">CMSC 201	Computer Science I</label></span>
<span title="Requires CMSC 201"><input type="checkbox" id="cs202" value="CMSC 202" onchange="rd(this)" name="taken[]"><label for="cs202">CMSC 202	Computer Science II</label></span>
<span title="Requires CMSC 202"><input type="checkbox" id="cs203" name="taken[]" value="CMSC 203" onchange="rd(this)"><label for="cs203">CMSC 203	Discrete Structures</label></span>
<span title="Requires CMSC 202"><input type="checkbox" id="cs232" name="taken[]" value="CMSC 232" onchange="rd(this)" checked><label for="cs232">CMSC 232	Advanced Java Techniques</label></span>
<span title="Requires CMSC 203"><input type="checkbox" id="cs291" name="taken[]" value="CMSC 291" onchange="rd(this)"><label for="cs291">CMSC 291	Special Topics in Computer Science</label></span>
<span title="Requires CMSC 203"><input type="checkbox" id="cs299" name="taken[]" value="CMSC 299" onchange="rd(this)"><label for="cs299">CMSC 299	Independent Study in Computer Science</label></span>
</div>
</div>
</td>
</tr>

<!-- cmsc 300 section -->
<tr>
<td>
<h2 id="300">300 Level CMSC Classes</h2>
<div id="alignClasses">
<div id="course">
<span title="Requires CMSC 202"><input type="checkbox" id="cs304" name="taken[]" value="CMSC 304" onchange="rd(this)"><label for="cs304">CMSC 304	Social/Ethical Issues In IT</label></span>
<span title="Requires CMSC 203"><input type="checkbox" id="cs313" name="taken[]" value="CMSC 313" onchange="rd(this)"><label for="cs313">CMSC 313	Computer Organazation & Assembly Language</label></span>
<span title="Requires CMSC 203"><input type="checkbox" id="cs331" name="taken[]" value="CMSC 331" onchange="rd(this)"><label for="cs331">CMSC 331	Principles of Programing Languages</label></span>
<span title="Requires CMSC 203"><input type="checkbox" id="cs341" name="taken[]" value="CMSC 341" onchange="rd(this)"><label for="cs341">CMSC 341	Data Structures</label></span>
<span title="Requires CMSC 341"><input type="checkbox" id="cs345" name="taken[]" value="CMSC 345" onchange="rd(this)"><label for="cs345">CMSC 345	Software Design and Development</label></span>
<span title="Requires 1 CMSC class"><input type="checkbox" id="cs352" name="taken[]" value="CMSC 352" onchange="rd(this)"><label for="cs352">CMSC 352	Women, Gender, and Information Technology</label></span>
<span title="Requires CMSC 203"><input type="checkbox" id="cs391" name="taken[]" value="CMSC 391" onchange="rd(this)"><label for="cs391">CMSC 391	Special Topics in Computer Science</label></span>
</div>
</div>
</td>
</tr>

<!-- cmsc 400 section -->
<tr>
<td>
<h2 id="400">400 Level CMSC Classes</h2>
<div id="alignClasses">
<div id="course">
<span title="Requires CMSC 313"><input type="checkbox" id="cs411" name="taken[]" value="CMSC 411" onchange="rd(this)"><label for="cs411">CMSC 411	Computer Architecture</label></span>
<span title="Requires CMSC 313 and 341"><input type="checkbox" id="cs421" name="taken[]" value="CMSC 421" onchange="rd(this)"><label for="cs421">CMSC 421	Principles Of Operating Systems</label></span>
<span title="Requires CMSC 421"><input type="checkbox" id="cs426" name="taken[]" value="CMSC 426" onchange="rd(this)"><label for="cs426">CMSC 426	Principles of Computer Security</label></span>
<span title="Requires CMSC 341"><input type="checkbox" id="cs427" name="taken[]" value="CMSC 427" onchange="rd(this)"><label for="cs427">CMSC 427	Wearable Computing</label></span>
<span title="Requires CMSC 331, CMSC 341, and CMSC 313"><input type="checkbox" id="cs431" name="taken[]" value="CMSC 431" onchange="rd(this)"><label for="cs431">CMSC 431	Compiler Design Principles</label></span>
<span title="Requires CMSC 331 and CMSC 341"><input type="checkbox" id="cs432" name="taken[]" value="CMSC 432" onchange="rd(this)"><label for="cs432">CMSC 432	Object-Oriented Programming Languages and Systems</label></span>
<span title="Requires CMSC 331"><input type="checkbox" id="cs433" name="taken[]" value="CMSC 433" onchange="rd(this)"><label for="cs433">CMSC 433	Scripting Languages</label></span>
<span title="Requires CMSC 313, CMSC 341, and MATH 221"><input type="checkbox" id="cs435" name="taken[]" value="CMSC 435" onchange="rd(this)"><label for="cs435">CMSC 435	Computer Graphics</label></span>
<span title="Requires CMSC 341 and CMSC 331"><input type="checkbox" id="cs436" name="taken[]" value="CMSC 436" onchange="rd(this)"><label for="cs436">CMSC 436	Data Visualization</label></span>
<span title="Requires CMSC 341"><input type="checkbox" id="cs437" name="taken[]" value="CMSC 437" onchange="rd(this)"><label for="cs437">CMSC 437	Graphical User Interface Programming</label></span>
<span title="Requires CMSC 341, STAT 355, and MATH 152"><input type="checkbox" id="cs441" name="taken[]" value="CMSC 441" onchange="rd(this)"><label for="cs441">CMSC 441	Design and Analysis of Algorithms</label></span>
<span title="Requires MATH 221 and CMSC 203"><input type="checkbox" id="cs442" name="taken[]" value="CMSC 442" onchange="rd(this)"><label for="cs442">CMSC 442	Information and Coding Theory</label></span>
<span title="Requires CMSC 341, STAT 355, and MATH 221"><input type="checkbox" id="cs443" name="taken[]" value="CMSC 443" onchange="rd(this)"><label for="cs443">CMSC 443	Cryptology</label></span>
<span title="Requires CMSC 421 and 481"><input type="checkbox" id="cs444" name="taken[]" value="CMSC 444" onchange="rd(this)"><label for="cs444">CMSC 444	Information Assurance</label></span>
<span title="Requires CMSC 331 and 341"><input type="checkbox" id="cs446" name="taken[]" value="CMSC 446" onchange="rd(this)"><label for="cs446">CMSC 446	Introduction to Design Patterns</label></span>
<span title="Requires Any CMSC 4xx"><input type="checkbox" id="cs447" name="taken[]" value="CMSC 447" onchange="rd(this)"><label for="cs447">CMSC 447	Software Engineering I</label></span>
<span title="Requires CMSC 447 "><input type="checkbox" id="cs448" name="taken[]" value="CMSC 448" onchange="rd(this)"><label for="cs448">CMSC 448	Software Engineering II</label></span>
<span title="Requires CMSC CMSC 202 and CMSC 203"><input type="checkbox" id="cs451" name="taken[]" value="CMSC 451" onchange="rd(this)"><label for="cs451">CMSC 451	Automata Theory and Formal Languages</label></span>
<span title="Requires CMSC 203"><input type="checkbox" id="cs452" name="taken[]" value="CMSC 452" onchange="rd(this)"><label for="cs452">CMSC 452	Logic for Computer Science</label></span>
<span title="Requires CMSC 341, MATH 221 and MATH 152"><input type="checkbox" id="cs453" name="taken[]" value="CMSC 453" onchange="rd(this)"><label for="cs453">CMSC 453	Applied Combinatorics and Graph Theory</label></span>
<span title="Requires CMSC 341"><input type="checkbox" id="cs455" name="taken[]" value="CMSC 455" onchange="rd(this)"><label for="cs455">CMSC 455	Numerical Computations</label></span>
<span title="Requires CMSC 341"><input type="checkbox" id="cs456" name="taken[]" value="CMSC 456" onchange="rd(this)"><label for="cs456">CMSC 456	Symbolic Computation</label></span>
<span title="Requires CMSC 203 and MATH 221"><input type="checkbox" id="cs457" name="taken[]" value="CMSC 457" onchange="rd(this)"><label for="cs457">CMSC 457	Quantum Computation</label></span>
<span title="Requires CMSC 341"><input type="checkbox" id="cs461" name="taken[]" value="CMSC 461" onchange="rd(this)"><label for="cs461">CMSC 461	Database Management Systems</label></span>
<span title="Requires CMSC 461 and 481"><input type="checkbox" id="cs465" name="taken[]" value="CMSC 465" onchange="rd(this)"><label for="cs465">CMSC 465	Introduction to Electronic Commerce</label></span>
<span title="Requires CMSC 461 and 481"><input type="checkbox" id="cs466" name="taken[]" value="CMSC 466" onchange="rd(this)"><label for="cs466">CMSC 466	Electronic Commerce Technology</label></span>
<span title="Requires CMSC 341"><input type="checkbox" id="cs471" name="taken[]" value="CMSC 471" onchange="rd(this)"><label for="cs471">CMSC 471	Introduction to Artificial Intelligence</label></span>
<span title="Requires CMSC 331"><input type="checkbox" id="cs473" name="taken[]" value="CMSC 473" onchange="rd(this)"><label for="cs473">CMSC 473	Introduction to Natural Language Processing</label></span>
<span title="Requires CMSC 341"><input type="checkbox" id="cs475" name="taken[]" value="CMSC 475" onchange="rd(this)"><label for="cs475">CMSC 475	Introduction to Neural Networks</label></span>
<span title="Requires CMSC 341"><input type="checkbox" id="cs476" name="taken[]" value="CMSC 476" onchange="rd(this)"><label for="cs476">CMSC 476	Information Retrieval</label></span>
<span title="Requires CMSC 471"><input type="checkbox" id="cs477" name="taken[]" value="CMSC 477" onchange="rd(this)"><label for="cs477">CMSC 477	Agent Architectures and Multi-Agent Systems</label></span>
<span title="Requires CMSC 471"><input type="checkbox" id="cs478" name="taken[]" value="CMSC 478" onchange="rd(this)"><label for="cs478">CMSC 478	Introduction to Machine Learning</label></span>
<span title="Requires CMSC 471"><input type="checkbox" id="cs479" name="taken[]" value="CMSC 479" onchange="rd(this)"><label for="cs479">CMSC 479	Introduction to Robotics</label></span>
<span title="Requires CMSC 341"><input type="checkbox" id="cs481" name="taken[]" value="CMSC 481" onchange="rd(this)"><label for="cs481">CMSC 481	Computer Networks</label></span>
<span title="Requires CMSC 421"><input type="checkbox" id="cs483" name="taken[]" value="CMSC 483" onchange="rd(this)"><label for="cs483">CMSC 483	Parallel and Distributed Processing</label></span>
<span title="Requires CMSC 202"><input type="checkbox" id="cs484" name="taken[]" value="CMSC 484" onchange="rd(this)"><label for="cs484">CMSC 484	Java Server Technologies</label></span>
<span title="Requires MATH 152"><input type="checkbox" id="cs486" name="taken[]" value="CMSC 486" onchange="rd(this)"><label for="cs486">CMSC 486	Mobile Telephony Communications</label></span>
<span title="Requires CMSC 421"><input type="checkbox" id="cs487" name="taken[]" value="CMSC 487" onchange="rd(this)"><label for="cs487">CMSC 487	Introduction To Network Security</label></span>
<span title="Requirements Depend on Section"><input type="checkbox" id="cs491" name="taken[]" value="CMSC 491" onchange="rd(this)"><label for="cs491">CMSC 491	Special Topics in Computer Science</label></span>
<span title="Requires CMSC 435 and 471"><input type="checkbox" id="cs493" name="taken[]" value="CMSC 493" onchange="rd(this)"><label for="cs493">CMSC 493	Capstone Games Group Project</label></span>
<span title="Requires Department Consent"><input type="checkbox" id="cs495" name="taken[]" value="CMSC 495" onchange="rd(this)"><label for="cs495">CMSC 495	Honors Thesis</label></span>
<span title="Requires Department Consent"><input type="checkbox" id="cs498" name="taken[]" value="CMSC 498" onchange="rd(this)"><label for="cs498">CMSC 498	Independent Study in Computer Science <br />                 CMSC Interns and Coop Students</label></span>
<span title="Requires Department Consent"><input type="checkbox" id="cs499" name="taken[]" value="CMSC 499" onchange="rd(this)"><label for="cs499">CMSC 499	Independent Study in Computer Science</label></span>
</div>
</div>
</td>
</tr>

<!-- math section -->
<tr>
<td>
<h2 id="math">Math Classes</h2>
<div id="alignClasses">
<div id="course">
<span title="Requires MATH 150 or a 5 on the LRC MATH placement exam"><input type="checkbox" id="math151" name="taken[]" value="MATH 151" onchange="rd(this)"><label for="math151">MATH 151	Calculus and Analytic Geometry I</label></span>
<span title="Requires either MATH 151, 141 or 155B"><input type="checkbox" id="math152" name="taken[]" value="MATH 152" onchange="rd(this)"><label for="math152">MATH 152	Calculus and Analytic Geometry II</label></span>
<span title="Requires either MATH 141, 151 or 380"><input type="checkbox" id="math221" name="taken[]" value="MATH 221" onchange="rd(this)"><label for="math221">MATH 221	Introduction to Linear Algebra</label></span>
</div>
</div>
</td>
</tr>

<!-- science section -->
<tr>
<td>
<h2 id="sci">Science Classes</h2>
<div id="alignClasses">
<div id="course">
<span><input type="checkbox" id="chem101" name="taken[]" value="CHEM 101" onchange="rd(this)"><label for="chem101">CHEM 101	Principles of Chemistry I</label></span>
<span title="Requires CHEM 101"><input type="checkbox" id="chem102" name="taken[]" value="CHEM 102" onchange="rd(this)"><label for="chem102">CHEM 102	Principles of Chemistry II</label></span>
<span title="Requires CHEM 101"><input type="checkbox" id="chem102l" name="taken[]" value="CHEM 102L" onchange="rd(this)"><label for="chem102l">CHEM 102L	Introductory Chemistry Lab I</label></span>
<span><input type="checkbox" id="biol141" name="taken[]" value="BIOL 141" onchange="rd(this)"><label for="biol141">BIOL 141	Foundations of Biology: Cells, Energy and Organisms</label></span>
<span title="Requires BIOL 141"><input type="checkbox" id="biol142" name="taken[]" value="BIOL 142" onchange="rd(this)"><label for="biol142">BIOL 142	Foundations of Biology: Ecology and Evolution</label></span>
<span title="Requires BIOL 141"><input type="checkbox" id="biol142l" name="taken[]" value="BIOL 142L" onchange="rd(this)"><label for="biol142l">BIOL 142L	Foundations of Biology: Ecology and Evolution Lab</label></span>
<span title="Requires concurrent enrollment in MATH 151"><input type="checkbox" id="phys121" name="taken[]" value="PHYS 121" onchange="rd(this)"><label for="phys121">PHYS 121	Introductory Physics I</label></span>
<span title="Requires PHYS 121"><input type="checkbox" id="phys122" name="taken[]" value="PHYS 122" onchange="rd(this)"><label for="phys122">PHYS 122	Introductory Physics II</label></span>
<span title="Requires PHYS 121"><input type="checkbox" id="phys122l" name="taken[]" value="PHYS 122L" onchange="rd(this)"><label for="phys122l">PHYS 122L	Introductory Physics Laboratory</label></span>
<span><input type="checkbox" id="ges110" name="taken[]" value="GES 110" onchange="rd(this)"><label for="ges110">GES 110	Physical Geography</label></span>
<span><input type="checkbox" id="ges286" name="taken[]" value="GES 286" onchange="rd(this)"><label for="ges286">GES 286	Introduction to the Environment: <br />                A Geo-Spatial Perspective</label></span>
<span><input type="checkbox" id="sci100" name="taken[]" value="SCI 100" onchange="rd(this)"><label for="sci100">SCI 100	Water; An Interdisciplinary Study </label></span>
</div>
</div>
</td>
</tr>

<!-- stat section -->
<tr>
<td>
<h2 id="stat">Statistics Classes</h1>
<div id="alignClasses">
<div id="course">
<span title=" Requires one of MATH 142, 152, 225 or 251"><input type="checkbox" id="stat355" name="taken[]" value="STAT 355" onchange="rd(this)"><label for="stat355">STAT 355	Introduction to Probability and Statistics<br/>                 for Scientists and Engineers</label></span>
</div>
</div>
</td>
</tr>
</table>
</div> <!-- close scrollbar div -->
<!-- end of class listings -->
</div> <!-- close content -->
</div>  <!-- closer container -->
	
<!-- scripts at the bottom to improve page load time -->
<!-- load the main js file that does validation -->
<script type="text/javascript" src="index_js.js"></script>
<!-- load previous user selections from the database with php and js -->
<?php
//execute javascript to check off the classes the user has already taken
//see javascript file for details on enableBox
echo('<script type="text/javascript">');
foreach ($cmsc200 as $k => $v){
	echo("enableBox('cs$k',$v);");
}
foreach ($cmsc300 as $k => $v){
	echo("enableBox('cs$k',$v);");
}
foreach ($cmsc400 as $k => $v){
	echo("enableBox('cs$k',$v);");
}
foreach ($math as $k => $v){
	echo("enableBox('math$k',$v);");
}
foreach ($sci as $k => $v){
	echo("enableBox('$k',$v);");
}
foreach ($stat as $k => $v){
	echo("enableBox('stat$k',$v);");
}
echo("</script>");
?>
<!-- script to highlight the selected section in the navigation bar -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script>
// This is the only usage of jquery
$(document).ready(function(){
// When we click on an 'a' inside an 'li'
	$("li > a").click(function(){
	  // If this isn't already active
	  if (!$(this).hasClass("active")) {
		// Remove the class from anything that is active
		$("a.active").removeClass("active");
		// And make this active
		$(this).addClass("active");
	  }
	});
});

$(document).ready(function(){
    $("h2").click(function(){
        $(this).next().slideToggle("fast");
    });
});
</script>

</body>
</html>
