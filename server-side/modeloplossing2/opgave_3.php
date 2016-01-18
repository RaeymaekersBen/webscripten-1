<?php

/**
 * Lab 02, Exercise 3 — Solution
 * @author Bramus Van Damme <bramus.vandamme@odisee.be> and Joris Maervoet <joris.maervoet@odisee.be>
 */
 
	$prices = array(
		'4GB' => 45,
		'8GB' => 54,
		'16GB' => 109
	);

	$moduleAction = isset($_POST['moduleAction']) ? $_POST['moduleAction'] : '';
	$memory = isset($_POST['memory']) ? $_POST['memory'] : '';

	$msgPrice = '';

	if (($moduleAction == 'processName') && ($memory !== '')) {
		$msgPrice = 'De prijs is ' . $prices[$memory] . '&euro;';
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Opgave 3</title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="styles.css" />
</head>
<body>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<fieldset>
			<h2>Opgave 3</h2>
			<dl class="clearfix">
				<dt><label>Kies een geheugenmodule:</label></dt>
				<dd class="text">
					<?php
	foreach ($prices as $type => $price) {
		echo '<input type="radio" name="memory" ' . (($memory === $type) ? 'checked' : '') . ' value="' . $type  .'">' . $type . '</input><br/>' . PHP_EOL;
	}
					 ?>
				</dd>
				<span class="text"><?php echo $msgPrice ?></span>
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
	var_dump($_POST);
	echo '</pre>';
?>
	</div>
</body>
</html>