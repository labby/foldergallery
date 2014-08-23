<?php

/**
 *  @module         foldergallery_jq
 *  @version        see info.php of this module
 *  @author         Jürg Rast; schliffer; Bianka Martinovic; Chio; Pumpi,Aldus; erpe
 *  @copyright      2009-2014 Jürg Rast; schliffer; Bianka Martinovic; Chio; Pumpi,Aldus; erpe 
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

require(WB_PATH.'/modules/admin.php');

// check if backend.css file needs to be included into <body></body>
if(!method_exists($admin, 'register_backend_modfiles') && file_exists(WB_PATH ."/modules/foldergallery_jq/backend.css")) {
echo '<style type="text/css">';
include(WB_PATH .'/modules/foldergallery_jq/backend.css');
echo "\n</style>\n";
}
// check if backend.js file needs to be included into <body></body>
if(!method_exists($admin, 'register_backend_modfiles') && file_exists(WB_PATH ."/modules/foldergallery_jq/backend.js")) {
echo '<script type="text/javascript">';
include(WB_PATH .'/modules/foldergallery_jq/backend.js');
echo "</script>";
}

// check if module language file exists for the language set by the user (e.g. DE, EN)
if(!file_exists(WB_PATH .'/modules/foldergallery_jq/languages/'.LANGUAGE .'.php')) {
// no module language file exists for the language set by the user, include default module language file DE.php
require_once(WB_PATH .'/modules/foldergallery_jq/languages/DE.php');
} else {
// a module language file exists for the language defined by the user, load it
require_once(WB_PATH .'/modules/foldergallery_jq/languages/'.LANGUAGE .'.php');
}

// Files includen
require_once (WB_PATH.'/modules/foldergallery_jq/info.php');
require_once (WB_PATH.'/modules/foldergallery_jq/backend.functions.php');

if(isset($_GET['page_id']) && is_numeric($_GET['page_id'])) {
	$page_id = $_GET['page_id'];
}

if(isset($_GET['section_id']) && is_numeric($_GET['section_id'])){
	$section_id = $_GET['section_id'];
}



if(isset($_GET['cat_id']) && is_numeric($_GET['cat_id'])) {
	$cat_id = $_GET['cat_id'];
	$sql = 'SELECT categorie, parent, has_child FROM '.TABLE_PREFIX.'mod_foldergallery_jq_categories WHERE id='.$cat_id.';';
	$query = $database->query($sql);
	if($result = $query->fetchRow()){
		// Dateien löschen
		$settings = getSettings($section_id);
		$delete_path = $path.$settings['root_dir'].$result['parent'].'/'.$result['categorie'];
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