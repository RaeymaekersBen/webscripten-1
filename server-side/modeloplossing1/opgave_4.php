<?php

/**
 * Lab 01, Exercise 4 — Solution
 * @author Bramus Van Damme <bramus.vandamme@odisee.be> and Joris Maervoet <joris.maervoet@odisee.be>
 */

	// Insuffucient parameters
	if ($argc < 2)  {
		echo 'Insuffucient parameters. Please supply 1 parameter to this script, e.g. `php opgave_6.php "1983-12-26 11:45:00"`' . PHP_EOL;
	}
	// Correct number of arguments set
	else {
		// Set timezone to Brussels
		date_default_timezone_set('Europe/Brussels');

		// get date
		$date = $argv[1];

		// Rework date to a timestamp
		$date = strtotime($date);

		if ($date !== false) { // if you use != the script wil not work for timestamp 0
			// Output
			echo $date . PHP_EOL;					// timestamp
			echo date('F', $date) . PHP_EOL;		// Month (in words)
			echo date('l', $date) . PHP_EOL;		// Day of week (in words)
			echo date('D', $date) . PHP_EOL;		// Day of week (short, in words)
			echo date('dmY', $date) . PHP_EOL;		// Date as "26121983"
			echo date('ymd', $date) . PHP_EOL;		// Date as "831226"
			echo date('g:i A', $date) . PHP_EOL;	// Date as "11:45 AM"
			echo date('t', $date) . PHP_EOL;		// Number of days in given month
			echo date('j F Y', $date) . PHP_EOL;	// Date as "26 december 1983"
			echo date('W', $date) . PHP_EOL;		// Weeknumber of date
		} else {
			echo ('The first parameter of this script could not be interpreted as a date.');
		}
	}

// EOF