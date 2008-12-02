<?php
	// Administrator Interface - Default Page
	// Samuel Moffatt/Toowoomba Regional Council
	
	// Loads up a page listing available options
	
	$buttons 	= Array();
	$buttons[] 	= Array('text'=>"User Administration", 
		'link'=>"index.php?option=com_admin&task=listusers",
		'image'=>"images/addusers.png",
		'js'=>"document.location.href='index.php?option=com_admin&task=listusers'");
	$buttons[] 	= Array('text'=>"Backup Database", 
		'link'=>"index.php?option=com_admin&task=backupdatabase",
		'image'=>"images/backup.png",
		'js'=>"document.location.href='index.php?option=com_admin&task=backupdatabase'");
	$buttons[] 	= Array('text'=>"Empty Database", 
//		'link'=>"index.php?option=com_admin&task=emptydatabase",
		'link'=>"javascript:alert('This feature is not implemented');",
		'image'=>"images/delete_f2.png",
		'js'=>"alert('This feature is not implemented');");
	$buttons[] 	= Array('text'=>"Repair Database", 
		'link'=>"index.php?option=com_admin&task=repairDatabase",
		'image'=>"images/extensions_f2.png",
		'js'=>"document.location.href='index.php?option=com_admin&task=repairDatabase'");
	myGovHTML::funkyfactory($buttons);

	switch($task) {
		case "repairDatabase":
			myGovDB::repairDatabase();
			break;
	}
	
?>
