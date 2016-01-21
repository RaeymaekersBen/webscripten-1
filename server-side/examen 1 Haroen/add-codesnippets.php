<?php

		// ...
		
		$name = '';
		$address = '';
		$description = '';
		$website ='';
		$lat = '';
		$lon= '';
		$categoryIdFromPost = '';

		// ...

		$name = isset($_POST['name']) ? trim($_POST['name']) : '';
		$address = isset($_POST['address']) ? trim($_POST['address']) : '';
		$categoryIdFromPost = isset($_POST['category']) ? (int) trim($_POST['category']) : '';
		$description = isset($_POST['description']) ? trim($_POST['description']) : '';
		$website = isset($_POST['website']) ? trim($_POST['website']) : '';
		$lat = isset($_POST['lat']) ?  trim($_POST['lat']) : '';
		$lon = isset($_POST['lon']) ?  trim($_POST['lon']) : '';

		// ...

		if (!$photo || !in_array((new SplFileInfo($photo['name']))->getExtension(), array('jpg'))) {
			$formErrors[] = 'Please choose a picture. Only .jpg allowed';
		}

		if ($name == '') {
			$formErrors[] = 'Please enter a name';
		}

		if ($address == '') {
			$formErrors[] = 'Please enter a address';
		}

		if (...) {
			$formErrors[] = 'Please select a category';
		}

		if ($description == '') {
			$formErrors[] = 'Please enter a description';
		}

		if ($website == '') {
			$formErrors[] = 'Please enter a website';
		}

		if ($lat == '') {
			$formErrors[] = 'Please enter a latitude';
		}

		if ($lon == '') {
			$formErrors[] = 'Please enter a longitude';
		}

		// ...
			
		'categories' => $categories,
		'categoryIdFromPost' => $categoryIdFromPost,
		'name' => $name,
		'address' => $address,
		'lat' => $lat,
		'lon' => $lon,
		'description' => $description,
		'website' => $website,
