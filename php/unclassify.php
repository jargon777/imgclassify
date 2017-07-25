<?php

if (!empty($_GET['mode'])) $mode= $_GET['mode'];
else $mode = False;

$location = "img/classified/" . $mode;
$movename = "img/unclassified/" . $mode;
$file_parts = pathinfo($location);
$json_location = "img/classified/" . $file_parts["filename"] . ".json";

unlink($json_location);
rename($location, $movename);

$note = "Unclassified Image " . $file_parts["filename"];

?>