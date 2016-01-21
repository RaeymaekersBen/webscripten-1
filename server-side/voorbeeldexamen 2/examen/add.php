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

	// start session (starts a new one, or continues the already started one)
	session_start();

	// logged in?
	if (!isset($_SESSION['user'])) {
		header('Location: login.php');
		exit();
	}

	/**
	 * Handle login
	 * ----------------------------------------------------------------
	 */
	
	// var to tell if we have an error
	$formErrors = array();

	// valid topics ids
	$topicids = array(0, 1, 2, 3, 4, 5);

	// persist values
	$persist = array();

	// form submitted
	if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'add')) {
		$title = isset($_POST['title']) ? $_POST['title'] : '';
		$numpages = isset($_POST['numpages']) ? $_POST['numpages'] : '';
		$topic = isset($_POST['topic_id']) ? $_POST['topic_id'] : 0;
		$persist = array('title' => $title, 'number' => $numpages, 'topic' => $topic);

		// Because of a weird reason, isset($_FILES['coverphoto']) always returns true even when nothing was uploaded. Bypassing this by checking the size
		if ($_FILES['coverphoto']['size'] > 0) {
			if (!in_array((new SplFileInfo($_FILES['coverphoto']['name']))->getExtension(), array('jpeg', 'jpg', 'png', 'gif'))) {
				array_push($formErrors, 'Invalid extension. Only .jpeg, .jpg, .png or .gif allowed');
			}
		} else {
			array_push($formErrors, 'Please choose a cover. Only .jpeg, .jpg, .png or .gif allowed');
		}
		if ($title === '') {
			array_push($formErrors, 'Please enter a title');
		}
		if ($numpages === '') {
			array_push($formErrors, 'Please enter the number of pages');
		} else if (!is_numeric($numpages)) {
			array_push($formErrors, 'Invalid number of pages');
		}
		if ($topic == 0) {
			array_push($formErrors, 'Please select a topic');
		} else if (!in_array($topic, $topicids)) {
			array_push($formErrors, 'Invalid topic.');
		}

		if (empty($formErrors)) {
			try {
				$db = new PDO('mysql:host=' . DB_HOST .';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			} catch (Exception $ex) {
				showDbError('connect', $ex->getMessage());
			}
			$stmt = $db->prepare('INSERT INTO books VALUES (?, ?, ?, ?, ?, ?, ?)');
			$stmt->execute(array(null, $title, $numpages, $_SESSION['user']['id'], $topic, (new SplFileInfo($_FILES['coverphoto']['name']))->getExtension(), (new DateTime())->format('Y-m-d H:i:s')));
			@move_uploaded_file($_FILES['coverphoto']['tmp_name'], __DIR__ . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'covers' . DIRECTORY_SEPARATOR . $db->lastInsertId() . '.' . (new SplFileInfo($_FILES['coverphoto']['name']))->getExtension()) or die('<p>Error while saving file in the uploads folder</p>');
			header('Location: index.php');
			exit();
		}
	}

	$loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
	$twig = new Twig_Environment($loader, array(
		'cache' => __DIR__ . '/cache',
		'auto_reload' => true // set to false on production
	));
	$tpl = $twig->loadTemplate('add.twig');
	echo $tpl->render(array(
		'pageTitle' => 'Add Book',
		'PHP_SELF' => $_SERVER['PHP_SELF'],
		'formErrors' => $formErrors,
		'persist' => $persist,
		'user' => isset($_SESSION['user']) ? $_SESSION['user']['username'] : null
	));

?>