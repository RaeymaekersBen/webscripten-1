<?php

/**
 * Lab 01, Exercise 2 — Solution
 * @author Joris Maervoet <joris.maervoet@odisee.be>
 */

	$alphabet = array(); // works without this line ;-S
	for ($i = 0; $i < 26 ; $i++) {
		$alphabet[] = chr($i + 97); // same effect: $alphabet[$i]
	}
	echo ('Name: $alphabet' . PHP_EOL);
	print_r($alphabet);
	
	foreach ($alphabet as $key => $letter) {
		echo ($key + 1) . $letter;
	}
	echo PHP_EOL;
	
	echo implode(',', $alphabet) . PHP_EOL;
	
	echo (count($alphabet)) . PHP_EOL;
	echo (array_shift($alphabet)) . PHP_EOL; // (not array_pop neither reset!)
	echo (count($alphabet)) . PHP_EOL;
	
	$cities = array(9000 => 'Gent', 1000 => 'Brussel', 8500 => 'Kortrijk', 9160 => 'Lokeren');
	/* Note: if you would specify the keys as strings ('9000' and so on), they will be stored as integers anyway.
	From the manual (about key casts in arrays):
	Strings containing valid integers will be cast to the integer type. E.g. the key "8" will actually be stored under 8. On the other hand "08" will not be cast, as it isn't a valid decimal integer.
	*/
	
	$zips = array_keys($cities);
	echo ('Name: $zips' . PHP_EOL);
	print_r($zips);
	echo ('Sum: ' . array_sum($zips) . PHP_EOL);
	
	asort($cities);
	echo ('Name: $cities' . PHP_EOL);
	print_r($cities);
	
	krsort($cities);
	echo ('Name: $cities' . PHP_EOL);
	print_r($cities);
	
	for ($i = 0; $i < 10000 ; $i += 1000) {
		echo (array_key_exists($i, $cities)? strtoupper($cities[$i]) . PHP_EOL : '');
	}

// EOF