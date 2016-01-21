<?php
	/**
	 * shops page
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

	// initial values
	$shop_id = isset($_GET['id']) ? $_GET['id'] : 0;

	if ($shop_id === 0) {
		// get categories from database
		$stmt = $db->prepare('SELECT * FROM categories');
		$stmt->execute();

		$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

		// get shops from database
		$stmt = $db->prepare('SELECT id, name, category_id, address, lat, lon FROM shops');
		$stmt->execute();

		$shops = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$lastShopId = (int) isset($_COOKIE['lastShopId']) ? $_COOKIE['lastShopId'] : 0;


		/**
		 * Render twig template
		 * ----------------------------------------------
		 */

		$tpl = $twig->loadTemplate('shops.twig');
		echo $tpl->render(array(
			'user' => $user['username'],
			'time' => $time,
			'categories' => $categories,
			'shops' => $shops,
			'lastShopId' => $lastShopId
		));
	}
	else {
		// get shop from database
		$stmt = $db->prepare('SELECT id, name, description, address, website  FROM shops
							  WHERE id = ?');
		$stmt->execute(array($shop_id));

		$shop = $stmt->fetch(PDO::FETCH_ASSOC);

		// set cookie for last visited shop
		setcookie('lastShopId', $shop['id'], time() + 24*60*60*7);

		/**
		 * Render twig template
		 * ----------------------------------------------
		 */

		$tpl = $twig->loadTemplate('singleshop.twig');
		echo $tpl->render(array(
			'user' => $user['username'],
			'time' => $time,
			'id' => $shop['id'],
			'name' => $shop['name'],
			'description' => $shop['description'],
			'address' => $shop['address'],
			'website' => $shop['website'],
		));
	}