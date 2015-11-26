<?php

/**
 *  @module         foldergallery_jq
 *  @version        see info.php of this module
 *  @author         Jürg Rast; schliffer; Bianka Martinovic; Chio; Pumpi,Aldus; erpe
 *  @copyright      2009-2016 Jürg Rast; schliffer; Bianka Martinovic; Chio; Pumpi,Aldus; erpe 
 *  @license        GNU General Public License
 *  @license terms  see info.php of this module
 *  @platform       see info.php of this module
 * 
 */

global $lepton_filemanager;
if (!is_object($lepton_filemanager)) require_once( "../../framework/class.lepton.filemanager.php" );

$files_to_register = array(
	'/modules/foldergallery_jq_jq/add.php',
	'/modules/foldergallery_jq/delete.php',
	'/modules/foldergallery_jq/modify.php',
	'/modules/foldergallery_jq/modify_cat.php',
	'/modules/foldergallery_jq/modify_cat_sort.php',
	'/modules/foldergallery_jq/modify_settings.php',
	'/modules/foldergallery_jq/modify_thumb.php',     
	'/modules/foldergallery_jq/save_cat.php',
	'/modules/foldergallery_jq/save_files.php',
	'/modules/foldergallery_jq/save_settings.php',
	'/modules/foldergallery_jq/sync.php',
	'/modules/foldergallery_jq/help.php',
	'/modules/foldergallery_jq/backend.functions.php',
	'/modules/foldergallery_jq/delete_cat.php',
	'/modules/foldergallery_jq/delete_img.php',
 	'/modules/foldergallery_jq/move_down.php',
	'/modules/foldergallery_jq/move_up.php',
	'/modules/foldergallery_jq/quick_img_sort.php',
	'/modules/foldergallery_jq/reorderCNC.php',
	'/modules/foldergallery_jq/reorderDND.php'
);

$lepton_filemanager->register( $files_to_register );

?>