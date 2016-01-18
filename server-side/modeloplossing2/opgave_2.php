<?php

/**
 * Lab 02, Exercise 2 — Solution
 * @author Bramus Van Damme <bramus.vandamme@odisee.be>
 */

	$first = isset($_GET['first']) ? $_GET['first']  : rand(0, 100);
	$second = isset($_GET['second']) ? $_GET['second']  : rand(0, 100);
	$moduleAction = isset($_GET['moduleAction']) ? $_GET['moduleAction'] : '';

	// only create sum if BOTH first and second are set/not emptyw
	if (($moduleAction == 'doCalculation') && is_numeric($first) && is_numeric($second)) {
		$sum = $first + $second;
	} else {
		$sum = '';
	}


?><!DOCTYPE html>
<html>
<head>
	<title>Opgave 2</title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="styles.css" />
</head>
<body>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">

		<fieldset>

			<h2>Opgave_2</h2>

			<dl class="clearfix">

				<dt><label for="first">Eerste getal</label></dt>
				<dd class="text"><input type="text" id="first" name="first" value="<?php echo htmlentities($first); ?>" class="input-text" /></dd>

				<dt><label for="second">Tweede getal</label></dt>
				<dd class="text"><input type="text" id="second" name="second" value="<?php echo htmlentities($second); ?>" class="input-text" /></dd>

				<dt><label for="sum">Som</label></dt>
				<dd class="text"><input type="text" id="sum" name="sum" value="<?php echo htmlentities($sum); ?>" class="input-text" disabled="disabled"/></dd>

				<dt class="full clearfix" id="lastrow">
					<input type="hidden" name="moduleAction" value="doCalculation" />
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