<?php
if (!empty($_GET['mode'])) $mode= $_GET['mode'];
else $mode = 0;
$page_max_img = 50;
?>
<div class="infobox">
	<span class="item-title">Classified Images, #<?php echo ($mode + 1) . " to " . $page_max_img ?></span>
	<span class="item-action">Click on Image to Re-do Classification</span>
	<div class="file-item-div">
	<?php 
	$files = (scan_dir("img/classified"));
	if ($files != false > 0){
		for ($i = $mode; $i < $page_max_img + $mode && $i < count($files); $i++) {
			$location = "img/classified/" . $files[$i];
			$file_parts = pathinfo($location);
			$json_location = "img/classified/" . $file_parts["filename"] . ".json";
			echo '<div style="display:inline-block;"><a style="display:block; text-align:center;" href="index.php?action=unclassify&mode=' . $file_parts["basename"] . '"><img class="preview-img" src="' . $location. '"></img></a>';
			$json_data = file_get_contents($json_location);
			echo '<span class="file-item">' . json_decode($json_data, true)["word_classification"] . '</span>';
			echo '<a class="file-item" href="' . $location . '" target="_blank">[view]</a>';
			echo '</div>';
		}
	}
	
	?>
	</div>
	<div class="clearer"></div>
	<br>
	<a href="index.php" class="generic-link">[Return to Classification]</a>
	<?php 
	if ($mode >= $page_max_img) {
		echo '<a href="index.php?action=browse&mode=' . (string)($mode - $page_max_img) . '" class="generic-link">[Prev '. $page_max_img .' Images]</a>';
	}
	if (count($files) - $mode > $page_max_img) {
		echo '<a href="index.php?action=browse&mode=' . (string)($mode + $page_max_img) . '" class="generic-link">[Next '. $page_max_img .' Images]</a>';
	}
	?>
	

	<div class="clearer"></div>
</div>