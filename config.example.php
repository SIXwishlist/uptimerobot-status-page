<?php

////	Configuration

// Title of Company
$Title = 'Example Corp';

// Your API Key
$API_Key = 'u1234-a1b2c34d56efgh789i012j34';
// Found at http://uptimerobot.com/dashboard#mySettings

// Monitor IDs
$Monitors = array(
	'012345678',
	'123456789',
	'987654321',
	'876543210'
); // Found at http://api.uptimerobot.com/getMonitors?format=xml&apiKey=YOURAPIKEYHERE

// Descriptions of Monitors
$Descriptions['777379363'] = 'A nice long description, HTML is allowed.';
$Descriptions['123456789'] = 'API for Third parties. Always online thanks to the bees.';
$Descriptions['987654321'] = '';
$Descriptions['876543210'] = 'Super-Secret-and-Secure Alien-Storage Area. Absolutely no breakouts. Ever.';

// Apologies to be printed if down
$Apologies['012345678'] = 'Our website is down, you will not be able to sign up. Sorry!';
$Apologies['123456789'] = 'Trained bees have been dispatched to fix our over-heating servers.';
$Apologies['987654321'] = 'Area 69 has been retired.';
$Apologies['876543210'] = 'The aliens appear to have escaped. You shall be vaporised in vengeance shortly.';

// Number of days to get uptime percentage for
$CustomTime = false;
// Set to false to disable

////	END of Configuration
