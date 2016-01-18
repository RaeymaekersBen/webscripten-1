<?php

/**
 * Lab 02, Exercise 1 — Solution
 * @author Bramus Van Damme <bramus.vandamme@odisee.be>
 */

	// Variable from GET
	$firstname = isset($_GET['firstname']) ? $_GET['firstname'] : '';
    $moduleAction = isset($_GET['moduleAction']) ? $_GET['moduleAction'] : '';

    // Error messages
    $msgFirstname = '*';

    // Form was sent!
    if ($moduleAction == 'processName') {

    	$allOk = true;

    	// Check firstname
    	if (trim($firstname) == '') {
    		$allOk = false;
    		$msgFirstname = 'Please enter your firstname';
    	}

    	if ($allOk === true) {
    		/* @TODO: redirect here */
    	}

    }

?><!DOCTYPE html>
<html>
<head>
	<title>Opgave 1</title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="styles.css" />
</head>
<body>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">

		<fieldset>

			<h2>Opgave_1</h2>

			<dl class="clearfix">

				<dt><label for="firstname">Voornaam</label></dt>
				<dd class="text">
					<input type="text" name="firstname" id="firstname" value="<?php echo htmlentities($firstname); ?>" class="input-text" />
					<span class="message error"><?php echo htmlentities($msgFirstname); ?></span>
				</dd>

				<dt class="full clearfix" id="lastrow">
					<input type="hidden" name="moduleAction" value="processName" />
					<input type="submit" id="btnSubmit" name="btnSubmit" value="Send" />
				</dt>

			</dl>

		</fieldset>

	</form>

	<div id="debug">
<?php
	echo '<pre>';
	var_dump($_GET);
	echo '</pre>';
?>
	</div>

</body>
</html>