<div class="infobox">
<span class="item-title">Upload Images</span>

<?php 
if (!empty($_GET['mode'])) $mode= $_GET['mode'];
else $mode = False;

switch ($mode) {
	default:			
		echo '
			<span class="item-action">Upload an archive of images. Max Size of Archive is 32 MiB. <br>To Zip Images in Windows, highlight the image files in the file explorer, right click on them, and select "Send to... compressed folder"</span>	
				<form enctype="multipart/form-data" style="display:block; margin:0.5em 5%; width:90%" action="index.php?action=processarchive" method="post">
			  	<input type="hidden" name="MAX_FILE_SIZE" value="33554432" />
			  	<input type="file" name="archive[]" accept=".zip"><br>
			<span class="item-title">';
}

?>
	  <input type="submit" name="submit" value="Upload"></span>
	</form>
</div>


