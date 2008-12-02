<?php
	// Administrator Interface - Add user
	// Samuel Moffatt/Toowoomba Regional Council
	$database = JFactory::getDBO();
	function userTypeSelectBox($type) {
		echo "<select name=\"usertype\">";
		
		echo "<option value=\"Administrator\"";
		if($type == "administrator") { echo " SELECTED "; }
		echo ">Administrator</option>";
		
		echo "<option value=\"User\"";
		if($type == "User") { echo " SELECTED "; }
		echo ">User</option></select>";
	}
	
	
	$buttons 	= Array();
	$buttons[] 	= Array('text'=>"Save", 
		'link'=>"javascript:editUser();",
		'image'=>"images/addusers.png",
		'js'=>"editUser();");
	$buttons[] 	= Array('text'=>"Close", 
		'link'=>"index.php?option=com_admin",
		'image'=>"images/jdeclose.gif",
		'js'=>"document.location.href='index.php?option=com_admin&task=listusers'");		
	myGovHTML::funkyfactory($buttons);

	myGovHTML::printTitle("Edit User");
	
	$uid = 0;
	if(isset($_REQUEST['uid'])) { $uid = $_REQUEST['uid']; }
	
	$query = "SELECT * FROM #__users WHERE id = $uid";
	$database->setQuery($query);
	$row = $database->loadObject();
?>
<form action="index.php?option=com_admin" method="post" name="mainform">
<input type="hidden" name="m" value="admin">
<input type="hidden" name="task" value="update">
<TABLE BORDER=0 BORDERCOLOR="#DEDCFF" bGCOLOR="#DEDCFF"  cellspacing=0 cellpadding=2 width="50%">
	<tr><td>User ID:</td><td><INPUT TYPE="TEXT" READONLY SIZE="5" ALIGN="RIGHT" value="<?php echo $uid ?>" NAME="uid"></td></tr>
	<tr><td>Name:</td><td><INPUT TYPE="TEXT" value="<?php echo $row->name;?>" NAME="name"></td></tr>
	<tr><td>Username:</td><td><INPUT TYPE="TEXT" value="<?php echo $row->username;?>" NAME="username"></td></tr>	
	<tr><td>User Type:</td><td><?php userTypeSelectBox($row->usertype) ?></td></tr>
</table>

</form>