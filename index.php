<?php 
/* DEFAULT MAPS */

$classifications = array("Bare", "Track-Bare", "Partially Snow Covered", "Fully Snow Covered");

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="css/default-v000.css">
	<link rel="stylesheet" type="text/css" href="css/stuff-v000.css">
</head>

<body>
<div id="wrapper">
	<div id="main-window">
		<?php 
		error_reporting(-1);
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
			default:
				include_once("php/classify.php");			
		}
		
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
			
			arsort($files);
			$files = array_keys($files);
			
			return ($files) ? $files : false;
		}
		
		?>
	
	</div>

</div>

</body>
</html>