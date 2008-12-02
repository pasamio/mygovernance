<?php
	// Graphs - Decision Matrix
	// Samuel Moffatt/Toowoomba Regional Council
    jimport ('mygovernance.phplot,phplot');
	
	// Set up debugging variables
	$dolinkbar = 0;
	$graphtype = 0;
	if(isset($_REQUEST['linkbar']) || isset($_REQUEST['debugbar'])) {
		// Do Graph switcher
		myGovHTML::htmlIncludes();
		echo "<p>Switch Graph: ";
		echo "<select name='graph' id='graph' onchange='return jump(this)'>";
		echo "<option value='index.php?option=com_reports&task=graph_decisionmatrix&linkbar=1'>Select Graph</option>";
		echo "<option value='index.php?option=com_reports&task=graph_decisionmatrix&linkbar=1&embed=1&graphtype=0'>ROI vs Risk</option>";
		echo "<option value='index.php?option=com_reports&task=graph_decisionmatrix&linkbar=1&embed=1&graphtype=1'>ROI vs Benefit</option>";
		echo "<option value='index.php?option=com_reports&task=graph_decisionmatrix&linkbar=1&embed=1&graphtype=2'>Cost vs Risk</option>";
		echo "<option value='index.php?option=com_reports&task=graph_decisionmatrix&linkbar=1&embed=1&graphtype=3'>Cost vs Benefit</option>";
		echo "</select>";
	}
	if(isset($_REQUEST['graphtype'])) { $graphtype = $_REQUEST['graphtype']; }
	if(isset($_REQUEST['linkbar'])) { 
//	echo "<h1>Graph $graphtype</h1>";
	$buttons 	= Array();
	// Back
	$buttons[] 	= Array('text'=>"Back", 
		'link'=>"javascript:history.go(-1);",
		'image'=>"images/back_f2.png",
		'js'=>"history.go(-1)");
	// Home
	$buttons[] 	= Array('text'=>"Home", 
		'link'=>"index.php",
		'image'=>"images/frontpage.png",
		'js'=>"document.location.href='index.php'");		
	// Table
	$buttons[] 	= Array('text'=>"Table",
		'link'=>"index.php?option=com_reports&task=graph_decisionmatrix&table=1&linkbar=1&graphtype=$graphtype",
		'image'=>"images/assesment.gif",
		'js'=>"document.location.href='index.php?option=com_reports&task=graph_decisionmatrix&table=1&linkbar=1&graphtype=$graphtype'");	
	// Embed Graph
	$buttons[] 	= Array('text'=>"Graph", 
		'link'=>"index.php?option=com_reports&task=graph_decisionmatrix&embed=1&linkbar=1",
		'image'=>"images/print_f2.png",
		'js'=>"document.location.href='index.php?option=com_reports&task=graph_decisionmatrix&embed=1&linkbar=1&graphtype=$graphtype'");	
	// Debug panel switcher
	if(myGovAuth::isAdmin($_SESSION['username'])) {
	// Embed Graph
	$buttons[] 	= Array('text'=>"Debug Mode", 
		'link'=>"index.php?option=com_reports&task=graph_decisionmatrix&embed=1&debugbar=1&graphtype=$graphtype",
		'image'=>"images/reload_f2.png",
		'js'=>"document.location.href='index.php?option=com_reports&task=graph_decisionmatrix&embed=1&debugbar=1&graphtype=$graphtype'");		
	}
		
	// Generate Buttons
	myGovHTML::funkyfactory($buttons);
	
	$dolinkbar = 1; $linkbar = 1; } else { $linkbar = 0; }
	if(isset($_REQUEST['debugbar'])) { 
	// Debugging Navigation Bar
	$buttons 	= Array();
	// Home
	$buttons[] 	= Array('text'=>"Home", 
		'link'=>"index.php",
		'image'=>"images/frontpage.png",
		'js'=>"document.location.href='index.php'");
	// Raw Data
	$buttons[] 	= Array('text'=>"Raw Data", 
		'link'=>"index.php?option=com_reports&task=graph_decisionmatrix&rawdata=1&debugbar=1&graphtype=$graphtype",
		'image'=>"images/assesment.gif",
		'js'=>"document.location.href='index.php?option=com_reports&task=graph_decisionmatrix&rawdata=1&debugbar=1&graphtype=$graphtype'");	
	// Table
	$buttons[] 	= Array('text'=>"Table", 
		'link'=>"index.php?option=com_reports&task=graph_decisionmatrix&table=1&debugbar=1&graphtype=$graphtype",
		'image'=>"images/assesment.gif",
		'js'=>"document.location.href='index.php?option=com_reports&task=graph_decisionmatrix&table=1&debugbar=1&graphtype=$graphtype'");	
	// Points
	$buttons[] 	= Array('text'=>"Points", 
		'link'=>"index.php?option=com_reports&task=graph_decisionmatrix&points=1&debugbar=1&graphtype=$graphtype",
		'image'=>"images/assesment.gif",
		'js'=>"document.location.href='index.php?option=com_reports&task=graph_decisionmatrix&points=1&debugbar=1&graphtype=$graphtype'");	
	// Calculations
	$buttons[] 	= Array('text'=>"Calculations", 
		'link'=>"index.php?option=com_reports&task=graph_decisionmatrix&calculations=1&debugbar=1&graphtype=$graphtype",
		'image'=>"images/assesment.gif",
		'js'=>"document.location.href='index.php?option=com_reports&task=graph_decisionmatrix&calculations=1&debugbar=1&graphtype=$graphtype'");	
	// Embed Graph
	$buttons[] 	= Array('text'=>"Embed Graph", 
		'link'=>"index.php?option=com_reports&task=graph_decisionmatrix&embed=1&debugbar=1&graphtype=$graphtype",
		'image'=>"images/print_f2.png",
		'js'=>"document.location.href='index.php?option=com_reports&task=graph_decisionmatrix&embed=1&debugbar=1&graphtype=$graphtype'");	
	// Normal Graph
	$buttons[] 	= Array('text'=>"Normal Graph", 
		'link'=>"index.php?option=com_reports&task=graph_decisionmatrix&graphtype=$graphtype",
		'image'=>"images/print_f2.png",
		'js'=>"document.location.href='index.php?option=com_reports&task=graph_decisionmatrix&graphtype=$graphtype'");	
	// Debug panel switcher
	// Embed Graph
	$buttons[] 	= Array('text'=>"Normal Mode", 
		'link'=>"index.php?option=com_reports&task=graph_decisionmatrix&embed=1&linkbar=$linkbar&graphtype=$graphtype",
		'image'=>"images/reload_f2.png",
		'js'=>"document.location.href='index.php?option=com_reports&task=graph_decisionmatrix&embed=1&linkbar=$linkbar&graphtype=$graphtype'");		
	// Generate Buttons
	myGovHTML::funkyfactory($buttons);
	$dolinkbar = 1; } 
	if(!isset($_REQUEST['table'])) { $dotable = 0; } else { $dotable = $_REQUEST['table']; }
	if(!isset($_REQUEST['points'])) { $dopoints = 0; } else { $dopoints = $_REQUEST['points']; }
	if(!isset($_REQUEST['calculations'])) { $docalcs = 0; } else { $docalcs = $_REQUEST['calculations']; }
	if(!isset($_REQUEST['rawdata'])) { $dorawdata = 0; } else { $dorawdata = $_REQUEST['rawdata']; }
	if(isset($_REQUEST['embed'])) { ?><a href='index.php?option=com_reports&task=graph_decisionmatrix&graphtype=<?php echo $graphtype ?>' target='_blank'><img src="index.php?option=com_reports&task=graph_decisionmatrix&graphtype=<?php echo $graphtype ?>" border=0></a><?php die(); }
	// echo "Hello World! PhPlot Research Page";
	// Set up data array
	//             Label   X Value  Y Value
/*	$data[] = array("P1",   "5.4",    "5");
	$data[] = array("P2",   "-3.2",   "4");
	$data[] = array("P3",   "2.6",    "5");
	$data[] = array("P4",   "6.1",    "6");
	$data[] = array("P5",   "4.2",    "7");*/
	
	// Boring data gathering stuff
	$sqlstmt = "SELECT * FROM projects WHERE proj_status != 'Product'";
	$query = $sqlstmt;
	$database->setQuery($query);
	$std= $database->Query();
	$roi_data = Array();
	$cost_data = Array();
	$benefit_data = Array();
	$risk_data = Array();

	if ($database->getNumRows()) {
		if($dotable) { echo "<table cellpadding='2' cellspacing='2' border='1'><tr><th>Project</th><th>Four Year Cost</th><th>Four Year Savings</th><th>Cost</th><th>ROI</th><th>Benefit</th><th>Risk</th></tr>"; }
		$risk = 0;
		$trisk = 0;
		$rows = $database->loadAssocList();
		foreach($rows as $row) {
//	foreach($rows as $row) {
			$x = 0.5;	// X offset, was 0.5
			$y = 0.5; // Y offset, was 0.5*/
//			$x = 0;	// X offset, was 0.5
//			$y = 0; // Y offset, was 0.5*/
	
			switch($row['proj_outcome_type']) {		
				case 'Strategic': $y++; break;
				case 'Speculative': $x++; $y++; break;
				case 'Support': $x++; break;
				case 'Compliance': $y++; $y++; break;
			}
			if($dopoints) { echo "$row[1] (Project $row[0]) offsets: $x,$y<br>"; }
			$fouryrcost = $row['proj_capital_y1']+$row['proj_other_y1']+$row['proj_capital_y2']+$row['proj_other_y2']+$row['proj_capital_y3']+$row['proj_other_y3']+$row['proj_capital_y4']+$row['proj_other_y4'];
			$fouryrsav = $row['proj_savings_y1']+$row['proj_savings_y2']+$row['proj_savings_y3']+$row['proj_savings_y4'];				
			// Old way of doing things
//			$risk = 1 - $scoresum / 10;
//			$benefit = myGovCommon::getScoreSum($scoresum) / 25;		
			// Slightly better way of doing things
			if((myGovCommon::calculateTotalRiskScore($row[0]) != 0) && (myGovCommon::calculateRiskScore($row[0]) != 0)) {
				$risk  = (1 - (myGovCommon::calculateRiskScore($row[0])/myGovCommon::calculateTotalRiskScore($row[0]) / 10)) / 2;
			}
			$benefit = 0;
			if(($tbenefit = myGovCommon::calculateTotalBenefitScore($row[0])) != 0) {
				$benefit  = myGovCommon::calculateBenefitScore($row[0]) / myGovCommon::calculateTotalBenefitScore($row[0]);
			}
			// if less than 0 it is a negative number, obvious!
			$negrisk = 0;
			$negbenefit = 0;
			if($risk < 0) { $negrisk = 1; }
			if($benefit < 0) { $negbenefit = 1; }
			$roi = ((log($fouryrsav) - log($fouryrcost)) / 10);
//			$roi = (($fouryrsav - $fouryrcost) % 10)/10+0.9;
			$cost = (log($row['proj_capital_y1']+$row['proj_other_y1']) - 8) / 10;
			if($dotable) { echo "<tr><td>$row[0]</td><td>$fouryrcost</td><td>$fouryrsav</td><td>$cost</td><td>$roi</td><td>$benefit</td><td>$risk</td></tr>"; }
			$scoresum = myGovCommon::getScoreSum($row[0]);
			$costval = log($cost) - 8 / 10;

			if($docalcs) {
				echo "<p>$row[1] (Project $row[0])</p>";
				echo "<p>Risk: $risk</p>";
				echo "<p>Benefit: $benefit</p>";
				echo "<p>Project Benefit Score: ".myGovCommon::calculateBenefitScore($row[0])."</p>";
				echo "<p>Project Benefit Potential: ".myGovCommon::calculateTotalBenefitScore($row[0])."</p>";
				echo "<p>Project Benefit Value: $benefit</p>";
				echo "<p>Project Cost: $cost</p>";
				echo "<p>Project ROI: $cost</p>";				
				echo "<hr>";
			}

			
    		if($fouryrcost != 0) { $roivsrisk_data[] = array("Project $row[0]",round($x+$roi,1), round($y+$risk,1)	); }
			if($cost != 0) { $costvsrisk_data[] = array("Project $row[0]",round($x+$cost,1), round($y+$risk,1)); }
    		if($fouryrcost != 0) { $roivsbenefit_data[] = array("Project $row[0]",round($x+$roi,1), round($y+$benefit,1)	); }
			if($cost != 0) { $costvsbenefit_data[] = array("Project $row[0]",round($x+$cost,1), round($y+$benefit,1)); }
			
	    }
		if($docalcs) { die(); } 
		if($dotable) { echo "</table>"; }
	}  else {
	    die ("No Results");
	}

	if($dotable || $dopoints) { die(); }	

	$graph = new PHPlot(900,600);
	$graph->SetDataType("data-data");
	$graph->SetPlotType("points");

	$title = "Decision Matrix";
	switch($graphtype) {
		default:
		case 0:
			// ROI vs Risk
//			echo "<p>ROI vs Risk</p>";
			$title = "ROI vs Risk";
			$data = $roivsrisk_data;
			break;
		case 1:
			// ROI vs Benefit
//			echo "<p>ROI vs Benefit</p>";
			$title = "ROI vs Benefit";
			$data = $roivsbenefit_data;
			break;
		case 2:
			// Cost vs Risk
//			echo "<p>Cost vs Risk</p>";
			$title = "Cost vs Risk";
			$data = $costvsrisk_data;
			break;
		case 3:
			// Cost vs Benefit
//			echo "<p>Cost vs Benefit</p>";
			$title = "Cost vs Benefit";
			$data = $costvsbenefit_data;
			break;
	}
	

	// Graphing stuff
	$graph->SetDataValues($data);
	$graph->SetTitle($title);
	
	if($dorawdata) { echo "<pre>"; print_r($data); die(); }
	
	//Set the data type
	$graph->SetDataType("linear-linear");

	//Remove the X data labels
	//$graph->SetXGridLabelType("none");

	// Set the default settings
	include "library/phplot_defaults.php";

	// Force size
	$graph->SetPlotAreaWorld(0,0,2,3);
	//$graph->SetPlotAreaWorld(0.5,0,2,3);

	if($dolinkbar) { die(); }
	
	// Flush buffer
	while (@ob_end_clean());
	
	//Draw the graph
	$graph->DrawGraph();
?>
