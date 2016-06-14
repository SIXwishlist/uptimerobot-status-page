<?php

if ( is_readable(__DIR__.'/config.php') ) {
	require __DIR__.'/config.php';
} else {
	// TODO Error nicely.
}

require __DIR__.'/function.uptimerobot.fetch.monitor.php';
require __DIR__.'/function.uptimerobot.nice.status.php';

require __DIR__.'/head.php';
echo '	<body>';
require __DIR__.'/header.php';

// Get the data.
$Data = uptimerobot_fetch_monitors(
	$Monitors,
	$API_Key,
	$Data['total'],
	$CustomTime
);
//var_dump($Data);

// Echo the Monitors
foreach($Data['monitors']['monitor'] as $Monitor) {

	if ( $Monitor['status'] > 2 ) {
		if ( empty($Apologies[$Monitor['id']]) ) {
			$Apologies['Current'] = false;
		} else {
			$Apologies['Current'] = '<p class="color-pomegranate">'.$Apologies[$Monitor['id']].'</p>';
		}
	}

	$Status = uptimerobot_nice_status($Monitor['status']);

	if ( !empty($Monitor['customuptimeratio']) ) {
		$Uptime = $Monitor['customuptimeratio'];
	} else {
		$Uptime = $Monitor['alltimeuptimeratio'];
	}

	echo '
<section class="grid">
	<div class="whole medium-half">
		<h2><a href="'.$Monitor['url'].'">'.$Monitor['friendlyname'].'</a></h2>
		'.$Apologies['Current'].'
		<p>'.$Descriptions[$Monitor['id']].'</p>
	</div>
	<div class="whole medium-half align-center box '.$Status['Direction'].'">
		<h3 class="align-center">'.$Status['Name'].'</h3>
		<p class="align-center">'.$Status['Name'].' since '.$Monitor['log'][0]['datetime'].'.</p>
		<p class="align-center">'.$Uptime.'% Uptime &nbsp;&middot;&nbsp; '.$Monitor['responsetime'][0]['value'].'ms'.' at '.$Monitor['responsetime'][0]['datetime'].'</p>
	</div>
	<div class="whole medium-half float-right expandable">
		<h4 class="align-center">Events</h4>
		';

	foreach($Monitor['log'] as $Log) {
		if ($Log['type'] == 2) {
			$Color = 'color-nephritis';
			$Status = 'Online';
		} elseif ($Log['type'] == 1) {
			$Color = 'color-pomegranate';
			$Status = 'Offline';
		} elseif ($Log['type'] == 98) {
			$Color = 'color-asbestos';
			$Status ='Started';
		} elseif ($Log['type'] == 99) {
			$Color = 'color-asbestos';
			$Status = 'Paused';
		} else {
			$Color = 'color-pomegranate';
			$Status = 'AWOL';
		}
		// TODO Format dates.
		echo '<p class="no-margin align-center '.$Color.'">'.$Status.' &nbsp;&middot;&nbsp; '.$Log['datetime'].'</p>';
	}

	echo '
	</div>
	<div class="clear"></div>
</section>';
}

// Load Footer
echo '<div class="clear"></div>';
require __DIR__.'/footer.php';
