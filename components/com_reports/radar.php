<?php
// Graphs - Project Evaluation RADAR
// Toowoomba Regional Council

jimport('pear.Image.Graph');
$database = JFactory::getDBO();
$config = JFactory::getConfig();
$fontpath = $config->getValue('config.fontpath');
$dolinkbar = 0;
if (isset ($_REQUEST['p'])) {
	$p = $_REQUEST['p'];
}

if(isset($_REQUEST['linkbar'])) { 
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
	$dolinkbar = 1; }
if(isset($_REQUEST['embed'])) { ?><img src="index.php?option=com_reports&task=radar&p=<?php echo $_REQUEST['p'] ?>"><?php die(); }

$sqlstmt='SELECT pquestions.qtype, sum(qwt*score) FROM  pquestions, panswers WHERE panswers.qid= pquestions.qid and ';
$sqlwhere='pid="'.$p.'" '.' group by pquestions.QTYPE';
$query = $sqlstmt.$sqlwhere;
$database->setQuery($query);
$std=$database->Query();
$Graph = & Image_graph::factory('graph',array(800,600));
$fontloc = $fontpath."arial.ttf";
$Font =& $Graph->addNew('ttf_font',$fontloc);
$Font->setSize(8);
$Graph->setFont($Font);
$Graph->add(
        Image_Graph::vertical(
            Image_Graph::factory('title', array("Project Risk and Value Summary for Project ".$p,12)),
            Image_Graph::vertical(
                $Plotarea = Image_Graph::factory('Image_Graph_Plotarea_Radar'),
                $Legend = Image_Graph::factory('legend'),
                90
            ),
            5
        )
    );

$Legend->setPlotarea($Plotarea);
$Plotarea->addNew('Image_Graph_Grid_Lines', IMAGE_GRAPH_AXIS_Y);
$DS1 =& Image_Graph::factory('dataset');
$DS2 =& Image_Graph::factory('dataset');
if ($database->getNumRows()) {
	$rows = $database->loadRowList();
    foreach($rows as $row) {
    	if(!$row[1]) { $row[1] = 25; }
    	$DS1->addPoint($row[0],$row[1]/100);
	    $DS2->addPoint($row[0],'2.5');
    }
}  else {
    die ("No Results");
}
$Plot1 =& $Plotarea->addNew('Image_Graph_Plot_Radar', $DS1);
$Plot2 =& $Plotarea->addNew('Image_Graph_Plot_Radar', $DS2);

// set a standard fill style
    $Plot1->setLineColor('blue@0.4');
    $Plot1->setFillColor('blue@0.2');

    $Plot2->setLineColor('red@0.4');
    $Plot2->setFillColor('red@0.2');
    
    $Plot1->setTitle('Project Score');
    $Plot2->setTitle('2.5 Average Score');

    // output the Graph
    
	while (@ob_end_clean());
$Graph->done();
//*/
die("Done");

 ?>
