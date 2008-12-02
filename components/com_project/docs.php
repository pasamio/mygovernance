<?php
	$database = JFactory::getDBO();
	$buttons 	= Array();
	$tmppid = $_REQUEST['projectid'] ? $_REQUEST['projectid'] : 0;
	$buttons[] 	= Array('text'=>"Home", 
		'link'=>"index.php",
		'image'=>"images/frontpage.png",
		'js'=>"document.location.href='index.php'");
	$buttons[] 	= Array('text'=>"Add Document", 
		'link'=>"javascript:addDoc();",
		'image'=>"images/backup.png",
		'js'=>"javascript:addDoc();");
	$buttons[] = Array('text'=>"Back to Project",
		'link'=>"index.php?option=com_project&task=viewproject&p=".$tmppid,
		'image'=>"images/forward_f2.png",
		'js'=>"document.location.href='index.php?option=com_project&task=viewproject&p=".$_REQUEST['projectid']."'" );
	$task = isset($_REQUEST['sqlaction']) ? $_REQUEST['sqlaction'] : 'default';
	switch($task) {
			case 'adddoc':
				if(isset($_POST['docid'])) {
					if(isset($_REQUEST['projectid'])) {
						if($_POST['docid'] && $_REQUEST['projectid']) {
							$docid = intval($_POST['docid']);
							$projectid = intval($_REQUEST['projectid']);
							$query = "INSERT INTO documents VALUES('$docid','{$_POST['title']}','$projectid')";
							$database->setQuery($query);
							$database->Query(); // or eval($__SQLERROR);
						} else {
							echo 'Failed to add document due to invalid or missing document or project identifier.';
						}
					} else {
						echo 'Missing Project ID. Could not add document.';
					}
				}
				break;
			case 'deldoc':
				if(isset($_REQUEST['docid']) && isset($_REQUEST['projectid'])) {
					if($_REQUEST['docid'] && $_REQUEST['projectid']) {
						$database->setQuery("DELETE FROM documents WHERE project = '{$_REQUEST['projectid']}' AND drf = '{$_REQUEST['docid']}'");
						$database->Query();
						echo 'Document Removed.';
					}
				}
				break;
			default:
				//echo "I'm the default! :D - $task - " . $_REQUEST['sqlaction'];
				break; 					
	}
	
	$database->setQuery("SELECT * FROM documents WHERE project = {$_REQUEST['projectid']}");
	$database->Query();// or eval($__SQLERROR);
	$rows = $database->loadAssocList();
?>
<Form method=post action="index.php?option=com_project&task=docs&projectid=<?php echo $_REQUEST['projectid'] ?>" name="mainform" id="mainform">
<input type="hidden" name="sqlaction" value="">
<table BORDER=0 BORDERCOLOR="#0000A0" ALIGN="Right" WIDTH=950>
   <tr>
          <td WIDTH=950 ALIGN=LEFT>
           <span style="vertical-align:middle"><b>
           <font face="Arial size=+4" color="#400040" >Documents </font>
           </b></span>
          </td>
   </tr>
</table>
<?php myGovHTML::funkyfactory($buttons); ?>
<p>Enter new DM document ID: <input type="text" name="docid"> Comment: <input type="text" name="title"></p><br>
<table   BORDERCOLOR="#DEDCFF" bGCOLOR="#DEDCFF" ALIGN=LEFT BORDER=0ALIGN=Right WIDTH=800>
	<tr>
		<th>Document ID</th><th>Title</th>
	</tr>
	<?php
		foreach($rows as $row) {
			echo '<tr><td><a href="drf.php?drf='.$row['drf'].'">'.	$row['drf'] . '</a><a href="index.php?option=com_project&task=docs&projectid='.$row['project'].'&docid='. $row['drf'] .'&sqlaction=deldoc"><img border="0" src="images/publish_x.png"></a></td>';
			echo '<td>' . $row['title'] . '</td></tr>';	
		}
	?>
</table>
		
</form>
</td></tr></table>