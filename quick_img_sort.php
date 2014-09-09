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

$error = null;

if(isset($_GET['cat_id']) && is_numeric($_GET['cat_id'])) {
	$cat_id = $_GET['cat_id'];
} else {
	$error['no_cat_id'] = 1;
}

if(isset($_GET['page_id']) && is_numeric($_GET['page_id'])) {
	$page_id = $_GET['page_id'];
} else {
	$error['no_page_id'] = 1;
}

if(isset($_GET['section_id']) && is_numeric($_GET['section_id'])) {
	$section_id = $_GET['section_id'];
} else {
	$error['no_section_id'] = 1;
}

if(isset($_GET['sort'])) {
	switch($_GET['sort']) {
		case "ASC":
			$sort = "ASC";
			break;
		case "DESC":
			$sort = "DESC";
			break;
		default:
			$error['no_sort'] = 1;
			break;
	}

}

if($error != null) {
	header("Location: ../../index.php");
	exit();
}

// Create new admin object and print admin header
require_once(LEPTON_PATH.'/framework/class.admin.php');
$admin = new admin('Pages', 'pages_settings');


$sql="SELECT file_name, position, id FROM `".TABLE_PREFIX."mod_foldergallery_jq_files` WHERE parent_id =".$cat_id." ORDER BY file_name ".$sort;

$query=$database->query($sql);

if($query->numRows()) {
	$sql = "UPDATE `".TABLE_PREFIX."mod_foldergallery_jq_files` SET position= CASE ";
	$position = 1;
	while($result = $query->fetchRow()){
		$sql = $sql."WHEN id=".$result['id']." THEN '".$position."' ";
		$position++;
	}
	$sql = $sql." ELSE position END;";
}


if($database->query($sql)){
	$admin->print_success($MESSAGE['PAGES']['REORDERED'],
	LEPTON_URL.'/modules/foldergallery_jq/modify_cat_sort.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id);
} else {
	$admin->print_error($TEXT['ERROR'],
	LEPTON_URL.'/modules/foldergallery_jq/modify_cat_sort.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id);
}

// Print admin footer
$admin->print_footer();
?>
