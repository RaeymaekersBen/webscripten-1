<?php

/**
 * Lab 03, Exercise 1 — Solution
 * @author Bramus Van Damme &amp; Joris Maervoet <joris.maervoet@odisee.be> 
 */

	// Set timezone to Brussels
	date_default_timezone_set('Europe/Brussels');

	// Set language to Dutch
	setlocale(LC_ALL, 'Dutch_Netherlands'); // not used by $dtm->format()

	try {
		$dtm = new DateTime('1983-12-26 11:45:00');

		// Output
		echo $dtm->getTimestamp() . '<br />';		// timestamp
		echo $dtm->format('F') . '<br />';		// Month (in words)
		echo $dtm->format('l') . '<br />';		// Day of week (in words)
		echo $dtm->format('D') . '<br />';		// Day of week (short, in words)
		echo $dtm->format('dmY') . '<br />';		// Date as "26121983"
		echo $dtm->format('ymd') . '<br />';		// Date as "831226"
		echo $dtm->format('g:i A') . '<br />';	// Date as "11:45 AM"
		echo $dtm->format('t') . '<br />';		// Number of days in given month
		echo $dtm->format('j F Y') . '<br />';	// Date as "26 december 1983" (*)
		echo $dtm->format('W') . '<br />';		// Weeknumber of date
	} catch (Exception $e) {
		echo ('The time of this script could not be interpreted as a date.');
	}

// EOF