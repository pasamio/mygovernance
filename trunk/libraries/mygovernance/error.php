<?php
	// Error Handling and Debugging
	// Samuel Moffatt / Toowoomba Regional Council
	class myGovErrorFunctions {
		function dberror($line, $file, $function, $query, $error, $bt=1) {
			echo "<h1>An error has occured!</h1>";
			echo '<p>If you can reproduce this error, please submit a bug report to <a target="_blank" href="http://gforge.toowoomba.qld.gov.au/bugzilla">Bugzilla</a> for this project. Please include the following information:</p>';
			echo '<p>Return to <a href="index.php">myGovernance Home</a></p>';
			echo "<hr>Error Occured at: ".date('Y-m-d H:i:s') . "<br>";
			if($bt) {
				echo "<b>Backtrace:</b><br>";
				echo "<pre>" . myGovCommon::printArray(debug_backtrace()) . "</pre>";
				echo "<hr>";
			}
			echo "<b>Request Variable:</b><br>";
			print_r($_REQUEST);
			echo "<hr><p><b>SQL:</b> ";
			sqlerror($line, $file, $function, $query);
			echo "</p><hr>";
			die( "<p>MySQL Error on $line of $file in $function : $error</p><br><pre>$query</pre><br>");		
		}	
		
		function sqlerror($line, $file, $function, $query) {
			echo("Query ($query) on $line in $file currently executing $function \n");
		}
		
		function doBackTrace() {
			echo "<b>Debugging Backtrace:</b><br>";
	 		echo "<pre>" . myGovCommon::printArray(debug_backtrace()) . "</pre>";
			echo "<hr>";
		}
	}

	// Error Handler Class
	class MyGovError {
		var $set = false;		// If there is a current error
		var $msg = "";			// The error message
		var $code = 0;			// Code for no errors ;)
		var $line = 0;			// Line of Error
		var $err_function = "";	// Function with error
		var $filename = "";		// Filename with error
		var $debug = true;		// Default to debugging
		
		function setError($msg, $code=1, $line=0, $filename=null,$err_function=null, $fatal=0) {
			$this->msg = $msg;
			$this->code = $code;
			$this->line = $line;
			$this->err_function = $err_function;
			$this->filename = $filename;
			$this->set = true;
			if($fatal) { die("<p>Fatal Error " . $this->code ." on line " .$this->line." of ".$this->filename." executing function '".$this->err_function . "': ".$this->msg."</p>"); }
		}
		
		function printError() {
			$this->set = false;
			echo ("<p>Error detected on line <b>".$this->line."</b> of <b>".$this->filename."</b>: ".$this->msg."</p>");
		}
		
		function exists() {
			return $this->set;
		}
		
		function debug() {
			return $this->debug;
		}
	}
?>