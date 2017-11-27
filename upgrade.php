<?php

/**
 *  @module         foldergallery_jq
 *  @version        see info.php of this module
 *  @author         Jürg Rast, schliffer, Bianka Martinovic, Chio, Pumpi, Aldus, erpe
 *  @copyright      2009-2017 Jürg Rast, schliffer, Bianka Martinovic, Chio, Pumpi, Aldus, erpe 
 *  @license        GNU General Public License
 *  @license terms  see info.php of this module
 *  @platform       see info.php of this module
 * 
 */
 
// include class.secure.php to protect this file and the whole CMS!
if (defined('LEPTON_PATH')) {	
	include(LEPTON_PATH.'/framework/class.secure.php'); 
} else {
	$oneback = "../";
	$root = $oneback;
	$level = 1;
	while (($level < 10) && (!file_exists($root.'/framework/class.secure.php'))) {
		$root .= $oneback;
		$level += 1;
	}
	if (file_exists($root.'/framework/class.secure.php')) { 
		include($root.'/framework/class.secure.php'); 
	} else {
		trigger_error(sprintf("[ <b>%s</b> ] Can't include class.secure.php!", $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
	}
}
// end include class.secure.php

/**
 *  delete not needed files
 */
$file_names = array(
	"/modules/foldergallery_jq/backend.js",
	"/modules/foldergallery_jq/backend.css",
	"/modules/foldergallery_jq/backend_body.js",
	"/modules/foldergallery_jq/frontend.js",
	"/modules/foldergallery_jq/frontend.css"
); 
LEPTON_handle::delete_obsolete_files ($file_names); 
 
/**
 *  delete obsolete directories
 */
$directory_names = array(
	'/modules/foldergallery_jq/scripts/highslide',
	'/modules/foldergallery_jq/scripts/jquery',
	'/modules/foldergallery_jq/scripts/fancybox',
	'/modules/foldergallery_jq/scripts/galleryview',
	'/modules/foldergallery_jq/scripts/lightbox2',
	'/modules/foldergallery_jq/scripts/pirobox'
);  
LEPTON_handle::delete_obsolete_directories($directory_names);

?>