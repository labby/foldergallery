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

$admin = new LEPTON_admin('Pages', 'pages_modify');

$file_names = array(
'/modules/foldergallery_jq/backend.functions.php',
'/modules/foldergallery_jq/register_language.php'
);
LEPTON_handle::include_files ($file_names);

$settings = getSettings($section_id);

if(isset($_POST['save'])) {
	if(isset($_POST['cat_id'])) {
		$cat_id = $_POST['cat_id'];
	} else {
		$error['no_cat_id'] = 1;
	}
	if(isset($_POST['cat_name'])) {
		$cat_name = $_POST['cat_name'];
	}
	if(isset($_POST['cat_description'])) {
		$cat_description = $_POST['cat_description'];
	}
	
	$active = 0;
	if(isset($_POST['active'])) {
		$active = $_POST['active'];
	}
	
	$fields = array(
		'cat_name'	=> $cat_name,
		'description'	=> $cat_description,
		'active'	=> $active
	);
	
	$database->build_and_execute(
		'update',
		TABLE_PREFIX.'mod_foldergallery_jq_categories',
		$fields,
		'id='.$cat_id
	);

	if(!$database->is_error()){
		$admin->print_success($TEXT['SUCCESS'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id.'&section_id='.$section_id);
	} else {
		$admin->print_error($MOD_FOLDERGALLERY_JQ['ERROR_MESSAGE'].": ".$database->get_error(), ADMIN_URL.'/pages/modify.php?page_id='.$page_id.'&section_id='.$section_id);
	}
}

$admin->print_footer();
?>