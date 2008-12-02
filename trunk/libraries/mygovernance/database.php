<?php

// Rewritten as mysql functions

/*Database Functions */
class myGovDB {
	function AddDummyResponse($dbc, $projid) {
		$dbc = JFactory::getDBO();
		$sqlstmt = 'SELECT count(*)  FROM pquestions';
		/* count number of records*/
		$dbc->setQuery($sqlstmt);
		$result = $dbc->Query();
		if ($dbc->getNumRows()) {
			/* insert records into panswers */
			$row = $dbc->loadRow();
			$valuecnt = $row[0];
			for ($i = 1; $i <= $valuecnt; $i++) {
				$sqlstmt = ' INSERT INTO `panswers` ( `pid` , `qid` , `score` ) ' .
				'VALUES ("' . $projid . '","' . $i . '","0")';
				$dbc->setQuery($sqlstmt);
				$result = $dbc->Query() or die(eval(myGovCommon::getSQLError()));
			}
		}
		return;
	}
	function DeleteResponse($dbc, $projid) {
		global $database;
		$sqlstmt = 'DELETE FROM `panswers` WHERE pid = ' . $projid;
		$database->setQuery($sqlstmt);
		$result = $database->Query();
		return;
	}
	function DeleteProject($dbc, $projid) {
		global $database;
		$sqlstmt = 'DELETE FROM `projects` WHERE pid = ' . $projid;
		$database->setQuery($sqlstmt);
		$result = $database->Query();
		return;
	}

	function HideProject($dbc, $projid) {
		global $database;
		$sqlstmt = 'UPDATE `projects` SET proj_hide = 1 WHERE pid = ' . $projid;
		$database->setQuery($sqlstmt);
		$result = $database->Query();
		return;
	}

	// Does a minimal repair
	function repairDatabase() {
		global $database;
		$sqlstmt = 'SELECT DISTINCT panswers.pid FROM panswers LEFT JOIN projects ON panswers.pid = projects.pid WHERE projects.pid IS NULL';
		$database->setQuery($sqlstmt);
		$result = $database->Query();
		$first = 1;
		if ($database->getNumRows()) {
			$query = "DELETE FROM panswers WHERE ";
			$rows = $database->loadResultArray();
			foreach ($rows as $row) {
				echo "Repairing {$row['pid']}...<br>\n";
				if ($first) {
					$first = 0;
				} else {
					$query .= " OR ";
				}
				$query .= " pid = {$row['pid']} ";
			}
			$database->setQuery($query);
			$result = $database->Query();
			echo "Database has been successfully repaired.";
		} else {
			echo "Database does not need repairing.";
		}
		return;
	}
}
?>
