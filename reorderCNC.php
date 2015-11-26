<?php

/**
 *  @module         foldergallery_jq
 *  @version        see info.php of this module
 *  @author         Jürg Rast; schliffer; Bianka Martinovic; Chio; Pumpi,Aldus; erpe
 *  @copyright      2009-2016 Jürg Rast; schliffer; Bianka Martinovic; Chio; Pumpi,Aldus; erpe 
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

if(defined('LEPTON_PATH') == false) { exit("Cannot access this file directly");  }

// First we prevent direct access and check for variables
if(!isset($_POST['action']) OR !isset($_POST['recordsArray'])) {
	// now we redirect to index, if you are in subfolder use ../index.php
	header( 'Location: ../../index.php' ) ;
} else {
 
 	// check if user has permissions to access the  module
	require_once(LEPTON_PATH.'/framework/class.admin.php');
	$admin = new admin('Modules', 'module_view', false, false);
	if (!($admin->is_authenticated() && $admin->get_permission('foldergallery', 'module'))) 
		die(header('Location: ../../index.php'));
	
	// Sanitized variables
	$action = $admin->add_slashes($_POST['action']);
	$updateRecordsArray = isset($_POST['recordsArray']) ? $_POST['recordsArray'] : array();

 
	// This line verifies that in &action is not other text than "updateRecordsListings", if something else is inputed (to try to HACK the DB), there will be no DB access..
	if ($action == "updateRecordsListings"){
	 
		$listingCounter = 1;
		$output = "";
		foreach ($updateRecordsArray as $recordIDValue) {
			
			$database->query("UPDATE `".TABLE_PREFIX."mod_foldergallery_jq_categories` SET position = ".$listingCounter." WHERE `id` = ".$recordIDValue);

			$listingCounter ++;
		}
	 
		echo '<img src="'.LEPTON_URL.'/modules/jsadmin/images/success.gif" style="vertical-align:middle;"/> <span style="font-size: 80%">Sucessfully reorderd</span>';

	}
} // this ends else statement from the top of the page
?>