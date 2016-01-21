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

	// start session or continue an already started one
	session_start();

	$user = null;

	if (isset($_SESSION['user'])) {
		$user = $_SESSION['user'];
	}

	/**
	 * Database Connection
	 * ----------------------------------------------------------------
	 */

	$db = getDatabase();

	/**
	 * Initial Values
	 * ----------------------------------------------------------------
	 */


	/**
	 * No action to handle: show our page itself
	 * ----------------------------------------------------------------
	 */

		// Get all todo items from databases
	$stmtActions = $db->prepare('SELECT * FROM actions ORDER BY weight ASC LIMIT 2');
	$stmtActions->execute();

	$actions = $stmtActions->fetchAll(PDO::FETCH_ASSOC);

	$stmtShops = $db->prepare('SELECT * FROM shops ORDER BY id ASC');
	$stmtShops->execute();

	$shops = $stmtShops->fetchAll(PDO::FETCH_ASSOC);

	/**
	 * Load and render template
	 * ----------------------------------------------------------------
	 */

	$time_logged_in = floor((time() - $user['time'])/60 ). 'm ' . (time() - $user['time']) % 60 . 's';

	$tpl = $twig->loadTemplate('index.twig');
	echo $tpl->render(array(
		'action' => $_SERVER['PHP_SELF'],
		'user' => $user,
		'user_time' => $time_logged_in,
		'actions' => $actions,
		'shops' => $shops
		));


// EOF