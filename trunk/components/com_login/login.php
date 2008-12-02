<?php
	// Authentication System - Frontend interface
	// Sam Moffatt/Toowoomba Regional Council
	
// TODO: Use Joomla! Auth System
// Authorization checks - second pass (myGovAuth::doAuth)
/*if (isset ($_SESSION['username'])) {
	// username in session variable
	if (!isset ($_SESSION['password'])) {
		$_SESSION['password'] = "";
	}
	if ($_SESSION['username'] != "") {
		myGovAuth :: doAuth($_SESSION['username'], $_SESSION['password']);
	} else {
		$_SESSION['attempt'] = 1;
		myGovAuth :: doAuth($_POST['username'], $_POST['password']);
	}
} else {
	// no username in session variable
	if (isset ($_POST['username'])) {
		// username in post variable
		if (!isset ($_POST['password'])) {
			$_POST['password'] = "";
		}
		$_SESSION['attempt'] = 1;
		myGovAuth :: doAuth($_POST['username'], $_POST['password']);
	}
}*/
if(JRequest::getVar('username')) {
	if($mainframe->login() == 1) { $mainframe->redirect('index.php'); }
}

?>
<h1>Welcome to myGovernance</h1><hr>
<p>You are currently not logged in. Please login:</p>
<form method="post" action="index.php" name="login" id="login">
<?php	
if(isset($_SESSION['attempt']) && ($_SESSION['attempt'] >= 1)) { echo "<p style='color: red;'>Username, password or access level is incorrect</p>"; } ?>
<table>
	<tr>
		<td>Username:</td><td><input type="text" name="username"></td>
	</tr>
	<tr>
		<td>Password:</td><td><input type="password" name="passwd"></td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" value="Login"></td>
	</tr>
</table>
</form>