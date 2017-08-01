<div id="left">	
	<div class="infobox">
		<?php 
			$pictures_to_preview = 6;
		
			if (!empty($_GET['skip'])) $skip = $_GET['skip'];
			else $skip = 0;
			$path = 'img/unclassified';
			$dir = opendir($path);
			$unclassified = array();
			/*
			$unclassified = array();
			for ($i = 0; $dir && ($file = readdir($dir)) !== false && $i < 20; $i++) {
				if (( $file != '.' ) && ( $file != '..' )) {
					$full = $path. '/' . $file;
					$unclassified[] = $full;
				}
			}*/
			$unclassified_dir_f = (scan_dir("img/unclassified"));
			for ($i = 0; $i < $skip; $i++) {
				array_shift($unclassified_dir_f);
			}
			if (count($unclassified_dir_f) == 0) $unclassified[] = "img/noimg.png";
			else {
				for ($i = 0; $i < $pictures_to_preview + 1 && $i < count($unclassified_dir_f); $i++) {
					$unclassified[] = "img/unclassified/" . $unclassified_dir_f[$i];
				}
			}
			//closedir($dir);
			echo '<a href="' . $unclassified[0] . '" target="_blank"><img style="margin: 1% 2.5%; width:95%" src="' . $unclassified[0] . '"></img></a>';
			$file_parts = pathinfo($unclassified[0]);
			$create_time = filemtime($unclassified[0]);
			echo '<span id="picture-name">' . $file_parts["basename"] . '<br>Uploaded '. date("Y M d", $create_time) . '</span>';
		?>
		<div style="display:block;">
		<?php 
			if ($skip > 0) echo '<a id="prev-picture-link" href="index.php?skip='. (string)($skip - 1) . '">&#x1f880 Unskip</a>';
			echo '<a id="next-picture-link" href="index.php?skip='. (string)($skip + 1) . '">Skip Picture &#x1f882</a>';
			?>
			<div class="clearer"></div>
			
		</div>
	</div>
	<div class="infobox">
	<span class="section-title">Classify Image</span>	
		<form style="display:inline-block; margin:0.5em 5%; text-align:left;" <?php echo 'action="index.php?action=saveclassify&img=' . urlencode($file_parts["basename"]) . '&skip=' . $skip . '"';?> method="post">
		<?php 
		if ($unclassified[0] == "img/noimg.png") {
			echo "No Images to Classify";
		}
		else {
			$imgdat = array();
			if (count($_POST) == count($categories) + 1) {
				foreach ($_POST as $key => $value) {
					if ($key == "submit") continue;
					$key = str_replace('_', ' ', $key);
					$imgdat[$key . "-numeric"] = $value;
					$imgdat[$key . "-word"] = $categories[$key][$value];
				}
			}
			foreach ($categories as $key => $value) {
				echo '<div class="optionholder">';
				echo '<span class="item-title" style="text-align:left;">' . $key .'</span>';
				for ($i = 0; $i < count($value); $i++) {
					if ($i != 0) echo "<br>";
					echo '<input type="radio" name="' . $key . '" value="' . (string)$i . '"';
					if (isset($imgdat[$key . "-numeric"]) && ($imgdat[$key . "-numeric"] == $i)) echo " checked ";
					echo '> ';
					echo (string)$value[$i];
				}
				echo '</div>';
			}
		}
		?>
		<span class="item-title"><br>
		  <input type="submit" name="submit" value="Save Clasification"></span>
		</form>
		<a id="next-picture-link" style="display:block; width:100%;" href="/">Exit Classification System</a>
		<div class="clearer"></div>
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
	<a class="item-action" href="index.php?action=deleteunc">Remove All Uploaded Unclassified Images</a>
	<a class="item-action" href="index.php?action=deletecls">Remove All Classified Images</a>
	<a class="item-action" href="index.php?action=browse">Browse Classified Images</a>
	<br>
	<span class="item-title">Import Images</span>
	<a class="item-action" href="index.php?action=newphoto&mode=default">Direct Upload New Images (ZIP)</a>
	<a class="item-action" href="index.php?action=newphoto&mode=http">HTTP Link Upload New Images (ZIP, e.g. from Dropbox)</a>
	<br>
	<span class="item-title">Export Classification</span>
	<a class="item-action" href="index.php?action=downloadzip">Download Classified Image Archive (JSON, CSV)</a>
	
	
	<br>
	<span class="item-title">Next <?php echo $pictures_to_preview; ?> Unclassified Images</span>
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
	<br><span class="item-title">Last 20 Classified Images</span>
	<span class="item-action">Click on Image to Re-do Classification</span>
	<div class="file-item-div">
	<?php 
	$files = (scan_dir("img/classified"));
	if ($files != false > 0){
		for ($i = count($files) - 1; $i >= 0 && $i > count($files) - 20; $i--) {
			$location = "img/classified/" . $files[$i];
			$file_parts = pathinfo($location);
			$json_location = "img/classified/" . $file_parts["filename"] . ".json";
			echo '<div style="display:inline-block;"><a style="display:block; text-align:center;" href="index.php?action=unclassify&mode=' . $file_parts["basename"] . '&skip=' . $skip . '"><img class="preview-img" src="' . $location. '"></img></a>';
			$json_data = file_get_contents($json_location);
			echo '<span class="file-item">' . json_decode($json_data, true)["Road Surface Condition-word"] . '</span></div>';
		}
	}
	
	?>
	
	</div>
	<div class="clearer"></div>
	</div>
</div>