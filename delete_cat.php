<?php

/**
 *  @module         foldergallery
 *  @version        see info.php of this module
 *  @author         Jürg Rast, schliffer, Bianka Martinovic, Chio, Pumpi, Aldus, erpe
 *  @copyright      2009-2018 Jürg Rast, schliffer, Bianka Martinovic, Chio, Pumpi, Aldus, erpe 
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


if(isset($_GET['page_id']) && is_numeric($_GET['page_id'])) {
	$page_id = $_GET['page_id'];
}

if(isset($_GET['section_id']) && is_numeric($_GET['section_id'])){
	$section_id = $_GET['section_id'];
}

if(isset($_GET['cat_id']) && is_numeric($_GET['cat_id'])) {
	$cat_id = $_GET['cat_id'];
	$sql = 'SELECT categorie, parent, has_child FROM '.TABLE_PREFIX.'mod_foldergallery_categories WHERE id='.$cat_id.';';
	$query = $database->query($sql);
	if($result = $query->fetchRow( )){
		// Dateien löschen
		$settings = getSettings($section_id);
		$delete_path = foldergallery::FG_PATH.$settings['root_dir'].$result['parent'].'/'.$result['categorie'];

		//deleteFolder($delete_path);
		// DB Einträge löschen
		rek_db_delete($cat_id);
		$admin->print_success($TEXT['SUCCESS'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id.'&section_id='.$section_id);
	} else {
		$admin->print_error($MOD_FOLDERGALLERY_JQ['ERROR_MESSAGE'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id.'&section_id='.$section_id);
	}

}
$admin->print_footer();
?>