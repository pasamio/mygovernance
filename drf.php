<?php
/*
 * Create a valid DRF file.
 * Created on May 19, 2006
 *
 */
if(isset($_GET['drf'])) {
	$ref = $_GET['drf'];
	header ("Content-Type: application/octet-stream; name=$ref.drf");
	header ("Content-Disposition: attachment; filename=$ref.drf");
	echo "Document;DOCS;$ref;R";
}
?>
