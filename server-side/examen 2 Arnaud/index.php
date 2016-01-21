<?php
	/**
	 * index page
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

	// start session or continue an already started one
	session_start();

	$user = null;
	$time = null;

	if (isset($_SESSION['user'])) {
		$user = $_SESSION['user'];
	}

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

	// get actions from database
	$stmt = $db->prepare('SELECT actions.id, title, name, address FROM actions
						  INNER JOIN shops
						  ON actions.shop_id = shops.id
						  ORDER BY weight');
	$stmt->execute();

	$actions = $stmt->fetchAll(PDO::FETCH_ASSOC);



	/**
	 * Render twig template
	 * ----------------------------------------------
	 */

	$tpl = $twig->loadTemplate('index.twig');
	echo $tpl->render(array(
		'user' => $user['username'],
		'time' => $time,
		'actions' => $actions
	));