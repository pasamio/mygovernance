<?php
	// Administrator Interface
	// Samuel Moffatt/Toowoomba Regional Council
	$uid = myGovAuth::getUid();
	$admin = myGovAuth::isAdmin();
	// Handles user management and the like
	if($admin) {
	$task = "";
	if(isset($_REQUEST['task'])) { $task = $_REQUEST['task']; }
	$database = JFactory::getDBO();
	switch($task) {
		case "adduser":
			require_once("admin.edituser.php");
			break;
		case "edituser":
			require_once("admin.edituser.php");
			break;
		case "deluser":
			if(isset($_REQUEST['uid'])) {
				$query = "DELETE FROM #__users WHERE id = {$_REQUEST['uid']}";
				$database->setQuery($query);
				$database->Query();
				echo "<p>User Removed</p>";
			}
			require_once("admin.listusers.php");			
			break;
		case "update":
			require_once("admin.update.php");
			require_once("admin.listusers.php");
			break;
		case "listusers":
			require_once("admin.listusers.php");
			break;		
		case "backupdatabase":
			require_once("admin.backup.php");
			break;
		default:
			require_once("admin.default.php");
			break;
	}
	
	} else {
		echo "You are not authorized to enter this section.";
	}
?>


