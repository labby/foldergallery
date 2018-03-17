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
LEPTON_handle::include_files ('/modules/foldergallery/backend.functions.php');

$oldSettings = $oFG->fg_settings;
$newSettings = array();


//	Get data from $_POST
if (isset($_POST['root_dir'])) {
    $newSettings['root_dir'] = $_POST['root_dir'];
} else {
    $newSettings['root_dir'] = '';
}
if (isset($_POST['extensions']) && ($_POST['extensions'] != '')) {
    $extensions = strtolower($_POST['extensions']);
	$extensionsarray = explode(',',str_replace(' ', '', $extensions));
	$extensionsarray = array_unique($extensionsarray);
	$newSettings['extensions'] = implode(',', $extensionsarray);
} else {
    $newSettings['extensions'] = $oldSettings['extensions'];
}
if (isset($_POST['invisible'])) {
	$newSettings['invisible'] = $_POST['invisible'];
} else {
	$newSettings['invisible'] = $oldSettings['invisible'];
}
if (isset($_POST['pics_pp']) && is_numeric($_POST['pics_pp']) ) {
	$newSettings['pics_pp'] = $_POST['pics_pp'];
} else {
	$newSettings['pics_pp'] = $oldSettings['pics_pp'];
}

if (isset($_POST['thumb_size']) && is_numeric($_POST['thumb_size']) ) {
	$newSettings['thumb_size'] = (int) trim($_POST['thumb_size']);
} else {
	$newSettings['thumb_size'] = '';
}

if (isset($_POST['catpic']) && is_numeric($_POST['catpic']) ) {
	$newSettings['catpic'] = (int) $_POST['catpic'];
} else {
	$newSettings['catpic'] = $oldSettings['catpic'];
}

if (isset($_POST['ratio'])) {
	$newSettings['ratio'] = $_POST['ratio'];
} else {
	$newSettings['ratio'] = '';
}

if (isset($_POST['lightbox']) && file_exists( dirname(__FILE__).'/templates/frontend/view_'.$_POST['lightbox'].'.htt' ) ) {
	$newSettings['lightbox'] = $_POST['lightbox'];
} else {
	$newSettings['lightbox'] = '';
}

echo(LEPTON_tools::display($oFG->language['SAVE_SETTINGS'],'pre','ui message'));
$newSettings['section_id'] = $_POST['section_id'];

$settingsTable = TABLE_PREFIX.'mod_foldergallery_settings';

// save values in db
$fields = array(
	'root_dir'		=> $newSettings['root_dir'], 
	'extensions'	=> $newSettings['extensions'], 
	'invisible'		=> $newSettings['invisible'],
	'pics_pp'		=> $newSettings['pics_pp'],
	'thumb_size'	=> $newSettings['thumb_size'],
	'ratio'			=> $newSettings['ratio'],
	'catpic'		=> $newSettings['catpic'],
	'lightbox'		=> $newSettings['lightbox']
);

$database->build_and_execute(
	'update',
	$settingsTable,
	$fields,
	"`section_id` = '".$_POST['section_id']."'"
);

// delete thumbs if thumb size or ratio has changed
if(($oldSettings['thumb_size'] != $newSettings['thumb_size'] || $oldSettings['ratio'] != $newSettings['ratio']) && !isset($_POST['noNew'])){
	$all_data = array();
	$database->execute_query(
	    'SELECT `parent`, `categorie` FROM `'.TABLE_PREFIX.'mod_foldergallery_categories` WHERE `section_id`='.$oldSettings['section_id'].';',
	    true,
	    $all_data
	);
	
	foreach($all_data as $link) {
		$pathToFolder = foldergallery::FG_PATH.$oldSettings['root_dir'].$link['parent'].'/'.$link['categorie'].foldergallery::FG_THUMBDIR;
		echo(LEPTON_tools::display('Delete: '.$pathToFolder.'','pre','ui message'));
		deleteFolder($pathToFolder);
	}
	
	$pathToFolder = foldergallery::FG_PATH.$oldSettings['root_dir'].foldergallery::FG_THUMBDIR;
	echo(LEPTON_tools::display('Delete: '.$pathToFolder.'','pre','ui message'));
	deleteFolder($pathToFolder);
}	


// delete db entries
if($oldSettings['root_dir'] != $newSettings['root_dir']){
	$aEntriesToDelete = array();
	$oFG->database->execute_query(
	    "SELECT `parent`, `categorie` FROM `".TABLE_PREFIX."mod_foldergallery_categories` WHERE `section_id`=".$oldSettings['section_id'].";",
	    true,
	    $aEntriesToDelete,
	    true
	);
	
	foreach( $aEntriesToDelete as $cat)
	{
		$oFG->database->simple_query("DELETE FROM `".TABLE_PREFIX."mod_foldergallery_files` WHERE `parent_id`=".$cat['parent']);
	}
	
	$oFG->database->simple_query( "DELETE FROM `".TABLE_PREFIX."mod_foldergallery_categories` WHERE `section_id`=".$oldSettings['section_id'].";" );
  
  // ?? Why this and why double parent ??
    $fields = array(
        "section_id"    => $_POST['section_id'],
        "parent_id"     => -1,
        "categorie"     => "Root",
        "cat_name"      => "Root",
        "active"        => 1,
        "is_empty"      => 0,
        "position"      => 0,
        "niveau"        => -1, // ?
        "has_child"     => 0,
        "childs"        => "",
        "description"   => ""
    );
    $oFG->database->build_and_execute(
        "insert",
        TABLE_PREFIX."mod_foldergallery_categories",
        $fields
    );
  
    if($oFG->database->is_error()) {
        $oFG->admin->print_error($oFG->database->get_error(), LEPTON_URL.'/modules/foldergallery/modify_settings.php?page_id='.$page_id.'&section_id='.$section_id);
    }
}

// sync db
syncDB($newSettings);

// check if database is error
if($oFG->database->is_error()) {
	$oFG->admin->print_error($oFG->database->get_error(), LEPTON_URL.'/modules/foldergallery/modify_settings.php?page_id='.$page_id.'&section_id='.$section_id);
} else {
	$oFG->admin->print_success($TEXT['SUCCESS'], LEPTON_URL.'/modules/foldergallery/sync.php?page_id='.$page_id.'&section_id='.$section_id);
}

// Print admin footer
$oFG->admin->print_footer();

?>