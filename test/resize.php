<?php
	// File and new size
	$filename = 'logo.png';
	$percent = 0.5;

	// Content type
	header('Content-type: image/png');

	// Get new sizes
	list($width, $height) = getimagesize($filename);
	$newwidth = $width * $percent;
	$newheight = $height * $percent;

	// Load
	$thumb = imagecreatetruecolor($newwidth, $newheight);
	$source = imagecreatefrompng($filename);

	// Resize
	imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

	// Output
	imagepng($thumb);
?>
