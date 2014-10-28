/*
	
	-----------------------------------
	----- HOW TO USE searchAjax() -----
	-----------------------------------
	
	searchAjax() is used to activate searching functionality.
	
	searchAjax("scriptName", "searchBoxID", "searchInputID", 350)
		
		- "scriptName" is the script you're calling.
		
		- "searchBoxID" is the div ID on the page that will be update via AJAX.
		
		- "searchInputID" is the ID of the text input that you're using for the search.
		
		- 350 represents the milisecond delay for how long to wait before processing user input.
				- This prevents unnecessary updating for each click.
				- The default value will automatically adjust based on character length.
	
	
	<< A Simple Example >>
		
		<input id="searchInputID"
				type="text" name="blah" value="" placeholder="Search . . ."
				onkeyup='searchAjax("basicSearch", "searchBoxID", "searchInputID")' />
	
*/

// Important Variables
var nextUpdate = 0;			// Keeps track of the last time that user input was sent
var lastInput = "";			// Tracks the state of the last input that was entered
var searchActive = false;	// If the search is active.

var g_scriptName = "";
var g_ajaxDivID = "";

// Track dropdown selection (up/down keys)
var curDropIndex = -1;

// This function will load the retrieved data into the "AJAX DIV".
function searchAjax(scriptName, searchBoxID, searchInputID, delay = -1)
{
	// Store Variables for the Search
	g_scriptName = scriptName;
	g_ajaxDivID = searchBoxID;
	
	// Start the update tester (if it is currently inactive)
	if(searchActive == false)
	{
		searchActive = true;
		searchUpdateChecker();
	}
	
	// Get Important Data
	var d = new Date();
	var ls = document.getElementById(searchInputID).value;
	
	// Update the last input (to test if it's different)
	if(ls != lastInput)
	{
		if(delay == -1)
		{
			delay = 50 + (50 * ls.length);
		}
		
		nextUpdate = d.getTime() + delay;
		lastInput = ls;
	}
}

// This function checks every few miliseconds to see if an update should be processed
function searchUpdateChecker()
{
	var d = new Date();
	
	// Update the search (if the update time has passed)
	if(nextUpdate != 0 && d.getTime() > nextUpdate)
	{
		curDropIndex = -1;
		nextUpdate = 0;
		loadAjax(g_scriptName, g_ajaxDivID, "search=" + lastInput);
		searchActive = false;
	}
	else
	{
		// Continue to run the updater
		setTimeout(searchUpdateChecker, 50);
	}
}

/********************************
****** Search Box Handling ******
********************************/

// When a search box is selected
function focusSearch(event, dropdownID)
{
	// event.target.id;	// The ID of the input being used
	
	var searchDropdown = document.getElementById(dropdownID);
	
	// Show the Dropdown
	searchDropdown.style.display = "block";
	
	curDropIndex = -1;
}

// When a search box is deselected
function blurSearch(event, dropdownID)
{
	var searchDropdown = document.getElementById(dropdownID);
	
	// Hide the Dropdown
	setTimeout(function() {
		searchDropdown.style.display = "none";
	}, 100);
	
	// Restore all dropdowns to their standard appearance
	var option = searchDropdown.getElementsByTagName("a");
	
	for(var i = 0;i < option.length;i++)
	{
		option[i].className = "searchSel";
	}
	
	curDropIndex = -1;
}

// This function handles the up/down/enter handling for search boxes
// It allows you to navigate with keys to click on links
function showSelectedSearch(event, dropdownID)
{
	var searchDropdown = document.getElementById(dropdownID);
	var option = searchDropdown.getElementsByTagName("a");
	
	// If there are no children, end here
	if(option.length == 0)
	{
		curDropIndex = -1;
		return false;
	}
	
	// Down Key
	if(event.keyCode == 40)
	{
		curDropIndex = curDropIndex + 1;
		if(curDropIndex >= option.length) { curDropIndex = 0; }
	}
	
	// UP Key
	else if(event.keyCode == 38)
	{
		curDropIndex = curDropIndex - 1;
		if(curDropIndex <= -1) { curDropIndex = option.length - 1; }
	}
	
	// Enter Key
	else if(event.keyCode == 13)
	{
		window.location = option[curDropIndex].href;
	}
	
	// Set the current index as active
	if(typeof(option[curDropIndex]) != "undefined")
	{
		// Restore all dropdowns to their standard appearance
		for(var i = 0;i < option.length;i++)
		{
			option[i].className = "searchSel";
		}
		
		// Highlight the active selector
		option[curDropIndex].className = "searchSelActive";
	}
}

/*
	
	---------------------------------
	----- HOW TO USE loadAjax() -----
	---------------------------------
	
	To properly call AJAX in our system, use the following syntax:
	
	loadAjax("scriptName", "ajaxDivID", "var1=a", "var2=b", ...)
	
		- "scriptName" is the script you're calling.
		
		- "ajaxDivID" is the div ID on the page that will be update via AJAX.
		
		- Each argument passed to loadAjax() after the AJAX DIV will provide additional parameters that
		  get sent as $_POST values to that page.
		  
			^ For example, the script above would pass $_POST['var1'] = "a" and $_POST['var2'] = "b",
			which can be used to generate data on that page.
	
	
	<< A Simple Example >>
	
		<a href="javscript:void(0)" onclick="loadAjax('checkData', 'ajaxDivID', 'menu=1')">
	
*/

// This function will load the retrieved data into the "AJAX DIV".
function loadAjax(scriptName, ajaxDivID)
{
	var queryString = "";
	
	// Add the extra data values to the query string
	// Each additional argument sent to this function is set up like: value=something
	// So a full function call would look like this:
	// loadAjax('ajaxCall', 'myDivID', 'username=Joe', 'value=something');
	for(var i = 2; i < arguments.length; i++)
	{
		queryString = queryString + "&" + arguments[i];
	}
	
	processAjax(scriptName, ajaxDivID, queryString);
}

// This is the AJAX Processor
// Don't call this directly. Use loadAjax() or processForm().
function processAjax(scriptName, ajaxDivID, queryString)
{
	xmlhttp = new XMLHttpRequest();
	
	xmlhttp.onreadystatechange = function()
	{
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			document.getElementById(ajaxDivID).innerHTML = xmlhttp.responseText;
		}
	}
	
	// Run the Processor
	xmlhttp.open("POST", "/ajax/" + scriptName, true);
	
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	
	xmlhttp.send(queryString);
}


/*
	
	----------------------------------
	----- HOW TO USE THIS SCRIPT -----
	----------------------------------
	The script is used to process forms through AJAX.
	
	To be called properly, the form must be set up like this:
	
	<form id="formID" name="someName"
			action="/page/to/load'
			onsubmit="return processForm('formID', 'fileToLoad', 'divToAlter')">
			
		<!-- Form Content Goes Here -->
	</form>
	
	This script represses the standard form behavior (since that normally forces a refresh).
	It does this because we don't want to reload the entire page - we only want to reload
	the AJAX DIV on THIS page.
	
*/

// Process Form
function processForm(formID, pageName, ajaxDivID)
{
	/* do what you want with the form */
	var form = document.getElementById(formID);
	var elements = form.elements;
	var queryString = "";
	
	for(var i = 0; i < elements.length; i++)
	{
		if(typeof elements[i] != 'undefined' && typeof elements[i].name != 'undefined' && typeof elements[i].value != 'undefined')
		{
			// Prepare Element Name
			var elemName = elements[i].name;
			
			// Special Checks for Checkboxes
			if(elements[i].type == "checkbox")
			{
				if(elements[i].checked == true)
				{
					queryString = queryString + "&" + elemName + "=on";
				}
			}
			else
			{
				var elemValue = encodeURIComponent(elements[i].value); // works
				
				queryString = queryString + "&" + elemName + "=" + elemValue;
			}
		}
	}
	
	// Send the Form Data through the ajax processing script:
	processAjax(pageName, ajaxDivID, queryString);
	
	// You must return false to prevent the default form behavior
	return false;
}
