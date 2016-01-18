<?php

/**
 * Lab 01, Exercise 5 — Solution
 * @author Bramus Van Damme <bramus.vandamme@odisee.be> and Joris Maervoet <joris.maervoet@odisee.be>
 */

	if ($argc <= 1) {
		echo 'Please add a parameter. Syntax: cat input.txt | php opgave_5.php 20';
	} else {
		$offset = $argv[1];

		while(!feof(STDIN)) {
			// Alternative strategy 1: don't trim and don't encode EOLs the for-loop
			// Alternative strategy 2: iterate by character using fgetc() and don't encode EOLs 
			$line = trim(fgets(STDIN));
			if(strlen($line) > 0) {
				// Alternative strategy 3: put the converted characters in an array and print the imploded array
				// Alternative strategy 4: change the chars of the string using []
				for ($x = 0; $x < strlen($line); $x++) {
					echo (chr(ord($line[$x]) + $offset));
				}
				echo PHP_EOL;
			}
		}
	}