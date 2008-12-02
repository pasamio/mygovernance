<?php
	// Administrator Interface - Backup - XML File
	// Samuel Moffatt/Toowoomba Regional Council
/*	require('config.php');			// Configuration File
	require('auth.inc.php');			// Authorization subsystem
	require('functions.php');			// Common Functions
	require('databasefns.php');			// Common Database Functions
	require('compat/compatlib.php');	// Compatibility Layer (Mambo)
	require('library/error.php');		// Error reporting subsystem*/
/** TODO: Integrate this */
	die('This has not been transferred');
	// Database Layer
	// Mambo Database Compat Layer
	$database = new database_replacement($dbhost,$dbuser,$dbpass,$dbname);	
	
	header("Content-Type: text/xml");
	
	ob_start();
	echo "<?xml version=\"1.0\"?>\n";
	echo "<mygovernance>\n";
	// Users
	$query = "SELECT * FROM #__users";
	$database->setQuery($query);
	$results = $database->loadAssocList();
	echo "\t<users>\n";
	foreach($results as $result) { 
		echo "\t\t<user>";
		echo "\t\t\t<userid>{$result['id']}</userid>\n";
		echo "\t\t\t<username>{$result['username']}</username>\n";
		echo "\t\t\t<name>{$result['name']}</name>\n";
		echo "\t\t\t<usertype>{$result['usertype']}</usertype>\n";
		echo "\t\t</user>\n";
	}
	echo "\t</users>";
	
	// Questions
	$query = "SELECT * FROM pquestions";
	$database->setQuery($query);
	$results = $database->loadAssocList();
	echo "\t<questions>\n";
	foreach($results as $result) { 
		echo "\t\t<question>\n";
		echo "\t\t\t<qid>{$result['qid']}</qid>\n";
		echo "\t\t\t<qtype>{$result['qtype']}</qtype>\n";
		echo "\t\t\t<qtext>{$result['qtext']}</qtext>\n";
		echo "\t\t\t<qv0>{$result['qv0']}</qv0>\n";
		echo "\t\t\t<qv1>{$result['qv1']}</qv1>\n";
		echo "\t\t\t<qv2>{$result['qv2']}</qv2>\n";
		echo "\t\t\t<qv3>{$result['qv3']}</qv3>\n";
		echo "\t\t\t<qv4>{$result['qv4']}</qv4>\n";
		echo "\t\t\t<qwt>{$result['qwt']}</qwt>\n";										
		echo "\t\t</question>\n";
	}
	echo "\t</questions>\n";
	
	// Projects
	$query = "SELECT * FROM projects";
	$database->setQuery($query);
	$results = $database->loadAssocList();
	echo "\t<projects>\n";
	foreach($results as $result) { 
		echo "\t\t<project>\n";
		echo "\t\t\t<pid>{$result['pid']}</pid>\n";
		echo "\t\t\t<proj_name>". htmlspecialchars($result['proj_name']) ."</proj_name>\n";
		echo "\t\t\t<proj_desc>". htmlspecialchars($result['proj_desc']) ."</proj_desc>\n";
		echo "\t\t\t<proj_type>{$result['proj_type']}</proj_type>\n";
		echo "\t\t</project>\n";
	}
	echo "\t</projects>";	
	
	
	// Answers
	$query = "SELECT * FROM panswers";
	$database->setQuery($query);
	$results = $database->loadAssocList();
	echo "\t<answers>\n";
	foreach($results as $result) { 
		echo "\t\t<answer>\n";
		echo "\t\t\t<pid>{$result['pid']}</pid>\n";
		echo "\t\t\t<qid>{$result['qid']}</qid>\n";
		echo "\t\t\t<score>{$result['score']}</score>\n";
		echo "\t\t</answer>\n";
	}
	echo "\t</answers>";		
	echo "</mygovernance>";
	
	$out = ob_get_clean();
	// Run it through any filters
	$out = str_replace("& ", "&amp; ", $out);
	echo $out;
	
	$database->close();
?>