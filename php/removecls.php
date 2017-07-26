<div class="infobox">

<br>
<?php
if (!empty($_GET['mode'])) $mode= $_GET['mode'];
else $mode = False;
if ($mode == "yes") {
	rrmdir("img/classified");
	mkdir("img/classified");
	echo '<span class="item-title">All Classified Images Deleted!</span>';
}
else {
	echo '<span class="item-title">Are you sure you want to remove all classified images and their classificaiton results? This action cannot be undone!</span>';
	echo '<a class="item-action" href="index.php?action=deletecls&mode=yes">Remove All Uploaded Classified Images</a>';
}
?>
<a class="item-action" href="index.php">Return to Classification</a>
<br>
</div>