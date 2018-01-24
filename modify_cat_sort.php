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
'/modules/foldergallery/register_language.php',
'/include/phplib/template.inc'
);
LEPTON_handle::include_files ($file_names);

$settings = getSettings($section_id);
$thumb_size = $settings['thumb_size']; //Chio
$root_dir = $settings['root_dir']; //Chio

if(isset($_GET['cat_id']) && is_numeric($_GET['cat_id'])) {
	$cat_id = $_GET['cat_id'];
} else {
	$error['no_cat_id'] = 1;
}

// Kategorie Infos aus der DB holen
$sql = 'SELECT * FROM '.TABLE_PREFIX.'mod_foldergallery_categories WHERE id='.$cat_id.' LIMIT 1;';
$query = $database->query($sql);
$categorie = $query->fetchRow();

if ( is_array( $categorie ) ) {
    if ( $categorie['parent'] != -1 ) {
        $cat_path = foldergallery::FG_PATH.$settings['root_dir'].$categorie['parent'].'/'.$categorie['categorie'];
        $parent   = $categorie['parent'].'/'.$categorie['categorie'];
    }
    else {
        // Root
        $cat_path = foldergallery::FG_PATH.$settings['root_dir'];
        $parent   = '';		
    }
}
$parent_id = $categorie['id'];
if ($categorie['active'] == 1) {$cat_active_checked = 'checked="checked"';} else {$cat_active_checked = '';}

$folder = $root_dir.$parent;
$pathToFolder = foldergallery::FG_PATH.$folder.'/';	
$pathToThumb = foldergallery::FG_PATH.$folder.foldergallery::FG_THUMBDIR.'/';
$urlToFolder = foldergallery::FG_URL.$folder.'/';		
$urlToThumb = foldergallery::FG_URL.$folder.foldergallery::FG_THUMBDIR.'/';


$bilder= array();
$sql = 'SELECT * FROM '.TABLE_PREFIX.'mod_foldergallery_files WHERE parent_id="'.$parent_id.'" ORDER BY position ASC;';
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
	'CANCEL_ONCLICK'		=> 'javascript: window.location = \''.LEPTON_URL.'/modules/foldergallery/modify_cat.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id.'\';',
	'QUICK_ASC_ONCLICK'		=> 'javascript: window.location = \''.LEPTON_URL.'/modules/foldergallery/quick_img_sort.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id.'&sort=ASC\';',
	'QUICK_DESC_ONCLICK'	=> 'javascript: window.location = \''.LEPTON_URL.'/modules/foldergallery/quick_img_sort.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id.'&sort=DESC\';'
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