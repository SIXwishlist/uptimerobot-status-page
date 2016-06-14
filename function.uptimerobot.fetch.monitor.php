<?php

function uptimerobot_fetch_monitors($Monitors, $Key, $CustomTime) {

	// Compute Variables
	$API_URL = 'http://api.uptimerobot.com/getMonitors?apiKey='.$Key.'&monitors=';
	foreach ( $Monitors as $Monitor ) {
		$API_URL .= $Monitor.'-';
	}
	$API_URL = trim($API_URL, '-');
	$API_URL .= '&logs=1&responseTimes=1&responseTimesAverage=1440&format=json&noJsonCallback=1';

	if ($CustomTime) $API_URL .= '&customUptimeRatio='.$CustomTime;

	// Fetch from API
	$API_Fetch = curl_init($API_URL);
	curl_setopt($API_Fetch, CURLOPT_RETURNTRANSFER, true);
	$API_Data = curl_exec($API_Fetch);
	curl_close($API_Fetch);

	// Parse JSON
	$Parsed = json_decode($API_Data, true);
	return $Parsed;

}
