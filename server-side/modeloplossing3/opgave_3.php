<?php 

/**
 * Lab 03, Exercise 3 — Solution
 * @author Bramus Van Damme <bramus.vandamme@kahosl.be>
 */

	// vars

		$basePath = __DIR__ . DIRECTORY_SEPARATOR . 'images'; // C:\wamp\www\vn.an\labo03\images
		$baseUrl = 'images'; // images
		$images = array();


	// Main code

		// Open dir and captions
		$di = new DirectoryIterator($basePath);

		// loop directory
		foreach ($di as $file) {

			if ($file->getExtension() == 'jpg') {
				array_push(
					$images, 
					array(
						'url' => $baseUrl . '/' . $file->getFileName(),
						'caption' => ''
					)
				);
			}

		}

?><!doctype html>
<html>
<head>
	<title>Images</title>
	<meta charset="utf-8" />
	<style>

		body {
			font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", sans-serif;
			font-weight: 300;
			font-size: 14px;
			line-height: 1.2;
			background: #FCFCFC;
		}

		ul {
			margin: 0;
			padding: 0;
			list-style: none;
		}

		li {
			display:  block;
			width: 310px;
			height: 310px;
			float: left;
			border: 1px solid #ccc;
			margin: 20px;
			position: relative;
			box-shadow: 0 0 20px #CCC;

		}

		li img {
			max-width: 100%;
		}

		li .caption {
			display: block;
			position: absolute;
			bottom: 0;
			left: 0;
			right: 0;
			padding: 5px;
			color: #000;
			background: rgba(255,255,255,0.9);
			border-top: 1px solid #ccc;
			text-shadow: 1px 1px 1px #fff;
		}

		li:hover {
			box-shadow: 0 0 20px #999;
		}

	</style>
</head>
<body>
	<ul>
<?php
	foreach ($images as $image) {
		echo '		<li><img src="' . $image['url'] . '" alt="' . htmlentities($image['caption']) . '" title="' . htmlentities($image['caption']) . '" /><span class="caption">' . htmlentities($image['caption']) . '</span></li>' . PHP_EOL;
	}
?>
	</ul>
</body>
</html>