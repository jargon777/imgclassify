<?php
if (isset($_GET["img"])) {
	$img = array();
	$img["filename"] = $_GET["img"];
	if (count($_POST) == count($categories) + 1) {
		// transfer all data into the img
		foreach ($_POST as $key => $value) { 
			if ($key == "submit") continue;
			$key = str_replace('_', ' ', $key);
			$img[$key . "-numeric"] = $value;
			$img[$key . "-word"] = $categories[$key][$value];
		}
		$img["datetime_classified"] = time();
		
		
		/* MOVE FILE TO CLASSIFIED FOLDER */
		$full = "img/unclassified/" . $img["filename"];
		$file_parts = pathinfo($full);
		$json_loc = "img/classified/" . $file_parts["filename"] . ".json";
		$movename = 'img/classified/' . $file_parts["filename"] . "." . $file_parts["extension"];
		for ($i = 1; ; $i++) {
			if (file_exists($movename)) {
				if (hash_file("md5", $movename) == hash_file("md5", $full)) {
					$note = "<br>File " . $file_parts["basename"] . " exists in classified archive. Classification over-written.";
					unlink($movename);
					unlink($json_loc);
					break;
				}
				else $movename = $rootdir . '/' . $file_parts["filename"] . "-" . $i . "." . $file_parts["extension"];
			}
			else {
				break;
			}
		}
		rename($full, $movename);
		$fp = fopen($json_loc, 'wb');
		fwrite($fp, json_encode($img, JSON_PRETTY_PRINT));
		fclose($fp);
		
	}
	else {
		$note = "Failed to Classify " . $img["filename"]. "! Image Classification Missing...";
	}
}
?>