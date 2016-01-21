<?php 
	/**
	 * logout page
	 * @author Arnaud Weyts
	 * @version 1-19-16
	 */

	// start session
	session_start();

	// not logged in
	if (!isset($_SESSION['user'])) {
		header('location: login.php');
		exit();
	}

	// Best practice: unset all session vars before stopping the session
	foreach ($_SESSION as $key => $value) {
		unset($_SESSION[$key]);
	}

	// destroy session
	session_destroy();

	header('location: index.php');
	exit();