<?php

	/**
	 * Includes
	 * ----------------------------------------------------------------
	 */

		// config & functions
		require_once 'includes/config.php';
		require_once 'includes/functions.php';
		require_once __DIR__ . '/includes/Twig/Autoloader.php';
		Twig_Autoloader::register();
		$loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
		$twig = new Twig_Environment($loader);


	/**
	 * Session Control: Only allow logged in users to this site
	 * ----------------------------------------------------------------
	 */

	session_start();

	$user = null;

	if (isset($_SESSION['user'])) {
		$user = $_SESSION['user'];
	} else {
		header('Location: login.php');
		exit();
	}

	/**
	 * Database Connection
	 * ----------------------------------------------------------------
	 */

		$db = getDatabase();


	/**
	 * Add a shop
	 * ----------------------------------------------------------------
	 */

	// var to tell if we have an error
	$formErrors = array();

	// valid categorys ids
	$categoryids = array(0, 1, 2, 3, 4, 5);

	// persist values
	$persist = array();

	// form submitted
	if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'add')) {
		$name = isset($_POST['name']) ? $_POST['name'] : '';
		$address = isset($_POST['address']) ? $_POST['address'] : '';
		$description = isset($_POST['description']) ? $_POST['description'] : '';
		$website = isset($_POST['website']) ? $_POST['website'] : '';
		$lat = isset($_POST['lat']) ? $_POST['lat'] : '';
		$lon = isset($_POST['lon']) ? $_POST['lon'] : '';
		$category = isset($_POST['category']) ? $_POST['category'] : 0;
		$persist = array('name' => $name, 'description' => $description, 'website' => $website, 'address' => $address, 'category' => $category, 'lat' => $lat, 'lon' => $lon);

		// Because of a weird reason, isset($_FILES['photo']) always returns true even when nothing was uploaded. Bypassing this by checking the size
		if ($_FILES['photo']['size'] > 0) {
			if (!in_array((new SplFileInfo($_FILES['photo']['name']))->getExtension(), array('jpeg', 'jpg', 'png', 'gif'))) {
				array_push($formErrors, 'Kies een foto. Enkel .jpeg, .jpg, .png of .gif toegestaan');
			}
		} else {
			array_push($formErrors, 'Kies een foto. Enkel .jpeg, .jpg, .png of .gif toegestaan');
		}
		if ($name === '') {
			array_push($formErrors, 'Voeg een naam in');
		}
		if ($category == 0) {
			array_push($formErrors, 'Kies een categorie');
		} else if (!in_array($category, $categoryids)) {
			array_push($formErrors, 'Ongeldige categorie.');
		}
		if ($description === '') {
			array_push($formErrors, 'Voeg een beschrijving in');
		}
		if ($address === '') {
			array_push($formErrors, 'Voeg een adres in');
		}
		if ($lat === '' || $lon === '') {
			array_push($formErrors, 'Voeg coördinaten in');
		}
		// website can be empty

		if (empty($formErrors)) {
			try {
				$db = new PDO('mysql:host=' . DB_HOST .';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			} catch (Exception $ex) {
				showDbError('connect', $ex->getMessage());
			}
			$stmt = $db->prepare('INSERT INTO shops VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
			$stmt->execute(array(null, $name, $category, $description, $address, $lat, $lon, $website));
			@move_uploaded_file($_FILES['photo']['tmp_name'], __DIR__ . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 's' . $db->lastInsertId() . '.' . (new SplFileInfo($_FILES['photo']['name']))->getExtension()) or die('<p>Error while saving file in the uploads folder</p>');
			header('Location: shops.php');
			exit();
		}
	}

	/**
	 * Load and render template
	 * ----------------------------------------------------------------
	 */

	$time_logged_in = floor((time() - $user['time'])/60 ). 'm ' . (time() - $user['time']) % 60 . 's';

		$tpl = $twig->loadTemplate('add.twig');
		echo $tpl->render(array(
			'action' => $_SERVER['PHP_SELF'],
			'user' => $user,
			'user_time' => $time_logged_in,
			'formErrors' => $formErrors,
			'persist' => $persist
		));


// EOF