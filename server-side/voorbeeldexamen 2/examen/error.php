<?php
if ($_GET['type'] === 'db') {
	switch ($_GET['detail']) {
		case 'connect':
			$error = 'Could not connect to the database';
			break;
		case 'get':
			$error = 'Could not fetch items from the database';
			break;
		case 'insert':
			$error = 'Could not add data to the database';
			break;
	}
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>An unexpected error occurred</title>
</head>
<body>
<h1><?php echo $error; ?></h1>
</body>
</html>