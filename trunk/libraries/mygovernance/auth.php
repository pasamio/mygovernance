<?php

// Authentication System
// Sam Moffatt/Toowoomba Regional Council
class myGovAuth {

	// Set up authentication system
	function beginAuth($username, $password) {
		//		echo "<p>Running authorization checks...";
		global $mainframe;
		
		$results = $mainframe->triggerEvent("onLoginUser", Array (
			'username' => $username,
			'password' => $password
		));
		foreach ($results as $result) {
			if ($result == 1 || $result->id = 1) {
				//				echo "Success!";
				return true;
			}
			if ($result != 0) {
				//				return true;
			}
		}
		//		echo "Failure!";
		return false;
	}

	// CLose up authentication system
	function endAuth() {

	}

	// Complete an authorization
	function doAuth($username, $password = "") {
		global $auth;
		if (myGovAuth::beginAuth($username, $password)) {
			if (myGovAuth::isValidUser($username)) {
				//				echo "<p>". $database->loadObject() . "</p>";
				$_SESSION['username'] = $username;
				//				$_SESSION['password'] = $password;
				$_SESSION['loggedin'] = 1;
				$auth = true;
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	function getUserType($username) {
		global $database;
		$query = "SELECT usertype FROM #__users WHERE username = '$username'";
		$database->setQuery($query);
		$result = $database->loadObject();
		if($result) return $database->loadObject();
		else {
			$obj = new stdClass();
			$obj->usertype = 'Unknown';
			return $obj;
		}
	}

	function isAdmin($username=false) {
		global $database;
		if(!$username) { $user = JFactory::getUser(); $username = $user->username; }
		$type = myGovAuth::getUserType($username);
		if ($type->usertype == "Administrator") {
			return true;
		} else {
			return false;
		}
	}

	function isValidUser($username) {
		global $database;
		$query = "SELECT usertype FROM #__users WHERE username = '$username'";
		$database->setQuery($query);
		$database->Query();
		if ($database->getNumRows()) {
			return true;
		} else {
			return false;
		}
	}

	function userExists($uid = 0) {
		global $database;
		$query = "SELECT * FROM #__users WHERE id = $uid LIMIT 0,1";
		$database->setQuery($query);
		$database->Query();
		return $database->getNumRows();
	}

	function getName($username=false) {
		$database = JFactory::getDBO();
		$database = JFactory::getDBO();
		if(!$username) { $user = JFactory::getUser(); $username = $user->username; }
		$database->setQuery("SELECT name FROM #__users WHERE username = '$username'");
		$result = $database->loadObject();
		if($result) 	return $result->name;
		return '';
	}

	function getUID($username=false) {
		$database = JFactory::getDBO();
		if(!$username) { $user = JFactory::getUser(); $username = $user->username; }
		$database->setQuery("SELECT id FROM #__users WHERE username = '$username'");
		$result = $database->loadObject();
		if($result) return $result->id;
		else return 0;
	}
}
?>