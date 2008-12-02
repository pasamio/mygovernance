<?php
$database = JFactory :: getDBO();
function typeSelectBox($selected = NULL) {
?><select name="qtype" >
		<option value="Risk" <?php if($selected == 'Risk') { echo "SELECTED"; } ?>>Risk</option>
		<option value="Strategic Alignment" <?php if($selected == 'Strategic Alignment') { echo "SELECTED"; }?>>Strategic Alignment</option>
		<option value="Direct Value Return" <?php if($selected == 'Direct Value Return') { echo "SELECTED"; }?>>Direct Value Return</option>
		<option value="Business Process Impact" <?php if($selected == 'Business Process Impact') { echo "SELECTED"; }?>>Business Process Impact</option>
		<option value="Architecture" <?php if($selected == 'Architecture') { echo "SELECTED"; }?>>Architecture</option>
		<option value="Technical Risk" <?php if($selected == 'Technical Risk') { echo "SELECTED"; }?>>Technical Risk</option>
		<option value="Compliance" <?php if($selected == 'Compliance') { echo "SELECTED"; }?>>Compliance</option>
		</select>
<?php

}

// Ensure locking procedure
$locked = 0;
if (!$locked) {
	if (isset ($qid)) {
		$sqlstmt = 'SELECT * FROM pquestions WHERE qid = ';
		$sqlwhere = $qid;
		$query = $sqlstmt . $sqlwhere;
		$database->setQuery($query);
		$database->Query();
		$row = $database->loadObject();
	}
	if (!isset ($p)) {
		$p = 0;
	}
	if (!isset ($qtype)) {
		$qtype = "Risk";
	}

	$buttons = Array ();
	$buttons[] = Array (
		'text' => "Update Response",
		'link' => "javascript:updateResponse();",
		'image' => "images/save.gif",
		'js' => "javascript:updateResponse();"
	);
	$buttons[] = Array (
		'text' => "Delete",
		'link' => "javascript:DeleteResponse();",
		'image' => "images/jdedelete.gif",
		'js' => "javascript:DeleteResponse();"
	);
	$buttons[] = Array (
		'text' => "Close",
		'link' => "javascript:history.go(-1);",
		'image' => "images/jdeclose.gif",
		'js' => "javascript:history.go(-1);"
	);
?>
<Form method="post" action="index.php?option=com_project&task=projresponse" name="mainform">
<input type="hidden" name="sqlaction" value="">
<input type="hidden" name="pid" value="<?php echo $p ?>">
<input type="hidden" name="p" value="<?php echo $p ?>">
<input type="hidden" name="qtype" value="<?php echo $qtype ?>">
<table BORDER=0 BORDERCOLOR="#0000A0" ALIGN="Right%" WIDTH=980>
   <tr>
          <td WIDTH=950 ALIGN=LEFT> <span style="vertical-align:middle"><b><font face="Arial size=+4" color="#400040" > Maintain Project Assessment - Values and Risks</font></b></td>
          </tr>
    <tr>
           <td  BGCOLOR="#F3F2ED" ALIGN=LEFT>
		   <?php myGovHTML::funkyfactory($buttons) ?>
         	</td>
    </tr>
    <tr>
		<td>             
   
<?Php

	$totalweight = 0;
	$line = 0;
	if (!isset ($row)) {
		$row = "";
	}
	//      $weight=$row->qwt*$row->score/100;
	//      $totalweight=$totalweight+$weight;
	$name1 = 'qid' . $line;
	$name2 = 'score' . $line++;
?>
              <table BORDER=1 BORDERCOLOR="#DEDCFF" bGCOLOR="#DEDCFF" ALIGN=Right% >
    		  <tr><td width="20%">Item Number:</td><td><input type="text" READONLY name="qid" value="<?php echo $row->qid ?>"></td></tr>
			  <tr><td width="20%">Type:</td><td><?php typeSelectBox($row->qtype) ?></td></tr>
              <tr><td width="20%">Text:</td><td><textarea cols="30" rows="5" name="qtext"><?php echo $row->qtext ?></textarea></td></tr>
			  <tr><td width="20%">Rating 0:</td><td><textarea cols="30" rows="5" name="qv0"><?php echo $row->qv0 ?></textarea></td></tr>
              <tr><td width="20%">Rating 1:</td><td><textarea cols="30" rows="5" name="qv1"><?php echo $row->qv1 ?></textarea></td></tr>
              <tr><td width="20%">Rating 2:</td><td><textarea cols="30" rows="5" name="qv3"><?php echo $row->qv3 ?></textarea></td></tr>
              <tr><td width="20%">Rating 4:</td><td><textarea cols="30" rows="5" name="qv4"><?php echo $row->qv4 ?></textarea></td></tr>			  
              <tr><td width="20%">Weight:</td><td><input type="text" name="qwt" value="<?php echo $row->qwt ?>"></td></tr>
            </tr>
		</table>
        </td>
    </tr>    
    </table>
	</td>
    </tr>    
    </table>
  </FORM>
  <?php } else { echo "<p>This section has been locked</p>"; } ?>