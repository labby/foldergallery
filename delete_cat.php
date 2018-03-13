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
LEPTON_handle::include_files ('/modules/foldergallery/backend.functions.php');


if(isset($_GET['page_id']) && is_numeric($_GET['page_id'])) {
	$page_id = $_GET['page_id'];
}

if(isset($_GET['section_id']) && is_numeric($_GET['section_id'])){
	$section_id = $_GET['section_id'];
}

if(isset($_GET['cat_id']) && is_numeric($_GET['cat_id'])) {
	$cat_id = $_GET['cat_id'];
	$result = array();	
	$oFG->database->execute_query(
			"SELECT * FROM ".TABLE_PREFIX."mod_foldergallery_categories WHERE id=". $cat_id,
			true,
			$result,
			false
		);		
	if(count($result) > 0){	
		// delete files
		$settings =  getSettings($section_id);
		$delete_path = foldergallery::FG_PATH.$settings['root_dir'].$result['parent'].'/'.$result['categorie'];
		
		// delete db entries
		rek_db_delete($cat_id);
		$oFG->admin->print_success($TEXT['SUCCESS'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id.'&section_id='.$section_id);
	} else {
		$oFG->admin->print_error($oFG->language['ERROR_MESSAGE'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id.'&section_id='.$section_id);
	}

}
$oFG->admin->print_footer();
?>