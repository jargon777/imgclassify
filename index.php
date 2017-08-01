<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="css/default-v000.css">
	<link rel="stylesheet" type="text/css" href="css/stuff-v000.css">
	<title>Manual Image Classification System</title>
</head>

<body>
<div id="wrapper">
<h1>Manual Image Classifier</h1>
	<div id="main-window">
		<?php 
		include_once("php/categories.php"); //edit this file to add additional categories/options.
		
		//SWITCH on the actions that the web app does.
		if (!empty($_GET['action'])) $action = $_GET['action'];
		else $action = False;
		
		switch ($action) {
			case "newphoto":
				include_once("php/upload.php");
				break;
			case "processarchive":
				include_once("php/processarchive.php");
				break;
			case "deleteunc":
				include_once("php/removeunc.php");
				break;
			case "deletecls":
				include_once("php/removecls.php");
				break;
			case "saveclassify":
				include_once("php/saveclassification.php");
				include_once("php/classify.php");
				break;
			case "unclassify":
				include_once("php/unclassify.php");
				include_once("php/classify.php");
				break;
			case "browse":
				include_once("php/browse.php");
				break;
			case "downloadzip":
				include_once("php/downloadzip.php");
				break;
			default:
				include_once("php/classify.php");			
		}
		
		
		//FUNCTIONs that are used throughout the application.
		function rrmdir($src) {
			$dir = opendir($src);
			while(false !== ( $file = readdir($dir)) ) {
				if (( $file != '.' ) && ( $file != '..' )) {
					$full = $src . '/' . $file;
					if ( is_dir($full) ) {
						rrmdir($full);
					}
					else {
						unlink($full);
					}
				}
			}
			closedir($dir);
			rmdir($src);
		}
		
		function scan_dir($dir) {
			$ignored = array('.', '..', '.svn', '.htaccess');
			$filter = array('json');
			
			$files = array();
			foreach (scandir($dir) as $file) {
				if (in_array($file, $ignored)) continue;
				$file_parts = pathinfo($file);
				if (in_array($file_parts["extension"], $filter)) continue;
				$files[$file] = filemtime($dir . '/' . $file);
			}
			
			/*arsort($files);
			$files = array_keys($files);*/
			$files = array_keys($files);
			sort($files);

			return ($files) ? $files : false;
		}
		
		?>
	
	</div>

</div>

</body>
</html>