<div class="infobox">

<?php 
if (!empty($_FILES["archive"]) && $_FILES["archive"]["name"][0] != "") {
	if ($_FILES["archive"]["error"][0] == 2) echo "File Exceeds Server Size Limit";
	else {
		$uploaddir = 'img/tmp';
		$uploadfile = $uploaddir . "/" . basename($_FILES['archive']['name'][0]);
		if (move_uploaded_file($_FILES['archive']['tmp_name'][0], $uploadfile)) {
			echo "File Uploaded Successfully...";
			
			$zip = new ZipArchive;
			if ($zip->open($uploadfile) === TRUE) {
				$zip->extractTo($uploaddir);
				$zip->close();
				echo ' Zip Ok...';
				move_to_root("img/unclassified", $uploaddir);
				rrmdir($uploaddir);
				mkdir($uploaddir);
				
				echo ' cleaned tmp...';
			} else {
				echo '<br> ERROR! Could not open archive... is it in Zip Format?';
			}
			
			
			
			
			/*******************CLEARNUP******************
			rrmdir($uploaddir)
			mkdir($uploaddir)
			/********************************************/
		}
		else echo "<br> ERROR! Failed to Upload File... PHP error is " . (string)($_FILES['archive']["error"][0]);
		echo "Done!";
	}
	
}
else echo("No Files Uploaded <br>");


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
				for ($i = 1; ; $i++) {
					if (file_exists($movename)) {
						if (hash_file("md5", $movename) == hash_file("md5", $full)) {
							echo("<br>File " . $file_parts["basename"] . " exists already in the unclassified folder");
							break;
						}
						else $movename = $rootdir . '/' . $file_parts["filename"] . "-" . $i . "." . $file_parts["extension"];
					}
					elseif ($file_parts["extension"] == "jpg" || $file_parts["extension"] == "png" || $file_parts["extension"] == "jpeg" || $file_parts["extension"] == "gif" || $file_parts["extension"] == "bmp") {
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