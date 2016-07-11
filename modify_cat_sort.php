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

require_once(LEPTON_PATH.'/modules/admin.php');
	
// check if backend.css file needs to be included into <body></body>
if(!method_exists($admin, 'register_backend_modfiles') && file_exists(LEPTON_PATH ."/modules/foldergallery_jq/backend.css")) {
echo '<style type="text/css">';
include(LEPTON_PATH .'/modules/foldergallery_jq/backend.css');
echo "\n</style>\n";
}
// check if backend.js file needs to be included into <body></body>
if(!method_exists($admin, 'register_backend_modfiles') && file_exists(LEPTON_PATH ."/modules/foldergallery_jq/backend.js")) {
echo '<script type="text/javascript">';
include(LEPTON_PATH .'/modules/foldergallery_jq/backend.js');
echo "</script>";
}

// check if module language file exists for the language set by the user (e.g. DE, EN)
if(!file_exists(LEPTON_PATH .'/modules/foldergallery_jq/languages/'.LANGUAGE .'.php')) {
// no module language file exists for the language set by the user, include default module language file DE.php
require_once(LEPTON_PATH .'/modules/foldergallery_jq/languages/DE.php');
} else {
// a module language file exists for the language defined by the user, load it
require_once(LEPTON_PATH .'/modules/foldergallery_jq/languages/'.LANGUAGE .'.php');
}

// Files includen
require_once (LEPTON_PATH.'/modules/foldergallery_jq/info.php');
require_once (LEPTON_PATH.'/modules/foldergallery_jq/backend.functions.php');

$settings = getSettings($section_id);
$thumb_size = $settings['thumb_size']; //Chio
$root_dir = $settings['root_dir']; //Chio

if(isset($_GET['cat_id']) && is_numeric($_GET['cat_id'])) {
	$cat_id = $_GET['cat_id'];
} else {
	$error['no_cat_id'] = 1;
}

// Kategorie Infos aus der DB holen
$sql = 'SELECT * FROM '.TABLE_PREFIX.'mod_foldergallery_jq_categories WHERE id='.$cat_id.' LIMIT 1;';
$query = $database->query($sql);
$categorie = $query->fetchRow();

if ( is_array( $categorie ) ) {
    if ( $categorie['parent'] != -1 ) {
        $cat_path = $path.$settings['root_dir'].$categorie['parent'].'/'.$categorie['categorie'];
        $parent   = $categorie['parent'].'/'.$categorie['categorie'];
    }
    else {
        // Root
        $cat_path = $path.$settings['root_dir'];
        $parent   = '';		
    }
}
$parent_id = $categorie['id'];
if ($categorie['active'] == 1) {$cat_active_checked = 'checked="checked"';} else {$cat_active_checked = '';}

$folder = $root_dir.$parent;
$pathToFolder = $path.$folder.'/';	
$pathToThumb = $path.$folder.$thumbdir.'/';
$urlToFolder = $url.$folder.'/';		
$urlToThumb = $url.$folder.$thumbdir.'/';


$bilder= array();
$sql = 'SELECT * FROM '.TABLE_PREFIX.'mod_foldergallery_jq_files WHERE parent_id="'.$parent_id.'" ORDER BY position ASC;';
$query = $database->query($sql);


$t = new Template(dirname(__FILE__).'/templates', 'remove');
$t->set_file('modify_cat_sort', 'modify_cat_sort.htt');
// clear the comment-block, if present
$t->set_block('modify_cat_sort', 'CommentDoc');
$t->clear_var('CommentDoc');
// Get the Blocks
$t->set_block('modify_cat_sort', 'image_loop', 'IMAGE_LOOP');

// Replace Language Strings
$t->set_var(array(
	'REORDER_IMAGES_STRING' 	=> 'Bilder sortieren',
	'CANCEL_STRING'		=> 'Abbrechen',
	'QUICK_SORT_STRING'		=> 'Bilder nach Dateiname sortiern',
	'QUICK_ASC_STRING'		=> 'Dateiname aufsteigend',
	'QUICK_DESC_STRING'		=> 'Dateiname absteigend',
	'MANUAL_SORT'			=> 'Frei sortieren'	
));

// Links Parsen
$t->set_var(array(
	'CANCEL_ONCLICK'		=> 'javascript: window.location = \''.LEPTON_URL.'/modules/foldergallery_jq/modify_cat.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id.'\';',
	'QUICK_ASC_ONCLICK'		=> 'javascript: window.location = \''.LEPTON_URL.'/modules/foldergallery_jq/quick_img_sort.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id.'&sort=ASC\';',
	'QUICK_DESC_ONCLICK'	=> 'javascript: window.location = \''.LEPTON_URL.'/modules/foldergallery_jq/quick_img_sort.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id.'&sort=DESC\';'
));

// JS Werte Parsen
$t->set_var(array(
	'PARENT_ID_VALUE'		=> $parent_id,
	'LEPTON_URL_VALUE'			=> LEPTON_URL
));

// Bilder parsen
if($query->numRows()) {
	while($result = $query->fetchRow()) {
		$bildfilename = $result['file_name'];
		$thumb = $pathToThumb.$bildfilename;
		$t->set_var(array(
			'RESULT_ID_VALUE'		=> $result['id'],
			'THUMB_SIZE_VALUE'		=> $thumb_size,
			'THUMB_URL'				=> $urlToThumb.$bildfilename,
			'TITLE_VALUE'			=> $result['position'].': '.$bildfilename
		));
		$t->parse('IMAGE_LOOP', 'image_loop', true);
	}
}


$t->pparse('output', 'modify_cat_sort');

$admin->print_footer();
?>