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
$oTWIG = lib_twig_box::getInstance();
$oTWIG->registerModule('foldergallery');
LEPTON_handle::include_files ('/modules/foldergallery/backend.functions.php');

$thumb_size = $oFG->fg_settings['thumb_size'];
$root_dir = $oFG->fg_settings['root_dir'];

if(isset($_GET['cat_id']) && is_numeric($_GET['cat_id'])) {
	$cat_id = $_GET['cat_id'];
} else {
	$oFG->admin->print_error('no categorie found', ADMIN_URL.'/pages/modify.php?page_id='.$page_id.'&section_id='.$section_id);
}

//get infos from db
$categorie = array();	
$oFG->database->execute_query(
	"SELECT * FROM ".TABLE_PREFIX."mod_foldergallery_categories WHERE id=".$cat_id,
	true,
	$categorie,
	false
);


if ( count($categorie) > 0 ) {
    if ( $categorie['parent'] != -1 ) {
        $cat_path = foldergallery::FG_PATH.$oFG->fg_settings['root_dir'].$categorie['parent'].'/'.$categorie['categorie'];
        $parent   = $categorie['parent'].'/'.$categorie['categorie'];
    }
    else {
        // Root
        $cat_path = foldergallery::FG_PATH.$oFG->fg_settings['root_dir'];
        $parent   = '';		
    }
}

$parent_id = $categorie['id'];
$folder = $root_dir.$parent;
$pathToFolder = foldergallery::FG_PATH.$folder.'/';	
$pathToThumb = foldergallery::FG_PATH.$folder.foldergallery::FG_THUMBDIR.'/';
$urlToFolder = foldergallery::FG_URL.$folder.'/';		
$urlToThumb = foldergallery::FG_URL.$folder.foldergallery::FG_THUMBDIR.'/';

$bilder = array();	
$oFG->database->execute_query(
	"SELECT * FROM ".TABLE_PREFIX."mod_foldergallery_files WHERE parent_id=".$parent_id." ORDER BY position ASC",
	true,
	$bilder,
	true
);


$data = array(
	'oFG'	=> $oFG,
	'cat_id'	=> $cat_id,
	'cat_path'	=> $cat_path,
	'categorie'	=> $categorie,
	'bilder'	=> $bilder,	
	'page_id'	=> $_GET['page_id'],
	'section_id'=> $_GET['section_id'],
	'time'		=> time(),
	'urlToThumb'=> $urlToThumb,	
	'leptoken'	=> get_leptoken()
);
		
echo $oTWIG->render( 
	"@foldergallery/backend/modify_cat_sort.lte",	//	template-filename
	$data								//	template-data
);

$oFG->admin->print_footer();
?>