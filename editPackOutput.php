<?php
	include "c_orderHandler.php";
	
	echo"
		pack edited: packet number ".($_GET['packIndex']+1)." changed to ".$_GET['packSize']." widgets<br>
	";
?>