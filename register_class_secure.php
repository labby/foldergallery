<?php

/**
 *  @module         foldergallery
 *  @version        see info.php of this module
 *  @author         Jürg Rast, schliffer, Bianka Martinovic, Chio, Pumpi, Aldus, erpe
 *  @copyright      2009-2018 Jürg Rast, schliffer, Bianka Martinovic, Chio, Pumpi, Aldus, erpe 
 *  @license        GNU General Public License
 *  @license terms  see info.php of this module
 *  @platform       see info.php of this module
 * 
 */

global $lepton_filemanager;
if (!is_object($lepton_filemanager)) require_once( "../../framework/class.lepton.filemanager.php" );

$files_to_register = array(
	'/modules/foldergallery_jq/add.php',
	'/modules/foldergallery/delete.php',
	'/modules/foldergallery/modify.php',
	'/modules/foldergallery/modify_cat.php',
	'/modules/foldergallery/modify_cat_sort.php',
	'/modules/foldergallery/modify_settings.php',
	'/modules/foldergallery/modify_thumb.php',     
	'/modules/foldergallery/save_cat.php',
	'/modules/foldergallery/save_files.php',
	'/modules/foldergallery/save_settings.php',
	'/modules/foldergallery/sync.php',
	'/modules/foldergallery/help.php',
	'/modules/foldergallery/backend.functions.php',
	'/modules/foldergallery/delete_cat.php',
	'/modules/foldergallery/delete_img.php',
 	'/modules/foldergallery/move_down.php',
	'/modules/foldergallery/move_up.php',
	'/modules/foldergallery/quick_img_sort.php',
	'/modules/foldergallery/reorderCNC.php',
	'/modules/foldergallery/reorderDND.php'
);

$lepton_filemanager->register( $files_to_register );

?>