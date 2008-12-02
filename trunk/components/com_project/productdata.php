<?php if(!isset($row)) { $row = ""; } ?>
<TABLE BGCOLOR="#DEDCFF" border=0 cellspacing=0 cellpadding=0>
       <TR><TD width=20></td>
	<TD width=920>
	<table border=0 cellspacing=0 cellpadding=0>
	<tr>
	    <td width=320 height=40 valign=center> <p><b>Product Id</b></p></td>
	    <td height=40 valign=center><p><INPUT TYPE="TEXT" ALIGN="LEFT" SIZE="10" MAXLENGTH="10"  value="<?php echo $row->pid;?>" NAME="pid"></p></td>
	</tr>
	 <tr>
  <td width=320  height=40 valign=top><p><b>Product type</b></p></td>
  <td width=600  height=40 valign=center><p><select size="1" name="proj_type">
                <Option <?php if ($row->proj_type=='Corporate') {print "SELECTED";}?> value="Corporate" >Corporate
                <Option <?php if ($row->proj_type=='Business') {print "SELECTED";}?> value="Business">Business
                <Option <?php if ($row->proj_type=='Infrastructure') {print "SELECTED";}?> value="Infrastructure">Infrastructure
                </Select></p>
                <input type="hidden" name="proj_status" value="Product" > </td>
 </tr>
  	<tr>
	    <td width=320 height=40 valign=center> <p><b>Product Name</b></p></td>
	    <td height=40 valign=center><p><INPUT TYPE="TEXT" ALIGN="LEFT" SIZE="80" MAXLENGTH="255" value="<?php echo $row->proj_name;?>" NAME="proj_name"></p></td>
	</tr>
 	<tr>
	    <td  valign=top> <p><b>Business Purpose</b></p></td>
  	    <td  valign=top> <p><TEXTAREA COLS="80" ROWS="3" WRAP="ON" MAXLENGTH="1024" NAME="proj_desc"><?php echo $row->proj_desc;?></TEXTAREA></p> </td>
 	</tr>
 	<tr>
  	    <td width=320 Height=50 valign=center> <p><b>Key Dates</b></p></td>
  	    <td Height=50 valign=top> <p>&nbsp;</p>   </td>
 	</tr>
 	<tr>
  	     <td width=320 valign=top> <p>When Installed</p></td>
  	     <td valign=top><p><INPUT TYPE="TEXT" ALIGN="RIGHT" SIZE="12" MAXLENGTH="12"  value="<?php echo $row->proj_commenced;?>" NAME="proj_commenced"></p></td>
 	</tr>
 	<tr>
	     <td width=320 valign=top> <p>Upgrade/Replace</p></td>
	     <td  valign=top> <p><INPUT TYPE="TEXT" ALIGN="RIGHT" SIZE="12" MAXLENGTH="12"  value="<?php echo $row->proj_completed;?>" NAME="proj_completed"></p></td>
 	</tr>
 	 <tr>
  	     <td width=320 colspan=2 Height=50 valign=center><p><b>Annual Support costs</b></p></td>
  	     <td Height=50 valign=bottom><p>&nbsp;</p></td>
 	</tr>
 	<tr>
  	    <td width=320 valign=top><p>Licenses($)</p></td>
            <td width=284 valign=top><p><INPUT TYPE="TEXT" ALIGN="RIGHT" SIZE="12" MAXLENGTH="12" value="<?php echo $row->proj_capital_y1;?>" NAME="proj_capital_y1"></p></td>
 	</tr>
 	<tr>
  	    <td valign=top><p>Tech. Support($)</p></td>
  	    <td valign=top><p><INPUT TYPE="TEXT" ALIGN="RIGHT" SIZE="12" MAXLENGTH="12" value="<?php echo $row->proj_other_y1;?>" NAME="proj_other_y1"></p></td>
 	</tr>
 	<tr>
  	    <td width=320 valign=top><p>Enhancements($)</p></td>
  	    <td  valign=top><p><INPUT TYPE="TEXT" ALIGN="RIGHT" SIZE="12" MAXLENGTH="12" value="<?php echo $row->proj_other_y2;?>" NAME="proj_other_y2"></p></td>
 	</tr>
 	<tr>
  	     <td height=40 colspan=2 width=250 valign=center><p><b>Annual Savings/Benefits</b></p></td>
  	     <td height=40 width=284 valign=top><p>&nbsp;</p></td>
 	</tr>
 	<tr>
 	     <td  valign=top><p>Actual Savings($)</p></td>
  	     <td  valign=top><p><INPUT TYPE="TEXT" ALIGN="RIGHT" SIZE="12" MAXLENGTH="12" value="<?php echo $row->proj_savings_y1;?>"  NAME="proj_savings_y1"></p></td>
 	</tr>
 	 <tr>
  	     <td  valign=top><p>Cost avoidance($)</p></td>
  	     <td  valign=top><p><INPUT TYPE="TEXT" ALIGN="RIGHT" SIZE="12" MAXLENGTH="12" value="<?php echo $row->proj_savings_y2;?>"  NAME="proj_savings_y2"></p></td>
 	</tr>
 	<tr>
 	     <td height=50 valign=center><p><B>Benefits</B></p></td>
  	     <td height=50 valign=top><p>&nbsp;</p></td>
 	</tr>
	<tr>
  	     <td width=250 valign=top><p>Customer</p></td>
	     <td width=284 valign=top><p><TEXTAREA COLS="80" ROWS="3" WRAP="ON" MAXLENGTH="1024" NAME="proj_benefits"><?php echo $row->proj_benefits;?></TEXTAREA></p></td>
 	</tr>
 	<tr>
  	<td width=250 valign=top><p>Compliance</p></td>
  	<td width=284 valign=top><p><TEXTAREA COLS="80" ROWS="3" WRAP="ON" MAXLENGTH="1024"  NAME="proj_benefits_compliance"><?php echo $row->proj_benefits_compliance;?> </TEXTAREA></p></td>
 	</tr>
 	<tr>
  	<td width=250 valign=top><p>Risk Mitigation</p></td>
  	<td width=284 valign=top><p><TEXTAREA COLS="80" ROWS="3" WRAP="ON" MAXLENGTH="1024"   NAME="proj_benefits_riskmitig"><?php echo $row->proj_benefits_riskmitig;?></TEXTAREA></p></td>
 	</tr>
   	<tr>
  	<td height=40 width=250 valign=center><p><b>Annual Costs</b></p></td>
  	<td height=40 width=284 valign=center><p>&nbsp;</p></td>
 	</tr>
 	<tr>
  	<td  valign=top><p>Actual Cost($)</p></td>
  	<td valign=top><p><INPUT TYPE="TEXT" ALIGN="RIGHT" SIZE="12" MAXLENGTH="12" value="<?php echo $row->proj_capital_y1+
       $row->proj_other_y1+
       $row->proj_other_y2-
       $row->proj_savings_y1?>"></p></td>
 	</tr>
 	<tr>
  	<td  valign=top> <p>Perceived Value($)</p></td>
  	<td  valign=center><p><INPUT TYPE="TEXT" ALIGN="RIGHT" SIZE="12" MAXLENGTH="12" value="<?php echo $row->proj_savings_y1+
       $row->proj_savings_y2
       -($row->proj_capital_y1+
       $row->proj_other_y1+
       $row->proj_other_y2)
       ?>"></p></td>
 	</tr>
 	<tr>
  	<td height=50 width=250 valign=center><p><b>Number users</b></p></td>
  	<td height=50 width=284 valign=bottom><p><INPUT TYPE="TEXT" ALIGN="RIGHT" SIZE="12" MAXLENGTH="12" value="<?php echo $row->proj_nousers;?>" NAME="proj_nousers"></p></p></td>
 	</tr>
 	<tr>
  	<td height=40  valign=center><p><b>Actual User/Cost/Ratio</p></td>
  	<td height=40  valign=center> <p><b>&nbsp;$<?php if($row->proj_nousers != 0) { echo ($row->proj_capital_y1+
       $row->proj_other_y1+
       $row->proj_other_y2-
       $row->proj_savings_y1)/$row->proj_nousers; } ?></p></td>
 	</tr>
 	<tr>
  	<td height=40 width=250 valign=center><p><b>Perceived User/Value Ratio</p></td>
  	<td height=40 valign=center><p><b>&nbsp;$<?php if($row->proj_nousers != 0) { echo ($row->proj_savings_y1+
       $row->proj_savings_y2
       -($row->proj_capital_y1+
       $row->proj_other_y1+
       $row->proj_other_y2))/$row->proj_nousers; }
       ?></p></td>
 	</tr>
    <tr>
  	<td valign=top><p><b> Date Created: </b> </p>  </td>
    <td  valign=top> <p>&nbsp;<INPUT TYPE="TEXT" READONLY SIZE="18"
      value="<?php if (isset($row->proj_createdate)){
            echo $row->proj_createdate;
        } else {
            echo date('Y-m-d H:i:s');
        }?>"
       NAME="proj_createdate"> </p>  </td>
    </tr>
   <tr>
     <td valign=top><p><b>Last updated:   </b> </p>  </td>
     <td  valign=top> <p>&nbsp;<INPUT TYPE="TEXT" READONLY SIZE="18" value="<?php  echo $row->proj_updated;  ?>" NAME="proj_updated"></p>  </td>
 	</tr>
      </td>
     </table>

