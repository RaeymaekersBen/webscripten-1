<?php

/**
 * Lab 01, Exercise 3 — Solution
 * @author Joris Maervoet <joris.maervoet@odisee.be>
 */

	define('OWNER_POSITION', 7);
	
	/**
	 * Prints a message when $searchString appears in the plate number 
	 * or in the owner part of $line 
	 * @param string $line
	 * @param string $searchString
	 * @return void
	 */
	function inspectLine($line, $searchString) {
		$pos = stripos($line, $searchString);
		if ($pos !== false) {
			$plate = substr($line, 0, OWNER_POSITION - 1);
			$owner = substr($line, OWNER_POSITION);
			if ($pos < OWNER_POSITION) {
				echo $plate . ' is the plate number of ' . $owner . PHP_EOL;
			} else {
				echo $owner . ' is the owner of plate ' . $plate . PHP_EOL;
			}
		}
	}
	
	if ($argc > 1) {
		while(!feof(STDIN)) {
			$line = trim(fgets(STDIN)); // If you don't trim, you keep some EOL-char
			inspectLine($line, $argv[1]);
		}
	} else {
		echo 'Insuffucient parameters. Please supply a search string parameter.' . PHP_EOL;
	}
	

// EOF