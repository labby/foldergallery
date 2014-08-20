<?php

/**
 *  @module         foldergallery_jq
 *  @version        see info.php of this module
 *  @author         J&uuml;rg Rast; schliffer; Bianka Martinovic; Chio; Pumpi,Aldus; erpe
 *  @copyright      2004-2014 J&uuml;rg Rast; schliffer; Bianka Martinovic; Chio; Pumpi,Aldus; erpe 
 *  @license        GNU General Public License
 *  @license terms  see info.php of this module
 *  @platform       see info.php of this module
 * 
 */
 
// include class.secure.php to protect this file and the whole CMS!
if (defined('WB_PATH')) {	
	include(WB_PATH.'/framework/class.secure.php'); 
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

//Variables for the Frontend
$MOD_FOLDERGALLERY['VIEW_TITLE']		= 'Image Gallery';
$MOD_FOLDERGALLERY['CATEGORIES_TITLE']	= 'Categories';
$MOD_FOLDERGALLERY['BACK_STRING']		= 'Back to overview';
$MOD_FOLDERGALLERY['FRONT_END_ERROR']	= 'This category does not exist or does not contain Images and/or Subcategories!';
$MOD_FOLDERGALLERY['PAGE']            = 'Page';


//Variables for the Backend
$MOD_FOLDERGALLERY['PICS_PP'] = 'Images per page';
$MOD_FOLDERGALLERY['LIGHTBOX'] = 'Lightbox';

$MOD_FOLDERGALLERY['MODIFY_CAT_TITLE']			= 'Modify categories and image details';
$MOD_FOLDERGALLERY['MODIFY_CAT']			= 'Modify category details:';
$MOD_FOLDERGALLERY['CAT_NAME']				= 'Category name/title:';
$MOD_FOLDERGALLERY['CAT_DESCRIPTION']			= 'Category description:';
$MOD_FOLDERGALLERY['MODIFY_IMG']			= 'Modify images:';
$MOD_FOLDERGALLERY['IMAGE']					= 'Image';
$MOD_FOLDERGALLERY['IMAGE_NAME']			= 'Image name';
$MOD_FOLDERGALLERY['IMG_CAPTION']			= 'Image description';


$MOD_FOLDERGALLERY['REDIRECT']  			= 'You will have to make some settings before using the Gallery.'
											. ' You will be forwarded in 2 seconds. (If JavaScript is activated.)';
$MOD_FOLDERGALLERY['TITEL_BACKEND'] 			= 'Foldergallery Admin';
$MOD_FOLDERGALLERY['TITEL_MODIFY'] 			= 'Modify categories and images:';
$MOD_FOLDERGALLERY['SETTINGS'] 				= 'Common settings';
$MOD_FOLDERGALLERY['ROOT_DIR'] 				= 'Root directory';
$MOD_FOLDERGALLERY['EXTENSIONS']			= 'Allowed extensions';
$MOD_FOLDERGALLERY['INVISIBLE']				= 'Hide folders';
$MOD_FOLDERGALLERY['NEW_SCANN_INFO']			= 'This action has created the database entries. The thumbnails are created when the category is shown the first time.';
$MOD_FOLDERGALLERY['FOLDER_NAME']			= 'Folder name';
$MOD_FOLDERGALLERY['DELETE']				= 'Delete?';
$MOD_FOLDERGALLERY['ERROR_MESSAGE']			= 'No data!';
$MOD_FOLDERGALLERY['DB_ERROR']				= 'Database error!';
$MOD_FOLDERGALLERY['FS_ERROR']				= 'Unable to delete folder!';
$MOD_FOLDERGALLERY['NO_FILES_IN_CAT']			= 'This category does not contain any images!';
$MOD_FOLDERGALLERY['SYNC']				= 'Sync database with filesystem';
$MOD_FOLDERGALLERY['EDIT_CSS']				= 'Edit CSS';
$MOD_FOLDERGALLERY['FOLDER_IN_FS']			= 'Filesystem folder:';
$MOD_FOLDERGALLERY['CAT_TITLE']				= 'Category title:';
$MOD_FOLDERGALLERY['ACTION']				= 'Actions:';
$MOD_FOLDERGALLERY['NO_CATEGORIES'] 			= 'No categories (=Subfolders) found.<br /><br />The Gallery will work, anyway, but no categories are shown.';
$MOD_FOLDERGALLERY['EDIT_THUMB'] 			= 'Edit thumbnail';
$MOD_FOLDERGALLERY['EDIT_THUMB_DESCRIPTION']		= '<strong>Please select new image</strong>';
$MOD_FOLDERGALLERY['EDIT_THUMB_BUTTON']			= 'Draw up thumbnail';
$MOD_FOLDERGALLERY['THUMB_SIZE']			= 'Thumbnail size';
$MOD_FOLDERGALLERY['THUMB_RATIO']			= 'Thumbnail ratio';
$MOD_FOLDERGALLERY['THUMB_NOT_NEW']			= 'Dont recreat thumbnails';
$MOD_FOLDERGALLERY['CHANGING_INFO']			= 'Changing <strong>thumb size</strong> or <strong>thumb ratio</strong> will delete (and recreate) all thumbs.';
$MOD_FOLDERGALLERY['SYNC_DATABASE']			= 'Synchronize file system with database...';
$MOD_FOLDERGALLERY['SAVE_SETTINGS']			= 'Settings are stored...';
$MOD_FOLDERGALLERY['SORT_IMAGE']			= 'Sort images';
$MOD_FOLDERGALLERY['BACK']					= 'Back';
$MOD_FOLDERGALLERY['REORDER_INFO_STRING']   = 'Reorder result will be displayed here.';



// Tooltips
$MOD_FOLDERGALLERY['ROOT_FOLDER_STRING_TT']	= 'This is the basic (root) folder to scan for images recursively. '
                                            . ' Please do not change this folder later, or all image settings will be lost!';
$MOD_FOLDERGALLERY['EXTENSIONS_STRING_TT']	= 'Define the file suffixes you wish to allow here. (Case insensitive.) Use "," (comma) as delimiter.';
$MOD_FOLDERGALLERY['INVISIBLE_STRING_TT']	= 'Folder that are listed here will not be scanned.';
$MOD_FOLDERGALLERY['DELETE_TITLE_TT']		= 'Warning: This will delete ALL categories and images! (The images will be REMOVED, too!)';
?>
