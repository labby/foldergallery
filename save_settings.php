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

// check if module language file exists for the language set by the user (e.g. DE, EN)
if(!file_exists(WB_PATH .'/modules/foldergallery_jq/languages/'.LANGUAGE .'.php')) {
	// no module language file exists for the language set by the user, include default module language file DE.php
	require_once(WB_PATH .'/modules/foldergallery_jq/languages/DE.php');
} else {
	// a module language file exists for the language defined by the user, load it
	require_once(WB_PATH .'/modules/foldergallery_jq/languages/'.LANGUAGE .'.php');
}

require_once(WB_PATH.'/modules/foldergallery_jq/info.php');
require_once(WB_PATH.'/modules/foldergallery_jq/backend.functions.php');

$oldSettings = getSettings($section_id);
$newSettings = array();



//Daten aus $_post auswerten und validieren
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
    $newSettings['extensions'] = '';
}
if (isset($_POST['invisible'])) {
	$newSettings['invisible'] = $_POST['invisible'];
} else {
	$newSettings['invisible'] = '';
}
if (isset($_POST['pics_pp']) && is_numeric($_POST['pics_pp']) ) {
	$newSettings['pics_pp'] = $_POST['pics_pp'];
} else {
	$newSettings['pics_pp'] = '';
}

//--------------------------
//Chio Thumbsize:
if (isset($_POST['thumb_size']) && is_numeric($_POST['thumb_size']) ) {
	$newSettings['thumb_size'] = (int) trim($_POST['thumb_size']);
} else {
	$newSettings['thumb_size'] = 150;
}

if (isset($_POST['catpic']) && is_numeric($_POST['catpic']) ) {
	$newSettings['catpic'] = (int) $_POST['catpic'];
} else {
	$newSettings['catpic'] = 0;
}
// Ende Chio

//--------------------------
//Pumpi Thumbratio:
if (isset($_POST['ratio'])) {
	$newSettings['ratio'] = $_POST['ratio'];
} else {
	$newSettings['ratio'] = 1;
}
// END ratio


if (isset($_POST['lightbox']) && file_exists( dirname(__FILE__).'/templates/view_'.$_POST['lightbox'].'.htt' ) ) {
	$newSettings['lightbox'] = $_POST['lightbox'];
// ----- jQueryAdmin / LibraryAdmin Integration; last edited 27.01.2011 -----
} elseif( isset($_POST['lightbox']) && file_exists( WB_PATH.'/modules/'.$_POST['lightbox'].'/foldergallery_template.htt' ) ) {
	$newSettings['lightbox'] = $_POST['lightbox'];
} elseif( isset($_POST['lightbox']) && file_exists( WB_PATH.'/modules/jqueryadmin/plugins/'.$_POST['lightbox'].'/foldergallery_template.htt' ) ) {
	$newSettings['lightbox'] = $_POST['lightbox'];
// ----- end jQueryAdmin / LibraryAdmin Integration -----
} else {
	$newSettings['lightbox'] = '';
}

//Debuganzeige die ab 1.1 auskommentiert wird
//echo "<textarea cols=\"100\" rows=\"20\" style=\"width: 100%;\">";
//var_export( $newSettings );
//echo "</textarea>";
//ENDE Debug
echo "<center>".$MOD_FOLDERGALLERY_JQ['SAVE_SETTINGS']."</center><br />";
$newSettings['section_id'] = $section_id;
//die('hier3');
$settingsTable = TABLE_PREFIX.'mod_foldergallery_jq_settings';
// SQL eintragen
$database->query("
	UPDATE `".$settingsTable."` 
	SET `root_dir` = '".$newSettings['root_dir']."', 
	`extensions` = '".$newSettings['extensions']."', 
	`invisible` = '".$newSettings['invisible']."',
	`pics_pp` = '".$newSettings['pics_pp']."',
	`thumb_size` = '".$newSettings['thumb_size']."',
	`ratio` = '".$newSettings['ratio']."',
	`catpic` = '".$newSettings['catpic']."',
	`lightbox` = '".$newSettings['lightbox']."'
	WHERE `section_id` = '".$section_id."'"
);

if(($oldSettings['thumb_size'] != $newSettings['thumb_size'] || $oldSettings['ratio'] != $newSettings['ratio']) && !isset($_POST['noNew'])){
	// Ok, thumb_size hat gewechselt, also alte Thumbs löschen
	$sql = 'SELECT `parent`, `categorie` FROM '.TABLE_PREFIX.'mod_foldergallery_jq_categories WHERE section_id='.$oldSettings['section_id'].';';
	$query = $database->query($sql);
	while($link = $query->fetchRow()) {
		$pathToFolder = $path.$oldSettings['root_dir'].$link['parent'].'/'.$link['categorie'].$thumbdir;
		echo '<center><br/>Delete: '.$pathToFolder.'</center>';
		deleteFolder($pathToFolder);
	}
	$pathToFolder = $path.$oldSettings['root_dir'].$thumbdir;
	echo '<center><br/>Delete: '.$pathToFolder.'</center><br />';
	deleteFolder($pathToFolder);
	
}	

///Chio verändert: Orig: // Ok, Ordner hat gewechselt, also alte Thumbs löschen
//Wieso thumbs löschen, wenn sich root-dir geändert hat? Die Thumbs sind bei den Bildern - egal wo.
	
if($oldSettings['root_dir'] != $newSettings['root_dir']){
	
	// Und jetzt noch alte DB Einträge
	$sql = 'SELECT `parent`, `categorie` FROM '.TABLE_PREFIX.'mod_foldergallery_jq_categories WHERE section_id='.$oldSettings['section_id'].';';
	$query = $database->query($sql);
	while($cat = $query->fetchRow()) {
		$sql = 'DELETE FROM '.TABLE_PREFIX.'mod_foldergallery_jq_files WHERE parent_id='.$cat['parent'];
		$database->query($sql);
	}
	
	
	$sql = 'DELETE FROM '.TABLE_PREFIX.'mod_foldergallery_jq_categories WHERE section_id='.$oldSettings['section_id'].';';
	$database->query($sql);
  // Root als Kategorie eintragen
  $sql = 'INSERT INTO '.TABLE_PREFIX."mod_foldergallery_jq_categories ( `section_id`,`parent_id`,`categorie`,`parent`,`cat_name`,`active`,`is_empty`,`position`,`niveau`,`has_child`,`childs`,`description` )
    VALUES ( '$section_id', '-1', 'Root', '-1', 'Root', '1', '0', '0', '-1', '0', '', 'Root Description' );";
  $query = $database->query($sql);
  if($database->is_error()) {
  	$admin->print_error($database->get_error(), WB_URL.'/modules/foldergallery_jq/modify_settings.php?page_id='.$page_id.'&section_id='.$section_id);
  }
}

// Jetzt wird die DB neu synchronisiert //Anm CHio: Wozu? Wenn ein Fehler ist, kann man nichtmal die Settings speichern.
syncDB($newSettings);

// Überprüfen ob ein Fehler aufgetreten ist, sonst Erfolg ausgeben
if($database->is_error()) {
	$admin->print_error($database->get_error(), WB_URL.'/modules/foldergallery_jq/modify_settings.php?page_id='.$page_id.'&section_id='.$section_id);
} else {
	$admin->print_success($TEXT['SUCCESS'], WB_URL.'/modules/foldergallery_jq/sync.php?page_id='.$page_id.'&section_id='.$section_id);
}

// Print admin footer
$admin->print_footer();
?>
