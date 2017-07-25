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

//Modul Description
$module_description = 'Create an Image Gallery with folders as categories';

//Variables for the Frontend
$MOD_FOLDERGALLERY_JQ['VIEW_TITLE']		= 'Image Gallery';
$MOD_FOLDERGALLERY_JQ['CATEGORIES_TITLE']	= 'Categories';
$MOD_FOLDERGALLERY_JQ['BACK_STRING']		= 'Back to overview';
$MOD_FOLDERGALLERY_JQ['FRONT_END_ERROR']	= 'This category does not exist or does not contain Images and/or Subcategories!';
$MOD_FOLDERGALLERY_JQ['PAGE']            = 'Page';

//Variables for the Backend
$MOD_FOLDERGALLERY_JQ['PICS_PP']	= 'Images per page';
$MOD_FOLDERGALLERY_JQ['LIGHTBOX']	= 'Lightbox';

$MOD_FOLDERGALLERY_JQ['MODIFY_CAT_TITLE']	= 'Modify categories and image details';
$MOD_FOLDERGALLERY_JQ['MODIFY_CAT']			= 'Modify category details:';
$MOD_FOLDERGALLERY_JQ['CAT_NAME']			= 'Category name/title:';
$MOD_FOLDERGALLERY_JQ['CAT_DESCRIPTION']	= 'Category description:';
$MOD_FOLDERGALLERY_JQ['MODIFY_IMG']			= 'Modify images:';
$MOD_FOLDERGALLERY_JQ['IMAGE']				= 'Image';
$MOD_FOLDERGALLERY_JQ['IMAGE_NAME']			= 'Image name';
$MOD_FOLDERGALLERY_JQ['IMG_CAPTION']		= 'Image description';

$MOD_FOLDERGALLERY_JQ['REDIRECT']  			= 'You will have to make some settings before using the Gallery.'
											. ' You will be forwarded in 2 seconds. (If JavaScript is activated.)';
$MOD_FOLDERGALLERY_JQ['TITEL_BACKEND'] 		= 'Foldergallery Admin';
$MOD_FOLDERGALLERY_JQ['TITEL_MODIFY'] 		= 'Modify categories and images:';
$MOD_FOLDERGALLERY_JQ['SETTINGS'] 			= 'Common settings';
$MOD_FOLDERGALLERY_JQ['ROOT_DIR'] 			= 'Root directory';
$MOD_FOLDERGALLERY_JQ['EXTENSIONS']			= 'Allowed extensions';
$MOD_FOLDERGALLERY_JQ['INVISIBLE']			= 'Hide folders';
$MOD_FOLDERGALLERY_JQ['NEW_SCANN_INFO']		= 'This action has created the database entries. The thumbnails are created when the category is shown the first time.';
$MOD_FOLDERGALLERY_JQ['FOLDER_NAME']		= 'Folder name';
$MOD_FOLDERGALLERY_JQ['DELETE']				= 'Delete?';
$MOD_FOLDERGALLERY_JQ['ERROR_MESSAGE']		= 'No data!';
$MOD_FOLDERGALLERY_JQ['DB_ERROR']			= 'Database error!';
$MOD_FOLDERGALLERY_JQ['FS_ERROR']			= 'Unable to delete folder!';
$MOD_FOLDERGALLERY_JQ['NO_FILES_IN_CAT']	= 'This category does not contain any images!';
$MOD_FOLDERGALLERY_JQ['SYNC']				= 'Sync database with filesystem';
$MOD_FOLDERGALLERY_JQ['EDIT_CSS']			= 'Edit CSS';
$MOD_FOLDERGALLERY_JQ['FOLDER_IN_FS']		= 'Filesystem folder:';
$MOD_FOLDERGALLERY_JQ['CAT_TITLE']			= 'Category title:';
$MOD_FOLDERGALLERY_JQ['ACTION']				= 'Actions:';
$MOD_FOLDERGALLERY_JQ['NO_CATEGORIES'] 		= 'No categories (=Subfolders) found.<br /><br />The Gallery will work, anyway, but no categories are shown.';
$MOD_FOLDERGALLERY_JQ['EDIT_THUMB'] 		= 'Edit thumbnail';
$MOD_FOLDERGALLERY_JQ['EDIT_THUMB_DESCRIPTION']		= '<strong>Please select new image</strong>';
$MOD_FOLDERGALLERY_JQ['EDIT_THUMB_BUTTON']			= 'Draw up thumbnail';
$MOD_FOLDERGALLERY_JQ['THUMB_SIZE']			= 'Thumbnail size';
$MOD_FOLDERGALLERY_JQ['THUMB_RATIO']		= 'Thumbnail ratio';
$MOD_FOLDERGALLERY_JQ['THUMB_NOT_NEW']		= 'Dont recreat thumbnails';
$MOD_FOLDERGALLERY_JQ['CHANGING_INFO']		= 'Changing <strong>thumb size</strong> or <strong>thumb ratio</strong> will delete (and recreate) all thumbs.';
$MOD_FOLDERGALLERY_JQ['SYNC_DATABASE']		= 'Synchronize file system with database...';
$MOD_FOLDERGALLERY_JQ['SAVE_SETTINGS']		= 'Settings are stored...';
$MOD_FOLDERGALLERY_JQ['SORT_IMAGE']			= 'Sort images';
$MOD_FOLDERGALLERY_JQ['BACK']				= 'Back';
$MOD_FOLDERGALLERY_JQ['REORDER_INFO_STRING']   = 'Reorder result will be displayed here.';
$MOD_FOLDERGALLERY_JQ['HELP_INFORMATION']      = 'Help / Info';

$MOD_FOLDERGALLERY_JQ['Ration_square']      = 'square';

// Tooltips
$MOD_FOLDERGALLERY_JQ['ROOT_FOLDER_STRING_TT']	= 'This is the basic (root) folder to scan for images recursively. '
                                            . ' Please do not change this folder later, or all image settings will be lost!';
$MOD_FOLDERGALLERY_JQ['EXTENSIONS_STRING_TT']	= 'Define the file suffixes you wish to allow here. (Case insensitive.) Use "," (comma) as delimiter.';
$MOD_FOLDERGALLERY_JQ['INVISIBLE_STRING_TT']	= 'Folder that are listed here will not be scanned.';
$MOD_FOLDERGALLERY_JQ['DELETE_TITLE_TT']		= 'Warning: This will delete ALL categories and images! (The images will be REMOVED, too!)';

// Helppage
$FG_HELP['TITLE']           = 'Foldergallery: Help- and Infopage';
$FG_HELP['VERSION']         = 'Release-info';
$FG_HELP['YOUR_VERSION']    = 'You are using Version %s.';
$FG_HELP['NOUPDATES']       = 'There are no updates aviable at the moment!';
$FG_HELP['UPDATE']          = 'Version %s is aviable, a update is recommeded.';
$FG_HELP['VERSION_TEXT']    = 'You can find latest release on <a href="http://www.lepton-cms.org/english/addons/free-addons.php" target="_blank">LEPTON Homepage</a>'
                            .' or on <a href="http://cms-lab.com/lab/en/modules/standard-modules/foldergallery-jquery.php" target="_blank" >CMS-LAB</a>';
$FG_HELP['HOMEPAGE_TEXT']   = 'On <a href="https://github.com/aldus/foldergallery_jq" target="_blank">GITHUB</a> you can find the whole changelog, current development and older releases.';                  
$FG_HELP['HELP_TITLE']      = 'Help and Support';
$FG_HELP['HELP_TEXT']       = 'You get support on the <a href="http://forum.lepton-cms.org" target="_blank">LEPTON CMS Addons Forum</a>.';
$FG_HELP['BUG_TITLE']       = 'Report a bug';
$FG_HELP['BUG_TEXT']        = 'Bugs can be reported on <a href="http://forum.lepton-cms.org/" target="_blank">LEPTON CMS Addons Forum</a> or directly on <a href="https://github.com/aldus/foldergallery_jq" target="_blank">GITHUB</a>';

$FG_HELP['BACK_STRING']     = 'Back';
?>