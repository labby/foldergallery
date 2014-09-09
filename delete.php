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

// Delete DB-Entries (messages and settings)
$sql = 'SELECT `parent` FROM '.TABLE_PREFIX.'mod_foldergallery_jq_categories WHERE section_id='.$section_id.';';
$query = $database->query($sql);
while($cat = $query->fetchRow( MYSQL_ASSOC )) {
	$sql = 'DELETE FROM '.TABLE_PREFIX.'mod_foldergallery_jq_files WHERE parent_id='.$cat['parent'];
	$database->query($sql);
}	
$database->query("DELETE FROM `".TABLE_PREFIX."mod_foldergallery_jq_settings` WHERE `page_id` = '$page_id' AND `section_id` = '$section_id'");
$database->query("DELETE FROM `".TABLE_PREFIX."mod_foldergallery_jq_categories` WHERE `section_id` = '$section_id'");

?>