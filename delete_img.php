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

$admin = new LEPTON_admin('Pages', 'pages_modify');

$file_names = array(
'/modules/foldergallery/backend.functions.php',
'/modules/foldergallery/register_language.php'
);
LEPTON_handle::include_files ($file_names);


if(isset($_GET['id']) && is_numeric($_GET['id'])) {
	$settings = getSettings($section_id);
	$root_dir = $settings['root_dir']; //Chio

	$cat_id = $_GET['cat_id'];
	$sql = 'SELECT * FROM '.TABLE_PREFIX.'mod_foldergallery_files WHERE id='.$_GET['id'].';';
	if($query = $database->query($sql)){
		$result = $query->fetchRow( );
		$bildfilename = $result['file_name'];
		$parent_id = $result['parent_id'];
		
		$query2 = $database->query('SELECT * FROM '.TABLE_PREFIX.'mod_foldergallery_categories WHERE id='.$parent_id.' LIMIT 1;');
		$categorie = $query2->fetchRow();
		$parent   = $categorie['parent'].'/'.$categorie['categorie'];
		$folder = $root_dir.$parent;
		$pathToFolder = foldergallery::FG_PATH.$folder.'/';
				
		$pathToFile = foldergallery::FG_PATH.$folder.'/'.$bildfilename;	
		$pathToThumb = foldergallery::FG_PATH.$folder.foldergallery::FG_THUMBDIR.'/thumb.'.$bildfilename;				
		LEPTON_handle::delete_obsolete_files ($pathToFile);  //deleteFile($pathToFile);
		LEPTON_handle::delete_obsolete_files ($pathToThumb); //deleteFile($pathToThumb);
		
		$sql = 'DELETE FROM '.TABLE_PREFIX.'mod_foldergallery_files WHERE id='.$_GET['id'];
		$database->query($sql);
			
		$admin->print_success($TEXT['SUCCESS'], LEPTON_URL.'/modules/foldergallery/modify_cat.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id);
		
	} else {
		$admin->print_error($MOD_FOLDERGALLERY['ERROR_MESSAGE'], LEPTON_URL.'/modules/foldergallery/modify_cat.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id);
	}
} else {
	$admin->print_error($MOD_FOLDERGALLERY['ERROR_MESSAGE'], LEPTON_URL.'/modules/foldergallery/modify_cat.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id);
}
$admin->print_footer();
?>