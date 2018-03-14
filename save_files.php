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

if(isset($_POST['save']) && is_string($_POST['save'])) {
	
	// use $_POST
	if(isset($_GET['cat_id']) && is_numeric($_GET['cat_id'])) {
		$cat_id = $_GET['cat_id'];
	} else {
		$oFG->admin->print_error('lost cat', ADMIN_URL.'/pages/modify.php?page_id='.$page_id.'&section_id='.$section_id);
		die();
	}
	
	if(!isset($_POST['caption'])) {

		$oFG->admin->print_success($TEXT['SUCCESS'], LEPTON_URL.'/modules/foldergallery/modify_cat.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id);
		$oFG->admin->print_footer();
		die();
	}

	foreach($_POST['caption'] as $key=>$value) {
			$image_id = $key;
			$image_caption = $value; 
			$result = $oFG->database->simple_query("Update ".TABLE_PREFIX."mod_foldergallery_files SET caption ='".$image_caption."' WHERE id=".$image_id);
			if($result == false) {
				echo(LEPTON_tools::display($oFG->database->get_error(),'pre','ui message'));
			}
			unset($image_id,$image_caption);
	}

	$oFG->admin->print_success($TEXT['SUCCESS'], LEPTON_URL.'/modules/foldergallery/modify_cat.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id);	
} else {
	$oFG->admin->print_error('wrong data!');	 
}
$oFG->admin->print_footer();
?>