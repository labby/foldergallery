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
// Frontend-Variables
   'BACK_STRING'		=> 'Back to overview',   
   'CATEGORIES_TITLE'	=> 'Categories',
   'FRONT_END_ERROR'	=> 'This category does not exist or does not contain Images and/or Subcategories!',
   'PAGE'				=> 'Page',
   'VIEW_TITLE'			=> 'Imagegallery',
   
// Backend Variables
   'ACTION'				=> 'Action:',
   'BACK'				=> 'Back',   
   'CAT_NAME'			=> 'Category name/title:',
   'CAT_DESCRIPTION'	=> 'Category description:',
   'CAT_TITLE' 			=> 'Category title:', 
   'CHANGING_INFO'		=> 'If you modify <strong>ThumbnailSize</strong> or <strong>Thumbnail Ratio</strong> all thumbnails are deleted and created again.',   
   'DB_ERROR' 			=> 'Database error!',   
   'DELETE'				=> 'Delete?',
   'EDIT_CSS' 			=> 'Modify CSS',   
   'ERROR_MESSAGE'		=> 'No data received!', 
   'EDIT_THUMB'  		=> 'Edit thumbnail',
   'EDIT_THUMB_DESCRIPTION'		=> '<strong>Please select new image view</strong>',
   'EDIT_THUMB_BUTTON'	=> 'Create thumbnail',   
   'EXTENSIONS'			=> 'Allowed files',   
   'FOLDER_IN_FS'		=> 'Folder in Root:',  
   'FOLDER_NAME'		=> 'Folder name in Root',   
   'FS_ERROR' 			=> 'Error deleting folder!',   
   'HELP_INFORMATION'	=> 'Help / Info',   
   'IMAGE' 				=> 'Image',
   'IMAGE_NAME'			=> 'Image name',
   'IMG_CAPTION'		=> 'Image description',   
   'INVISIBLE' 			=> 'Invisible Folder',   
   'LIGHTBOX'			=> 'Lightbox',  
   'MODIFY_CAT_TITLE'	=> 'Modify Category and image details',
   'MODIFY_CAT'			=> 'Edit categories:',
   'MODIFY_IMG'			=> 'Edit images:',  
   'NEW_SCANN_INFO'		=> 'This action has created the database entries. The thumbnails are created when the category is shown the first time.',
   'NO_CATEGORIES'		=> 'No categories (=Subfolders) found.<br /><br />The Gallery will work, anyway, but no categories are shown.',
   'NO_FILES_IN_CAT' 	=> 'No images in this category!',   
   'PICS_PP'			=> 'Images per page',
   'Ration_square'		=> 'square',
   'REDIRECT'			=> 'You will have to make some settings before using the Gallery.<br /> You will be forwarded in 2 seconds. (If JavaScript is activated.)',
   'REORDER_INFO_STRING'=> 'Reorder result will be displayed here.',
   'ROOT_DIR'			=> 'Root directory',
   'SAVE_SETTINGS'		=> 'Settings have been saved...',
   'SETTINGS'  			=> 'Settings',
   'SORT_IMAGE'			=> 'Sort images',
   'SYNC'				=> 'Sync data with database',
   'SYNC_DATABASE'		=> 'Sync data with database...',   
   'TITEL_BACKEND'		=> 'Foldergallery Settings',
   'TITEL_MODIFY'		=> 'Edit category and images:',
   'THUMB_NOT_NEW'		=> 'Do not create new thumbs',
   'THUMB_SIZE' 		=> 'Thumbnail Size',
   'THUMB_RATIO'		=> 'Thumbnail Ratio',

//  Sort Variables
	'MANUAL_SORT'			=> 'Per drag and drop.',
	'QUICK_SORT_STRING'		=> 'Sort images by filename.',
	'QUICK_ASC_STRING'		=> 'Filename asc.',
	'QUICK_DESC_STRING'		=> 'Filename desc.',
	'REORDER_IMAGES_STRING' => 'Sort images',

//  Errors durinbg thumbnail generation	
	'ERROR_THUMBNAILS_CANT_CREATE_DIR'  => "Can't create thumbnail-directory!",
	'ERROR_THUMBNAILS_FILE_TOO_LAGE' => "File is too big! (Over ".foldergallery::FG_MEGAPIXEL_LIMIT.")",
	'ERROR_THUMBNAILS_NO_TYPE_MATCH' => "No mime-type match! (File type has to be 'jpeg', 'png', or 'gif'.)",

// Tooltips
    'DELETE_TITLE_TT' 		=> 'Warning: This will delete ALL categories and images! (The images will be REMOVED, too!)',
    'EXTENSIONS_STRING_TT' 	=> 'Define the file suffixes you wish to allow here. (Case insensitive.) Use "," (comma) as delimiter.',
    'INVISIBLE_STRING_TT' 	=> 'Folder that are listed here will not be scanned.',
    'ROOT_FOLDER_STRING_TT' => 'This is the basic (root) folder to scan for images recursively.<br />Please do not change this folder later, or all image settings will be lost!',	
);
?>