<?php

//// 	Configuration		////

// 		Title of Company
$Title = 'Example Corp';

// 		Your API Key
$API_Key = 'u1234-a1b2c34d56efgh789i012j34';
// Found at http://uptimerobot.com/mySettings.asp

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
	'Control Panel and Forum for Members',
	'Area 51',
	'API System'
);

// Apologies to be printed if down
$Apologies = array(
	'Our website is down, you will not be able to sign up. Sorry!',
	'Trained bees have been dispatched to fix our over-heating servers.',
	'The aliens appear to have escaped. You shall be vaporised in vengeance shortly.',
	'Our API is down. Only third-party apps are effected. Who cares?'
);

// Number of days to get uptime percentage for
$CustomTime = false;
// Set to false to disable

////		END of Configuration		////

// Header
?><!DocType html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta http-equiv="cleartype" content="on">
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="keywords" content="<?php echo $Title; ?> Network Status">
		<meta name="description" content="<?php echo $Title; ?> Network Status">
		<title>Network Status &nbsp;&middot;&nbsp; <?php echo $Title; ?></title>
		<link rel="alternate" type="application/rss+xml" title="" href="" /><!-- TODO: RSS -->
		<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic">
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<div id="skiptomain"><a href="#maincontent">skip to main content</a></div>
		<div id="headcontainer">
			<header>
				<h1>Network Status</h1>
				<h5>of <?php echo $Title; ?></h5>
			</header>
		</div>
		<div id="maincontentcontainer">
			<div id="maincontent">
				<div class="section group">
<?

function fetch($ID, $Description, $Problem, $Key, $Count, $CustomTime) {

    // Compute Variables
	$API_URL = 'http://api.uptimerobot.com/getMonitors?logs=1&format=xml&apiKey=' . $Key . '&monitors=' . $ID;

	if ($CustomTime) $API_URL .= '&customUptimeRatio=' . $CustomTime;

	// Fetch from API
	$API_Fetch = curl_init($API_URL);
	curl_setopt($API_Fetch, CURLOPT_RETURNTRANSFER, true);
	$API_XML = curl_exec($API_Fetch);
	curl_close($API_Fetch);

	// Parse XML
	$ParsedXML = simplexml_load_string($API_XML);

	// Loop Monitors
	foreach($ParsedXML->monitor as $Monitor) {
		echo '<div class="col span_1_of_', $Count, '">';
		echo '<h2>', $Monitor['friendlyname'], '</h2>';
		if ($Monitor['status'] == 2) {
			$Direction = 'up';
			$Status = 'Online';
		} elseif ($Monitor['status'] == 9) {
			$Direction = 'down';
			$Status = 'Offline';
		} elseif ($Monitor['status'] == 8) {
			$Direction = 'level';
			$Status = 'Experiencing Difficulties';
		} elseif ($Monitor['status'] == 0) {
			$Direction = 'none';
			$Status = 'Paused';
		} elseif ($Monitor['status'] == 1) {
			$Direction = 'none';
			$Status ='Not Checked Yet';
		} else {
			$Direction = 'down';
			$Status = 'AWOL';
		}
		echo '<p class="equalize box">', $Description;
		if ($Status != 'Online') echo '<br><span class="red">', $Problem, '</span>';
		echo '</p>';
		echo '<h3 class="box ', $Direction, '">', $Status, '</h3>';
		if ($CustomTime) {
			if ($Monitor['customuptimeratio'] >= 99) {
				$Direction = 'up';
			} elseif ($Monitor['customuptimeratio'] >= 90) {
				$Direction = 'level';
			} else {
				$Direction = 'down';
			} echo '<h4 class="box ', $Direction, '">', $Monitor['customuptimeratio'], '% Uptime</h4>';
		} else {
			if ($Monitor['alltimeuptimeratio'] >= 99) {
				$Direction = 'up';
			} elseif ($Monitor['alltimeuptimeratio'] >= 90) {
				$Direction = 'level';
			} else {
				$Direction = 'down';
			} echo '<h4 class="box ', $Direction, '">', $Monitor['alltimeuptimeratio'], '% Uptime</h4>';
		}
		echo '<div class="breaker"></div>';
		echo '<h5>Events</h5>';
		foreach($ParsedXML->monitor->log as $Log) {
			if ($Log['type'] == 2) {
				$Direction = 'up';
				$Status = 'Online';
			} elseif ($Log['type'] == 1) {
				$Direction = 'down';
				$Status = 'Offline';
			} elseif ($Log['type'] == 98) {
				$Direction = 'none';
				$Status ='Started';
			} elseif ($Log['type'] == 99) {
				$Direction = 'level';
				$Status = 'Paused';
			} else {
				$Direction = 'down';
				$Status = 'AWOL';
			}
			echo '<h6 class="box ', $Direction, ' faded">', $Status, ' &nbsp;&middot;&nbsp; ', $Log['datetime'], '</h6>';
		}
		echo '</div>';
	}

}

$Count = count($IDs);
for ($i=0; $i<$Count; ++$i) {
    fetch($IDs[$i], $Descriptions[$i], $Apologies[$i], $API_Key, $Count, $CustomTime);
}

// Load Footer
?>
				</div>
			</div>
		</div>
		<div id="footercontainer">
			<footer class="section group">
				<div class="col span_5_of_8">
					<p class="left">Copyright &copy; <?php echo date('Y'), ' ', $Title; ?></p>
				</div>
				<div class="col span_1_of_8"><p><a href="//status.example.corp/">Status</a></div>
				<div class="col span_1_of_8"><p><a href="//forum.example.corp/">Disclaimer</a></div>
				<div class="col span_1_of_8"><p><a href="//www.example.corp/legal/copyright/">Copyright</a></p></div>
			</footer>
		</div>
		<!--[if lt IE 9]>
			<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
			<script type="text/javascript">window.jQuery || document.write('<script src="http://labs.eustasy.org/js/jquery-1.10.2.min.js"><\/script>');</script>
		<![endif]-->
		<!--[if IE 9]><!-->
			<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
			<script>window.jQuery || document.write('<script src="http://labs.eustasy.org/js/jquery-2.0.3.min.js"><\/script>');</script>
		<!--<![endif]-->
		<script src="http://labs.eustasy.org/js/modernizr.min.js"></script>
		<script src="http://labs.eustasy.org/js/jquery.equalize.min.js"></script>
	</body>
</html>
