/* disable everything to start with */
function reset(){
	var arr = document.getElementsByTagName("input");
	for	(var i = 0; i < arr.length; i++) {
		// if(arr[i].startsWith('cs'){
		arr[i].checked = false;
		arr[i].disabled = true;
		//}
	}
	document.getElementById("submit").disabled = false;
	document.getElementById("csgw").disabled = false;
	document.getElementById("cs201").disabled = false;
	document.getElementById("chem101").disabled = false;
	document.getElementById("biol141").disabled = false;
	document.getElementById("phys121").disabled = false;
	document.getElementById("ges110").disabled = false;
	document.getElementById("ges286").disabled = false;
	document.getElementById("sci100").disabled = false;
	document.getElementById("math151").disabled = false;
}
reset();
var num400taken = 0;
/**
 * Validatation for checkbox dependencies
 */
function gateway(e){
	var arr = ["cs201", "cs202", "cs203"];
	if(e.checked){
		for	(var i = 0; i < arr.length; i++) {
			document.getElementById(arr[i]).checked = true;
			rd1(arr[i], true);
		}
	} else{
		for	(var i = arr.length - 1; i >= 0; i--) {
			document.getElementById(arr[i]).checked = false;
			rd1(arr[i], false);
		}
	}
}

/**
 * enableBox takes the id of the checkbox and the val to set it to
 * if val is 1/true, it will check the box. Otherwise it will leave it as is 
 */
function enableBox(id, val){
	if(val == 1 ) {
		var box = document.getElementById(id);
		if(box != null) {
			box.checked = true;
			rd(box);
		}
	}
}

/* 
 * Wrapper function to resolve dependencies
 * Every single checkbox is hooked up to call this function in 'onchange'
 * Grab the values from the e (the checkbox) and pass them to rd1 
 */
function rd(e){
	rd1(e.id, e.checked);
	// 447 needs at least 1 400 level, so keep a count of 400 levels taken to see if it should be enabled.
	// use a regex to check if the id starts with "cs4"
	if(new RegExp('^cs4').test(e.id)){
		num400taken = (e.checked) ? num400taken+1 : num400taken-1;
		if(num400taken == 0){
			resolve(false, ["cs447"]);
		} else{
			document.getElementById("cs447").disabled = false;
		}
	}
}
/* Resolve the dependencies for classes when they are checked */
function rd1(id, checked){
	switch(id) {
		case "cs201":
			resolve(checked, ["cs202", "cs352"]);
			break;
		case "cs202":
			resolve(checked, ["cs203", "cs232", "cs304", "cs484"]);
			break;
		case "cs203":
			// TODO UNSURE OF REQS OF 291 299 391
			// making cs491 have cs gateway as requirement
			resolve(checked, ["cs291", "cs299", "cs391", "cs313", "cs331", "cs341", "cs452", "cs457", "cs491"]);
			// 442 also needs math221
			multiDependency(checked, "cs442", ["math221"]);
			
			//451 needs 203 and 202
			multiDependency(checked, "cs451", ["cs202"]);
			break;
		case "cs313":
			resolve(checked, ["cs411"]);
			// 421 also needs 341
			multiDependency(checked, "cs421", ["cs341"]);
			
			//435 needs 341 and math 221
			multiDependency(checked, "cs435", ["cs341", "math221"]);
			
			//431 needs 313, 341, 331
			multiDependency(checked, "cs431", ["cs341", "cs331"]);
			
			break;
		case "cs331":
			resolve(checked, ["cs433", "cs473"]);
			
			// 431, 432, 446 also need 341
			multiDependency(checked, "cs431", ["cs341", "cs313"]);
			multiDependency(checked, "cs446", ["cs341"]);
			multiDependency(checked, "cs432", ["cs341"]);
			multiDependency(checked, "cs436", ["cs341"]);
			break;
		case "cs341":
			resolve(checked, ["cs345", "cs427", "cs436", "cs437", "cs455", "cs456", "cs475", "cs476", "cs461", "cs481", "cs471" ]);
			// 421,435 also need 313
			multiDependency(checked, "cs421", ["cs313"]);
			multiDependency(checked, "cs435", ["cs313", "math221"]);
			
			// 431,446 also needs 331
			multiDependency(checked, "cs431", ["cs331", "cs313"]);
			multiDependency(checked, "cs446", ["cs331"]);
			multiDependency(checked, "cs453", ["math221", "math152"]);
			
			//443 requires 341, stat355, and math221
			multiDependency(checked, "cs443", ["stat355", "math221"])
			
			//441 requires 341, stat 355, and math 221
			multiDependency(checked, "cs441", ["stat355", "math152"]);
			
			//436 also needs 331
			multiDependency(checked, "cs436", ["cs331"]);
			multiDependency(checked, "cs432", ["cs331"]);
			break;
		case "cs421":
			resolve(checked, ["cs426", "cs483"]);
			// 444,487 also need 481
			multiDependency(checked, "cs444", ["cs481"]);
			multiDependency(checked, "cs487", ["cs481"]);
			break;
		case "cs435":
			// 493 also needs 471
			multiDependency(checked, "cs493", ["cs471"]);
			break;
		case "cs447":
			resolve(checked, ["cs448"]);
			break;
		case "cs461":
			multiDependency(checked, "cs465", ["cs481"]);
			multiDependency(checked, "cs466", ["cs481"]);
			break;
		case "cs481":
			multiDependency(checked, "cs444", ["cs421"]);
			multiDependency(checked, "cs465", ["cs461"]);
			multiDependency(checked, "cs466", ["cs461"]);
			multiDependency(checked, "cs487", ["cs421"]);
			break;
		case "cs471":
			resolve(checked, ["cs477", "cs478", "cs479", "cs493"]);
			// 493 also needs 435
			multiDependency(checked, "cs493", ["cs435"]);
			break;
		case "math151":
			resolve(checked, ["math152", "math221"]);
			break;
		case "math152":
			resolve(checked, ["stat355", "cs486"]);
			break;
		case "math221":
			// Requires either MATH 141, 151 or 380
			// 442 also needs cs203
			multiDependency(checked, "cs442", ["cs203"]);
			multiDependency(checked, "cs435", ["cs341", "cs313"]);
			break;
		case "chem101":
			resolve(checked, ["chem102", "chem102l"]);
			break;
		case "biol141":
			resolve(checked, ["biol142", "biol142l"]);
			break;
		case "phys121":
			resolve(checked, ["phys122", "phys122l"]);
			break;
		default:
			break;
		}
}

/* resolve a dependency when there are multiple requirements */
function multiDependency(checked, target_class, depends_on){
	if(!checked){
		// if the parent class got uncheked, send the unchecking and disaling down the tree
		resolve(checked, [target_class]);
	} else{
		var dependencesMet = true;
		for	(var i = 0; i < depends_on.length; i++) {
			if(!document.getElementById(depends_on[i]).checked){
				dependencesMet = false;
				break;
			}
		}
		if(dependencesMet){
			// if all parents are checked, enable the child
			resolve(checked, [target_class]);
		} // else dont enable until all dependencies are met
	}			
}
/*
 * Takes a boolean and an array of class ids.
 * If true, it enables and unchecks the classes.
 * If false, it disables and unchecks the classes,
 * and follows the dependences of those classes down and
 * disables and unchecks those as well 
 */
function resolve(checked, arr){
	for	(var i = 0; i < arr.length; i++) {
		// enable/disable the dependency
		document.getElementById(arr[i]).disabled = !checked;
		// if it was checked and a 400, it will be unchecked, so subtract 1 from count
		if(document.getElementById(arr[i]).checked && new RegExp('^cs4').test(arr[i])){
			num400taken = num400taken-1;
		}
		// uncheck the dependency
		document.getElementById(arr[i]).checked = false;
		if(!checked){
			// also disable and uncheck dependencies
			rd1(arr[i], checked);
		}
	}
}
