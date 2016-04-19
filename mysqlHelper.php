<?php


/**
*	executes a query to the database
*
*	@param string $q the query to execute
*	@return object results
*/
function query($q) {

	$servername = "localhost";
	$username = "root";
	$password = "";
	$database = "cmsc433";

	$conn = new mysqli($servername, $username, $password, $database);

	// Check connection
	if ($conn->connect_error) {
    		die("Connection failed: " . $conn->connect_error);
	}

	$res = $conn->query($q);

	$conn->close();

	return $res;
}
/**
*	updates a user in the database. If they do not exist, add one
*
*	@param string $name Full name of the user
*	@param string $umbcID 7 character umbc id
*	@param string $email UMBC email address
*	@return object result
*/
function updateUser($name, $umbcID, $email) {

	$checkRow = "SELECT `id` FROM `users` WHERE `umbc_id` = '$umbcID' LIMIT 1";
	$res = query($checkRow);
	//user already exists
	if($res->num_rows > 0) {
		$id = $res->fetch_assoc()["id"];
		$updateUser = "UPDATE `users` SET `name`='$name', `email`='$email' WHERE `id`=$id";
		return query($updateUser);
	}
	//user does not exist
	else {
		$createUser = "INSERT INTO `users` (`name`,`umbc_id`,`email`) VALUES ('$name','$umbcID','$email')";
		$res = query($createUser);
		return $res;
	}
}
/**
*	Returns the rowID of the user (primary key from the user database) given their UMBC id
*
*	@param string $umbcID Student's umbc id
*	@return integer rowid
*/
function getUserID($umbcID) {
	$checkRow = "SELECT `id` FROM `users` WHERE `umbc_id` = '$umbcID' LIMIT 1";
	$res = query($checkRow);
	if($res->num_rows > 0) {
		return $res->fetch_assoc()["id"];
	}
	return -1;
}
//
// returns classes from the database given the table name
//
// @param string $classType must be a table:
//	cmsc200
//	cmsc300
//	cmsc400
//	math
//	science
//	statistics
// @param string $umbcID student's umbc id
// @return result
//
function getSelectedClasses($umbcID,$classType) {
	$id = getUserID($umbcID);
	if($id != -1) {
		$getClasses = "SELECT * FROM `$classType` WHERE `is_recommendation` = 0 AND `user_id` = $id LIMIT 1";
		return query($getClasses);
	}
	return null;
}
/**
*	Updates the user's cs classes in the database
*
*	@param string $umbcID student's umbc id
*	@param array $taken array of classes student has signed up for
*	@param string $tableName cmsc table name to insert data into
*/
function updateCS($umbcID,$taken,$tableName) {

	$id=getUserID($umbcID);
	//get column names
	$q = "DESCRIBE $tableName";
	$res = query($q);
	$i = 0;
	//clear out user's previous data before adding them
	$clearClasses = "DELETE FROM `$tableName` WHERE `user_id` = '$id'";

	query($clearClasses);
	//begin constructing our query
	$addRow = "INSERT INTO `$tableName` (`user_id`, `is_recommendation`, ";

	$classes = array();

	while($row =  $res->fetch_assoc()) {
		$i++;
		//skip id, user_id, and is_recommendation
		if($i>3) {
			$classes[]=$row["Field"];
		}

	}
	//add each class as a column to insert into
	for($i=0; $i<count($classes); $i++) {
		$addRow.= "`$classes[$i]`";
		if($i!=count($classes)-1) {
			$addRow.=", ";
		}
		else {
			$addRow.=")";
		}
	}
	//get the boolean values of each class (0,1) to insert into database
	$addRow.=" VALUES($id, 0, ";
	for($i=0; $i<count($classes); $i++) {
		//form submits with CMSC at beginning, so we check if 'CMSC x' where x is the class number from the database
        	$addRow.= in_array("CMSC ".$classes[$i],$taken) ? 1 : 0;
        	if($i!=count($classes)-1) {
        		$addRow.=", ";
                }
                else {
                        $addRow.=")";
                }
        }
	return query($addRow);

}
/**
*       Updates the user's math classes in the database
*
*       @param string $umbcID student's umbc id
*       @param array $taken array of classes student has signed up for
*       @param string $tableName math table name to insert data into
*/

function updateMath($umbcID,$taken,$tableName) {

        $id=getUserID($umbcID);
	//get columns
        $q = "DESCRIBE $tableName";
        $res = query($q);
        $i = 0;
	//clear old data
        $clearClasses = "DELETE FROM `$tableName` WHERE `user_id` = '$id'";

        query($clearClasses);
	//begin our incomplete query
        $addRow = "INSERT INTO `$tableName` (`user_id`, `is_recommendation`, ";

        $classes = array();

        while($row =  $res->fetch_assoc()) {
                $i++;
                //skip id, user_id, and is_recommendation
                if($i>3) {
                        $classes[]=$row["Field"];
                }

        }
	//use our column names for inserting into db
        for($i=0; $i<count($classes); $i++) {
                $addRow.= "`$classes[$i]`";
                if($i!=count($classes)-1) {
                        $addRow.=", ";
                }
                else {
                        $addRow.=")";
                }
        }
	//construct our values
        $addRow.=" VALUES($id, 0, ";
        for($i=0; $i<count($classes); $i++) {
                $addRow.= in_array("MATH ".$classes[$i],$taken) ? 1 : 0;
                if($i!=count($classes)-1) {
                        $addRow.=", ";
                }
                else {
                        $addRow.=")";
                }
        }
        return query($addRow);

}
/**
*       Updates the user's sci classes in the database
*
*       @param string $umbcID student's umbc id
*       @param array $taken array of classes student has signed up for
*       @param string $tableName sci table name to insert data into
*/

function updateSci($umbcID,$takenc,$tableName) {

	$taken = array();
	//because classes are passed as "CHEM 101" but saved as "chem101" we reduce to lowercase w/o spaces
	foreach($takenc as $c){
		$taken[] = strtolower(str_replace(' ','',$c));
	}
        $id=getUserID($umbcID);
	//get column names
        $q = "DESCRIBE $tableName";
        $res = query($q);
        $i = 0;

        $clearClasses = "DELETE FROM `$tableName` WHERE `user_id` = '$id'";

        query($clearClasses);
	//begin insert
        $addRow = "INSERT INTO `$tableName` (`user_id`, `is_recommendation`, ";

        $classes = array();

        while($row =  $res->fetch_assoc()) {
                $i++;
                //skip id, user_id, and is_recommendation
                if($i>3) {
                        $classes[]=$row["Field"];
                }

        }
	//add columns to insert
        for($i=0; $i<count($classes); $i++) {
                $addRow.= "`$classes[$i]`";
                if($i!=count($classes)-1) {
                        $addRow.=", ";
                }
                else {
                        $addRow.=")";
                }
        }
	//add values 0 or 1
        $addRow.=" VALUES($id, 0, ";
        for($i=0; $i<count($classes); $i++) {
                $addRow.= in_array($classes[$i],$taken) ? 1 : 0;
                if($i!=count($classes)-1) {
                        $addRow.=", ";
                }
                else {
                        $addRow.=")";
                }
        }
	//return $addRow;
        return query($addRow);
}
/**
*       Updates the user's stat classes in the database
*
*       @param string $umbcID student's umbc id
*       @param array $taken array of classes student has signed up for
*       @param string $tableName stat table name to insert data into
*/

function updateStat($umbcID,$taken,$tableName) {

        $id=getUserID($umbcID);

        $q = "DESCRIBE $tableName";
        $res = query($q);
        $i = 0;
	//clear old data
        $clearClasses = "DELETE FROM `$tableName` WHERE `user_id` = '$id'";

        query($clearClasses);
	//start insert
        $addRow = "INSERT INTO `$tableName` (`user_id`, `is_recommendation`, ";

        $classes = array();

        while($row =  $res->fetch_assoc()) {
                $i++;
                //skip id, user_id, and is_recommendation
                if($i>3) {
                        $classes[]=$row["Field"];
                }

        }
	//columns to insert
        for($i=0; $i<count($classes); $i++) {
                $addRow.= "`$classes[$i]`";
                if($i!=count($classes)-1) {
                        $addRow.=", ";
                }
                else {
                        $addRow.=")";
                }
        }
	//values to insert
        $addRow.=" VALUES($id, 0, ";
        for($i=0; $i<count($classes); $i++) {
                $addRow.= in_array("STAT ".$classes[$i],$taken) ? 1 : 0;
                if($i!=count($classes)-1) {
                        $addRow.=", ";
                }
                else {
                        $addRow.=")";
                }
        }
        return query($addRow);

}

?>
