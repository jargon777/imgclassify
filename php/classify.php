<div id="left">	
	<div class="infobox">
		<?php 
			$path = 'img/unclassified';
			$dir = opendir($path);
			$unclassified = array();
			for ($i = 0; $dir && ($file = readdir($dir)) !== false && $i < 20; $i++) {
				if (( $file != '.' ) && ( $file != '..' )) {
					$full = $path. '/' . $file;
					$unclassified[] = $full;
				}
			}
			if (count($unclassified) == 0) $unclassified[] = "img/noimg.png";
			closedir($dir);
			echo '<a href="' . $unclassified[0] . '" target="_blank"><img style="margin: 1% 2.5%; width:95%" src="' . $unclassified[0] . '"></img></a>';
			$file_parts = pathinfo($unclassified[0]);
			$create_time = filemtime($unclassified[0]);
			echo '<span id="picture-name">' . $file_parts["basename"] . '<br>Uploaded '. date("Y M d", $create_time) . '</span>';
		?>
		<div style="display:block;">
			<a id="prev-picture-link" href="index.php?action=undo">Undo</a>
			<a id="next-picture-link" href="index.php?view=0">View Next Picture</a>
			<div class="clearer"></div>
			
		</div>
	</div>
	<div class="infobox">
	<span class="item-title">Classify Image</span>	
		<form style="display:block; margin:0.5em 5%; width:90%" <?php echo 'action="index.php?action=saveclassify&img=' . urlencode($file_parts["basename"]) . '"';?> method="post">
		<?php 
		for ($i = 0; $i < count($classifications); $i++) {
			echo '<input type="radio" name="class_code" value="' . (string)$i . '"> ';
			echo (string)$classifications[$i];
			echo "<br>";
		}
		?>
		<span class="item-title">
		  <input type="submit" name="submit" value="Classify"></span>
		</form>
	</div>
	<?php 
	if (isset($note)) {
		echo '<div class="infobox"><br>';
		echo '<span class="item-title">' . (string)$note . '</span>';
		echo '<br></div>';
	}
	?>
</div>

<div id="right">

	<div class="infobox">
	<span class="item-title">Maintenance Actions</span>
	<a class="item-action" href="index.php?action=newphoto&mode=default">Direct Upload New Images (ZIP)</a>
	<a class="item-action" href="index.php?action=deleteunc">Remove All Uploaded Unclassified Images</a>
	<a class="item-action" href="">Remove All Classified Images</a>
	<a class="item-action" href="index.php?action=browse">Browse Classified Images</a>
	<a class="item-action" href="">Download Classified Image Archive (JSON, CSV)</a>
	<a class="item-action" href="">Download Classification Spreadsheet (CSV)</a>
	
	
	<br>
	<span class="item-title">Next 20 Unclassified Files</span>
	<div class="file-item-div">
		<?php 
		if (count($unclassified > 1)) {
			for ($i = 1; $i < count($unclassified); $i++) {
				echo '<a href="' . $unclassified[$i] . '" target="_blank"><img class="preview-img" src="' . $unclassified[$i] . '"></img></a>';
			}
		}
		
		?>
		<!--  <span class="file-item">IMGTEST.jpg</span><a href="" class="file-item">[view]</a> -->
	</div>
	<div class="clearer"></div>
	<span class="item-title">Last 20 Classified Images</span>
	<span class="item-action">Click on Image to Re-do Classification</span>
	<div class="file-item-div">
	<?php 
	$files = (scan_dir("img/classified"));
	if ($files != false > 0){
		for ($i = 0; $i < 40 && $i < count($files); $i++) {
			$location = "img/classified/" . $files[$i];
			$file_parts = pathinfo($location);
			$json_location = "img/classified/" . $file_parts["filename"] . ".json";
			echo '<div style="display:inline-block;"><a style="display:block; text-align:center;" href="index.php?action=unclassify&mode=' . $file_parts["basename"] . '"><img class="preview-img" src="' . $location. '"></img></a>';
			$json_data = file_get_contents($json_location);
			echo '<span class="file-item">' . json_decode($json_data, true)["word_classification"] . '</span></div>';
		}
	}
	
	?>
	
	</div>
	<div class="clearer"></div>
	</div>
</div>