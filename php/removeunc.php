<div class="infobox">

<br>
<?php
if (!empty($_GET['mode'])) $mode= $_GET['mode'];
else $mode = False;
if ($mode == "yes") {
	rrmdir("img/unclassified");
	mkdir("img/unclassified");
	echo '<span class="item-title">All Pending Unclasified Images Deleted!</span>';
}
else {
	echo '<span class="item-title">Are you sure you want to remove all unclassified images? Images must be re-uploaded if classification still desired.</span>';
	echo '<a class="item-action" href="index.php?action=deleteunc&mode=yes">Remove All Uploaded Unclassified Images</a>';
}
?>
<a class="item-action" href="index.php">Return to Classification</a>
<br>
</div>