<?php
	// Administrator Interface - Backup
	// Samuel Moffatt/Toowoomba Regional Council
	
	$buttons 	= Array();
	$buttons[] 	= Array('text'=>"XML Backup", 
		'link'=>"components/com_admin/backup.xml.php",
		'image'=>"images/backup.png",
		'js'=>"document.location.href='components/com_admin/backup.xml.php'");
	$buttons[] 	= Array('text'=>"SQL Backup", 
		'link'=>"components/com_admin/backup.sql.php",
		'image'=>"images/backup.png",
		'js'=>"document.location.href='components/com_admin/backup.sql.php'");		
	$buttons[] 	= Array('text'=>"Close", 
		'link'=>"index.php?option=com_admin",
		'image'=>"images/jdeclose.gif",
		'js'=>"document.location.href='index.php?option=com_admin'");
	myGovHTML::funkyfactory($buttons);

	myGovHTML::printTitle("Backup");
?>
<p>Backups should be completed regularly as a part of maintainence. There are two types of backups, XML or SQL. XML backups are designed for importing into different databasing systems and a future import tool and SQL backups are designed for restoring a database back to its original state.</p>
<p>To backup, select the option and save the file to your hard drive. Make sure this file is kept in a safe place!</p>