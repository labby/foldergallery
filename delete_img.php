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

$oFG = foldergallery::getInstance();

if(isset($_GET['id']) && is_numeric($_GET['id'])) {	
	$root_dir = $oFG->all_settings['root_dir']; 
	$page_id = $_GET['page_id'];
	$section_id = $_GET['section_id'];
	$cat_id = $_GET['cat_id'];
	
	$result = array();	
	$oFG->database->execute_query(
			"SELECT * FROM ".TABLE_PREFIX."mod_foldergallery_files WHERE id=". $_GET['id'],
			true,
			$result,
			false
		);
		
	if(count($result) > 0){	
		// delete images
		$bildfilename = $result['file_name'];
		$parent_id = $result['parent_id'];

		$categorie = array();	
		$oFG->database->execute_query(
				"SELECT * FROM ".TABLE_PREFIX."mod_foldergallery_categories WHERE id=".$parent_id,
				true,
				$categorie,
				false
			);		

		$parent   = $categorie['parent'].'/'.$categorie['categorie'];
		$folder = $root_dir.$parent;
		$pathToFolder = foldergallery::FG_PATH.$folder.'/';
				
		$pathToFile = foldergallery::FG_PATH.$folder.'/'.$bildfilename;	
		$pathToThumb = foldergallery::FG_PATH.$folder.foldergallery::FG_THUMBDIR.'/thumb.'.$bildfilename;
		
		LEPTON_handle::delete_obsolete_files ($pathToFile);  //deleteFile($pathToFile);
		LEPTON_handle::delete_obsolete_files ($pathToThumb); //deleteFile($pathToThumb);
		
		$oFG->database->simple_query("DELETE FROM ".TABLE_PREFIX."mod_foldergallery_files WHERE id=".$_GET['id']); //delete from db
			
		$oFG->admin->print_success($TEXT['SUCCESS'], LEPTON_URL.'/modules/foldergallery/modify_cat.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id);
		
	} else {
		$oFG->admin->print_error($oFG->language['ERROR_MESSAGE'], LEPTON_URL.'/modules/foldergallery/modify_cat.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id);
	}
} else {
	$oFG->admin->print_error($oFG->language['ERROR_MESSAGE'], LEPTON_URL.'/modules/foldergallery/modify_cat.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id);
}
$oFG->admin->print_footer();
?>