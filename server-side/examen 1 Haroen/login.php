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
	 * Action: login
	 * ----------------------------------------------------------------
	 */

	$formErrors = array();

	// form submitted
	if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'login')) {

		// extract sent in username & password
		$username = isset($_POST['username']) ? trim($_POST['username']) : '';
		$password = isset($_POST['password']) ? $_POST['password'] : '';

		if (($username === '') || ($password === '')) {
			array_push($formErrors, 'Empty fields');
		}

		// username & password are 'valid'
		else {

			//  Database Connection
			try {
				$db = new PDO('mysql:host=' . DB_HOST .';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			} catch (Exception $ex) {
				showDbError('connect', $ex->getMessage());
			}

			$stmt = $db->prepare('SELECT * FROM users WHERE username = ?');
			$stmt->execute(array($username));
			$user = $stmt->fetch(PDO::FETCH_ASSOC);

			if (empty($user)) {
				array_push($formErrors, 'Invalid username and/or password');
			} else {
				if (password_verify($password, $user['password'])) {

					// store user (usually returned from database) in session
					$_SESSION['user'] = array('id' => $user['id'], 'username' => $user['username'], 'time' => time());

					setcookie('persist', $user['username']);

					// redirect to previous page
					header('Location: index.php');
					exit();
				} else {
					array_push($formErrors, 'Invalid username and/or password');
				}
			}
		}
	}

	/**
	 * Load and render template
	 * ----------------------------------------------------------------
	 */

	$time_logged_in = floor((time() - $user['time'])/60 ). 'm ' . (time() - $user['time']) % 60 . 's';

	$tpl = $twig->loadTemplate('login.twig');
	echo $tpl->render(array(
		'action' => $_SERVER['PHP_SELF'],
		'user' => $user,
		'user_time' => $time_logged_in,
		'formErrors' => $formErrors
	));


// EOF