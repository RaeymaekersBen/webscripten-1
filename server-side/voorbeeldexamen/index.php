<?php  
	/**
	 * index page
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

	// start session or continue an already started one
	session_start();

	$user = null;

	if (isset($_SESSION['user'])) {
		$user = $_SESSION['user'];
	}

	/**
	 * Initial Values
	 * -----------------------------------------------
	 */

	$activetopicid = isset($_GET['topic']) ? $_GET['topic'] : '';

	// Get all topics from database
	$stmt = $db->prepare('SELECT * FROM topics ORDER BY title');
	$stmt->execute();

	$topics = $stmt->fetchAll(PDO::FETCH_ASSOC);

	// Get the all books
	if ($activetopicid === '') {
		$sqlstmt = 'SELECT books.id, books.title AS booktitle, numpages, cover_extension, username, topics.title AS topictitle FROM books 
					INNER JOIN users
					ON books.user_id = users.id
					INNER JOIN topics
					ON books.topic_id = topics.id
					ORDER BY booktitle';
			$stmt = $db->prepare($sqlstmt);
			$stmt->execute();
	}
	else {
		$sqlstmt = 'SELECT books.id, books.title AS booktitle, numpages, cover_extension, username, topics.title AS topictitle FROM books 
					INNER JOIN users
					ON books.user_id = users.id
					INNER JOIN topics
					ON books.topic_id = topics.id
					WHERE topic_id = ?
					ORDER BY booktitle';
			$stmt = $db->prepare($sqlstmt);
			$stmt->execute(array($activetopicid));
	}
	$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

	/**
	 * Render twig template
	 * ----------------------------------------------
	 */

	$tpl = $twig->loadTemplate('library.twig');
	echo $tpl->render(array(
		'activetopicid' => $activetopicid,
		'topics' => $topics,
		'books' => $books, 
		'user' => $user['username']
	));