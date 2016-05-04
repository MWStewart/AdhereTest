<?php
	include "c_orderHandler.php";
	
	//this script will have been run by the javascript.
	//call the editpacksize function from the class	
	c_orderHandler::editPackSize($_GET['packIndex'], $_GET['packSize']);
?>