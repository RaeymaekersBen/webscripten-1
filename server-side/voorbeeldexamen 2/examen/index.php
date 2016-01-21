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

	/**
	 * Database Connection
	 * ----------------------------------------------------------------
	 */

	try {
		$db = new PDO('mysql:host=' . DB_HOST .';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	} catch (Exception $ex) {
		showDbError('connect', $ex->getMessage());
	}


	/**
	 * No action to handle: show our page itself
	 * ----------------------------------------------------------------
	 */

		// Fetch needed data from DB

			// @TODO get all items from databases
			$items = array();
			try {
				if (isset($_GET['topic'])) {
					$resultSet = $db->prepare('SELECT books.id,books.title AS "booktitle",numpages,cover_extension,topics.id AS "topicid",topics.title AS "topictitle",username FROM `books` join users on user_id=users.id join topics on topic_id=topics.id WHERE topics.id=? ORDER BY booktitle ASC;');
					$resultSet->execute(array($_GET['topic']));
				} else {
					$resultSet = $db->query('SELECT books.id,books.title AS "booktitle",numpages,cover_extension,topics.id AS "topicid",topics.title AS "topictitle",username FROM `books` join users on user_id=users.id join topics on topic_id=topics.id ORDER BY booktitle ASC;');
				}
				if ($resultSet) foreach ($resultSet as $rij) array_push($items, $rij);
			} catch (Exception $ex) {
				showDbError('get', $ex->getMessage());
			}


	$loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
	$twig = new Twig_Environment($loader, array(
		'cache' => __DIR__ . '/cache',
		'auto_reload' => true // set to false on production
	));
	$tpl = $twig->loadTemplate('index.twig');
	echo $tpl->render(array(
		'pageTitle' => 'Index',
		'books' => $items,
		'user' => isset($_SESSION['user']) ? $_SESSION['user']['username'] : null
	));

?>