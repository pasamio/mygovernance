<?php 
if(!isset($row)) { 
	$row = myGovCommon::blankProject();
} 
//global $database;
// Check that dotProject exists
global $__SQLERROR;
$config = JFactory::getConfig();
$database = JFactory::getDBO();
if($config->getValue('config.dotproject')) {
	// Grab Business Unit from dotProject
	$dotproject_database = $config->getValue('config.dotproject_database');
	if($dotproject_database) {
		$database->setQuery("SELECT dept_name FROM $dotproject_database.departments ORDER BY dept_name");
		$companies = $database->loadRowList() or eval(myGovCommon::getSQLError());
		
		$bu = '<select size="1" name="businessunit">';	
		foreach($companies as $company) {
			$bu .= '<option value="'.$company[0].'"';
			if($company[0] == $row->businessunit) {
				$bu .= ' SELECTED ';
			}
			$bu .= '>'.$company[0].'</option>';
		}
		$bu .= '</select>';	
	}
} else {
	$bu = '<input type="text" name="businessunit" value="'. $row->businessunit .'">';
}
$row->proj_stage = isset($row->proj_stage) ? $row->proj_stage : "Inception";

$fyear = '<select size="1" name="financialyear">';
if(!isset($row->financialyear) || $row->financialyear == '') {
	$row->financialyear = intval(date('Y')) . '/' . sprintf("%02d", intval(date('y'))+1);
}
for($i = 0; $i < 4; $i++) {
	$fyear .= '<option ';
	$first = intval(date('Y'));
	$first += $i - 1;
	$second = intval(date('y'));
	$second += $i;
	$string = $first . '/' . sprintf("%02d", $second);
	if($string == $row->financialyear) {
		$fyear .= ' SELECTED ';
	}
	$fyear .= '>'.$string . '</option>';
}

//$dochtml = '';
if(isset($row->doccount) && $row->doccount) {
	$database->setQuery('SELECT * FROM documents WHERE project = '. $row->pid);
	$docs = $database->loadObjectList() or die($database->getErrorMsg());
	$dochtml = '<ol>';
	foreach($docs as $doc) {
		$dochtml .= '<li><a href="drf.php?drf='.$doc->drf.'">'.$doc->title.'</a></li>'; 
	}
	$dochtml .= '</ol>';
} else $dochtml = '<p>No Documents found.</p>';


if(!myGovCommon::in_string($row->financialyear,$fyear)) {
	$fyear .= '<option DEFAULT>'.$row->financialyear.'</option>';
}
$row->proj_assessment = isset($row->proj_assessment) ? ($row->proj_assessment ? $row->proj_assessment : 0) : 0;
$fyear .= '</select>';
 ?>
<link rel="stylesheet" href="js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css" media="screen"></LINK>
<SCRIPT type="text/javascript" src="js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js"></script>
<p><b>Status: <?php echo myGovCommon::assessmentStatusToString($row->proj_assessment) ?></b></p>
<TABLE BORDER=1 BORDERCOLOR="#DEDCFF" bGCOLOR="#DEDCFF"  cellspacing=0 cellpadding=0>
    <TR><TD width=20><p>&nbsp;</p></td>
	<TD width 920>
	<table border=0 cellspacing=0 cellpadding=0>
  	<tr>
  	<td width=320 height=40 valign=center><p><B>Project Id:</b></p>  </td>
  	<td height=40 valign=center><p><INPUT TYPE="TEXT" READONLY SIZE="5" ALIGN="RIGHT" value="<?php echo $row->pid;?>" NAME="pid"></p> </td>
 	</tr>
 	<tr>
  	<td width=320 valign=top><p><B>Documents:</b><br><a href="index.php?option=com_project&task=docs&projectid=<?php echo $row->pid ?>">Manage Documents</a></p></td>
  	<td valign=top><?php echo $dochtml ?></td>
	</tr> 	
 <tr>
  <td width=320 valign=top><p><BR><b>Project Name</b></p></td>
  <td width=600 valign=top><p><BR><INPUT TYPE="TEXT" SIZE="70" value="<?php echo $row->proj_name;?>" NAME="proj_name"></p> </td>
 </tr>
 <tr>
  <td width=320 valign=top><p><BR><b>Project Short Name</b></p></td>
  <td width=600 valign=top><p><BR><INPUT TYPE="TEXT" SIZE="10" value="<?php echo $row->proj_shortname;?>" NAME="proj_shortname"></p> </td>
 </tr>
 
 <tr>
  <td width=320  height=40 valign=center><p><b>Project type</b></p></td>
  <td width=600  height=40 valign=centerp><p><select size="1" name="proj_type">
                <Option <?php if ($row->proj_type=='Corporate') {print "SELECTED";}?> value="Corporate" >Corporate
                <Option <?php if ($row->proj_type=='Business') {print "SELECTED";}?> value="Business">Business
                <Option <?php if ($row->proj_type=='Infrastructure') {print "SELECTED";}?> value="Infrastructure">Infrastructure
                </Select></p>  </td>
 </tr>
 <!-- Deprecated in favour of proj_assessment -->
 <!--
 <tr>
  <td width=320  height=40 valign=center><p><b>Project stage</b></p> </td>
  <td width=600 height=40 valign=center><p><select size="1" name="proj_stage">
                <Option <?php if ($row->proj_stage=='Inception') {print "SELECTED";}?> value="Inception">Inception
                <Option <?php if ($row->proj_stage=='Assessment') {print " SELECTED";}?> value="Assessment">Assessment
                <Option <?php if ($row->proj_stage=='Design') {print "SELECTED";}?> value="Design">Design
                <Option <?php if ($row->proj_stage=='Development') {print "SELECTED";}?> value="Development">Development
                <Option <?php if ($row->proj_stage=='Testing') {print "SELECTED";}?> value="Testing">Testing
                <Option <?php if ($row->proj_stage=='Deployment') {print "SELECTED";}?> value="Deployment">Deployment
                <Option <?php if ($row->proj_stage=='PIR') {print "SELECTED";}?> value="PIR">PIR
                <Option <?php if ($row->proj_stage=='Product') {print "SELECTED";}?> value="Product">Product
                </Select></p> </td>
 </tr>-->
 <tr>
  <td width=320  height=40 valign=center><p><b>Project status</b></p> </td>
  <td width=600 height=40 valign=center><p><select size="1" name="proj_status">
                <Option <?php if ($row->proj_status=='On Schedule') {print "SELECTED";}?> value="On Schedule">On Schedule
                <Option <?php if ($row->proj_status=='Behind Schedule') {print " SELECTED";}?> value="Behind Schedule">Behind Schedule
                <Option <?php if ($row->proj_status=='Postponed') {print "SELECTED";}?> value="Postponed">Postponed
                <Option <?php if ($row->proj_status=='Achieved') {print "SELECTED";}?> value="Achieved">Achieved
                <Option <?php if ($row->proj_status=='Not Achieved') {print "SELECTED";}?> value="Not Achieved">Not Achieved
                <Option <?php if ($row->proj_status=='Overbudget') {print "SELECTED";}?> value="Overbudget">Overbudget
                </Select></p> </td>
 </tr>
  <tr>
  <td width=320  height=40 valign=center><p><b>Project Outcome</b></p> </td>
  <td width=600 height=40 valign=center><p><select size="1" name="proj_outcome_type">
                <Option <?php if ($row->proj_outcome_type=='Compliance') {print "SELECTED";}?> value="Compliance">Compliance
                <Option <?php if ($row->proj_outcome_type=='Strategic') {print " SELECTED";}?> value="Strategic">Strategic
                <Option <?php if ($row->proj_outcome_type=='Core') {print "SELECTED";}?> value="Core">Core
                <Option <?php if ($row->proj_outcome_type=='Speculative') {print "SELECTED";}?> value="Speculative">Speculative
                <Option <?php if ($row->proj_outcome_type=='Support') {print "SELECTED";}?> value="Support">Support
                </Select></p> </td>
 </tr>
<tr>
  <td width=320  height=40 valign=center><p><b>Business Unit</b><br><i> (e.g. Corporate Apps)</i></p> </td>
  <td width=600 height=40 valign=center><p><?php echo $bu; ?></p> </td>
 </tr>
<tr>
  <td width=320  height=40 valign=center><p><b>Financial Year Portfolio</b></p> </td>
  <td width=600 height=40 valign=center><p><?php echo $fyear ?></p> </td>
 </tr>
   <td width=320  height=40 valign=center><p><b>Recommended</b></p> </td>
  <td width=600 height=40 valign=center><p><select size="1" name="recommended">
                <Option <?php if ($row->recommended=='Yes') {print "SELECTED";}?> value="Yes">Yes
                <Option <?php if ($row->recommended=='No') {print " SELECTED";}?> value="No">No
                <Option <?php if ($row->recommended=='Postponed') {print "SELECTED";}?> value="Postponed">Postponed
                </Select></p> </td>
 </tr>

 <tr>
  <td width=320 valign=top><p><b><BR>Brief</b><br><i>Brief description of project purpose</i></p></td>
  <td width=600 valign=top> <BR><p><TEXTAREA COLS="70" ROWS="3" WRAP="ON" MAXLENGTH="1024" NAME="proj_desc"><?php echo $row->proj_desc;?></TEXTAREA></p></td>
 </tr>
 <tr>
  <td width=320 valign=top><p><b><BR>Deliverables</b><br><i>Project Deliverables</i></p></td>
  <td width=600 valign=top> <BR><p><TEXTAREA COLS="70" ROWS="3" WRAP="ON" MAXLENGTH="1024" NAME="proj_deliverables"><?php echo $row->proj_deliverables;?></TEXTAREA></p></td>
 </tr>
 <tr>
  <td width=320 valign=top><p><b><BR>Branches and Impact</b><br><i>Branches and the imapct upon them.</i></p></td>
  <td width=600 valign=top> <BR><p><TEXTAREA COLS="70" ROWS="3" WRAP="ON" MAXLENGTH="1024" NAME="proj_impacts"><?php echo $row->proj_impacts;?></TEXTAREA></p></td>
 </tr> 
 <tr>
  <td width=320 valign=top>
  <p><b>Benefit</b>: <br>
  <i>List Major Benefits to TCC and stakeholders</i></p>
  </td>
  <td width=600 valign=center><p><BR><TEXTAREA COLS="70" ROWS="3" WRAP="ON" MAXLENGTH="1024" NAME="proj_benefits"><?php echo $row->proj_benefits;?></TEXTAREA></p></td>
 </tr>
 <tr>
  <td width=320 valign=top><p><b>Number Users</b></p></td>
  <td width=600 valign=top><p><INPUT TYPE="TEXT" SIZE="3" value="<?php echo $row->proj_nousers;?>" NAME="proj_nousers"></p> </td>
 </tr>
 <tr>
  <td width=320 valign=top><p><b>Required Project Begin Date</b><i>(Format: YYYY-MM-DD)</i></p></td>
  <td width=600 valign=top><p><INPUT TYPE="TEXT" SIZE="10" value="<?php echo $row->proj_begin;?>" NAME="proj_begin">
  <input type="button" value="Cal" onclick="displayCalendar(document.forms[0].proj_begin,'yyyy/mm/dd',this)"></p> </td>
 </tr>
 <tr>
  <td width=320 valign=top><p><b>Required Project End Date</b><i>(Format: YYYY-MM-DD)</i></p></td>
  <td width=600 valign=top><p><INPUT TYPE="TEXT" SIZE="10" value="<?php echo $row->proj_end;?>" NAME="proj_end">
  <input type="button" value="Cal" onclick="displayCalendar(document.forms[0].proj_end,'yyyy/mm/dd',this)"></p> </td>
 </tr>

 <tr>
  <td width=320 valign=top><p><b><BR>Timetable</b><br><i>List project stages and target dates for completions including stages that
  are to be covered by subsequent proposals</i></p> </td>
  <td width=446 valign=center> <p><TEXTAREA COLS="70" ROWS="3" WRAP="ON" MAXLENGTH="1024" NAME="proj_timetable"><?php echo $row->proj_timetable;?></TEXTAREA></p> </td>
 </tr>
 <tr>
  <td width=320 valign=top><p><b>Costs ($)</b> <br><br></p><h2 align=right>&nbsp;</h2>
  <p align=right>&nbsp;</p> <p><b><br> <br> <br><br></b></p>  </td>
  <td width=446 valign=top>
  <table border=1 cellspacing=0 cellpadding=0 width=443>
   <tr>
    <td width=76 valign=top> <p align=center>&nbsp;</p></td>
    <td width=76 valign=top> <p align=center><b>Year 1 <br>$</b></p></td>
    <td width=76 valign=top> <p align=center><b>Year 2<br> $</b></p></td>
    <td width=76 valign=top> <p align=center><b>Year 3<br> $</b></p></td>
    <td width=76 valign=top> <p align=center><b>Year 4<br> $</b></p></td>
    <td width=76 valign=top> <p align=center><b>Cumulative<br>$ Total</b></p></td>
   </tr>
   <tr>
    <td width=76 valign=top><p><b>Capital</b></p></td>
    <td width=10 valign=top><p><INPUT TYPE="TEXT" align=right SIZE="10" value="<?php echo $row->proj_capital_y1;?>" NAME="proj_capital_y1"></p></td>
    <td width=1o valign=top><p><INPUT TYPE="TEXT" align=right SIZE="10" value="<?php echo $row->proj_capital_y2;?>" NAME="proj_capital_y2"></p></td>
    <td width=10 valign=top><p><INPUT TYPE="TEXT" align=right SIZE="10" value="<?php echo $row->proj_capital_y3;?>" NAME="proj_capital_y3"></p></td>
    <td width=76 valign=top><p><INPUT TYPE="TEXT" align=right SIZE="10" value="<?php echo $row->proj_capital_y4;?>" NAME="proj_capital_y4"></p></td>
    <td width=76 align=right valign=top><p><b><?php echo $row->proj_capital_y1+$row->proj_capital_y2+$row->proj_capital_y3+$row->proj_capital_y4;?></b></p></td>
   </tr>
   <tr>
    <td width=76 valign=top><p><b>Recurrent</b></p></td>
    <td width=10 valign=top><p><INPUT align=right TYPE="TEXT" SIZE="10" value="<?php echo $row->proj_other_y1;?>" NAME="proj_other_y1"></p></td>
    <td width=76 valign=top><p><INPUT align=right TYPE="TEXT" SIZE="10" value="<?php echo $row->proj_other_y2;?>" NAME="proj_other_y2"></p></td>
    <td width=76 valign=top><p><INPUT align=right TYPE="TEXT" SIZE="10" value="<?php echo $row->proj_other_y3;?>" NAME="proj_other_y3"></p></td>
    <td width=76 valign=top><p><INPUT align=right TYPE="TEXT" SIZE="10" value="<?php echo $row->proj_other_y4;?>" NAME="proj_other_y4"></p></td>
    <td width=76 align=right valign=top><p><b><?php echo $row->proj_other_y1+$row->proj_other_y2+$row->proj_other_y3+$row->proj_other_y4;?></b></p></td>
   </tr>
   <tr>
    <td width=76 align=right valign=top><p>&nbsp;</p></td>
    <td width=76 align=right valign=top><p>&nbsp;</p></td>
    <td width=76 align=right valign=top><p>&nbsp;</p></td>
    <td width=76 align=right valign=top><p>&nbsp;</p></td>
    <td width=76 align=right valign=top><p>&nbsp;</p></td>
   </tr>
   <tr>
    <td width=10 valign=top><p><b>Savings</b></p></td>
    <td width=10 valign=top><p><INPUT align=right TYPE="TEXT" SIZE="10" value="<?php echo $row->proj_savings_y1;?>" NAME="proj_savings_y1"></p></td>
    <td width=10 valign=top><p><INPUT align=right TYPE="TEXT" SIZE="10" value="<?php echo $row->proj_savings_y2;?>" NAME="proj_savings_y2"></p></td>
    <td width=10 valign=top><p><INPUT align=right TYPE="TEXT" SIZE="10" value="<?php echo $row->proj_savings_y3;?>" NAME="proj_savings_y3"></p></td>
    <td width=10 valign=top><p><INPUT align=right TYPE="TEXT" SIZE="10" value="<?php echo $row->proj_savings_y4;?>" NAME="proj_savings_y4"></p></td>
    <td width=10 align=right valign=top><p><b><?php echo $row->proj_savings_y1+$row->proj_savings_y2+$row->proj_savings_y3+$row->proj_savings_y4;?></b></p></td>
   </tr>
   <tr>
    <td width=76 valign=top><p>Total Net Cost</p></td>
    <td width=76 align=right valign=center><p><b>&nbsp;<?php echo $row->proj_capital_y1+$row->proj_other_y1-$row->proj_savings_y1;?></b></p></td>
    <td width=76 align=right valign=center><p><b>&nbsp;<?php echo $row->proj_capital_y2+$row->proj_other_y2-$row->proj_savings_y2;?></b></p></td>
    <td width=76 align=right valign=center><p><b>&nbsp;<?php echo $row->proj_capital_y3+$row->proj_other_y3-$row->proj_savings_y3;?></b></p></td>
    <td width=76 align=right valign=center><p><b>&nbsp;<?php echo $row->proj_capital_y4+$row->proj_other_y4-$row->proj_savings_y4;?></b></p></td>
    <td width=76 align=right valign=top><p>&nbsp;</p></td>
   </tr>
   <tr>
    <td width=76 valign=top><p><b>Funding (Source)</b></p></td>
    <td width=76 valign=top><p>&nbsp;<INPUT TYPE="TEXT" SIZE="10" value="<?php echo $row->proj_funding_y1;?>" NAME="proj_funding_y1"></p></td>
    <td width=76 valign=top><p>&nbsp;<INPUT TYPE="TEXT" SIZE="10" value="<?php echo $row->proj_funding_y2;?>" NAME="proj_funding_y2"></p></td>
    <td width=76 valign=top><p>&nbsp;<INPUT TYPE="TEXT" SIZE="10" value="<?php echo $row->proj_funding_y3;?>" NAME="proj_funding_y3"></p></td>
    <td width=76 valign=top><p>&nbsp;<INPUT TYPE="TEXT" SIZE="10" value="<?php echo $row->proj_funding_y4;?>" NAME="proj_funding_y4"></p></td>
    <td width=76 valign=top><p>&nbsp</p></td>
   </tr>
  </table>
  <p></p>
  </td>
 </tr>
 <tr>
  <td width=320 valign=top><p><b>FTE Weeks</b> <br><br></p><h2 align=right>&nbsp;</h2>
  <p align=right>&nbsp;</p> <p><b><br> <br> <br><br></b></p>  </td>
  <td width=446 valign=top>
  <table border=1 cellspacing=0 cellpadding=0 width=443>
   <tr>
    <td width=76 valign=top> <p align=center>&nbsp;</p></td>
    <td width=76 valign=top> <p align=center><b>Year 1</b></p></td>
    <td width=76 valign=top> <p align=center><b>Year 2</b></p></td>
    <td width=76 valign=top> <p align=center><b>Year 3</b></p></td>
   </tr>
   <tr>
    <td width=76 valign=top><p><b>Staff Required</b></p></td>
    <td width=10 valign=top><p><INPUT TYPE="TEXT" align=right SIZE="10" value="<?php echo $row->proj_staffreq_y1;?>" NAME="proj_staffreq_y1"></p></td>
    <td width=1o valign=top><p><INPUT TYPE="TEXT" align=right SIZE="10" value="<?php echo $row->proj_staffreq_y2;?>" NAME="proj_staffreq_y2"></p></td>
    <td width=10 valign=top><p><INPUT TYPE="TEXT" align=right SIZE="10" value="<?php echo $row->proj_staffreq_y3;?>" NAME="proj_staffreq_y3"></p></td>
   </tr>
   <tr>
    <td width=76 valign=top><p><b>Applications</b></p></td>
    <td width=10 valign=top><p><INPUT align=right TYPE="TEXT" SIZE="10" value="<?php echo $row->proj_applications_y1;?>" NAME="proj_applications_y1"></p></td>
    <td width=76 valign=top><p><INPUT align=right TYPE="TEXT" SIZE="10" value="<?php echo $row->proj_applications_y2;?>" NAME="proj_applications_y2"></p></td>
    <td width=76 valign=top><p><INPUT align=right TYPE="TEXT" SIZE="10" value="<?php echo $row->proj_applications_y3;?>" NAME="proj_applications_y3"></p></td>
   </tr>
   <tr>
    <td width=10 valign=top><p><b>Consultants</b></p></td>
    <td width=10 valign=top><p><INPUT align=right TYPE="TEXT" SIZE="10" value="<?php echo $row->proj_consultants_y1;?>" NAME="proj_consultants_y1"></p></td>
    <td width=10 valign=top><p><INPUT align=right TYPE="TEXT" SIZE="10" value="<?php echo $row->proj_consultants_y2;?>" NAME="proj_consultants_y2"></p></td>
    <td width=10 valign=top><p><INPUT align=right TYPE="TEXT" SIZE="10" value="<?php echo $row->proj_consultants_y3;?>" NAME="proj_consultants_y3"></p></td>
   </tr>
   <tr>
    <td width=10 valign=top><p><b>Technical</b></p></td>
    <td width=10 valign=top><p><INPUT align=right TYPE="TEXT" SIZE="10" value="<?php echo $row->proj_technical_y1;?>" NAME="proj_technical_y1"></p></td>
    <td width=10 valign=top><p><INPUT align=right TYPE="TEXT" SIZE="10" value="<?php echo $row->proj_technical_y2;?>" NAME="proj_technical_y2"></p></td>
    <td width=10 valign=top><p><INPUT align=right TYPE="TEXT" SIZE="10" value="<?php echo $row->proj_technical_y3;?>" NAME="proj_technical_y3"></p></td>
   </tr>
   <tr>
    <td width=10 valign=top><p><b>Business Unit Experts</b></p></td>
    <td width=10 valign=top><p><INPUT align=right TYPE="TEXT" SIZE="10" value="<?php echo $row->proj_buexpert_y1;?>" NAME="proj_buexpert_y1"></p></td>
    <td width=10 valign=top><p><INPUT align=right TYPE="TEXT" SIZE="10" value="<?php echo $row->proj_buexpert_y2;?>" NAME="proj_buexpert_y2"></p></td>
    <td width=10 valign=top><p><INPUT align=right TYPE="TEXT" SIZE="10" value="<?php echo $row->proj_buexpert_y3;?>" NAME="proj_buexpert_y3"></p></td>
   </tr>   
  </table>
  <p></p>
  </td>
 </tr> 
 <tr>
  <td width=320 valign=top>
  <p><b>Project Board & Management <br></b><i>Identify group, branch, Team with responsibility for project
  management</i></p>
  </td>
  <td width=446 valign=center> <p><TEXTAREA COLS="70" ROWS="3" WRAP="ON" MAXLENGTH="1024" NAME="proj_board"><?php echo $row->proj_board;?></TEXTAREA></p>
  </td>
 </tr>
 <tr>
  <td width=320 valign=top><p><b>Business Contact</b></p> </td>
  <td width=446 valign=top> <p>&nbsp;<INPUT TYPE="TEXT" SIZE="30" value="<?php echo $row->bus_owner;?>" NAME="bus_owner"></p> </td>
 </tr>
 <tr>
  <td width=320 valign=top><p><b>Project Contact</b></p> </td>
  <td width=446 valign=top> <p>&nbsp;<INPUT TYPE="TEXT" SIZE="30" value="<?php echo $row->proj_owner;?>" NAME="proj_owner"></p> </td>
 </tr> 
 <tr>
  <td width=320 valign=top><p><b> Date Created: </b> </p>  </td>
  <td width=446 valign=top> <p>&nbsp;<INPUT TYPE="TEXT" READONLY SIZE="18"
   value="<?php if (isset($row->proj_createdate) && $row->proj_createdate != ''){
            echo $row->proj_createdate;
        } else {
            echo date('Y-m-d H:i:s');
        }?>"
       NAME="proj_createdate"> </p>  </td>
 </tr>
 <tr>
  <td width=320 valign=top><p><b>Last updated:   </b> </p>  </td>
  <td width=446 valign=top> <p>&nbsp;<INPUT TYPE="TEXT" READONLY SIZE="18" value="<?php echo $row->proj_updated;?>" NAME="proj_updated"></p>  </td>
  </tr>
 <tr>
  <td width=320 valign=top><p><b>Notification List:   </b><br><i>Comma seperated email list</i> </p>  </td>
  <td width=446 valign=top><p>&nbsp;<INPUT TYPE="TEXT" SIZE="30" value="<?php echo $row->proj_notify ?>" NAME="proj_notify"></p>
 </tr>
</table>
