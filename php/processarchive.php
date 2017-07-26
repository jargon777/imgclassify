<div class="infobox">

<?php 
$processzip = False;

if (!empty($_FILES["archive"]) && $_FILES["archive"]["name"][0] != "") {
	if ($_FILES["archive"]["error"][0] == 2) echo "File Exceeds Server Size Limit";
	else {
		$uploaddir = 'img/tmp';
		$uploadfile = $uploaddir . "/" . basename($_FILES['archive']['name'][0]);
		if (move_uploaded_file($_FILES['archive']['tmp_name'][0], $uploadfile)) {
			echo "File Uploaded Successfully...";
			$processzip = True;
		}
		
		echo "Done!";
	}
	
}
elseif (!empty($_POST["filelocation"])) {
	set_time_limit(500);
	$url = $_POST["filelocation"];
	$parseu = parse_url($url);
	if ($parseu["host"] == "www.dropbox.com") {
		$url = "http://" . $parseu["host"] . $parseu["path"] . "?raw=1";
	}
	$uploaddir = 'img/tmp';
	$uploadfile = 'img/tmp/tmp.zip';
	if (copy($url, $uploadfile)) {
		echo "File Copied Successfully";
		$processzip = True;
	}
	else echo "Failed to copy file from URL, is it a Zip File?";
}
else echo("No Files Uploaded <br>");

if ($processzip) {
	$zip = new ZipArchive;
	if ($zip->open($uploadfile) === TRUE) {
		$zip->extractTo($uploaddir);
		$zip->close();
		echo ' Zip Ok...';
		move_to_root("img/unclassified", $uploaddir);
	
		echo ' cleaned tmp...';
		} else {
			echo '<br> ERROR! Could not open archive... is it in Zip Format?';
		}
	rrmdir($uploaddir);
	mkdir($uploaddir);
}

function move_to_root($rootdir, $src) {
	$dir = opendir($src);
	$filesmoved = 0;
	while(false !== ( $file = readdir($dir)) ) {
		if (( $file != '.' ) && ( $file != '..' )) {
			$full = $src . '/' . $file;
			if ( is_dir($full) ) {
				move_to_root($rootdir, $full);
			}
			else {
				$file_parts = pathinfo($full);
				$movename = $rootdir . '/' . $file_parts["filename"] . "." . $file_parts["extension"];
				$allowed_images = array("jpg", "JPG", "jpeg", "JPEG", "gif", "GIF", "png", "PNG", "bmp", "BMP");
				for ($i = 1; ; $i++) {
					if (file_exists($movename)) {
						if (hash_file("md5", $movename) == hash_file("md5", $full)) {
							echo("<br>File " . $file_parts["basename"] . " exists already in the unclassified folder");
							break;
						}
						else $movename = $rootdir . '/' . $file_parts["filename"] . "-" . $i . "." . $file_parts["extension"];
					}
					elseif (in_array($file_parts["extension"], $allowed_images)) {
						rename($full, $movename);
						$filesmoved++;
						break;
					}
					else {
						if ($file_parts["extension"] != "zip") echo("<br>File " . $file_parts["basename"] . " is not a valid image...");
						break;
					}
				}
			}
		}
	}
	echo "<br>" . $filesmoved . " files uploaded to unclassified folder from " . $src . "...";
	closedir($dir);
}



?>

<br><br>
<a href="index.php">Return to Classification</a>
</div>