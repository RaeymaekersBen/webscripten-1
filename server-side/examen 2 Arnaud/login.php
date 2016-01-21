<?php
	/**
	 * login page
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

	// already logged in!
	if (isset($_SESSION['user'])) {
		header('location: index.php');
		exit();
	}

	$username = (string) isset($_COOKIE['username']) ? $_COOKIE['username'] : '';
	$formErrors = array();

	// form submitted
	if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'login')) {
		//extract sent in username & password
		$username = isset($_POST['username']) ? trim($_POST['username']) : '';
		$password = isset($_POST['password']) ? trim($_POST['password']) : '';

		$stmt = $db->prepare('SELECT * FROM users WHERE username = ?');
		$stmt->execute(array($username));

		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		// username & password are valid
		if (($username != '') && (password_verify($password, $user['password']))) {
			// store user
			$_SESSION['user'] = $user;
			$_SESSION['timestamp'] = $_SERVER['REQUEST_TIME'];

			// set cookie
			setcookie('username', $username, time() + 24*60*60*7);

			// redirect to index
			header('location: index.php');
			exit();
		}

		// username & password are invalid
		else {
			$formErrors[] = 'Invalid login credentials';
		}
	}


	/**
	 * Render twig template
	 * ----------------------------------------------
	 */

	$formaction = $_SERVER['PHP_SELF'];
	$tpl = $twig->loadTemplate('login.twig');
	echo $tpl->render(array(
		'formaction' => $formaction,
		'formErrors' => $formErrors,
		'username' => $username
	));