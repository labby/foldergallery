<?php

/**
 *  @module         foldergallery_jq
 *  @version        see info.php of this module
 *  @author         Jürg Rast, schliffer, Bianka Martinovic, Chio, Pumpi, Aldus, erpe
 *  @copyright      2009-2017 Jürg Rast, schliffer, Bianka Martinovic, Chio, Pumpi, Aldus, erpe 
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

global $MOD_FOLDERGALLERY_JQ;
$admin = new LEPTON_admin('Pages', 'pages_modify');

$file_names = array(
'/modules/foldergallery_jq/backend.functions.php',
'/modules/foldergallery_jq/register_language.php',
'/include/phplib/template.inc'
);
LEPTON_handle::include_files ($file_names);

$settings = getSettings($section_id);
$thumb_size = $settings['thumb_size']; //Chio
$root_dir = $settings['root_dir']; //Chio
$ratio = $settings['ratio']; //Pumpi


if(isset($_GET['cat_id']) && is_numeric($_GET['cat_id'])) {
	$cat_id = $_GET['cat_id'];
} else {
	$error['no_cat_id'] = 1;
	$admin->print_error('lost cat', ADMIN_URL.'/pages/modify.php?page_id='.$page_id.'&section_id='.$section_id);
	die();
}

// Kategorie Infos aus der DB holen
$sql = 'SELECT * FROM '.TABLE_PREFIX.'mod_foldergallery_jq_categories WHERE id='.$cat_id.' LIMIT 1;';
$query = $database->query($sql);
$categorie = $query->fetchRow();

if ( is_array( $categorie ) ) {
    if ( $categorie['parent'] != -1 ) {
        $cat_path = foldergallery_jq::FG_PATH.$settings['root_dir'].$categorie['parent'].'/'.$categorie['categorie'];
		$cat_path = str_replace(LEPTON_PATH, '', $cat_path);
        $parent   = $categorie['parent'].'/'.$categorie['categorie'];
    }
    else {
        // Root
        $cat_path = foldergallery_jq::FG_PATH.$settings['root_dir'];
        $parent   = '';		
    }
}
$parent_id = $categorie['id'];
if ($categorie['active'] == 1) {$cat_active_checked = 'checked="checked"';} else {$cat_active_checked = '';}


$folder = $root_dir.$parent;
$pathToFolder = foldergallery_jq::FG_PATH.$folder.'/';	
$pathToThumb = foldergallery_jq::FG_PATH.$folder.foldergallery_jq::FG_THUMBDIR.'/';
$urlToFolder = foldergallery_jq::FG_URL.$folder.'/';		
$urlToThumb = foldergallery_jq::FG_URL.$folder.foldergallery_jq::FG_THUMBDIR.'/';

//echo '<h3>'.$parent_id.'</h3>'; 

$bilder= array();
$sql = 'SELECT * FROM '.TABLE_PREFIX.'mod_foldergallery_jq_files WHERE parent_id="'.$parent_id.'" ORDER BY position ASC;';
$query = $database->query($sql);

if($query->numRows()){
	while($result = $query->fetchRow()) {
		// Falls es das Vorschaubild noch nicht gibt:
		//Chio Start
		$bildfilename = $result['file_name'];
		$file = $pathToFolder.$bildfilename;
		if(!is_file($file)){	
			$deletesql = 'DELETE FROM '.TABLE_PREFIX.'mod_foldergallery_jq_files WHERE id='.$result['id'];
			$database->query($deletesql);
			continue;
		}
		
		$thumb = $pathToThumb.$bildfilename;			
		if(!is_file($thumb)){	
			generateThumb($file, $thumb, $thumb_size, 0, $ratio);
		}
		
		//Chio Ende
		$bilder[] = array(
			'id'		=> $result['id'],
			'file_name'	=> $bildfilename, //Chio
			'caption'	=> $result['caption'], //Chio
			'thumb_link'=> $urlToThumb .$bildfilename
		);		
	}
} else {
	// Diese Kategorie enthält noch keine Bilder
	$error['noimages'] = 1;
}

//Template
$t = new Template(dirname(__FILE__).'/templates', 'remove');
$t->set_file('modify_cat', 'modify_cat.htt');
// clear the comment-block, if present
$t->set_block('modify_cat', 'CommentDoc'); $t->clear_var('CommentDoc');
$t->set_block('modify_cat', 'file_loop', 'FILE_LOOP');

$MOD_FOLDERGALLERY_JQ;

// Textvariablen parsen
$t->set_var(array(
	'MODIFY_CAT_TITLE'		=> $MOD_FOLDERGALLERY_JQ['MODIFY_CAT_TITLE'],
	'MODIFY_CAT_STRING'		=> $MOD_FOLDERGALLERY_JQ['MODIFY_CAT'],
	'FOLDER_IN_FS_STRING'	=> $MOD_FOLDERGALLERY_JQ['FOLDER_IN_FS'],
	'FOLDER_IN_FS_VALUE'	=> htmlentities($cat_path),
	'CAT_ACTIVE_CHECKED'	=> $cat_active_checked,
	'CAT_NAME_STRING'		=> $MOD_FOLDERGALLERY_JQ['CAT_NAME'],
	'CAT_NAME_VALUE'		=> $categorie['cat_name'],
	'CAT_DESCRIPTION_STRING'=> $MOD_FOLDERGALLERY_JQ['CAT_DESCRIPTION'],
	'CAT_DESCRIPTION_VALUE'	=> $categorie['description'],
	'MODIFY_IMG_STRING'		=> $MOD_FOLDERGALLERY_JQ['MODIFY_IMG'],
	'IMAGE_STRING'			=> $MOD_FOLDERGALLERY_JQ['IMAGE'],
	'IMAGE_NAME_STRING'		=> $MOD_FOLDERGALLERY_JQ['IMAGE_NAME'],
	'IMAGE_CAPTION_STRING'	=> $MOD_FOLDERGALLERY_JQ['IMG_CAPTION'],
	'IMAGE_ACTION_STRING'	=> $MOD_FOLDERGALLERY_JQ['ACTION'],
	'SAVE_STRING'			=> $TEXT['SAVE'],
	'CANCEL_STRING'			=> $TEXT['CANCEL'],
	'SORT_IMAGE_STRING'		=> $MOD_FOLDERGALLERY_JQ['SORT_IMAGE'],
	// Section und Page ID
	'SECTION_ID_VALUE'		=> $section_id,
	'PAGE_ID_VALUE'			=> $page_id,
	'CAT_ID_VALUE'			=> $cat_id,
	'LEPTON_URL'	=> LEPTON_URL
));

// Links parsen
$t->set_var(array(
	'SAVE_CAT_LINK'			=> LEPTON_URL.'/modules/foldergallery_jq/save_cat.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id,
	'SAVE_FILES_LINK'		=> LEPTON_URL.'/modules/foldergallery_jq/save_files.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id,
	'CANCEL_ONCLICK'		=> 'javascript: window.location = \''.ADMIN_URL.'/pages/modify.php?page_id='.$page_id.'\';'
));

// Files parsen
$counter = 0;
foreach($bilder as $bild) {
	$t->set_var(array(
		'ID_VALUE'			=> $bild['id'],
		'IMAGE_VALUE'		=> $bild['thumb_link'].'?t='.time(),
		'IMAGE_NAME_VALUE'	=> $bild['file_name'],
		'CAPTION_VALUE'		=> $bild['caption'],
		'EDIT_THUMB_SOURCE'	=> LEPTON_URL.'/modules/lib_lepton/backend_images/resize_16.png',
		'DELETE_IMG_SOURCE'	=> LEPTON_URL.'/modules/lib_lepton/backend_images/delete_16.png',
		'THUMB_EDIT_LINK'	=> LEPTON_URL."/modules/foldergallery_jq/modify_thumb.php?page_id=".$page_id."&section_id=".$section_id."&cat_id=".$cat_id."&id=".$bild['id'],	
		'IMAGE_DELETE_LINK'	=> "javascript: confirm_link(\"Sind Sie sicher, dass Sie das ausgew&auml;hlte Bild l&ouml;schen m&ouml;chten?\", \"".LEPTON_URL."/modules/foldergallery_jq/delete_img.php?page_id=".$page_id."&section_id=".$section_id."&cat_id=".$cat_id."&id=".$bild['id']."\");",
		'COUNTER'			=> $counter
	));
	$t->parse('FILE_LOOP', 'file_loop', true);
	$counter++;
}

$t->pparse('output', 'modify_cat');

$admin->print_footer();

?>