<?php

/**
 *  @module         foldergallery
 *  @version        see info.php of this module
 *  @author         Aldus, erpe (initiated by Jürg Rast)
 *  @copyright      2009-2018 Aldus, erpe 
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

/*
 * Add new db entry
 * root_dir is set to module_guid to check, if directory is set
 */
 $oFG = foldergallery::getInstance();
 $database->simple_query("INSERT INTO `" .TABLE_PREFIX ."mod_foldergallery_settings` (`page_id`, `section_id`, `root_dir`, `extensions`) VALUES(".$page_id.", ".$section_id.", '".$oFG->module_guid."', '".$oFG->fg_extensions."') ");
?>