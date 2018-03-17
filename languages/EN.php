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

//Modul Description
$module_description = 'Create an Image Gallery with folders as categories';

$MOD_FOLDERGALLERY = array(
//Variables for the Frontend
    'VIEW_TITLE' 		=> 'Image Gallery',
    'CATEGORIES_TITLE' 	=> 'Categories',
    'BACK_STRING' 		=> 'Back to overview',
    'FRONT_END_ERROR' 	=> 'This category does not exist or does not contain Images and/or Subcategories!',
    'PAGE'             => 'Page',

//Variables for the Backend
    'PICS_PP' 	=> 'Images per page',
    'LIGHTBOX' 	=> 'Lightbox',

    'MODIFY_CAT_TITLE' 	=> 'Modify categories and image details',
    'MODIFY_CAT' 			=> 'Modify category details:',
    'CAT_NAME' 			=> 'Category name/title:',
    'CAT_DESCRIPTION' 	=> 'Category description:',
    'MODIFY_IMG' 			=> 'Modify images:',
    'IMAGE' 				=> 'Image',
    'IMAGE_NAME' 			=> 'Image name',
    'IMG_CAPTION' 		=> 'Image description',

    'REDIRECT'   			=> 'You will have to make some settings before using the Gallery.'
											. ' You will be forwarded in 2 seconds. (If JavaScript is activated.)',
    'TITEL_BACKEND'  		=> 'Foldergallery Admin',
    'TITEL_MODIFY'  		=> 'Modify categories and images:',
    'SETTINGS'  			=> 'Common settings',
    'ROOT_DIR'  			=> 'Root directory',
    'EXTENSIONS' 			=> 'Allowed extensions',
    'INVISIBLE' 			=> 'Hide folders',
    'NEW_SCANN_INFO' 		=> 'This action has created the database entries. The thumbnails are created when the category is shown the first time.',
    'FOLDER_NAME' 		=> 'Folder name',
    'DELETE' 				=> 'Delete?',
    'ERROR_MESSAGE' 		=> 'No data!',
    'DB_ERROR' 			=> 'Database error!',
    'FS_ERROR' 			=> 'Unable to delete folder!',
    'NO_FILES_IN_CAT' 	=> 'This category does not contain any images!',
    'SYNC' 				=> 'Sync database with filesystem',
    'EDIT_CSS' 			=> 'Edit CSS',
    'FOLDER_IN_FS' 		=> 'Filesystem folder:',
    'CAT_TITLE' 			=> 'Category title:',
    'ACTION' 				=> 'Actions:',
    'NO_CATEGORIES'  		=> 'No categories (=Subfolders) found.<br /><br />The Gallery will work, anyway, but no categories are shown.',
    'EDIT_THUMB'  		=> 'Edit thumbnail',
    'EDIT_THUMB_DESCRIPTION' 		=> '<strong>Please select new image</strong>',
    'EDIT_THUMB_BUTTON' 			=> 'Draw up thumbnail',
    'THUMB_SIZE' 			=> 'Thumbnail size',
    'THUMB_RATIO' 		=> 'Thumbnail ratio',
    'THUMB_NOT_NEW' 		=> 'Dont recreat thumbnails',
    'CHANGING_INFO' 		=> 'Changing <strong>thumb size</strong> or <strong>thumb ratio</strong> will delete (and recreate) all thumbs.',
    'SYNC_DATABASE' 		=> 'Synchronize file system with database...',
    'SAVE_SETTINGS' 		=> 'Settings are stored...',
    'SORT_IMAGE' 			=> 'Sort images',
    'BACK' 				=> 'Back',
    'REORDER_INFO_STRING'    => 'Reorder result will be displayed here.',
    'HELP_INFORMATION'       => 'Help / Info',

    'Ration_square'       => 'square',

	'REORDER_IMAGES_STRING' => 'Sort images',
	'QUICK_SORT_STRING'		=> 'Sort images by filename.',
	'QUICK_ASC_STRING'		=> 'Filename asc.',
	'QUICK_DESC_STRING'		=> 'Filename desc.',
	'MANUAL_SORT'			=> 'Per drag and drop.',	

// Tooltips
    'ROOT_FOLDER_STRING_TT' 	=> 'This is the basic (root) folder to scan for images recursively. '
                                            . ' Please do not change this folder later, or all image settings will be lost!',
    'EXTENSIONS_STRING_TT' 	=> 'Define the file suffixes you wish to allow here. (Case insensitive.) Use "," (comma) as delimiter.',
    'INVISIBLE_STRING_TT' 	=> 'Folder that are listed here will not be scanned.',
    'DELETE_TITLE_TT' 		=> 'Warning: This will delete ALL categories and images! (The images will be REMOVED, too!)'
);
?>