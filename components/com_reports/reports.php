<?php
	// Reports Interface
	// Samuel Moffatt / Toowoomba Regional Council
	
function defaultAction() {
	// Create the buttons using the Funky buttons factory
	echo "<h1>Graphs</h1>";
	$buttons 	= Array();
	$buttons[] 	= Array('text'=>"ROI vs Risk", 
		'link'=>"index.php?option=com_reports&task=graph_decisionmatrix&linkbar=1&embed=1&graph=0",
		'image'=>"images/print_f2.png",
		'js'=>"document.location.href='index.php?option=com_reports&task=graph_decisionmatrix&linkbar=1&embed=1&graph=0'");
	$buttons[] 	= Array('text'=>"ROI vs Benefit", 
		'link'=>"index.php?option=com_reports&task=graph_decisionmatrix&linkbar=1&embed=1&graph=1",
		'image'=>"images/print_f2.png",
		'js'=>"document.location.href='index.php?option=com_reports&task=graph_decisionmatrix&linkbar=1&embed=1&graph=1'");
	$buttons[] 	= Array('text'=>"Cost vs Risk", 
		'link'=>"index.php?option=com_reports&task=graph_decisionmatrix&linkbar=1&embed=1&graph=2",
		'image'=>"images/print_f2.png",
		'js'=>"document.location.href='index.php?option=com_reports&task=graph_decisionmatrix&linkbar=1&embed=1&graph=2'");
	$buttons[] 	= Array('text'=>"Cost vs Benefit", 
		'link'=>"index.php?option=com_reports&task=graph_decisionmatrix&linkbar=1&embed=1&graph=3",
		'image'=>"images/print_f2.png",
		'js'=>"document.location.href='index.php?option=com_reports&task=graph_decisionmatrix&linkbar=1&embed=1&graph=3'");
		
	myGovHTML::funkyfactory($buttons);
}

$task = JRequest :: getVar('task', 'listproject');
switch ($task) {
	case 'radar':
		include('radar.php');
		break;
	default:
		defaultAction();
		break;
}