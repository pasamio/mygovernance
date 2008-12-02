<?php
	// Administrator Interface - List users
	// Samuel Moffatt/Toowoomba Regional Council
	$database = JFactory::getDBO();
	
	$buttons 	= Array();
	$buttons[] 	= Array('text'=>"Add User", 
		'link'=>"index.php?option=com_admin&task=adduser",
		'image'=>"images/addusers.png",
		'js'=>"document.location.href='index.php?option=com_admin&task=adduser'");
	$buttons[] 	= Array('text'=>"Close", 
		'link'=>"index.php?option=com_admin",
		'image'=>"images/jdeclose.gif",
		'js'=>"document.location.href='index.php?option=com_admin'");
	myGovHTML::funkyfactory($buttons);

	myGovHTML::printTitle("Users");	
?>

              <table BORDER=1 BORDERCOLOR="#DEDCFF" bGCOLOR="#DEDCFF" ALIGN=Right width=100% >
    		  <tr><td width="4%" align=center>&nbsp</td>
    		  <td width=5% align=center>User Id</td>
                <td width=30%>Name</td>
                <td width=15% ALIGN=CENTER> User Name </td>
                <td width=15% ALIGN=CENTER> User Type </td>
            </tr>
			
<?php
	$query = "SELECT * FROM #__users ORDER BY username";
	$database->setQuery($query);
	$database->Query();
	if ($database->getNumRows()) {

		$rows = $database->loadAssocList();
		foreach($rows as $row) {
			echo "<tr><td width=\"4%\" ><a href='index.php?option=com_admin&task=deluser&uid={$row['id']}'><img src='images/publish_x.png' border=0></a><a href='index.php?option=com_admin&task=edituser&uid={$row['id']}'><img src=images/edit.png width=16 height=16 border=0/></td><td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['username']}</td><td>{$row['usertype']}</td></tr>";
        }
	}
		

	echo "	</table>";
?>