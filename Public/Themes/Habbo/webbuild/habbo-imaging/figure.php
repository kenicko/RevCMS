<?php

	define('BASE', 'http://www.habbo.dk/habbo-imaging/avatarimage?figure=');
    $figure = $_GET['figure'];
    $position = (isset($_GET['direction']) ? $_GET['direction'] : $_GET['position']);
    $size = isset($_GET['size']) ? $_GET['size'] : 'b';
    $gesture = isset($_GET['gesture']) ? $_GET['gesture'] : 'sml';
    $gesture = isset($_GET['action']) ? $_GET['action'] : 'std';

  
    $src = imagecreatefrompng(BASE . $figure . '&direction=' . $position . '&head_direction=' . $position . '&size=' . $size);
  
    imagealphablending($src, true); // alpha blending on
    imagesavealpha($src, true); // save alphablending (important)
  
    header('Content-Type: image/png');
  
    $outputString = imagepng($src);
    $outputString .= "(c) sulake!"; // copyright shit, should work
  
    echo $outputString;
    imagedestroy($src);

?>