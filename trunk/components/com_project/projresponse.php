<?php
global $dbc, $database;
$dbo = JFactory::getDBO();
if (isset ($p) && isset ($qtype)) {

} else {
	$p = "*";
	$qtype = "risk";
}
$buttons = Array ();
// Add Response check
$user = JFactory::getUser();
$results = $mainframe->triggerEvent("onAddResponse", Array (
	'username' => $user->username
));

$dbo->setQuery("SELECT proj_name FROM projects WHERE pid = " . $p);
$proj_name = $dbo->loadResult();

if (is_array($results)) {
	foreach ($results as $result) {

		if ($result == 1 || $result->id = 1) {
			$buttons[] = Array (
				'text' => "Add Response",
				'link' => "index.php?option=com_project&task=editresp&p=$p",
				'image' => "images/jdeadd.gif",
				'js' => "document.location.href='index.php?option=com_project&task=editresp&p=$p'"
			);
		}
	}
}
$buttons[] = Array (
	'text' => "Find Response",
	'link' => "javascript:findResponse();",
	'image' => "images/jdefind.gif",
	'js' => "findResponse();"
);
$buttons[] = Array (
	'text' => "Update Score",
	'link' => "javascript:updateScore()",
	'image' => "images/save.gif",
	'js' => "updateScore()"
);
$buttons[] = Array (
	'text' => "Close",
	'link' => "index.php",
	'image' => "images/jdeclose.gif",
	'js' => "document.location.href='index.php'"
);
?> 
<Form method="post" action="index.php?option=com_project&task=projresponse" name="mainform">
<input type="hidden" name="sqlaction" value="">
<input type="hidden" name="p" value="<?php echo $p ?>">
<table BORDER=0 BORDERCOLOR="#0000A0" ALIGN="Right%" WIDTH="100%">
   <tr>
          <td WIDTH=950 ALIGN=LEFT> <span style="vertical-align:middle"><b><font face="Arial size=+4" color="#400040" > Maintain Project Assessment - Values and Risks</font></b></td>
          </tr>
    <tr>
           <td  BGCOLOR="#F3F2ED" ALIGN=LEFT>
		   		<?php myGovHTML::funkyfactory($buttons) ?>
         </td>
    </tr>
   <tr>
        <td  BGCOLOR="#F3F2ED" ALIGN=LEFT>
             <table BORDER=0 BORDERCOLOR="#004080" ALIGN=Right% WIDTH=800>
             <tr height=40>
             <Td width=80> Project Id: </td>
                 <td><input name=p value=<?php print $p;?>  type=text align=LEFT size=3 maxlength=10 />
             <td width=80> Value/Risk: </td>
             <td align="left">
                <select size="1" name="qtype">
                <Option <?php if ($qtype=='Risk') {print "SELECTED";}?> value="Risk">Risk
                <Option <?php if ($qtype=='Technical Risk') {print "SELECTED";}?> value="Technical Risk">Technical Risk
                <Option <?php if ($qtype=='Strategic Alignment') {print "SELECTED";}?> value="Strategic Alignment">Strategic Alignment
                <Option <?php if ($qtype=='Compliance') {print "SELECTED";}?> value="Compliance">Compliance
                <Option <?php if ($qtype=='Direct Value Return') {print "SELECTED";}?> value="Direct Value Return">Direct Value Return
                <Option <?php if ($qtype=='Business Process Impact') {print "SELECTED";}?> value="Business Process Impact">Business Process Impact
                <Option <?php if ($qtype=='Architecture') {print "SELECTED";}?> value="Architecture">Architecture
                </Select></td>
             <td><?php echo $proj_name; ?></td>
             </tr>
             </Table>
         </td>
    </tr>
    <tr>
              <td>
              
              <table BORDER=1 BORDERCOLOR="#DEDCFF" bGCOLOR="#DEDCFF" ALIGN=Right% >
    		  <tr><td width=5% align=center>Item Number</td>
                <td width=20%>Item</td>
                <td width=15% ALIGN=CENTER> 0 </td>
                <td width=15% ALIGN=CENTER> 1 </td>
                <td width=15% ALIGN=CENTER> 2 </td>
                <td width=15% ALIGN=CENTER> 3 </td>
                <td width=15% ALIGN=CENTER> 4 </td>
                <td width=10% ALIGN=CENTER> Value </td>
                <td width=10% ALIGN=CENTER> Weighted Value </td>
            </tr>
    
<?Php

$totalweight = 0;
$line = 0;

$database->setQuery('SELECT proj_name FROM projects WHERE pid = ' . intval($p));
$proj_name = $database->loadObject();
if (is_object($proj_name)) {
	$proj_name = $proj_name->proj_name;
} // Too lazy to check this, so lets just let PHP do it!
$sqlstmt = 'SELECT * FROM pquestions, panswers WHERE panswers.qid= pquestions.qid and panswers.pid=';
$sqlwhere = $p . ' and pquestions.qtype = ' . "'" . $qtype . "'";
/*print $sqlstmt.$sqlwhere;*/
//  $dbh->setFetchMode(DB_FETCHMODE_OBJECT);
$query = $sqlstmt . $sqlwhere;
$database->setQuery($query);
$std = $database->Query();

if ($database->getNumRows()) {
	$rows = $database->loadAssocList();
	foreach ($rows as $row) {
		$weight = $row['qwt'] * $row['score'] / 100;
		$totalweight = $totalweight + $weight;
		$name1 = 'qid' . $line;
		$name2 = 'score' . $line++;
		print "<tr>
		                <td ALIGN=CENTER><a href=\"index.php?option=com_project&task=editresp&qid={$row['qid']}&p={$p}&qtype={$qtype}\"><img src='images/pencil.gif' border=\"0\">{$row['qid']}</a></td>
		                <input type=hidden name=$name1 value={$row['qid']} type=text>
		                <td>{$row['qtext']}</td>
		                <td><input type='radio' name='{$name2}radio' onclick='document.mainform.$name2.value=0;'>{$row['qv0']}</td>
		                <td width=10%><input type='radio' name='{$name2}radio' onclick='document.mainform.$name2.value=1;'>{$row['qv1']}</td>
		                <td width=10%><input type='radio' name='{$name2}radio' onclick='document.mainform.$name2.value=2;'>{$row['qv2']}</td>
		                <td width=10%><input type='radio' name='{$name2}radio' onclick='document.mainform.$name2.value=3;'>{$row['qv3']}</td>
		                <td><input type='radio' name='{$name2}radio' onclick='document.mainform.$name2.value=4;'>{$row['qv4']}</td>
		                <td ALIGN=center>&nbsp;<input name=$name2 value={$row['score']} type=text align=MIDDLE valign=middle size=1 maxlength=1 /></td>
		                <td ALIGN=RIGHT>$weight </td>
		            </tr>";
	}
	print "<tr>";
	print "<td colspan=7>&nbsp;</td><td>Total: </td><td ALIGN=RIGHT> $totalweight</td>";
	print "</tr>";
	print "</table>
	        </td>
	    </tr>
	    
	    </table>";

} else {
	print "<tr><td colspan=\"9\" align=\"center\"><b>No Results Found</b></td></tr></table>";

}
?>
  </FORM>
