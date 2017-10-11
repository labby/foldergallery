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

require(LEPTON_PATH.'/modules/admin.php');

// check if backend.css file needs to be included into <body></body>
if(!method_exists($admin, 'register_backend_modfiles') && file_exists(LEPTON_PATH ."/modules/foldergallery_jq/backend.css")) {
echo '<style type="text/css">';
include(LEPTON_PATH .'/modules/foldergallery_jq/backend.css');
echo "\n</style>\n";
}
// check if backend.js file needs to be included into <body></body>
if(!method_exists($admin, 'register_backend_modfiles') && file_exists(LEPTON_PATH ."/modules/foldergaller/backend.js")) {
echo '<script type="text/javascript">';
include(LEPTON_PATH .'/modules/foldergallery_jq/backend.js');
echo "</script>";
}

// check if module language file exists for the language set by the user (e.g. DE, EN)
if(!file_exists(LEPTON_PATH .'/modules/foldergallery_jq/languages/'.LANGUAGE .'.php')) {
// no module language file exists for the language set by the user, include default module language file DE.php
require_once(LEPTON_PATH .'/modules/foldergallery_jq/languages/DE.php');
} else {
// a module language file exists for the language defined by the user, load it
require_once(LEPTON_PATH .'/modules/foldergallery_jq/languages/'.LANGUAGE .'.php');
}

// Files includen
require_once (LEPTON_PATH.'/modules/foldergallery_jq/info.php');
require_once (LEPTON_PATH.'/modules/foldergallery_jq/backend.functions.php');

if(isset($_GET['id']) && is_numeric($_GET['id'])) {
	$settings = getSettings($section_id);
	$root_dir = $settings['root_dir']; //Chio

	$cat_id = $_GET['cat_id'];
	$sql = 'SELECT * FROM '.TABLE_PREFIX.'mod_foldergallery_jq_files WHERE id='.$_GET['id'].';';
	if($query = $database->query($sql)){
		$result = $query->fetchRow( );
		$bildfilename = $result['file_name'];
		$parent_id = $result['parent_id'];
		//echo '<h2>'.$parent_id.'</h2>' ;
		
		$query2 = $database->query('SELECT * FROM '.TABLE_PREFIX.'mod_foldergallery_jq_categories WHERE id='.$parent_id.' LIMIT 1;');
		$categorie = $query2->fetchRow();
		$parent   = $categorie['parent'].'/'.$categorie['categorie'];
		$folder = $root_dir.$parent;
		$pathToFolder = $path.$folder.'/';
				
		$pathToFile = $path.$folder.'/'.$bildfilename;	
		$pathToThumb = $path.$folder.$thumbdir.'/thumb.'.$bildfilename;				
		deleteFile($pathToFile);
		deleteFile($pathToThumb);
		
		$sql = 'DELETE FROM '.TABLE_PREFIX.'mod_foldergallery_jq_files WHERE id='.$_GET['id'];
		$database->query($sql);
			
		$admin->print_success($TEXT['SUCCESS'], LEPTON_URL.'/modules/foldergallery_jq/modify_cat.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id);
		
	} else {
		$admin->print_error($MOD_FOLDERGALLERY_JQ['ERROR_MESSAGE'], LEPTON_URL.'/modules/foldergallery_jq/modify_cat.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id);
	}
} else {
	$admin->print_error($MOD_FOLDERGALLERY_JQ['ERROR_MESSAGE'], LEPTON_URL.'/modules/foldergallery_jq/modify_cat.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id);
}
$admin->print_footer();
?>