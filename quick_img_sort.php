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


if(isset($_POST['cat_id']) && is_numeric($_POST['cat_id'])) {
	$cat_id = $_POST['cat_id'];
} else {
	$oFG->admin->print_error('no categorie found', ADMIN_URL.'/pages/modify.php?page_id='.$page_id.'&section_id='.$section_id);
	die();
}

if(isset($_POST['page_id']) && is_numeric($_POST['page_id'])) {
	$page_id = $_POST['page_id'];
}

if(isset($_POST['section_id']) && is_numeric($_POST['section_id'])) {
	$section_id = $_POST['section_id'];
}

if(isset($_POST['sort'])) {
	switch($_POST['sort']) {
		case "ASC":
			$sort = "ASC";
			break;
		case "DESC":
			$sort = "DESC";
			break;
		default:
			$oFG->admin->print_error('no sort advice');
			break;
	}
}

// get class instance
$oFG = foldergallery::getInstance();

// get infos from db
$result = array();	
$oFG->database->execute_query(
	"SELECT * FROM ".TABLE_PREFIX."mod_foldergallery_files  WHERE parent_id =".$cat_id." ORDER BY file_name ".$sort,
	true,
	$result,
	true
);	

if(count($result) > 0) {
	$sql = "UPDATE `".TABLE_PREFIX."mod_foldergallery_files` SET position= CASE ";
	$position = 1;
	foreach($result as $image){
		$sql = $sql."WHEN id=".$image['id']." THEN '".$position."' ";
		$position++;
	}
	$sql = $sql." ELSE position END;";
}


if($oFG->database->query($sql)){
	$oFG->admin->print_success($MESSAGE['PAGES_REORDERED'],
	LEPTON_URL.'/modules/foldergallery/modify_cat_sort.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id);
} else {
	$oFG->admin->print_error($TEXT['ERROR'],
	LEPTON_URL.'/modules/foldergallery/modify_cat_sort.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id);
}

// Print admin footer
$oFG->admin->print_footer();

?>