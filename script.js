function processOrder()
{
	//alert("func started");
	
	//using ajax to output the search results without refreshing the whole page
	
	var xmlHttp; 
	var orderAmount = document.getElementById("qty").value; //grab the qty from the textbox
	var formattedOrderAmount = ""+orderAmount+"";
	
	//check the input, make sure it's numerical
	if(/[^0-9]/.test(orderAmount) == true) // /[^0-9]/ check orderAmount for characters that AREN'T numerical.  if any are found, return true.
	{
		alert("Please enter a numerical value for the order quantity.");
		return;
	}
	
	//init the ajax object
	if(window.XMLHttpRequest)
	{
		xmlHttp = new XMLHttpRequest();				
	}
	else	
	{
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");			
	}
			
	//this is the function called when the ajaxed div is ready to be updated
	xmlHttp.onreadystatechange = function()
	{
		if(4==xmlHttp.readyState && 200==xmlHttp.status)
		{
			//alert('ajax ready');
			document.getElementById("orderFormOutput").innerHTML = xmlHttp.responseText; 
		}
	}	
	
	//call the relevant php scripts
	xmlHttp.open("GET", "processOrder.php?qty="+orderAmount, true);	//the output from this file goes into the main results div
	xmlHttp.send();		
}

function editPackSize(boxIndex)
{	
	var xmlHttp; 
	var xmlHttp2;
	
	var newPackSize = document.getElementById("packSize_"+boxIndex).value;//get the value from the form
	//alert(document.getElementById("packSize_"+boxIndex).value);
	
	//check the input, make sure it's numerical
	if(/[^0-9]/.test(newPackSize) == true) // /[^0-9]/ check the input for characters that AREN'T numerical.  if any are found, return true.
	{
		alert("Please enter a numerical value for the new pack size.");
		return;
	}
	
	if(window.XMLHttpRequest)
	{
		xmlHttp = new XMLHttpRequest();		
		xmlHttp2 = new XMLHttpRequest();		
		//alert('ajax ready: xmlhttprequest');		
	}
	else	
	{
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");		
		xmlHttp2 = new ActiveXObject("Microsoft.XMLHTTP");
		//alert('ajax ready: activex');
	}			
	
	xmlHttp.onreadystatechange = function()
	{
		if(4==xmlHttp.readyState && 200==xmlHttp.status)
		{			
			document.getElementById("packSectionPacks").innerHTML = xmlHttp.responseText; 
			//alert('pack section ready');
		}
	}/**/	
	
	xmlHttp2.onreadystatechange = function()
	{
		if(xmlHttp2.readyState==4 && xmlHttp2.status==200)
		{			
			document.getElementById("packSectionOutput").innerHTML = xmlHttp2.responseText; 
			
		}
	}/**/	
	
	//call the php script, commit the change, display the results
	xmlHttp.open("GET", "editPackSize.php?packIndex="+boxIndex+"&packSize="+newPackSize, true);			
	xmlHttp.send();	
	
	xmlHttp2.open("GET", "editPackOutput.php?packIndex="+boxIndex+"&packSize="+newPackSize, true);			
	xmlHttp2.send();				
}

function removePackSize(boxIndex)
{	
	var xmlHttp; 
	var xmlHttp2;
	
	if(window.XMLHttpRequest)	
	{
		xmlHttp = new XMLHttpRequest();	
		xmlHttp2 = new XMLHttpRequest();	
	}
	else		
	{
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");	
		xmlHttp2 = new ActiveXObject("Microsoft.XMLHTTP");
	}
				
	
	xmlHttp.onreadystatechange = function()
	{
		if(4==xmlHttp.readyState && 200==xmlHttp.status)					
			document.getElementById("packSectionPacks").innerHTML = xmlHttp.responseText; 	
	}
	
	xmlHttp2.onreadystatechange = function()
	{
		if(4==xmlHttp2.readyState && 200==xmlHttp2.status)					
			document.getElementById("packSectionOutput").innerHTML = xmlHttp2.responseText; 	
	}
	
	//call the php script, commit the change, display the results
	xmlHttp.open("GET", "removePackSize.php?packIndex="+boxIndex, true);			
	xmlHttp.send();		

	xmlHttp2.open("GET", "removePackOutput.php?packIndex="+boxIndex, true);			
	xmlHttp2.send();		
}

function addPackSize()
{	
	var xmlHttp; 
	var xmlHttp2;
	
	var newSize = document.getElementById("newSizeEntry").value;
	
	if(/[^0-9]/.test(newSize) == true) // /[^0-9]/ check the input for characters that AREN'T numerical.  if any are found, return true.
	{
		alert("Please enter a numerical value for the new pack size.");
		return;
	}
	
	if(window.XMLHttpRequest)	
	{
		xmlHttp = new XMLHttpRequest();	
		xmlHttp2 = new XMLHttpRequest();			
	}
	else		
	{
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");						
		xmlHttp2 = new ActiveXObject("Microsoft.XMLHTTP");
	}	
	
	xmlHttp.onreadystatechange = function()
	{
		if(4==xmlHttp.readyState && 200==xmlHttp.status)					
			document.getElementById("packSectionPacks").innerHTML = xmlHttp.responseText; 	
	}
	
	xmlHttp2.onreadystatechange = function()
	{
		if(4==xmlHttp2.readyState && 200==xmlHttp2.status)					
			document.getElementById("packSectionOutput").innerHTML = xmlHttp2.responseText; 	
	}
	
	//call the php script, commit the change, display the results
	xmlHttp.open("GET", "addPackSize.php?newEntry="+newSize, true);			
	xmlHttp.send();	
	
	xmlHttp2.open("GET", "addPackOutput.php?newEntry="+newSize, true);			
	xmlHttp2.send();				
}