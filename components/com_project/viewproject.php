<?php
global $db, $dbc, $database;
  //interfaces requirements
  // use this module for both projects and products so need entry to identify type
  // also need Project_no to be passed
  // if project_no new then Project_no=*
  // then must request name, ptype,pstatus
  // and create project and pass back to here
  // url=
  if ($p!='*') {
  	$sqlstmt='SELECT a.*, count(b.drf) AS doccount From projects AS a LEFT JOIN documents AS b ON a.pid = b.project where pid =';
  	$sqlwhere=$p;  
  	$sqlgroup = ' GROUP BY a.pid';
  	$query = $sqlstmt.$sqlwhere.$sqlgroup;
  	$database->setQuery($query);
  	$std = $database->Query(); 
  	if($database->getNumRows()) {
	  $row = $database->loadObject();
  	}
	$row->proj_stage = isset($row->proj_stage) ? $row->proj_stage : "Inception";  
    if ($row->proj_stage=='Product') {
    	$mt='product';
    } else {
    	$mt='project';
    }	
  } else {
  	if($p == 0) {
		?><a href="index.php">Return to list page</a><?php
	}
  }
  if($p == "*") { $tp = "0"; }
 ?>
<Form method=post action="index.php?option=com_project&task=listproject" name="mainform" id="mainform">
<input type="hidden" name="sqlaction" value="">
<table BORDER=0 BORDERCOLOR="#0000A0" ALIGN="Right%" WIDTH=950>
   <tr>
          <td WIDTH=950 ALIGN=LEFT> <span style="vertical-align:middle"><b><font face="Arial size=+4" color="#400040" >
<?php
	if(!isset($mt)) { $mt = ""; }
    if ($mt=='project'){
?>
Maintain Project Data
<?php
} else {
?>
Maintain Product Data
<?php }



?>
            </font></b></td>
          </tr>
<?php

	$buttons 	= Array();
	$buttons[] 	= Array('text'=>"Save", 
		'link'=>"javascript:updateProject();",
		'image'=>"images/save.gif",
		'js'=>"javascript:updateProject();");
	$buttons[] 	= Array('text'=>"Delete", 
		'link'=>"javascript:DeleteProject();",
		'image'=>"images/jdedelete.gif",
		'js'=>"javascript:DeleteProject();");
	$buttons[] 	= Array('text'=>"Close", 
		'link'=>"index.php",
		'image'=>"images/jdeclose.gif",
		'js'=>"document.location.href='index.php'");
	$user = JFactory::getUser();
	$results = $mainframe->triggerEvent("onViewProjectMenu", Array('username'=>$user->username));
	if(is_array($results)) {
		foreach($results as $result) {
			if($result) {
				foreach($result as $item) {
					$buttons[] = $item;
				}
			}
		}
	}
						
?>		 
    <tr>
           <td  BGCOLOR="#F3F2ED" ALIGN=LEFT>
		   <?php myGovHTML::funkyfactory($buttons); ?>
         </td>
    </tr>
   <tr>

    <tr>
    <td>
 <?php
 if ($mt=='project') {
    include 'projectdata.php';
 } else {
    include 'productdata.php';
 };
  ?>

   
</td></tr></table>
  </FORM>