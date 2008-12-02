<?php

// Generic HTML items
// Samuel Moffatt / Toowoomba Regional Council

// HTML equiv of 'includes'
class myGovHTML {
	function pageHeader() {
?>
<!--<html>
	<head>
		<title>myGovernance</title>
	</head>
	<body style="margin: 0px"><table width="100%"><tr><td colspan="2"><table border="0" width="100%" cellpadding="0" cellspacing="0">-->
	<tr><td><p style="background: #FFFF88">myGovernance Options: <a href="index.php">Home</a> - <a href="index.php?option=com_user">Change Details</a> - <a href="<?php echo $_SERVER['REQUEST_URI'] ?>">Refresh</a>  - <a href="index.php?option=com_logout">Logout</a></p></td></tr>
<?php

	}
	
	function pageFooter() {
?>		<hr>
<p>&nbsp; &copy; Toowoomba Regional Council, 2005-2007. <a href="index.php?option=com_about">About myGovernance</a></p>
</body>
</html>
<?php
	}
	
	function welcomeBanner($name,$admin) {
?><tr><td><p style="background: #33FF88">Welcome <?php echo $name ?><?php
		if ($admin) {
?>, <a href="index.php?option=com_admin">jump to administration home page</a><?php } ?></p></td></tr><?php
	}
	
	function htmlIncludes() {
?>
			<link href="css/main.css" rel="stylesheet" type="text/css" />
			<script language="JavaScript" src="js/functions.js" type="text/javascript"></script>
<?php

	}

	function printTitle($title) {
?> <span style="vertical-align:middle"><b><font face="Arial size=+4" color="#400040" ><?php echo $title ?></font></b><?php

	}

	// 'Funky' buttons as used in our menu bar
	// HTML/JS encoding from videolan, PHP generator by Samuel Moffatt
	function funkyfactory($buttons) {
		myGovHTML :: funkyTableStart();
		foreach ($buttons as $button) {
			myGovHTML :: funkyButton($button['text'], $button['link'], $button['image'], $button['js']);
		}
		myGovHTML :: funkyTableEnd();
	}

	function funkyTableStart() {
?>
			<table BORDER=2 class="menu" BORDERCOLOR="#004080" ALIGN=Right% >
	             <tr>
		<?php

	}

	function funkyTableEnd() {
?>
				</tr>
			</table>
		<?php

	}

	function funkyButton($text, $link, $image, $js, $width = 32) {
?>
					 <TD class="button"  onMouseOut="this.className='button'" onMouseOver="this.className='button-up'" onMouseDown="this.className='button-down'" onClick="<?php echo $js ?>">
								<TABLE style="margin: 0px;" cellpadding="1" cellspacing="0" border="0">
									<TBODY>
										<TR>
											<TD valign="top"><!--<A href="<?php echo $link ?>">--><IMG class="button" src="<?php echo $image ?>" alt="<?php echo $text ?>" height="35" width="<?php echo $width ?>"><!--</A>-->
											</TD>
											<TD class="button-text"><!--<A href="<?php echo $link ?>">--><?php echo $text ?><!--</A>-->
											</TD>
										</TR>
									</TBODY>
								</TABLE>
							</TD>		
			<?php

	}
}
?>
