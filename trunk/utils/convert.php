<?php
/*
 * 
 * myGovernance to dotProject Conversion Script
 * Created on 5/05/2006
 * 
 * This is a simple script to translate projects across the gap ignoring duplicate projects 
 * 
 * PHP4/MySQL4
 *  
 * Created on 26/05/2006
 * 
 * @package myGovernance
 * @author Sam Moffatt <sam.moffatt@toowoombarc.qld.gov.au>
 * @author Toowoomba Regional Council Information Management Department
 * @license GNU/GPL http://www.gnu.org/licenses/gpl.html
 * @copyright 2008 Toowoomba Regional Council/Sam Moffatt 
 * @version SVN: $$Id: convert.php 460 2008-04-15 00:41:14Z s.moffatt@toowoomba.qld.gov.au $$
 * @see Project Documentation DM Number: #???????
 * @see Gaza Documentation: http://gaza.toowoomba.qld.gov.au
 */
 
// DATABASE OPTIONS
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
 
// MYGOVERNANCE SETTINGS
$mygovernance_database = 'research_mygovernance';

// DOTPROJECT SETTINGS
$dotproject_database = 'research_dotproject';
$dotproject_company = 1;
$dotproject_department = 0;
$dotproject_owner = 0;
$dotproject_creator = 0;
$dotproject_type = 0;
$dotproject_projects = Array();
$dotproject_queries = Array();

$connection = mysql_connect($dbserver, $dbuser, $dbpass, 1);
if(!$connection) {
	die("MySQL Connect Failed:<pre>" . mysql_error() ."</pre>");
}

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
	$dotproject_queries[] = "INSERT INTO $dotproject_database.projects VALUES (".
		"0,$dotproject_company,$dotproject_department,'$project_name', '$project_name', " .
		"$dotproject_owner, '','',NULL,NULL,1,0,'FFFFFF', '$project_description', $project_budget, 0, ".
		"$dotproject_creator, 1, 0, NULL, NULL, 0, $dotproject_type);";	
}	

foreach($dotproject_queries as $query) {
	echo $query.'<br>';
	$result = mysql_query($query);
	if(!$result){
		die("MySQL Query Failed:<pre>" . mysql_error() . "<br><br>" . $query."</pre>");
	}
	
}
?>
