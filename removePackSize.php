<?php
	include "c_orderHandler.php";
	
	//this script will have been run by the javascript.
	//call the removepacksize methodfrom the class	
	c_orderHandler::removePackSize($_GET['packIndex']);
?>