<?php
	include "c_orderHandler.php";
	//this script is called ajax in order to enact the class method
	
	c_orderHandler::processOrder($_GET['qty']);
	
?>