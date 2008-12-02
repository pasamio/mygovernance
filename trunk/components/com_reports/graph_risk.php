<?php
global $dbc,$db;
//  die("Hello");
//error_reporting(0);
if(!isset($_REQUEST['table'])) { $dotable = 0; } else { $dotable = $_REQUEST['table']; }
if(!isset($_REQUEST['points'])) { $dopoints = 0; } else { $dopoints = $_REQUEST['points']; }
jimport ('pear.Image.Graph');
//$sqlstmt='SELECT pquestions.qtype, sum(qwt*score), panswers.score, projects.proj_name FROM  pquestions, panswers, projects WHERE panswers.qid = pquestions.qid AND panswers.pid = projects.pid ';
//$sqlwhere=' group by pquestions.QTYPE';
	myGovHTML::htmlIncludes();
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
	// Generate Buttons
	myGovHTML::funkyfactory($buttons);
die("Not implemented at this point in time.");
$Graph = & Image_graph::factory('graph',array(900,500));
$fontloc = $fontpath."arial.ttf";
$Font =& $Graph->addNew('ttf_font',$fontloc);
$Font->setSize(8);
$Graph->setFont($Font);
$Graph->add(
        Image_Graph::vertical(
            Image_Graph::factory('title', array("Decision Matrix",12)),
            Image_Graph::vertical(
                $Plotarea = Image_Graph::factory('Image_Graph_Plotarea'),
                $Legend = Image_Graph::factory('legend'),
                90
            ),
            5
        )
    );
$Legend->setPlotarea($Plotarea);
//$Plotarea->addNew('Image_Graph_Grid_Lines', IMAGE_GRAPH_AXIS_X);
$AxisX =& $Plotarea->getAxis(IMAGE_GRAPH_AXIS_X);
$AxisY =& $Plotarea->getAxis(IMAGE_GRAPH_AXIS_Y);

/*$AxisX->setLabelInterval(1);
$AxisY->setLabelInterval(1);
$AxisX->forceMinimum(0);
$AxisY->forceMinimum(0);
$AxisX->forceMaximum(5);
$AxisY->forceMaximum(3);*/

// Boring data gathering stuff
$sqlstmt = "SELECT * FROM projects";
$query = $sqlstmt.$sqlwhere;
$database->setQuery($query);
$std=$database->Query();
$roi_data = Array();
$cost_data = Array();
$benefit_data = Array();
$risk_data = Array();

if ($database->getNumRows()) {
	if($dotable) { echo "<table cellpadding='2' cellspacing='2' border='1'><tr><th>Project</th><th>Four Year Cost</th><th>Four Year Savings</th><th>Cost</th><th>ROI</th></tr>"; }
	$rows = $database->loadAssocList();
    foreach($rows as $row) {
//	foreach($rows as $row) {
		$x = 0.5;	// X offset
		$y = 0.5; // Y offset
		switch($row['proj_outcome_type']) {
			case 'Strategic': $y++; break;
			case 'Speculative': $x++; $y++; break;
			case 'Support': $x++; break;
			case 'Compliance': $x++; break;
		}
		
		$fouryrcost = $row['proj_capital_y1']+$row['proj_other_y1']+$row['proj_capital_y2']+$row['proj_other_y2']+$row['proj_capital_y3']+$row['proj_other_y3']+$row['proj_capital_y4']+$row['proj_other_y4'];
		$fouryrsav = $row['proj_savings_y1']+$row['proj_savings_y2']+$row['proj_savings_y3']+$row['proj_savings_y4'];				
		$risk = calculateRisk($row[0]);
		
		$roi = ((log($fouryrsav) - log($fouryrcost)));
//		$roi = (($fouryrsav - $fouryrcost) % 10)/10+0.9;
		$cost = (log($row['proj_capital_y1']+$row['proj_other_y1']) - 8);
		if($dotable) { echo "<tr><td>$row[0]</td><td>$fouryrcost</td><td>$fouryrsav</td><td>$cost</td><td>$roi</td></tr>"; }
		$scoresum = myGovCommon::getScoreSum($row[0]);
		$risk = 1 - $scoresum / 10;
		$benefit = myGovCommon::getScoreSum($scoresum) / 25;
    	if($fouryrcost > 0) { $roi_data[] = array('x' => round($x+$roi,1), 'y' => round($y+$scoresum,1), 'project' => $row[1]); }
		if($cost > 0) { $cost_data[] = array('x' => round($x+$cost,1), 'y' => round($y+$scoresum,1), 'project' => $row[1]); }
    }
	if($dotable) { echo "</table>"; }
}  else {
    die ("No Results");
}
if($dotable) { die(); }
sort($roi_data); reset($roi_data);
sort($cost_data); reset($cost_data);
sort($benefit_data); reset($benefit_data);
sort($risk_data); reset($risk_data);
$DS1 =& Image_Graph::factory('dataset_trivial');
$DS2 =& Image_Graph::factory('dataset_trivial');
foreach($roi_data as $datum) {
	if($dopoints) { echo "Adding ROI point {$datum['x']}, {$datum['y']} for item \"{$datum['project']}\"<br>"; }
	$DS1->addPoint($datum['x'], $datum['y']);
}
foreach($cost_data as $datum) {
	if($dopoints) { echo "Adding ROI point {$datum['x']}, {$datum['y']} for item \"{$datum['project']}\"<br>"; }
	$DS2->addPoint($datum['x'], $datum['y']);
}
if($dopoints) { die(); }
//$Plot1 =& $Plotarea->addNew('Image_Graph_Plot_Dot', $DS1);
$Plot2 =& $Plotarea->addNew('Image_Graph_Plot_Dot', $DS2);

    // create the dataset
//    $Dataset =& Image_Graph::factory('random', array(10, 2, 15, false));
    // create the 1st plot as smoothed area chart using the 1st dataset
//    $Plot =& $Plotarea->addNew('Image_Graph_Plot_Dot', $Dataset);
    
    // set a line color
//    $marker = $Plot1->setMarker(Image_Graph::factory('Image_Graph_Marker_Circle'));
//	$marker->write();
    $Plot2->setMarker(Image_Graph::factory('Image_Graph_Marker_Box'));
    // output the Graph
	while (@ob_end_clean());
    $Graph->done();
/*

// set a standard fill style
    $Plot1->setLineColor('blue@0.4');
    $Plot1->setFillColor('blue@0.2');

    $Plot2->setLineColor('red@0.4');
    $Plot2->setFillColor('red@0.2');
    
    $Plot1->setTitle('Project Score');
    $Plot2->setTitle('2.5 Average Score');

    // output the Graph
$Graph->done();
//*/
//die("Done");

 ?>