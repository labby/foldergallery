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
$temp_path = LEPTON_PATH."/modules/foldergallery_jq/backend.js";
if (file_exists($temp_path)) {
	$result = unlink ($temp_path);
	if (false === $result) {
		echo "Cannot delete file ".$temp_path.". Please check file permissions and ownership or delete file manually.";
	}
}

$temp_path = LEPTON_PATH."/modules/foldergallery_jq/backend.css";
if (file_exists($temp_path)) {
	$result = unlink ($temp_path);
	if (false === $result) {
		echo "Cannot delete file ".$temp_path.". Please check file permissions and ownership or delete file manually.";
	}
}

$temp_path = LEPTON_PATH."/modules/foldergallery_jq/backend_body.js";
if (file_exists($temp_path)) {
	$result = unlink ($temp_path);
	if (false === $result) {
		echo "Cannot delete file ".$temp_path.". Please check file permissions and ownership or delete file manually.";
	}
}

$temp_path = LEPTON_PATH."/modules/foldergallery_jq/frontend.js";
if (file_exists($temp_path)) {
	$result = unlink ($temp_path);
	if (false === $result) {
		echo "Cannot delete file ".$temp_path.". Please check file permissions and ownership or delete file manually.";
	}
}

$temp_path = LEPTON_PATH."/modules/foldergallery_jq/frontend.css";
if (file_exists($temp_path)) {
	$result = unlink ($temp_path);
	if (false === $result) {
		echo "Cannot delete file ".$temp_path.". Please check file permissions and ownership or delete file manually.";
	}
}

// delete obsolete directories
require_once(LEPTON_PATH . '/framework/summary.functions.php');
rm_full_dir(LEPTON_PATH . '/modules/foldergallery_jq/scripts/highslide');
rm_full_dir(LEPTON_PATH . '/modules/foldergallery_jq/scripts/jquery');
rm_full_dir(LEPTON_PATH . '/modules/foldergallery_jq/scripts/fancybox');
rm_full_dir(LEPTON_PATH . '/modules/foldergallery_jq/scripts/galleryview');
rm_full_dir(LEPTON_PATH . '/modules/foldergallery_jq/scripts/lightbox2');
rm_full_dir(LEPTON_PATH . '/modules/foldergallery_jq/scripts/pirobox');
?>