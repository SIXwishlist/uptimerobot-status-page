<?php

//// 	Configuration		////

// 		Title of Company
$Title = 'Example Corp';

// 		Your API Key
$API_Key = 'u1234-a1b2c34d56efgh789i012j34';
// Found at http://uptimerobot.com/dashboard#mySettings

// Monitor IDs
$IDs = array(
	'012345678',
	'123456789',
	'987654321',
	'876543210'
); // Found at http://api.uptimerobot.com/getMonitors?format=xml&apiKey=YOURAPIKEYHERE

// Descriptions of Monitors (in same order)
$Descriptions = array(
	'Main Website and Signups',
	'API for Third parties. Always online thanks to the bees.',
	'',
	'Super-Secret-and-Secure Alien-Storage Area. Absolutely no breakouts. Ever.'
);

// Apologies to be printed if down
$Apologies = array(
	'Our website is down, you will not be able to sign up. Sorry!',
	'Trained bees have been dispatched to fix our over-heating servers.',
	'Area 69 has been retired.',
	'The aliens appear to have escaped. You shall be vaporised in vengeance shortly.'
);


// Number of days to get uptime percentage for
$CustomTime = false;
// Set to false to disable

////		END of Configuration		////