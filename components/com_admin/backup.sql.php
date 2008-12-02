<?php
	// Administrator Interface - Backup - SQL File
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
	
	header("Content-Type: text/plain");	
	
	ob_start();
	echo "-- myGovernance SQL Backup\n";
	echo "-- Table Structure from phpMyAdmin\n";
	echo "-- --------------------------------------------------------

-- 
-- Table structure for table `mambots`
-- 

CREATE TABLE `mambots` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `element` varchar(100) NOT NULL default '',
  `folder` varchar(100) NOT NULL default '',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `published` tinyint(3) NOT NULL default '0',
  `iscore` tinyint(3) NOT NULL default '0',
  `client_id` tinyint(3) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_folder` (`published`,`client_id`,`access`,`folder`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `username` varchar(25) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `password` varchar(100) NOT NULL default '',
  `usertype` varchar(25) NOT NULL default '',
  `block` tinyint(4) NOT NULL default '0',
  `sendEmail` tinyint(4) default '0',
  `gid` tinyint(3) unsigned NOT NULL default '1',
  `registerDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `activation` varchar(100) NOT NULL default '',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `usertype` (`usertype`),
  KEY `idx_name` (`name`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `panswers`
-- 

CREATE TABLE `panswers` (
  `pid` int(11) NOT NULL default '0',
  `qid` int(11) NOT NULL default '0',
  `score` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pid`,`qid`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `pquestions`
-- 

CREATE TABLE `pquestions` (
  `qid` int(6) unsigned NOT NULL auto_increment,
  `qtype` enum('Risk','Strategic Alignment','Direct Value Return','Business Process Impact','Architecture','Technical Risk','Compliance') NOT NULL default 'Risk',
  `qtext` varchar(255) NOT NULL default '',
  `qv0` varchar(128) NOT NULL default '',
  `qv1` varchar(128) NOT NULL default '',
  `qv2` varchar(128) NOT NULL default '',
  `qv3` varchar(128) NOT NULL default '',
  `qv4` varchar(128) NOT NULL default '',
  `qwt` tinyint(2) NOT NULL default '10',
  PRIMARY KEY  (`qid`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `projects`
-- 

CREATE TABLE `projects` (
  `pid` int(8) unsigned NOT NULL auto_increment,
  `proj_name` varchar(255) NOT NULL default '',
  `proj_desc` longtext NOT NULL,
  `proj_type` enum('Infrastructure','Corporate','Business') NOT NULL default 'Infrastructure',
  `proj_status` enum('Inception','Assessment','Design','Development','Testing','Deployment','PIR','Product','Postponed') NOT NULL default 'Inception',
  `proj_benefits` mediumtext NOT NULL,
  `proj_benefits_compliance` text,
  `proj_benefits_riskmitig` text,
  `proj_nousers` int(11) NOT NULL default '0',
  `proj_capital_y1` decimal(8,0) NOT NULL default '0',
  `proj_other_y1` decimal(8,0) NOT NULL default '0',
  `proj_savings_y1` decimal(8,0) NOT NULL default '0',
  `proj_funding_y1` varchar(255) NOT NULL default 'Recurrent',
  `proj_capital_y2` decimal(8,0) NOT NULL default '0',
  `proj_other_y2` decimal(8,0) NOT NULL default '0',
  `proj_savings_y2` decimal(8,0) NOT NULL default '0',
  `proj_funding_y2` varchar(255) NOT NULL default 'Recurrent',
  `proj_capital_y3` decimal(8,0) NOT NULL default '0',
  `proj_other_y3` decimal(8,0) NOT NULL default '0',
  `proj_savings_y3` decimal(8,0) NOT NULL default '0',
  `proj_funding_y3` varchar(255) NOT NULL default 'Recurrent',
  `proj_capital_y4` decimal(8,0) NOT NULL default '0',
  `proj_other_y4` decimal(8,0) NOT NULL default '0',
  `proj_savings_y4` decimal(8,0) NOT NULL default '0',
  `proj_funding_y4` varchar(255) NOT NULL default 'Recurrent',
  `proj_timetable` mediumtext NOT NULL,
  `proj_owner` varchar(30) NOT NULL default '',
  `proj_board` varchar(60) NOT NULL default '',
  `proj_commenced` date default NULL,
  `proj_completed` date default NULL,
  `proj_createdate` datetime NOT NULL default '0000-00-00 00:00:00',
  `proj_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `proj_benefit_recs` char(1) binary NOT NULL default '',
  `proj_risks_exist` char(1) binary NOT NULL default '',
  `proj_outcome_type` enum('Compliance','Strategic','Core','Speculative','Support') NOT NULL default 'Compliance',
  `proj_hide` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pid`),
  KEY `proj_createdate` (`proj_createdate`)
) TYPE=MyISAM PACK_KEYS=0 COMMENT='Main project table';

-- --------------------------------------------------------

-- 
-- Table structure for table `pyear`
-- 

CREATE TABLE `pyear` (
  `yearid` int(11) NOT NULL auto_increment,
  `proj_capital` decimal(8,0) NOT NULL default '0',
  `proj_other` decimal(8,0) NOT NULL default '0',
  `proj_saving` decimal(8,0) NOT NULL default '0',
  `proj_funding` varchar(255) NOT NULL default 'Recurrent',
  PRIMARY KEY  (`yearid`)
) TYPE=MyISAM COMMENT='Year information table (for projects)';

-- --------------------------------------------------------
-- --------------------------------------------------------\n\n";
	// Users
	$query = "SELECT * FROM #__users";
	$database->setQuery($query);
	$results = $database->loadAssocList();
	echo "-- Users\n";
	foreach($results as $result) { 
		echo "INSERT INTO `users` (id,username,name,usertype) VALUES ";
		echo "('{$result['id']}', '{$result['username']}', '{$result['name']}', '{$result['usertype']}');\n";
	}
	
	
	// Questions
	$query = "SELECT * FROM pquestions";
	$database->setQuery($query);
	$results = $database->loadAssocList();
	echo "-- Questions\n";	
	foreach($results as $result) { 
		echo "INSERT INTO `pquestions` VALUES ('{$result['qid']}', '{$result['qtype']}', '{$result['qtext']}', '{$result['qv0']}', '{$result['qv1']}', '{$result['qv2']}', '{$result['qv3']}', '{$result['qv4']}', '{$result['qwt']}');\n";
	}
	
	// Projects
	$query = "SELECT * FROM projects";
	$database->setQuery($query);
	$results = $database->loadAssocList();
	echo "-- Projects\n";
	foreach($results as $result) { 
		echo "INSERT INTO `projects` VALUES ('{$result['pid']}', '{$result['proj_name']}', '{$result['proj_desc']}', '{$result['proj_type']}');\n";
	}
	
	// Answers
	$query = "SELECT * FROM panswers";
	$database->setQuery($query);
	$results = $database->loadAssocList();
	echo "-- Answers\n";
	foreach($results as $result) { 
		echo "INSERT into `panswers` VALUES ('{$result['pid']}', '{$result['qid']}', '{$result['score']}');\n";
	}

	$out = ob_get_clean();
	// Run it through any filters
	$out = str_replace("& ", "&amp; ", $out);
	echo $out;
	
	$database->close();
?>