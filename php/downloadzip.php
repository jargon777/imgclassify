<div class="infobox">

<br>

<?php 
if (!empty($_GET['mode'])) $mode= $_GET['mode'];
else $mode = False;

if ($mode) {
	$readloc = "img/classified";
	$temploc = "img/zip";
	if (!file_exists($temploc)) mkdir($temploc);
	$csvloc = "img/zip/_classified.csv";
	$ziploc = "img/zip/classified.zip";
	if (file_exists($ziploc)) unlink($ziploc);
	$csvfile = fopen($csvloc, "w");
	$array_headers = false;
	
	$zip = new ZipArchive();
	$zip_r = $zip->open($ziploc, ZipArchive::CREATE);
	if ($zip_r === True) {
	
		$files = (scan_dir($readloc));
		for ($i = 0; $i < count($files); $i++) {
			$location = "img/classified/" . $files[$i];
			$file_parts = pathinfo($location);
			$json_location = "img/classified/" . $file_parts["filename"] . ".json";
			$json_data = file_get_contents($json_location);
			$json_data = json_decode($json_data, true);
			if (!$array_headers) fputcsv($csvfile, array_keys($json_data)); $array_headers=true;
			fputcsv($csvfile, array_values($json_data));
			if ($mode == "bare") {
				$zip->addFile($location, $files[$i]);
				$zip->addFile($json_location, $file_parts["filename"] . ".json");
			}
			elseif ($mode == "folder") {
				$filerootname = $json_data["Road Surface Condition-numeric"] . "/";
				$zip->addFile($location, $filerootname . $files[$i]);
				$zip->addFile($json_location, $filerootname . $file_parts["filename"] . ".json");
			}
		}
		fclose($csvfile);
		$zip->addFile($csvloc, "_classified.csv");
		$zip->close();
		echo '<span class="item-title">Zip File Created</span>';
		echo '<a class="item-action" href="img/zip/classified.zip">Download Zip Archive</a>';
	}
	else echo "Could not create zip file!";
	
	
}
else {
	echo '<span class="item-title">Choose Export Structure</span>';
	echo '<span class="item-title">Large Repositories of Classified Images May Take Long to Process! Do Not Refresh the Page!</span><span class="item-action">Classification data is stored in JSON files that have numeric and word values for each of the classification options.<br>A CSV file is also generated indexed based on the file names and is included in the root directory of the zip.</span><br>';
	echo '<a class="item-action" href="index.php?action=downloadzip&mode=folder">Export Images and JSON in Separate Folder For Each RSC Classification Level.</a>';
	echo '<a class="item-action" href="index.php?action=downloadzip&mode=bare">Export All Images and JSON in Same Folder</a>';
}
?>
<br>
<a class="item-action" href="index.php">Return to Classification</a>
<br>
</div>