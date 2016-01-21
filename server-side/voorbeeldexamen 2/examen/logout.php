<?php
session_start();
if (isset($_SESSION['user'])) {
	foreach ($_SESSION as $key => $value) unset($_SESSION[$key]);
}
session_destroy();
header('Location: index.php');
exit();