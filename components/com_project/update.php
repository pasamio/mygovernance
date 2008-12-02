<?php
defined('_JEXEC') or die('Where is this?');
$database = JFactory :: getDBO();
$config = JFactory :: getConfig();
$pid = isset($_POST['pid']) ? intval($_POST['pid']) : ($_GET['projectid'] ? intval($_GET['projectid']) : '*');

switch ($_POST['sqlaction']) {
	case 'markpending' :
		if ($pid) {
			$database->setQuery("UPDATE projects SET proj_assessment = 2 WHERE pid = $pid");
			$database->Query();
			myGovCommon :: mailProjectStatus(NULL, "Project Marked Pending", $pid);
			return "<b>Project marked as pending.</b>";
		}
		return "<b>Invalid Project ID Specified</b>";
		break;
	case 'unmarkpending' :
		if ($pid) {
			$database->setQuery("UPDATE projects SET proj_assessment = 0 WHERE pid = $pid");
			$database->Query();
			myGovCommon :: mailProjectStatus(NULL, "Project unmarked pending", $pid);
			return "<b>Project unmarked as pending.</b>";
		}
		return "<b>Invalid Project ID Specified</b>";
		break;
	case 'rescheduleproject' :
		$database->setQuery('SELECT financialyear FROM projects WHERE pid = ' . $pid);
		$result = $database->loadObject();
		if ($result) {
			$parts = explode('/', $result->financialyear);
			$first = intval($parts[0]);
			$first++;
			$second = intval($parts[1]);
			$second++;
			$string = $first . '/' . sprintf("%02d", $second);
			$database->setQuery('UPDATE projects SET financialyear = "' . $string . '", proj_assessment = 0 WHERE pid = ' . $pid);			
			$database->Query();
			myGovCommon :: mailProjectStatus(NULL, "Project Rescheduled", $pid);
			return "<b>Project rescheduled.</b>";
		} else {
			return "<b>Failed to update financial year";
		}
		break;
	case 'rejectproject' :
		if ($pid) {
			$database->setQuery(("UPDATE projects SET proj_assessment = -1, proj_hide = 1 WHERE pid = $pid"));
			$database->Query();
			myGovCommon :: mailProjectStatus(NULL, "Project Rejected", $pid);
			return "<b>Project Successfully Rejected</b>";
		} else {
			return "<b>Invalid Project ID for operation - unable to reject proejct.</b>";
		}
		break;
	case 'requestassessment' :
		$pid = intval($_POST['pid']);
		$proj_name = $_POST['proj_name'];
		$my =& JFactory::getUser();
		$username = $my->get('username'); //$_SESSION['username'];
		if (!$pid) {
			die("Invalid Project ID specified");
		}
		$database->setQuery("UPDATE projects SET proj_assessment = 1 WHERE pid = $pid");
		$database->Query() or die($database->getErrorMsg());
		$url = $config->getValue('config.baseurl') . '/index.php?option=com_project&task=viewproject&p=' . $pid;

		$assessmentemail = $config->getValue('config.assessmentemail');
		// To send HTML mail, the Content-type header must be set
		$headers = 'MIME-Version: 1.0' . "\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
		// Additional headers
		$headers .= 'To: myGovernance Assessor <' . $assessmentemail . '>' . "\n";
		$headers .= 'From: myGovernance <noreply@TODO.changeme.example.com>' . "\n";
		$subject = "myGovernance: Request for Project Assessment ($proj_name)";
		$message = "<html><head><title>$subject</title></head><body><p>The user '$username' has requested that you assess <a href='$url'>$proj_name</a></p>.";
		mail($assessmentemail, $subject, $message, $headers) or die('Failed to notify assesser!');
		myGovCommon :: mailProjectStatus(NULL, "Project Requesting Assessment", $pid);
		return ('<b>Project assessment request sent</b>');
		break;
	case 'approveprox' :
		// Approve it and insert it into dotproject
		// What its ID though?
		$mygovernance_database = $dbname;
		$pid = intval($_POST['pid']);
		if (!$pid) {
			die("Invalid Project ID specified");
		}
		$dotproject_database 		= $config->getValue('config.dotproject_database');
		$dotproject_company	 	= $config->getValue('config.dotproject_company');
		$dotproject_department 	= $config->getValue('config.dotproject_department');
		$dotproject_owner 			= $config->getValue('config.dotproject_owner');
		$dotproject_creator 		= $config->getValue('config.dotproject_creator');
		$dotproject_status 		= $config->getValue('config.dotproject_status');
		$mygovernance_database	= $config->getValue('config.db');
		$database->setQuery('SELECT project_name FROM ' . $dotproject_database . '.projects');
		$dotproject_projects = $database->loadResultArray();
		$database->setQuery('SELECT * FROM ' . $mygovernance_database . '.projects WHERE proj_name NOT IN (\'' . implode("','", $dotproject_projects) . '\') AND proj_hide != 1 AND proj_type != "" AND pid = ' . $pid);
		$database->Query();
		if (!$database->getNumRows()) {
			die("Error: The project appears to be already approved. To update this project, the entire system needs to be synchronized. <a href='index.php'>myGovernance Home</a>".$database->getQuery());
		}
		$line = $database->loadObject();
		$project_name = $line->proj_name;
		$project_shortname = $line->proj_shortname;
		$project_description = $line->proj_desc;
		$project_budget = intval($line->proj_capital_y1) + intval($line->proj_other_y1) + 0;
		$project_start = $line->proj_begin ? $line->proj_begin : "0000-00-00";
		$project_end = $line->proj_end ? $line->proj_end : "0000-00-00";

		// Get company id from business unit
		$database->setQuery("SELECT dept_id, dept_company FROM $dotproject_database.departments WHERE dept_name = '{$_POST['businessunit']}'");
		$company_details = $database->loadAssocList();
		$company_id = $company_details[0]['dept_company'] ? $company_details[0]['dept_company'] : $dotproject_company;
		$dept_id = $company_details[0]['dept_id'] ? $company_details[0]['dept_id'] : $dotproject_department;

		$database->setQuery("INSERT INTO $dotproject_database.projects VALUES (" .
		"0,$company_id,$dept_id,'$project_name', '$project_shortname', " .
		"$dotproject_owner, '','','$project_start','$project_end',$dotproject_status,0,'FFFFFF', '" . $database->Quote($project_description) . "', $project_budget, 0, " .
		"$dotproject_creator, 1, 0, $company_id, NULL, 0, 0);");
		$database->Query();
		$projid = intval($database->insertid());
		$database->setQuery("INSERT INTO $dotproject_database.project_departments VALUES($projid,$company_id)");
		$database->Query();
		$id = $database->insertid();
		$database->setQuery("UPDATE projects SET proj_dotprojectid = $id, proj_assessment = 3 WHERE pid = $pid");
		$database->Query();
		myGovCommon :: mailProjectStatus($line->proj_notify, "Project Approved", $pid);
		return ('<b>Project successfully converted</b>');
		break;
	case 'dotprojectsync' :
		return ("<b>Feature not implemented</b>");
		//return ("<b>Projects Synchronized without Error</p>");
		break;
	case 'deleteprox' :
		// We don't like deleting things...
		//$returncode=myGovDB::DeleteResponse($dbc,$_POST['pid']);
		//$returncode=myGovDB::DeleteProject($dbc,$_POST['pid']);
		$returncode = myGovDB :: HideProject($database, $_POST['pid']);
		return ('<b>Project Record and children deleted Sucessfully</b>');
		break;
	case 'updateprox' :
		$update_array = array_slice($_POST, 2);
		$_POST['proj_status'] = isset($_POST['proj_status']) ? $_POST['proj_status'] : 'On Schedule';
		if ($_POST['pid'] == null) {
			$query = 'SELECT count(pid) FROM projects WHERE proj_name = "' . $update_array['proj_name'] . '"';
			$database->setQuery($query);
			$result = $database->Query();
			$row = $database->loadRow();
			if ($row[0]) {
				echo '<h1>Alert: Trying to insert a project with the same name. Did you refresh?</h1>';
				break;
			}
			myGovCommon :: doAutoInsert("projects", $update_array, $database,false,Array('Itemid'));
			// Always check that $result is not an error
			$query = 'SELECT * FROM projects WHERE proj_createdate = "' . $_POST['proj_createdate'] . '"';
			$database->setQuery($query);
			//$result = $database->Query();
			$row = $database->loadObject();
			if ($_POST['proj_status'] != 'product') {
				myGovDB :: AddDummyResponse($database, $row->pid);
			}
			return ('<b>Record Sucessfully inserted</b>');
		} else {
			myGovCommon :: doAutoInsert('projects', $update_array, $database, 'pid=' . $_POST['pid'], Array (
				'Itemid'
			));
			return ('<b>Record Sucessfully Updated</b>');
		}
		break;
	case 'updatescore' :
		$i = 0;
		$qid = 'qid' . $i;
		while (isset ($_POST[$qid])) {
			$sqlstmt = ' UPDATE `panswers` SET  `score` =' . $_POST['score' . $i] . ' WHERE pid=' . $p . ' AND qid=' . $_POST[$qid];
			$database->setQuery($sqlstmt);
			$result = $database->Query();
			$i++;
			$qid = 'qid' . $i;
		}
		return ('<b>Project Scores Sucessfully Updated</b>');
		break;
	case 'updateresp' :
		// Cheaply grab $_POST
		$update_array = array_slice($_POST, 2);
		// Clean it up a bit
		unset ($update_array['p']);
		unset ($update_array['sqlaction']);
		if ($_POST['qid'] == null) {
			//			myGovCommon::printArray($update_array);
			$qid = myGovCommon :: doAutoInsert("pquestions", $update_array, $database, '', Array (
				'Itemid'
			));
			myGovCommon :: doAutoInsert("panswers", Array (
				'qid' => $qid,
				'pid' => $_POST['pid'],
				'score' => '0'
			), $database, '', Array (
				'Itemid'
			));
			return ('<b>Record Sucessfully inserted</b>');
		} else {
			$qid = myGovCommon :: doAutoInsert('pquestions', $update_array, $database, 'qid=' . $_POST['qid'], Array (
				'Itemid'
			));
			//			myGovCommon::doAutoInsert('panswers',
			return ('<b>Record Sucessfully Updated</b>');
		}
		break;
	default :
		// 		echo "<p>We thank you for attempting to update something, but we believe that you have specified an invalid command.<br>";
		//		echo "Please check the form, and try again.</p>";
		break;
}
?>
