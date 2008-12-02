<?php
/**
 * Document Description
 * 
 * Document Long Description 
 * 
 * PHP4/5
 *  
 * Created on Apr 11, 2007
 * 
 * @package package_name
 * @author Your Name <author@toowoombarc.qld.gov.au>
 * @author Toowoomba Regional Council Information Management Department
 * @license GNU/GPL http://www.gnu.org/licenses/gpl.html
 * @copyright 2008 Toowoomba Regional Council/Sam Moffatt 
 * @version SVN: $Id:$
 */

/** Common Variables */
$p = '*';
$ptype = '*';
//$pstate = '';
//$pstatusx = '';
$qtype = 'Direct Value Return';

if (isset ($_REQUEST['p'])) {
	$p = $_REQUEST['p'];
}
if (isset ($_REQUEST['mt'])) {
	$mt = $_REQUEST['mt'];
}
if (isset ($_REQUEST['qtype'])) {
	$qtype = $_REQUEST['qtype'];
}
if (isset ($_REQUEST['qid'])) {
	$qid = $_REQUEST['qid'];
}
$returncode = -1;
if (isset ($_REQUEST['find'])) {
	if ($_REQUEST['p']) {
		$p = $_REQUEST['p'];
	}
	if ($_REQUEST['find'] == 'findproject') {
		if ($_REQUEST['ptype']) {
			$ptype = $_REQUEST['ptype'];
		}
		if ($_REQUEST['pstatusx']) {
			$pstatusx = $_REQUEST['pstatusx'];
		}
		if ($_REQUEST['pstate']) {
			$pstate = $_REQUEST['pstate'];
		}
		if(isset($pstate)) 		$_SESSION['pstate'] = $pstate;
		if(isset($pstatusx))	$_SESSION['pstatusx'] = $pstatusx;
		if(isset($ptype)) 		$_SESSION['ptype'] = $ptype;
	} else
		if ($_REQUEST['find'] == 'findresponse') {
			if ($_REQUEST['qtype']) {
				$qtype = $_REQUEST['qtype'];
			}
		}
} else {
	if(isset($_SESSION['pstate'])) $pstate = $_SESSION['pstate'];
	if(isset($_SESSION['pstatusx'])) $pstatusx = $_SESSION['pstatusx'];
	if(isset($_SESSION['ptype'])) $ptype = $_SESSION['ptype'];
}



if (isset ($_REQUEST['sqlaction'])) {
	//die('Test: '. $_REQUEST['sqlaction']);
	if (isset ($_REQUEST['p'])) {
		$p = $_REQUEST['p'];
	}
	if (isset ($_REQUEST['qtype'])) {
		$qtype = $_REQUEST['qtype'];
	}
	$returncode = require_once ('update.php');
	if (strlen($returncode) > 2) {
			echo "<p>" . $returncode . "</p>";
	}
}

$task = JRequest :: getVar('task', 'listproject');
switch ($task) {
	case 'docs' :
		include ('docs.php');
		break;
	case 'projresponse' :
		include ('projresponse.php');
		break;
	case 'viewproject' :
		include ('viewproject.php');
		break;
	case 'editresp':
		include ('editresp.php');
		break;
	default :
		include ('listprojects.php');
		break;
}

?>