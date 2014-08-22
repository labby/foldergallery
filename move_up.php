<?php

/**
 *  @module         foldergallery_jq
 *  @version        see info.php of this module
 *  @author         Jürg Rast; schliffer; Bianka Martinovic; Chio; Pumpi,Aldus; erpe
 *  @copyright      2004-2014 Jürg Rast; schliffer; Bianka Martinovic; Chio; Pumpi,Aldus; erpe 
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

require('../../../config.php');

// Get id
if(isset($_GET['page_id']) AND is_numeric($_GET['page_id'])) {
	if(isset($_GET['id']) AND is_numeric($_GET['id'])) {
		$page_id = $_GET['page_id'];
		$id = $_GET['id'];
		$id_field = 'id';
		$common_field = 'parent_id';
		$table = TABLE_PREFIX.'mod_foldergallery_jq_categories';
	}
} else {
	header("Location: index.php");
	exit(0);
}

// Create new admin object and print admin header
require_once(WB_PATH.'/framework/class.admin.php');
$admin = new admin('Pages', 'pages_settings');

// Include the ordering class
require(WB_PATH.'/framework/class.order.php');

// Create new order object an reorder
$order = new order($table, 'position', $id_field, $common_field);
if($id_field == 'id') {
	if($order->move_up($id)) {
		$admin->print_success($MESSAGE['PAGES']['REORDERED'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
	} else {
		$admin->print_error($MESSAGE['PAGES']['CANNOT_REORDER'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
	}
} else {
	if($order->move_up($id)) {
		$admin->print_success($TEXT['SUCCESS'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
	} else {
		$admin->print_error($TEXT['ERROR'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
	}
}

// Print admin footer
$admin->print_footer();

?>