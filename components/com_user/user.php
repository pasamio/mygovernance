<?php
	// User Details Page
	// Samuel Moffatt/Toowoomba Regional Council
	$database = JFactory::getDBO();
	$uid = myGovAuth::getUid();
	// Edits an individual user.
if(isset($_REQUEST['task'])) {
	if($_REQUEST['task'] == 'update') { 
		$query = "UPDATE #__users SET name = '{$_REQUEST['name']}' WHERE id = $uid";
		$database->setQuery($query);
		$database->Query();
	}
}
	
	$buttons 	= Array();
	$buttons[] 	= Array('text'=>"Save", 
		'link'=>"javascript:editUser();",
		'image'=>"images/addusers.png",
		'js'=>"editUser();");
	$buttons[] 	= Array('text'=>"Close", 
		'link'=>"index.php",
		'image'=>"images/jdeclose.gif",
		'js'=>"document.location.href='index.php'");		
	myGovHTML::funkyfactory($buttons);

	myGovHTML::printTitle("Edit Details");
	
	$query = "SELECT * FROM #__users WHERE id = $uid";
	$database->setQuery($query);
	$row = $database->loadObject();

//	echo "<p>$uid</p>";
?>

<form action="index.php?option=com_user" method="post" name="mainform">
<input type="hidden" name="m" value="details">
<input type="hidden" name="task" value="update">
<TABLE BORDER=0 BORDERCOLOR="#DEDCFF" BGCOLOR="#DEDCFF"  cellspacing=0 cellpadding=2 width="50%">
	<tr><td>Name:</td><td><INPUT TYPE="TEXT" value="<?php echo $row->name;?>" NAME="name"></td></tr>
</table>

</form>