<?php
	// Administrator Interface - Update User Details
	// Samuel Moffatt/Toowoomba Regional Council
	$database = JFactory::getDBO();
	$uid = 0;
	if(isset($_REQUEST['uid'])) { $uid = $_REQUEST['uid']; }
	if($_REQUEST['usertype'] == 'Administrator') $gid = 2; else $gid = 1;
	if(myGovAuth::userExists($uid)) {
		$query = "UPDATE #__users SET name = '{$_REQUEST['name']}', username = '{$_REQUEST['username']}', usertype = '{$_REQUEST['usertype']}', gid = $gid WHERE id = $uid";
		$database->setQuery($query);
		$database->Query();
		$msg =  "<p>User updated!</p>";
	} else {
		$query = "INSERT INTO #__users (`name`,`username`,`usertype`,`gid`) VALUES ('{$_REQUEST['name']}','{$_REQUEST['username']}','{$_REQUEST['usertype']}',$gid)";
		$database->setQuery($query);
//		echo ($database->getQuery());
		$database->Query();
		$msg = "<p>New user created!</p>";
	}
	
	echo $msg;
?>