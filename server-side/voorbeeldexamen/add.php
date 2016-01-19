<?php  
	/**
	 * add page
	 * @author Arnaud Weyts
	 * @version 1-19-16
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

	$user = $_SESSION['user'];
	$formErrors = array();

	// Get all topics from database
	$stmt = $db->prepare('SELECT * FROM topics');
	$stmt->execute();

	$activetopicid = "add";
	$topics = $stmt->fetchAll(PDO::FETCH_ASSOC);


	//TODO: errythang bitch

	/**
	 * Render twig template
	 * ----------------------------------------------
	 */

	$formaction = $_SERVER['PHP_SELF'];
	$tpl = $twig->loadTemplate('add.twig');
	echo $tpl->render(array(
		'formaction' => $formaction,
		'formErrors' => $formErrors,
		'topics' => $topics,
		'activetopicid' => $activetopicid,
		'user' => $user['username']
	));