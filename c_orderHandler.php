<?php
	/*
		name: c_orderHandler.php
		programmer: mikey stewart
		what is it: this class holds the main functionality of this app.  handles incoming orders and the adding, removal and editing of available packs in the array.
	*/
	
	class c_orderHandler
	{
		//properties		
		private static $result; //this is used to return the final list of packs needed to satisfy the order	
		
		
		//methods
		/*
			c_orderHandler::init()
			this is run when the page is first loaded, nothing more than some basic, but necessary initialisation
		*/
		static function init()
		{
			session_start();				
			self::$result = array();  //this is used to return the final list of packs needed to satisfy the order				
		}
	
		
		
		/*
			c_orderHandler::processOrder()
			
			handles the incoming order. the way it works is that it starts with the biggest pack in the array and compares that with the required
			order amount.  if the order amount is bigger than the pack size, then the pack size amount is subtracted from the order amount and the 
			pack size is added to the result array (this is what we use to display the results after the method is done), otherwise, we check
			the next pack size down.  This continues until the order is satisfied.  
		*/
		public static function processOrder($n_totalNeeded)
		{				
			$b_done = false;		
			
			//sort the array, 
			sort($_SESSION['boxSizes']);			
			
			$n_boxSizeIndex = sizeof($_SESSION['boxSizes']) - 1;			
			
			$n_resultIndex = 0;								
			
			while($b_done == false)
			{				
				if($_SESSION['boxSizes'][$n_boxSizeIndex] <= $n_totalNeeded)				
				{
					$n_totalNeeded = $n_totalNeeded - $_SESSION['boxSizes'][$n_boxSizeIndex];						
					self::$result[$n_resultIndex] = $_SESSION['boxSizes'][$n_boxSizeIndex];					
					++$n_resultIndex;					
					if($n_totalNeeded <= 0)
					{
						echo"Final order breakdown: <br>";						
						$fResult = array_count_values(self::$result);
						foreach ($fResult as $key => $value)
							echo $key." x ".$value."<br>";								
						
						$b_done = true;					
					}
				}
				else
				{
					//if($n_totalNeeded <= 250)
					if($n_totalNeeded <= $_SESSION['boxSizes'][0]) //the smallest one
					{						
						/*
						add 250 to result array
						set done to true
						*/
						
						self::$result[$n_resultIndex] = $_SESSION['boxSizes'][0];
						echo"Final order breakdown: <br>";							
						
						/*if there are two 250 packs in the results array (say if the order was for 251 packs), remove them and replace them a single 500*/											
						$check = array_count_values(self::$result); //get a count of each value in the array
												
						//if there are two 250s..									
						if(array_key_exists(250, $check) == true) //make sure 250 IS in the results array (checkindex, holds the key, not the index)		
						{						
							if(($check[250] == 2)) //need to make sure this array HAS 250 in it before we hit this line
							{								
								//remove the offending elements								
								$duplicatesRemoved = false;
								while($duplicatesRemoved == false)
								{
									$targetIndex = array_search(250, self::$result);
									if($targetIndex !== false)									
										unset(self::$result[$targetIndex]);								
									else									
										$duplicatesRemoved = true;									
								}
								
								$lastIndex = sizeof(self::$result);
								if($lastIndex == 0)
									self::$result[$lastIndex] = 500;
								else
									self::$result[$lastIndex - 1] = 500;								
		
								$fResult = array_count_values(self::$result);
								foreach ($fResult as $key => $value)
									echo $key." x ".$value."<br>";											

								$b_done = true;	
							}
						}
						
						
						if($b_done == false)
						{							
							$fResult = array_count_values(self::$result);
							foreach ($fResult as $key => $value)
								echo $key." x ".$value."<br>";						
							
							$b_done = true;							
						}											
					}
					else					
						--$n_boxSizeIndex;					
				}
			}
			
			return self::$result; //spit out the results
		}	
		
		
		/*
			c_orderHandler::addPackSize()
			
			simply adds a new element to the pack size array, used by ajax to refresh the page.
		*/
		public static function addPackSize($n_newSize) 
		{			
			//add a new element to pack size array
			array_push($_SESSION['boxSizes'], $n_newSize);		

			//refresh the pack sizes
			echo"
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
			";				
		}
		
		
		/*
			c_orderHandler::removePackSize()
			
			removes the chosen element from the pack size array, also uses ajax to refresh the page.
		*/
		public static function removePackSize($n_targetIndex) //array index
		{		
			//remove the desired element from the pack size array
			unset($_SESSION['boxSizes'][$n_targetIndex]);	

			//will need to rebuild the pack array
			$_SESSION['boxSizes'] = array_values($_SESSION['boxSizes']);

			//refresh the pack sizes
			echo"
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
			";				
		}
		
		/*
			c_orderHandler::editPackSize()
			
			pretty self explanatory, but for your benefit it allows the user to edit the values of the pack sizes.
		*/
		public static function editPackSize($n_targetIndex, $n_newPackSize) //array index, amount size
		{				
			//set the new size
			$_SESSION['boxSizes'][$n_targetIndex] = $n_newPackSize;
					
			//refresh the pack sizes
			echo"				
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
			";							
		}		
	}
	
	//set up the properties
	c_orderHandler::init();	//need to make sure this is called only when the properties arent set up
?>