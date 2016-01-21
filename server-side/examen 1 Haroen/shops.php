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
	$stmtShops = $db->prepare('SELECT * FROM shops ORDER BY id ASC');
	$stmtShops->execute();

	$shops = $stmtShops->fetchAll(PDO::FETCH_ASSOC);

	$stmtCategories = $db->prepare('SELECT * FROM categories');
	$stmtCategories->execute();

	$categories = $stmtCategories->fetchAll(PDO::FETCH_ASSOC);


	/**
	 * Load and render template
	 * ----------------------------------------------------------------
	 */
	if (isset($_GET['id'])) {
		$tpl = $twig->loadTemplate('shop.twig');
		setcookie('last_visited', $_GET['id'], time() + 60*60*24*7);
	} else {
		$tpl = $twig->loadTemplate('shops.twig');
	}

	$time_logged_in = floor((time() - $user['time'])/60 ). 'm ' . (time() - $user['time']) % 60 . 's';

	echo $tpl->render(array(
		'action' => $_SERVER['PHP_SELF'],
		'user' => $user,
		'user_time' => $time_logged_in,
		'shops' => $shops,
		'categories' => $categories,
		'id' => isset($_GET['id']) ? $_GET['id'] : '',
		'last_visited' => isset($_COOKIE['last_visited']) ? $_COOKIE['last_visited'] : ''
		));

// EOF