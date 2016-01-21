<?php
	/**
	 * add page
	 * @author Arnaud Weyts
	 * @version 1-21-16
	 */

	// config & functions
	require_once 'includes/config.php';
	require_once 'includes/functions.php';
	require_once __DIR__ . '/includes/Twig/lib/Twig/Autoloader.php';
	Twig_Autoloader::register();
	$loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
	$twig = new Twig_Environment($loader);

	/**
	 * Database Connection
	 * ----------------------------------------------
	 */

	$db = getDatabase();

	// start session
	session_start();

	// not logged in
	if (!isset($_SESSION['user'])) {
		header('location: login.php');
		exit();
	}

	$user = null;
	$time = null;

	$user = $_SESSION['user'];

	if (isset($_SESSION['timestamp'])) {
		$time = $_SESSION['timestamp'];
		$time = ($_SERVER['REQUEST_TIME'] - $time );
		$seconds = $time % 60;
		$minutes = ($time - $seconds) / 60;
		if ($seconds < 10) {
			$time = "$minutes:0$seconds";
		}
		else {
			$time = "$minutes:$seconds";
		}
	}

	$formErrors = array();

	// initial values
	$name = isset($_POST['name']) ? trim($_POST['name']) : '';
	$address = isset($_POST['address']) ? trim($_POST['address']) : '';
	$categoryIdFromPost = isset($_POST['category']) ? (int) trim($_POST['category']) : '';
	$description = isset($_POST['description']) ? trim($_POST['description']) : '';
	$website = isset($_POST['website']) ? trim($_POST['website']) : '';
	$lat = isset($_POST['lat']) ?  trim($_POST['lat']) : '';
	$lon = isset($_POST['lon']) ?  trim($_POST['lon']) : '';


	// get categories from database
	$stmt = $db->prepare('SELECT id, name FROM categories');
	$stmt->execute();

	$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);


	// formchecking
	if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'add')) {

		$allOk = true;

		// get cover photo
		if (isset($_FILES['photo'])) {
			$extension = (new SplFileInfo($_FILES['photo']['name']))->getExtension();
			if (!in_array($extension, array('jpg'))) {
				$allOk = false;
				$formErrors[] = 'Please choose a picture. Only .jpg allowed';
			}
		}

		if ($name == '') {
			$formErrors[] = 'Please enter a name';
		}

		if ($address == '') {
			$formErrors[] = 'Please enter a address';
		}

		if ($categoryIdFromPost == '') {
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


		// if everything ok, add to database & move coverfile
		if ($allOk) {
			$stmt = $db->prepare('INSERT INTO shops (name, address, category_id, description, website, lat, lon) VALUES (?, ?, ?, ?, ?, ?, ?)');
			$stmt->execute(array($name, $address, $categoryIdFromPost, $description, $website, $lat, $lon));
			$stmt = $db->query('SELECT LAST_INSERT_ID()');
			$shop_id = $stmt->fetch(PDO::FETCH_NUM);
			@move_uploaded_file($_FILES['photo']['tmp_name'], __DIR__ . DIRECTORY_SEPARATOR . 'files/images/s' . $shop_id[0] . '.jpg') or die('<p>Error while saving file in the uploads folder</p>');
			//header('location: shops.php');
			//exit();
		}
	}

	/**
	 * Render twig template
	 * ----------------------------------------------
	 */

	$formaction = $_SERVER['PHP_SELF'];
	$tpl = $twig->loadTemplate('add.twig');
	echo $tpl->render(array(
		'user' => $user['username'],
		'time' => $time,
		'formaction' => $formaction,
		'formErrors' => $formErrors,
		'categories' => $categories,
		'categoryIdFromPost' => $categoryIdFromPost,
		'name' => $name,
		'address' => $address,
		'lat' => $lat,
		'lon' => $lon,
		'description' => $description,
		'website' => $website
	));