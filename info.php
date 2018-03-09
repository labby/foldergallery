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

$module_directory	= 'foldergallery';
$module_name		= 'Foldergallery';
$module_function	= 'page';
$module_version		= '3.0.0';
$module_platform	= '4.x';
$module_author		= 'Aldus, erpe';
$module_license		= 'GNU General Public License';
$module_description	= 'Create an Image Gallery with folders as categories.';
$module_home		= 'http://cms-lab.com/';
$module_guid		= 'c362eb43-878d-492f-906f-57a07da6d0f6';

	
	/**
	 *  IMPORTANT
	 *  All variables and constants are set in
	 *  class foldergallery
	**/ 

?>