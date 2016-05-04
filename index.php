<?php

/*
	name		: index.php
	programmer	: mikey stewart
	what's it do: 	this is the entry point for the wallys widget website.  A simple page with forms that uses ajax/javascript call 
					to take the user input and then calls a php script calling the appropriate method in the c_orderHandler, this class handles
					all the basic functionality concerning packs and orders.
					
					put simply, the buttons on this page call a javascript function, which calls an ajax function, which in turn runs a php script
					 which finally calls the appropriate method in the c_orderHandler class.
					
					if I had more time I would have spent a bit more time working on the style/appearance of the page, and other stuff like
					input validation (at the moment there's nothing to stop you from entering alphabetic characters into the textboxes)
*/

session_start();
if(isset($_SESSION['boxSizes']) == FALSE)
{	
	$_SESSION['boxSizes'] = array(250, 500, 1000, 2000, 5000);	
}

echo"
<html>
	<head>
		<script src='script.js'></script>
		<link rel='stylesheet' type='text/css' href='style.css'/>
		<title>Adhere Test: Mikey Stewart</title>
	</head>
	
	<body>
		<div id='header'>
			<div id='headerText'>Wally's Widget Company</div>
			 <div id='headerBlurb'>
				This is a simple webpage that allows you to order a given number of widgets from Wally's Widgets.  The company only provide packs of widgets of specified amounts.
				The user enters the desired amount of widgets and the webpage will work out how many packs of which quantities are needed to satisfy the order. For example: an order
				of 12001 packs will cause the system to yield 5000*2, 2000*1 and 250*1
				The initial pack sizes are 5000, 2000, 1000, 500 and 250 widgets, but the user is able to change the packs.<!---->
			</div>
		</div>
		
		<div id='orderSection'>
			<div id='sectionHeader'>Place Order</div>
			
			<div id='orderForm'>
				<form action='processOrder.php' method='post'>
					<table>
						<tr>
							<td><input class='wwTextBox' type='text' id='qty'></input></td>							
							<td><button class='wwButton' type='button' onClick='processOrder()'>Place Order</button></td>
						</tr>
					</table>
				</form>	
			</div>

			<div id='orderFormOutput'>
				
			</div>
		</div>
		
		<div id='packSection'>
			<div id='sectionHeader'>Available Packs</div>
			<div id='packSectionPacks'>
				<table >";
					for ($i=0; $i < sizeof($_SESSION['boxSizes']); $i++)
					{
						echo"
						<tr>
							<td><input class='wwTextBox' type='text' value='".$_SESSION['boxSizes'][$i]."' id='packSize_".$i."'></input></td>
							<td><button class='wwButton' type='button' onClick='editPackSize(".$i.")'>Change Pack Size</button></td>
							<td><button class='wwButton' type='button' onClick='removePackSize(".$i.")'>Remove Pack Size</button></td>
						</tr>";					
					}
					echo"
					<tr>
						<td colspan='2'><input class='wwTextBox' type='text' style='width:100%' id='newSizeEntry'></input></td>
						<td><button class='wwButton' type='button' style='width:100%' onClick='addPackSize()'>Add Pack Size</button></td>					
					</tr>";
				echo"
				</table>	
			</div>
			<div id='packSectionOutput'>
				
			</div>
		</div>
		
	</body>
</html>";
?>