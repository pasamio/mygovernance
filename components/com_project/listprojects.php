<?php

$sqlstmt = 'SELECT a.Pid, a.proj_name, a.proj_type, a.proj_owner,a.proj_createdate,a.financialyear,a.proj_assessment, count(b.drf) AS doccount from projects AS a LEFT JOIN documents AS b ON a.pid = b.project ';
$sqlwhere = "";

if (!isset ($p)) {
	$p = "*";
}
if (!isset ($ptype)) {
	$ptype = "*";
}
if (!isset ($pstatusx)) {
	$pstatusx = 'On Schedule,Behind Schedule,Overbudget';// Default view
}
if (!isset ($pstate)) {
	$pstate = '*';
}
if ($p != '*') {
	$sqlwhere = 'where ' . 'a.pid="' . $p . '"';
}
if ($ptype != '*') {
	if ($sqlwhere != "") {
		$sqlwhere = $sqlwhere . ' and ' . 'a.proj_type="' . $ptype . '" ';
	} else {
		$sqlwhere = ' where ' . 'a.proj_type="' . $ptype . '" ';
	}
}

if($pstatusx != '*') {
	if($sqlwhere != '') {
		$sqlwhere .= ' AND a.proj_status IN ("'. implode('","',explode(',', $pstatusx)).'") ';
	} else {
		$sqlwhere = ' where a.proj_status IN ("'. implode('","',explode(',', $pstatusx)).'") ';
	}	
}

if (!myGovCommon::in_string("where", $sqlwhere)) {
	$sqlwhere .= " WHERE";
} else {
	$sqlwhere .= " AND";
}

$sqlwhere .= ' a.proj_hide = 0';
$sqlwhere .= ($pstate != '*') ? ' AND a.proj_assessment = ' . $pstate : '';
$sqlorder = " ORDER BY ";
if (isset ($_REQUEST['fieldorder'])) {
	$sqlorder .= 'a.' . $_REQUEST['fieldorder'];
	if (isset ($_REQUEST['fieldordermode'])) {
		$sqlorder .= ' ' . $_REQUEST['fieldordermode'];
	}
	$sqlorder .= ', ';
}
$sqlorder .= " a.pid ASC ";

$sqlgroup = ' GROUP BY a.pid';

$query = $sqlstmt . $sqlwhere . $sqlgroup . $sqlorder;
$database = JFactory::getDBO();
$database->setQuery($query);
$std = $database->Query();

$buttons[] = Array (
	'text' => "Find Project",
	'link' => "javascript:findProject();",
	'image' => "images/jdefind.gif",
	'js' => "javascript:findProject();"
);
$buttons[] = Array (
	'text' => "Add Project",
	'link' => "index.php?option=com_project&task=viewproject&mt=project&p=*",
	'image' => "images/jdeadd.gif",
	'js' => "window.location='index.php?option=com_project&task=viewproject&mt=project&p=*';"
);
/*	$buttons[] 	= Array('text'=>"Add Product", 
		'link'=>"index.php?option=com_project&task=viewproject&mt=product&p=*",
		'image'=>"images/jdeadd.gif",
		'js'=>"window.location='index.php?option=com_project&task=viewproject&mt=product&p=*';");*/
$buttons[] = Array (
	'text' => "Reports",
	'link' => "index.php?option=com_reports",
	'image' => "images/jderowexit.gif",
	'js' => "window.location='index.php?option=com_reports';"
);

?> 

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
        <FORM ACTION="index.php?option=com_project&task=listproject" METHOD="POST" name="mainform">
<input type="hidden" name="find" value="findproject">
        
             <table BORDER=0 BORDERCOLOR="#004080" ALIGN="LEFT" CELLPADDING="10">
             <tr height=40>
                 <Td width=80> Project Id: </td>
                 <td><input name="p" value=<?php echo $p;?> type=text align=LEFT size=3 maxlength=5 /></td>
                 <td width=120> Project Type: </td>
                 <td align="left">
                <select size="1" name="ptype">
                <Option <?php if ($ptype=='*')  { echo "SELECTED" ;} ?> value="*" >All
                <Option <?php if ($ptype=='Corporate') { echo "SELECTED";} ?> value="Corporate" >Corporate
                <Option <?php if ($ptype=='Business') { echo "SELECTED";} ?> value="Business">Business
                <Option <?php if ($ptype=='Infrastructure') { echo "SELECTED";} ?> value="Infrastructure">Infrastructure
                </Select></td>
         		<td> Project Status: </td>
         		<td align="left">
	         		<select size="1" name="pstatusx">
	                <Option <?php if ($pstatusx=='On Schedule,Behind Schedule,Overbudget') { echo "SELECTED";} ?> value="On Schedule,Behind Schedule,Overbudget" >In Progress
	                <Option <?php if ($pstatusx=='Postponed') { echo "SELECTED";} ?> value="Postponed">Postponed
	                <Option <?php if ($pstatusx=='Achieved,Not Achieved') { echo "SELECTED";} ?> value="Achieved,Not Achieved">Complete
	                <Option <?php if ($pstatusx=='*')  { echo "SELECTED" ;} ?> value="*" >All
	                </Select>
                </td>
                <td align="left">
                	<select size="1" name="pstate">
					<option <?php if($pstate=='-1') { echo 'SELECTED'; } ?> value="-1" >Rejected</option>
					<option <?php if($pstate=='0') { echo 'SELECTED'; } ?> value="0" >Normal</option>
					<option <?php if($pstate=='1') { echo 'SELECTED'; } ?> value="1" >Requesting Assessment</option>
					<option <?php if($pstate=='2') { echo 'SELECTED'; } ?> value="2" >Pending</option>
                	<option <?php if($pstate=='3') { echo 'SELECTED'; } ?> value="3" >Approved</option>
                	<option <?php if($pstate=='*') { echo 'SELECTED'; } ?> value="*" >All</option>
                	</select>
              </tr>
           </table>
           </FORM>
        </td>         			
    </tr>
    <tr>
              <td>
              
              <table BORDER=1 BORDERCOLOR="#DEDCFF" BGCOLOR="#DEDCFF" ALIGN=Right WIDTH="100%" >
    		  	<tr>
    		  		<td width="5%" align=center>&nbsp</td>
    		  		<td width="5%" align=center>Proj Id</td>
			  		<td width="5%" NOWRAP>Financial Year <a href="index.php?fieldorder=financialyear&fieldordermode=asc"><img src="images/uparrow.png" border="0"></a><a href="index.php?fieldorder=financialyear&fieldordermode=desc"><img src="images/downarrow.png" border="0"></a> </td>
              		<td width="30%" NOWRAP>Project Name <a href="index.php?fieldorder=proj_name&fieldordermode=asc"><img src="images/uparrow.png" border="0"></a><a href="index.php?fieldorder=proj_name&fieldordermode=desc"><img src="images/downarrow.png" border="0"></a> </td>
              		<td width="10%" NOWRAP ALIGN=CENTER> Project type <a href="index.php?fieldorder=proj_type&fieldordermode=asc"><img src="images/uparrow.png" border="0"></a><a href="index.php?fieldorder=proj_type&fieldordermode=desc"><img src="images/downarrow.png" border="0"></a></td>
                	<td width="15%" NOWRAP ALIGN=CENTER> Project Owner <a href="index.php?fieldorder=proj_owner&fieldordermode=asc"><img src="images/uparrow.png" border="0"></a><a href="index.php?fieldorder=proj_owner&fieldordermode=desc"><img src="images/downarrow.png" border="0"></a></td>
                	<td width="10%" NOWRAP ALIGN=CENTER> Date <a href="index.php?fieldorder=proj_createdate&fieldordermode=asc"><img src="images/uparrow.png" border="0"></a><a href="index.php?fieldorder=proj_createdate&fieldordermode=desc"><img src="images/downarrow.png" border="0"></a></td>
                	<td width="5%">Status <a href="index.php?fieldorder=proj_assessment&fieldordermode=asc"><img src="images/uparrow.png" border="0"></a><a href="index.php?fieldorder=proj_assessment&fieldordermode=desc"><img src="images/downarrow.png" border="0"></a></td>
                	<td width="1%">Doc Count</td>
            	</tr>
<?php
if ($database->getNumRows()) {
	$rows = $database->loadRowList();
	foreach ($rows as $row) {
		print "<tr><td><a href=index.php?option=com_project&task=viewproject&p=$row[0]><img src=images/pencil2.gif width=20 height=20 border=0/></a>";
		if ($row[3] != 'Product') {
			print "<a href=\"index.php?option=com_reports&task=radar&p=$row[0]&linkbar=1&embed=1\"><img src=images/binocular.gif width=20 height=20 border=0/></a> " .
			"<a href=index.php?option=com_project&task=projresponse&qtype=Risk&p=$row[0]><img src=images/assesment.gif width=20 height=20 border=0/></a>" .
			"<a href=\"index.php?option=com_project&task=docs&projectid={$row[0]}\"><img src=images/attachfind.gif width=20 height=20 border=0/></a>";
		}

		$assessmentstatus = myGovCommon::assessmentStatusToString($row[6]);
		print "</td>" .
		"<td ALIGN=CENTER>$row[0]</td>" .
		"<td>&nbsp;$row[5]</td>" .
		"<td>$row[1]</td>" .
		"<td ALIGN=CENTER>&nbsp;$row[2]</td>" .
		"<td ALIGN=CENTER width=10%>&nbsp;$row[3]</td>" .
		"<td ALIGN=CENTER width=10%>&nbsp;$row[4]</td>" .
		"<td ALIGN=CENTER>&nbsp;$assessmentstatus</td>" .
		'<td ALIGN=CENTER><a href="index.php?option=com_project&task=docs&projectid=' . $row[0] . '">' . $row[7] . '</a></td>' .
		"</tr>";
	}
?></table>
        </td>
   	 </tr>
    </table><?php

} else {
	print "No Results";
}
?>
