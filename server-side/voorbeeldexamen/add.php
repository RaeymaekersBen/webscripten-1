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

	// initial values
	$title = '';
	$numpages = false;
	$topic_id = false;

	// Get all topics from database
	$stmt = $db->prepare('SELECT * FROM topics ORDER BY title');
	$stmt->execute();

	$activetopicid = "add";
	$topics = $stmt->fetchAll(PDO::FETCH_ASSOC);


	// formchecking
	if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'add')) {
		
		$allOk = true;

		// get cover photo
		if (isset($_FILES['coverphoto'])) {
			$extension = (new SplFileInfo($_FILES['coverphoto']['name']))->getExtension();
			if (!in_array($extension, array('jpeg', 'jpg', 'png', 'gif'))) {
				$allOk = false;
				$formErrors[] = 'Please choose a cover. Only .jpeg, .jpg, .png or .gif allowed';
			}
		}

		// get title
		$title = isset($_POST['title']) ? $_POST['title'] : '';
		if (!$title || $title === '') {
			$allOk = false;
			$formErrors[] = 'Please enter a title';
		}

		// get numpages
		$numpages = isset($_POST['numpages']) ? (int) $_POST['numpages'] : 0;
		if (!$numpages || $numpages === 0) {
			$allOk = false;
			$formErrors[] = 'Please enter the number of pages';
		}

		// get topic
		$topic_id = isset($_POST['topic_id']) ? (int) $_POST['topic_id'] : 0;
		if (!$topic_id || $topic_id === 0) {
			$allOk = false;
			$formErrors[] = 'Please select a topic';
		}

		// if everything ok, add to database & move coverfile
		if ($allOk) {
			$stmt = $db->prepare('INSERT INTO books (title, numpages, user_id, topic_id, cover_extension, added_on) VALUES (?, ?, ?, ?, ?, ?)');
			$stmt->execute(array($title, $numpages, $user['id'], $topic_id, $extension, (new DateTime())->format('Y-m-d H:i:s')));
			$stmt = $db->prepare('SELECT MAX(id) from books');
			$stmt->execute();
			$book_id = $stmt->fetch(PDO::FETCH_ASSOC);
			@move_uploaded_file($_FILES['coverphoto']['tmp_name'], __DIR__ . DIRECTORY_SEPARATOR . 'files/covers/' . $book_id['MAX(id)'] . '.' . $extension) or die('<p>Error while saving file in the uploads folder</p>');
			header('location: index.php');
			exit();
		}
	}

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
		'user' => $user['username'],
		'title' => $title,
		'numpages' => $numpages,
		'topic_id' => $topic_id
	));