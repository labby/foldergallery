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

if(isset($_POST['save'])) {
	if(!isset($_POST['cat_id'])) {
		$oFG->admin->print_error('no_cat_id');
	}
	
	$active = 0;
	if(isset($_POST['active'])) {
		$active = $_POST['active'];
	}
	
	$fields = array(
		'cat_name'	=> $_POST['cat_name'],
		'description'	=> $_POST['cat_description'],
		'active'	=> $active
	);
	
	$oFG->database->build_and_execute(
		'update',
		TABLE_PREFIX.'mod_foldergallery_categories',
		$fields,
		'id='.$_POST['cat_id']
	);

	if(!$database->is_error()){
		$oFG->admin->print_success($TEXT['SUCCESS'], $oFG->folder_url.'modify_cat.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$_POST['cat_id']);
	} else {
		$oFG->admin->print_error($oFG->language['ERROR_MESSAGE'].": ".$database->get_error(), ADMIN_URL.'/pages/modify.php?page_id='.$page_id.'&section_id='.$section_id);
	}
} else {
	die ('something went wrong');
}

$oFG->admin->print_footer();
?>