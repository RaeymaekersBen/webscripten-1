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

	// already logged in?
	if (isset($_SESSION['user'])) {
		header('Location: index.php');
		exit();
	}

	/**
	 * Handle login
	 * ----------------------------------------------------------------
	 */
	
	// var to tell if we have a login error
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
					$_SESSION['user'] = array('id' => $user['id'], 'username' => $user['username']);
					setcookie('persist', $user['username']);

					// redirect to index
					header('Location: index.php');
					exit();
				} else {
					array_push($formErrors, 'Invalid username and/or password');
				}
			} 
		}
	}

	$loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
	$twig = new Twig_Environment($loader, array(
		'cache' => __DIR__ . '/cache',
		'auto_reload' => true // set to false on production
	));
	$tpl = $twig->loadTemplate('login.twig');
	echo $tpl->render(array(
		'pageTitle' => 'Login',
		'PHP_SELF' => $_SERVER['PHP_SELF'],
		'formErrors' => $formErrors,
		'persist' => isset($_COOKIE['persist']) ? $_COOKIE['persist'] : ""
	));

?>