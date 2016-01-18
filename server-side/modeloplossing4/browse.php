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


		$priorities = array('low','normal','high'); // The possible priorities of a todo
		$formErrors = array(); // The encountered form errors

		$what = isset($_POST['what']) ? $_POST['what'] : ''; // The todo that was sent in via the form
		$priority = isset($_POST['priority']) ? $_POST['priority'] : 'low'; // The priority that was sent in via the form


	/**
	 * Handle action 'add' (user pressed add button)
	 * ----------------------------------------------------------------
	 */

		if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'add')) {


			// Check form: what not filled in
			if (trim($what) === '') {
				$formErrors[] = 'Please enter a name/description for your todo';
			}

			// Check form: priority not a correct value
			if (!in_array($priority, $priorities)) {
				$formErrors[] = 'Invalid priority selected';
			}

			// form is correct: insert values into database
			if (sizeof($formErrors) == 0) {

				// build & execute prepared statement
				$stmt = $db->prepare('INSERT INTO todolist (what, priority, added_on) VALUES (?, ?, ?)');
				$stmt->execute(array($what, $priority, (new DateTime())->format('Y-m-d H:i:s')));

				// the query succeeded, redirect to this very same page
				if ($db->lastInsertId() !== 0) {
					header('location: browse.php');
					exit();
				}

				// the query failed
				else {
					 $formErrors[] = 'Error while inserting the item. Please retry.';
				}

			}

		}


	/**
	 * No action to handle: show our page itself
	 * ----------------------------------------------------------------
	 */

		// Get all todo items from databases
		$stmt = $db->prepare('SELECT * FROM todolist ORDER BY priority, what DESC');
		$stmt->execute();

		$items = $stmt->fetchAll(PDO::FETCH_ASSOC);



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

	<script src="js/browse.js"></script>

</head>
<body>

	<div id="siteWrapper">

		<!-- header -->
		<header>
			<h1><a href="index.php">Todolist</a></h1>
		</header>

		<!-- content -->
		<section>

			<div class="box" id="boxAddTodo">

				<h2>Add new todo</h2>

				<div class="boxInner">
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
						<fieldset>
							<dl class="clearfix columns">
								<dd class="column column-46"><input type="text" name="what" id="what" value="<?php echo htmlentities($what); ?>" /></dd>
								<dd class="column column-16" id="col-priority">
									<select name="priority" id="priority">
<?php
	foreach ($priorities as $prio) {
		echo '<option value="' . $prio . '"' . (($priority == $prio) ? ' selected="selected"' : '') . '>' . $prio . '</option>' . PHP_EOL;
	}
?>
									</select>
								</dd>
								<dd class="column column-16" id="col-submit">
									<label for="btnSubmit"><input type="submit" id="btnSubmit" name="btnSubmit" value="Add" /></label>
									<input type="hidden" name="moduleAction" id="moduleAction" value="add" />
								</dd>
							</dl>
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

			<div class="box" id="boxYourTodos">

				<h2>Your todos</h2>

				<div class="boxInner">

<?php

	// if any todoitems are found, show them inside <ul></ul> using the struct below
	if (sizeof($items) > 0) {

		echo '<ul>' . PHP_EOL;

		foreach ($items as $item) {

			echo '<li id="item-' . $item['id'] . '" class="item ' . $item['priority'] . ' clearfix">' . PHP_EOL
				.'	<a href="delete.php?id=' . urlencode($item['id']) . '" class="delete" title="Delete/Complete this item">delete/complete</a>' . PHP_EOL
				.'	<a href="edit.php?id=' . urlencode($item['id']) . '" class="edit" title="Edit this item">edit</a>' . PHP_EOL
				.'	<span>' . htmlentities($item['what']) . '</span>' . PHP_EOL
				.'</li>' . PHP_EOL;

		}

		echo '</ul>' . PHP_EOL;

	}

	// if no todoitems are found, show a userfriendly message
	else {
		echo '<p>No todos, it must be your lucky day!</p>' . PHP_EOL;
	}

?>
				</div>

			</div>

		</section>

		<!-- footer -->
		<footer>
			<p>&copy; 2014, <a href="http://www.ikdoeict.be/" title="IkDoeICT.be">IkDoeICT.be</a></p>
		</footer>

	</div>

</body>
</html>