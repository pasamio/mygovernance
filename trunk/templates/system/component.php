<?
/**
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<jdoc:include type="head" />
	<link rel="stylesheet" href="templates/_system/css/template.css" type="text/css" />
	<link rel="stylesheet" href="templates/<?php echo $mainframe->getTemplate(); ?>/css/template.css" type="text/css" />
	<link href="css/main.css" rel="stylesheet" type="text/css" />
	<script language="JavaScript" src="js/functions.js" type="text/javascript"></script>
</head>
<body style="margin: 0px" class="contentpane">
	<table width="100%">
		<tr><td colspan="2"><table border="0" width="100%" cellpadding="0" cellspacing="0">
			<tr><td><div style="background: #FFFF88">myGovernance <?php
			if(myGovAuth::getUID()) { ?>Options: <a href="index.php">Home</a> - <a href="index.php?option=com_user">Change Details</a> - <a href="index.php?option=com_logout">Logout</a><?php } ?></div></td></tr>
			<tr><td><div style="background: #33FF88">Welcome <?php echo myGovAuth::getName(); if(myGovAuth::isAdmin()) { ?>, <a href="index.php?option=com_admin">jump to administration home page</a><?php } ?></div></td></tr>
		</table></td></tr>
	</table>
	<jdoc:include type="message" />
	<jdoc:include type="component" />
	<hr>
	<p>&nbsp; &copy; Toowoomba Regional Council, 2005-2007. <a href="index.php?option=com_about">About myGovernance</a></p>
</body>
</html>