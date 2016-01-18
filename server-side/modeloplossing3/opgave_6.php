<?php  

/**
 * Lab 03, Exercise 6 — Solution
 * @author Bramus Van Damme <bramus.vandamme@kahosl.be>
 */

	// helper functions

		/**
		 * Format a filesize in a human readable format
		 * @param int
		 * @return string
		 * @see http://www.php.net/manual/en/function.filesize.php#99333
		 */
		function format_size($size) {
			$sizes = array(" Bytes", " kB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
			if ($size == 0) { return('n/a'); } else {
			return (round($size/pow(1024, ($i = floor(log($size, 1024)))), $i > 1 ? 2 : 0) . $sizes[$i]); }
		}


	// vars

		$path = isset($_GET['path']) ? $_GET['path'] : '';
		$basePath = __DIR__ . DIRECTORY_SEPARATOR . $path;
		$baseUrl = $path;
		$dirs = [];
		$files = [];


	// Checks

		if (strstr($path, '..')) exit('Possibly a dangerous path!');
		if (!file_exists($basePath)) exit('Invalid Path!');


	// Main code

		// Create directory iterator
		$di = new DirectoryIterator($basePath);

		// add 'up level is necessary'
		if ($path != '') {
			$dirs[] = array(
				'type' => 'up',
				'name' => '..',
				'extension' => '',
				'link' => substr($baseUrl, 0, strrpos($baseUrl, '/'))
			);
		}

		// loop directory children
		foreach ($di as $child) {

			// Files
			if ($child->isFile()) {

				// store the image
				$files[] = array(
					'type' => 'file',
					'name' => (string) $child,
					'extension' => $child->getExtension(),
					'size' => format_size($child->getSize()),
					'link' => $baseUrl . '/' . $child
				);

			} 

			// Directory
			else if ($child->isDir() && !$child->isDot()) {

				// store the image
				$dirs[] = array(
					'type' => 'folder',
					'name' => (string) $child,
					'extension' => '',
					'link' => (($baseUrl == '') ? (substr($baseUrl . '/' . $child, 1)) : ($baseUrl . '/' . $child))
				);

			}

		}

?><!doctype html>
<html>
<head>
	<title>Filebrowser</title>
	<meta charset="utf-8" />
	<style>
		ul {
			margin: 0;
			padding: 0;
		}
		li {
			list-style: none;
			display: block;
			height: 24px;
			line-height: 24px;
			font-family: monospace;
			padding-left: 24px;
		}

		li {
			background: transparent url(images/icons/default.gif) no-repeat 0 50%;
		}

		li.folder {
			background-image: url(images/icons/folder.gif);
		}

		li.up {
			background-image: url(images/icons/up.gif);
		}

		li.jpg {
			background-image: url(images/icons/jpg.gif);
		}

		li.zip {
			background-image: url(images/icons/zip.gif);
		}

		li.php {
			background-image: url(images/icons/php.gif);
		}

		li.txt {
			background-image: url(images/icons/txt.gif);
		}

		/* @todo: other extensions */

		li:nth-child(2n) {
			background-color: rgba(0,0,0,0.05);
		}

		li:hover {
			background-color: #c2e1ff;
		}
	</style>
</head>
<body>

	<h1>Browsing <code><?php echo $basePath ;?></code></h1>

	<ul>
<?php

	foreach ($dirs as $dir) {
		echo '		<li class="' . $dir['type'] . '"><a href="' . $_SERVER['PHP_SELF'] . '?path=' . urlencode($dir['link']) . '">' . $dir['name'] . '</a></li>' . PHP_EOL;
	}

	foreach ($files as $file) {
		echo '		<li class="' . $file['type'] . ' ' . $file['extension'] . '"><a href="' . $file['link'] . '">' . $file['name'] . '</a> <em>(' . $file['size'] . ')</em></li>' . PHP_EOL;
	}
?>
	</ul>

</body>
</html>