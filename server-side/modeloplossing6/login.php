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
	 * Session Control
	 * ----------------------------------------------------------------
	 */

		// start session
		session_start();
		
		// user is already logged in, redirect to browse
		if (isset($_SESSION['user'])) {
			header('location: browse.php');
			exit();
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

		// The encountered form errors
		$formErrors = array();

		// form params
		$username = isset($_POST['username']) ? trim($_POST['username']) : '';
		$password = isset($_POST['password']) ? trim($_POST['password']) : '';

		// read stored username from cookie (if not sent via $_POST already)
		if ($username == '') {
			$username = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';
		}


	/**
	 * Handle action 'add' (user pressed add button)
	 * ----------------------------------------------------------------
	 */

		if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'login')) {

			// Get user with sent in username from DB
			$stmt = $db->prepare('SELECT * FROM users WHERE username = ?');
			$stmt->execute(array($username));

			// No user found
			if ($stmt->rowCount() != 1) {
				$formErrors[] = 'Invalid login credentials'; // Don't be too specific here (Do not say "invalid username") to not give away that the username exists
			}

			// User found
			else {

				// Fetch user
				$user = $stmt->fetch(PDO::FETCH_ASSOC);

				// Password checks out
				if (password_verify($password, $user['password'])) {

					// Store session data
					$_SESSION['user'] = $user;

					// store username in a cookie which expires in a week from now
					setcookie('username', $user['username'], time() + 60*60*24*7);

					// Redirect to index
					header('location: index.php');
					exit();

				}

				// Invalid login
				else {

					$formErrors[] = 'Invalid login credentials';

				}

			}

		}


	/**
	 * Load and render template
	 * ----------------------------------------------------------------
	 */

		$tpl = $twig->loadTemplate('login.twig');
		echo $tpl->render(array(
			'action' => $_SERVER['PHP_SELF'],
			'username' => $username,
			'formErrors' => $formErrors,
			'user' => false
		));


// EOF