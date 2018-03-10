<?php

/**
 *  @module         foldergallery
 *  @version        see info.php of this module
 *  @author         cms-lab (initiated by Jürg Rast)
 *  @copyright      2010-2018 cms-lab 
 *  @license        GNU General Public License
 *  @license terms  see info.php of this module
 *  @platform       see info.php of this module
 * 
 */



$files_to_register = array(
	'add.php',
	'delete.php',
	'modify.php',
	'modify_cat.php',
	'modify_cat_sort.php',
	'modify_settings.php',
	'modify_thumb.php',     
	'save_cat.php',
	'save_files.php',
	'save_settings.php',
	'sync.php',
	'help.php',
	'backend.functions.php',
	'delete_cat.php',
	'delete_img.php',
 	'move_down.php',
	'move_up.php',
	'quick_img_sort.php',
	'reorderCNC.php',
	'reorderDND.php'
);

LEPTON_secure::getInstance()->accessFiles( $files_to_register );

?>