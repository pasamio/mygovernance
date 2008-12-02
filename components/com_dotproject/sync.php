<?php
/*
 * dotProject Synchronization File
 * 
 * This file is used to synchronize with dotProject ensuring basic data is updated. 
 * Checks to see if there are matches,
 * 
 * PHP4
 * MySQL 4/4.1
 *  
 * Created on Jun 16, 2006
 * 
 * @package mygovernance
 * @author Samuel Moffatt <Sam.Moffatt@toowoombarc.qld.gov.au>
 * @author Toowoomba Regional Council Information Management Department
 * @license GNU/GPL http://www.gnu.org/licenses/gpl.html
 * @copyright 2008 Toowoomba Regional Council/Sam Moffatt 
 * @version SVN: $Id:sync.php 267 2007-04-13 04:25:34Z sam.moffatt@toowoombarc.qld.gov.au $
 */
defined($_GET['override']) or die("Disabled"); 
// Connect to server and ensure that the connection is unique (hence the final one)
//require_once("config.php");
//require_once("config.dp.php");
die('This system has not been converted');
/** TODO: Integrate this */

$mygovernance_database = $dbname;
$connection = mysql_connect($dbserver, $dbuser, $dbpass, 1);
if(!$connection) {
	die("MySQL Connect Failed:<pre>" . mysql_error() ."</pre>");
}
if(!mysql_select_db($dbname)) {
	die("MySQL Select Failed:<pre>" . mysql_error() . "</pre>");
}
//SELECT * FROM mygovernance.projects WHERE proj_name NOT IN ('Draft Planning Scheme','ITSM Rollout','DR Site','Etrust7 Upgrade','Centralised Logging Service','SDE Swap-over','JDE Monitoring with Argent','AS402 Rebuild','ParkFinder','Single Tasks Nick','Zenworks for Desktops 6.5','Netware 6 Utility Server','Web Marshal Migration','Decommission John','VPN / Firewall Upgrade','Science Week','LiveState Recovery Deployment (V2i)','Aerial photo delivery','Internal Requests','Grave Finder','Single Tasks - Garry','IDM (DirXML)','Enterprise One','Setup test ArcSDE Server on Linux','Create maps for fire management','OES Linux upgrades for remotes','Compaq/HP Mgmt tools on Linux','Parks Field Data Recording System','CID Upgrade','XP SOE','Fax server implementation','Self Assessment survey form','Connecting Communities','Cadastral Adjustment','LGEMS01- Preproject Planning & Contract Negotiatio','LGEMS02: LIS Implementation Project','Data Validation','Orthos - Cooby','Data Coordination','Opensource CMS for Int*net','Digital field data capture','Training - Delivery','Software Utility Creation','Hand held apps','CBD Survey','MIS3 Volume reassignments','Netware Service Packs','Self Assessment Survey','ZenWorks Upgrade','Wheelie-Bin changes form','Cemetery enhancements','Edroc website','Rebuild jil','New Netware NAS','GeoWeb Improvements','Install CVS repository(subversion) on doorman','Shared storage facility (SAN)','Computer room rack relocation','Ortho03 creation','ARTIS','ESX Sever Replication','Spydus Upgrade (to SQL)','Citrix Implementation','iPrint distribution','Network Infrastructure Review & Strategy','SingleTasks - Ian','Orthos - Perso and Cress','DvTDM','ATLIS enhancements','PDA app for veg mapping','TCC Forge Site','PDA app for Animal Control','Smartnet Revamp','Emergency Response System','Orthos - City','PDA apps and Pathway','Inter gov data sharing','Backups','ArcGIS 9 upgrade','Digital lodgement','Trainees Jobs','BinFinder 2','X-Finders','Engineering Arcpad Tracklogs','Electrical Services PDA','ArcReader Roll Out','ESX Server Upgrade and Migration','Code Management System','Setup Cacti','Mail Marshal Upgrade','VPN Testing and Configuration','Rebuild Doorman (VM)','Argent Configuration','TCC Website Upgrade','Rationalise external websites','Run Joomla training','SmartNet/Engineering','SmartNet/CEO','Automatic authentication','Upgrade to Joomla','Pathway DCDB Join Assessment','Template - Basic','Smartnet/Leadership','Bin Finder','Self Assessment Survey','Project tool for M&C','GraveFinder revamp','Office plan changes','Update E1 to 8.11 SP1','After Hours Tasks','RightFax Implementation','GIS Team Work Plan 05/06','Security Audit','Domino1 hardware upgrade','Eview Implimention','Help Desk Review','E1: Corporate Asset Preventive Maintenance Phase 1','E1: Human Resources: Work Place Safety and Health Module Implementation','Rate Modelling & Valuation Analysis system','Printer/Copier Review','Pathway: Facilities Booking System','E1: Financial Systems Post Implementation Review','E1: Human Resources Reporting Requirements','Network Infrastructure Upgrade','E1: Process development project','DM: Convert DA Applications scanned externally to DM','Establish Disaster Recovery Centre - Stage 1','GIS: EVIEW','DM:  DM 6/Lotus Notes Integration upgrade','Pathway: Waste Management','Pathway: Storage of images linked to Pathway licenses','E1: Automation of payroll deductions into Pathway Rates and Debtors','E1: 8.11 Upgrade','E1: Purchasing: Review Practice & Configuration','E1:  Create Library of Easy Fix Solutions','E1: Implement Non-Stock Item Masters For Road Signs','E1: Implement Unified Log-Ons','Server Consolidation/Replacement','Pathway: Trade Waste','E1: Finance Post-Implementation Review','E1: Payroll Post-Implementation Review','E1: Human Resources Self Service Pilot','E1: Human Resources: Electronic Time Sheet Entry Pilot','E1: Web Portal Pilot','E1: Purchasing Business Process Transformation','E1: Partial Report Conversion to Crystal','E1: Align Business Processes Around E1 best Practice','E1: HR Custom Reports suite','E1: New Interface to Pathway Debtors & Rates','E1: Bulk Import of New Fixed Assets','E1:Non-stock Item Masters For Road Signs','E1: Unified log-Ons','GIS: Digital Orthophotography','Misc: Asset Register for Mobile Phones','Pathway: Process to archive  GL reports and audit records','Pathway: Reporting','Pathway: Version 3 implimention (formaly 2.21 Upgrade)','Pathway: ?POSTman?','Pathway: Review of current system security','Infomaster: RRIF  24*7 Public access to Development Application and Planning  Information','Toolbox:: RRIF 24*7 Public Access to Environment & Health Information','Art Gallery collection database','Pathway: RRIF GEAC Pathway Epathway modules','Office 2003 Upgrade','Lotus Notes 7 Upgrade','Pathway: 2.22 SP1 Upgrade','DM:  Document Managment Systems integration with Drawing and Laboratory Management Systems','Business Intelligence Pilot Project','GIS: Eview implementation and GEOWEB Replacement','GIS: Eview Business Applications Integration','DM: Pathway integration','E1: 8.12 upgrade','Mobile Computing Project','E1: Implement Recruitment and Selection Module','WEB: Smartnet (Planning)','WEB: Smartnet (engineering)','WEB: Webblog / Wikki pilot project','WEB: Image processing guidelines','WEB: Telemetary services to intranet','WEB: Milne Bay Website','WEB: TCC website redevelopment','WEB: Internet and Intranet Syustems Audit','GIS: Sewer Plan Recrification','GIS: Auspec 6A','GIS: Parks Data Capture','DM: Investigation - converting from K-Image to Hummingbird imaging or PDF','E1 Accoubts Payable Process Review','Mobile Computing - groundHog','myGovernance Upgrade','GIS: External Web Mapping (Eview) for DDROC','SEQ Regulation Reduction Incentive Fund(RRIF)','Upgrade DM to 5.1.0.5 SR5 MR3','Pathway Development Environment') AND proj_hide != 1 AND proj_type != ""
$query = 'SELECT project_name FROM '.$dotproject_database.'.projects';
$result = mysql_query($query);
if(!$result) {
	die("MySQL Query Failed:<pre>" . mysql_error() . "<br><br>" . $query."</pre>");
}

while($line = mysql_fetch_row($result)) {
	$dotproject_projects[] = $line[0];
}

$query = 'SELECT * FROM '.$mygovernance_database.'.projects WHERE proj_name NOT IN (\''.implode("','",$dotproject_projects).'\') AND proj_hide != 1 AND proj_type != ""';
$result = mysql_query($query);
if(!$result) {
	die("MySQL Query Failed:<pre>" . mysql_error() . "<br><br>" . $query."</pre>");
}
echo '<pre>';
while($line = mysql_fetch_assoc($result)) {	
	$project_name = $line['proj_name'];
	$project_description = $line['proj_description'];
	$project_budget = intval($line['proj_capital_y1']) + intval($line['proj_other_y1']);
	$project_begin = $line['proj_begin'];
	$project_end = $line['proj_end'];
	
	$tmpquery  = "UPDATE $dotproject_database.projects SET ";
	$values    = Array();
	if($project_begin) $vakyes[] = "project_start_date = '$project_begin'";
	if($project_end) $values[] = "project_end_date = '$proj_end'";
	if($project_budget) $values[] = "project_target_budget = '$proj_budget'";
	$tmpquery .= implode(' AND ', $values);
	$tmpquery .=  "WHERE project_name = '$project_name' ";
	$dotproject_queries[] = $tmpquery;
}	

foreach($dotproject_queries as $query) {
	echo $query.'<br>';
	$result = mysql_query($query);
	if(!$result){
		die("MySQL Query Failed:<pre>" . mysql_error() . "<br><br>" . $query."</pre>");
	}
	
}
?>
