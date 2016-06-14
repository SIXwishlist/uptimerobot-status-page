<?php

function uptimerobot_nice_status($Input) {
	if ( $Input == 2 ) {
		$Status['Direction'] = 'background-emerald';
		$Status['Name'] = 'Online';
	} elseif ($Input == 9) {
		$Status['Direction'] = 'background-alizarin';
		$Status['Name'] = 'Offline';
	} elseif ($Input == 8) {
		$Status['Direction'] = 'background-orange';
		$Status['Name'] = 'Experiencing Difficulties';
	} elseif ( $Input == 0 ) {
		$Status['Direction'] = 'background-concrete';
		$Status['Name'] = 'Paused';
	} elseif ($Input == 1) {
		$Status['Direction'] = 'background-concrete';
		$Status['Name'] ='Not Checked Yet';
	} else {
		$Status['Direction'] = 'background-alizarin';
		$Status['Name'] = 'AWOL';
	}

	return $Status;

}
