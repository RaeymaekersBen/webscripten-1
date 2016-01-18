<?php

	/**
	 * Includes
	 * ----------------------------------------------------------------
	 */


		// config & functions
		require_once 'includes/config.php';
		require_once 'includes/functions.php';


	/**
	 * Database Connection
	 * ----------------------------------------------------------------
	 */

		$db = getDatabase();


	/**
	 * Initial Values
	 * ----------------------------------------------------------------
	 */


		$formErrors = array(); // The encountered form errors
		$id = isset($_GET['id']) ? (int) $_GET['id'] : 0; // The passed in id of the todo

	/**
	 * Handle action 'edit' (user pressed edit button)
	 * ----------------------------------------------------------------
	 */

		if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'delete')) {

			// get the id
			$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

			// check if item exists (use the id from the $_POST array!)
			$stmt = $db->prepare('SELECT COUNT(*) FROM todolist WHERE id = ?');
			$stmt->execute(array($id));
			$numItems = $stmt->fetchColumn();

			if ($numItems != 1) {
				header('location: browse.php');
				exit();
			}

			// form is correct: update values into database
			if (sizeof($formErrors) == 0) {

				// build and execute statement
				$stmt = $db->prepare('DELETE FROM todolist WHERE id = ?');
				$stmt->execute(array($id));

				// the query succeeded, redirect to this very same page
				if ($stmt->rowCount() != 0) {
					header('location: browse.php');
					exit();
				}

				// the query failed
				else {
					 $formErrors[] = 'Error while deleting the item. Please retry.';
				}

			}

		}


	/**
	 * No action to handle: show delete page
	 * ----------------------------------------------------------------
	 */

		// Check if the passed in id (in $_GET) exists as a todoitem
		$stmt = $db->prepare('SELECT * FROM todolist WHERE id = ?');
		$stmt->execute(array($id));

		if ($stmt->rowCount() != 1) {
			header('location: browse.php');
			exit();
		}

		// Get the item from the database
		$item = $stmt->fetch(PDO::FETCH_ASSOC);


?><!DOCTYPE html>
<!--[if lt IE 7 ]><html class="oldie ie6" lang="en"><![endif]-->
<!--[if IE 7 ]><html class="oldie ie7" lang="en"><![endif]-->
<!--[if IE 8 ]><html class="oldie ie8" lang="en"><![endif]-->
<!--[if IE 9 ]><html class="ie9" lang="en"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en"><!--<![endif]-->
<head>

	<title>Todolist</title>

	<meta charset="UTF-8" />
	<meta name="viewport" content="width=520" />
	<meta http-equiv="cleartype" content="on" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

	<link rel="stylesheet" media="screen" href="css/reset.css" />
	<link rel="stylesheet" media="screen" href="css/screen.css" />

	<script src="js/delete.js"></script>

</head>
<body>

	<div id="siteWrapper">

		<!-- header -->
		<header>
			<h1><a href="index.php">Todolist</a></h1>
		</header>

		<!-- content -->
		<section>

			<div class="box" id="boxCompleteTodo">

				<h2>Complete todo</h2>

				<div class="boxInner">
					<p>Are you sure you want to complete the todo <strong><?php echo htmlentities($item['what']); ?></strong>?</p>
					<form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . htmlentities(urlencode($id)); ?>" method="post">
						<fieldset class="columns">
							<label class="column column-12 cancel alignLeft"><a href="index.php" title="Cancel and go back">Cancel and go back</a></label>
							<label for="btnSubmit" class="column column-12 alignRight"><input type="submit" id="btnSubmit" name="btnSubmit" value="Complete" /></label>
							<input type="hidden" name="id" value="<?php echo htmlentities($id); ?>" />
							<input type="hidden" name="moduleAction" id="moduleAction" value="delete" />
						</fieldset>
					</form>
				</div>

			</div>

<?php

	// show errors (if any)
	if (sizeof($formErrors) > 0) {

		echo '<div class="box" id="boxError"><p>One or more errors were encountered:</p><ul class="errors">' . PHP_EOL;

		foreach ($formErrors as $error) {
			echo '<li>' . $error . '</li>';
		}

		echo '</ul></div>' . PHP_EOL;

	}

?>

		</section>

		<!-- footer -->
		<footer>
			<p>&copy; 2014, <a href="http://www.ikdoeict.be/" title="IkDoeICT.be">IkDoeICT.be</a></p>
		</footer>

	</div>

</body>
</html>