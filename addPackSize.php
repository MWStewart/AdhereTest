<?php
	include "c_orderHandler.php";
	
	//this script will have been run by the javascript.
	//call the addpacksize function from the class	
	c_orderHandler::addPackSize($_GET['newEntry']);
?>