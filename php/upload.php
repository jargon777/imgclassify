<div class="infobox">
<span class="item-title">Upload Images</span>

<?php 
if (!empty($_GET['mode'])) $mode= $_GET['mode'];
else $mode = False;

switch ($mode) {
	case ("http"):
		echo '
			<span class="item-action">Paste a link to an archive of the images. After pressing Upload, the next stage may take time as the images must be downloaded to this server. Please be patient.</span>
			<span class="item-action">Archives bigger than 100MiB not reccomended. Dropbox links can be processed automatically if you paste the shareable link. For other services, please ensure you get a direct link to the file. If you paste the link in your browser, it should ask to "download" that file.</span>
				<form enctype="multipart/form-data" style="display:block; margin:0.5em 5%; width:90%" action="index.php?action=processarchive" method="post">
			  	<input style="width:100%" type="text" name="filelocation"><br>
			<span class="item-title">';
		break;
	default:			
		echo '
			<span class="item-action">Upload an archive of images. Max Size of Archive is 32 MiB. <br>To Zip Images in Windows, highlight the image files in the file explorer, right click on them, and select "Send to... compressed folder"</span>	
				<form enctype="multipart/form-data" style="display:block; margin:0.5em 5%; width:90%" action="index.php?action=processarchive" method="post">
			  	<input type="hidden" name="MAX_FILE_SIZE" value="33554432" />
			  	<input type="file" name="archive[]" accept=".zip"><br>
			<span class="item-title">';
		break;
}

?>
	  <input type="submit" name="submit" value="Upload"></span>
	</form>
	<a href="index.php">Return to Classification</a>
</div>


