<?php


// Common Functions and 'macros'
$__DBERROR = "myGovErrorFunctions::dberror(__LINE__, __FILE__, __FUNCTION__, \$database->getQuery(), \$database->getError());";
$__SQLERROR = "myGovErrorFunctions::sqlerror(__LINE__, __FILE__, __FUNCTION__, \$database->getQuery());";

class myGovCommon {
	function getDBError() { return "myGovErrorFunctions::dberror(__LINE__, __FILE__, __FUNCTION__, \$database->getQuery(), \$database->getError());"; }
	function getSQLError() { return "myGovErrorFunctions::sqlerror(__LINE__, __FILE__, __FUNCTION__, \$database->getQuery());"; }
	
	function &blankProject() {
		$row = new stdClass();
		$row->pid='';
		$row->proj_name='';
		$row->proj_desc='';
		$row->proj_type='';
		$row->proj_status='';
		$row->proj_benefits='';
		$row->proj_benefits_compliance='';
		$row->proj_benefits_riskmitig='';
		$row->proj_nousers='';
		$row->proj_capital_y1='';
		$row->proj_other_y1='';
		$row->proj_savings_y1='';
		$row->proj_funding_y1='';
		$row->proj_capital_y2='';
		$row->proj_other_y2='';
		$row->proj_savings_y2='';
		$row->proj_funding_y2='';
		$row->proj_capital_y3='';
		$row->proj_other_y3='';
		$row->proj_savings_y3='';
		$row->proj_funding_y3='';
		$row->proj_capital_y4='';
		$row->proj_other_y4='';
		$row->proj_savings_y4='';
		$row->proj_funding_y4='';
		$row->proj_timetable='';
		$row->proj_owner='';
		$row->proj_board='';
		$row->proj_commenced='';
		$row->proj_completed='';
		$row->proj_createdate='';
		$row->proj_updated='';
		$row->proj_benefit_recs='';
		$row->proj_risks_exist='';
		$row->proj_outcome_type='';
		$row->financialyear='';
		$row->recommended='';
		$row->proj_hide='';
		$row->proj_staffreq_y1='';
		$row->proj_staffreq_y2='';
		$row->proj_staffreq_y3='';
		$row->proj_applications_y1='';
		$row->proj_applications_y2='';
		$row->proj_applications_y3='';
		$row->proj_consultants_y1='';
		$row->proj_consultants_y2='';
		$row->proj_consultants_y3='';
		$row->proj_technical_y1='';
		$row->proj_technical_y2='';
		$row->proj_technical_y3='';
		$row->proj_buexpert_y1='';
		$row->proj_buexpert_y2='';
		$row->proj_buexpert_y3='';
		$row->proj_assessment='';
		$row->proj_shortname='';
		$row->businessunit='';
		$row->proj_deliverables='';
		$row->proj_impacts='';
		$row->proj_begin='';
		$row->proj_end='';
		$row->bus_owner='';
		$row->proj_dotprojectid='';
		$row->proj_notify='';
		$row->doccount='';
		$row->proj_stage='';
		return $row;
	}
	
	/**
	 * Finds a needle in haystack (strings)
	 * @param string needle The item to find
	 * @param string haystack The item to search in
	 * @param int insensitive case insensitive (default 0)
	 * @return bool result of operation
	 */
	function in_string($needle, $haystack, $insensitive = 0) {
		if ($insensitive) {
			return (false !== stristr($haystack, $needle)) ? true : false;
		} else {
			return (false !== strpos($haystack, $needle)) ? true : false;
		}
	}

	function printArray($array, $level = 0) {
		if ($level == 0) {
			echo "<pre>";
		}
		foreach ($array as $key => $line) {
			if (is_array($line)) {
				myGovCommon::printArray($line, $level++);
			} else {
				for ($i = 0; $i > $level; $i++) {
					echo "\t";
				}
				echo $key . " = " . $line;
			}
			echo "\n";
		}
		if ($level == 0) {
			echo "</pre>";
		}
	}

	function doAutoInsert($table, $array, $dbc, $where = false, $ignore=Array()) {
		global $database;
		$first = 0;
		if (!$where) {
			$query = "INSERT INTO `$table` ";
			$columns = "";
			$values = "";
			foreach ($array as $column => $value) {
				if(in_array($column, $ignore)) { break; }
				if (!$first) {
					$first = 1;
				} else {
					$columns .= ",";
					$values .= ",";
				}
				$columns .= "`" . $column . "`";
				$values .= "'" . $value . "'";
			}
			$query .= "($columns) VALUES ($values)";
			if ($where) {
				$query . " " . $where;
			}
			$database->setQuery($query);
			$database->Query() or die($database->getErrorMsg());
			return $database->insertid();
		} else {
			$query = "UPDATE `$table` SET ";
			foreach ($array as $column => $value) {
				if(in_array($column, $ignore)) { break; }
				if (!$first) {
					$first = 1;
				} else {
					$query .= ",";
				}
				$query .= "`" . $column . "` = " . "'" . $value . "'";
			}
			$query .= " WHERE " . $where;
			$database->setQuery($query);
			$database->Query() or die($database->getErrorMsg());
			return 0;
		}
	}

	function getScoreSum($pid) {
		return 0.5;
	}

	function getTotalScore($pid) {
		return 0.5;
	}

	function calculateRiskScore($pid) {
		global $database, $__DBERROR;
		$query = "SELECT * FROM panswers AS ans, pquestions ques WHERE ans.pid = '$pid' AND ans.qid = ques.qid AND (ques.qtype = 'Risk' OR ques.qtype = 'Technical Risk')";
		$database->setQuery($query);
		$std = $database->Query() or eval ($__DBERROR);
		$totalweight = 0;
		$rows = $database->loadResultList();
		foreach ($rows as $row) {
			$weight = $row['qwt'] * $row['score'] / 100;
			$totalweight = $totalweight + $weight;
		}
		return $totalweight +1;
	}

	function calculateTotalRiskScore($pid) {
		global $database;
		$totalweight = 0;
		$query = "SELECT * FROM panswers AS ans, pquestions ques WHERE ans.pid = '$pid' AND ans.qid = ques.qid AND (ques.qtype = 'Risk' OR ques.qtype = 'Technical Risk')";
		$database->setQuery($query);
		$std = $database->Query();
		$rows = $database->loadResultList();
		foreach ($rows as $row) {
			$weight = $row['qwt'] * 9 / 100;
			$totalweight = $totalweight + $weight;
		}
		return $totalweight;
	}

	function calculateBenefitScore($pid) {
		global $dbc, $__DBERROR;
		$query = "SELECT * FROM panswers AS ans, pquestions ques WHERE ans.pid = '$pid' AND ans.qid = ques.qid AND (ques.qtype != 'Risk' AND ques.qtype != 'Technical Risk')";
		$database->setQuery($query);
		$std = $database->Query() or eval ($__DBERROR);
		$totalweight = 0;
		$rows = $database->loadResultList();
		foreach ($rows as $row) {
			$weight = $row['qwt'] * $row['score'] / 100;
			$totalweight = $totalweight + $weight;
		}
		return $totalweight +1;
	}

	function calculateTotalBenefitScore($pid) {
		global $dbc, $__DBERROR;
		$totalweight = 0;
		$query = "SELECT * FROM panswers AS ans, pquestions ques WHERE ans.pid = '$pid' AND ans.qid = ques.qid AND (ques.qtype != 'Risk' AND ques.qtype != 'Technical Risk')";
		$database->setQuery($query);
		$std = $database->Query() or eval ($__DBERROR);
		$rows = $database->loadResultList();
		foreach ($rows as $row) {
			$weight = $row['qwt'] * 9 / 100;
			$totalweight = $totalweight + $weight;
		}
		return $totalweight;
	}

	function assessmentStatusToString($status) {
		switch ($status) {
			case -1 :
				return "Rejected";
				break;
			case 0 :
				return "Data Entry/Normal";
				break;
			case 1 :
				return "Requesting Assessment";
				break;
			case 2 :
				return "Pending";
				break;
			case 3 :
				return "Approved";
				break;
			default :
				return "Unknown";
				break;
		}
	}

	function mailProjectStatus($emails, $subject, $project) {
		global $database, $__DBERROR;
		$config = JFactory::getConfig();
		$baseurl =  $config->getValue('config.baseurl');
		$database->setQuery("SELECT * FROM `projects` WHERE pid = $project");
		$result = new stdclass();
		$result = $database->loadObject() or die(eval ($__DBERROR));

		// Allows us to override the emails if need be or supply default ones
		// Really C style stuff, but hey, thats life
		if ($emails == NULL) {
			$emails = $result->proj_notify;
		}
		$proj_name = $result->proj_name;
		$url = $baseurl . 'index.php?option=com_project&task=viewproject&p=' . $project;

		// To send HTML mail, the Content-type header must be set
		$headers = 'MIME-Version: 1.0' . "\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
		// Additional headers
		//$headers .= 'To: '. $emails . "\n";
		$headers .= 'From: myGovernance <mygovernance@smartnet.toowoomba.qld.gov.au>' . "\n";
		$subject = "myGovernance: Project Status Update ($proj_name - $subject)";
		$message = "<html><head><title>$subject</title></head><body><p>The project <a href=$url>$proj_name</a> has changed status. It is now:  " . myGovCommon::assessmentStatusToString($result->proj_assessment) . "</p></body></html>";

		$email_list = explode(",", $emails);
		foreach ($email_list as $email) {
			$mheaders = 'To: ' . $email . "\n" . $headers;
			mail($email, $subject, $message, $mheaders) or die('Failed to notify user! User: ' . $email);
		}
	}
}

// Other Common Classes

class displayItem {
	var $accesslevel 	= 0;	// Access level to view
	var $display 		= 0;	// Display or not?
	
	function displayItem($newname, $newaction, $newdisplay=0,$newaccesslevel=0) {
		$accesslevel = $newaccesslevel;
		$display = $newdisplay;
	}
}

class displayHandler {
	var $listProjectsMenu 	= null;
	var $editProjectMenu 	= null;
	var $editProductMenu 	= null;
	var $reportsMenu		= null;
	var $editResponseMenu	= null;
	var $adminMenu			= null;
	var $adminUserMenu		= null;
	var $adminBackupMenu	= null;
	
}

?>