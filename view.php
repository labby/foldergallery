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


$oFGF = foldergallery_frontend::getInstance();
$oFGF->init_frontend_page($page_id, $section_id);
LEPTON_handle::include_files ( '/modules/foldergallery/backend.functions.php');
$oTWIG = lib_twig_box::getInstance();
$oTWIG->registerModule('foldergallery');

// Foldergallery settings
$settings = $oFGF->fg_settings;
$thumb_size = $settings['thumb_size'];
$root_dir = $settings['root_dir'];
$catpic = (int) $settings['catpic'];
$ratio = $settings['ratio']; 

// Links to page
$page_link = $database->get_one("SELECT link FROM ".TABLE_PREFIX."pages WHERE page_id = ".$page_id." LIMIT 1");
$link = LEPTON_URL.PAGES_DIRECTORY.$page_link.PAGE_EXTENSION;

// Build the category tree
/*
$aCatTree = array();
$oFGF->buildCatTree( 0, $aCatTree, 0);
echo (LEPTON_tools::display( $aCatTree ,'pre','ui message'));
return 0; // No "die" - we just exit here (in this __FILE__ and keep the current process going on ..
*/
$result = array();
$subCat = array();
$images = array();
$error = false;
$title = PAGE_TITLE;


// get root?
if((isset($_GET['cat']) && is_string($_GET['cat']))) {
	$currentCat = $_GET['cat'];
} else {
	$currentCat = '';
}

$currentCat_id = 0;
$sRootDescription = NULL;
$bIsRootPage = false;

$all_cats = array();
$database->execute_query(
    'SELECT * FROM `'.TABLE_PREFIX.'mod_foldergallery_categories` WHERE `section_id`='.$section_id.' AND `is_empty`=0 AND `active`=1 ORDER BY `position` DESC',
    true,
    $all_cats,
    true
);
echo(LEPTON_tools::display($all_cats,'pre','ui message'));
foreach($all_cats as &$result)
{
	$p = $result['parent'].'/'.$result['categorie'] ;
	
	if ($result['parent'] == '-1') 
	{
		$p = ''; 
		$sRootDescription = $result['description'];
		$sRootTitle = $result['cat_name'];
	}
	
	if ($p == $currentCat)
	{
		$currentCat_id = $result['id'];
		if( $result['parent'] == '-1' )
		{
		    $bIsRootPage = true;
		}
		break;	
	}
}

//	display root if nothing is to display
if(!$currentCat){
	$sql = 'SELECT * FROM '.TABLE_PREFIX.'mod_foldergallery_categories WHERE section_id='.$section_id.' AND parent="" AND is_empty=0 AND active=1 ORDER BY position ASC';
} else {
	$sql = 'SELECT * FROM '.TABLE_PREFIX.'mod_foldergallery_categories WHERE section_id='.$section_id.' AND parent="'.$currentCat.'" AND is_empty=0 AND active=1 ORDER BY position DESC';
}

// get thumbsize from settings
$catWidth = $settings['thumb_size'] + 10;
if ($settings['ratio'] > 1) {
	if ($settings['thumb_size']  >= 150) $catHeight = $settings['thumb_size'] + 10;
	else $catHeight = $settings['thumb_size']/$settings['ratio'] + 50 ;
}
else {
	if ($settings['thumb_size']  >= 150) $catHeight = $settings['thumb_size'] + 10;
	else $catHeight = $settings['thumb_size'] + 50 ;
}

$data = array(
	'oFGF'	=> $oFGF,
	'page_id'	=> $page_id,
	'section_id'=> $section_id,
	'page_title'=> PAGE_TITLE,
	'all_cats'=>$all_cats,	
	'catWidth'=> $catWidth,
	'catHeight'=> $catHeight,
//	'AllCartegories' => $aAllCartegories,	
	'leptoken'	=> get_leptoken()
);
		
echo $oTWIG->render( 
	"@foldergallery/frontend/".$settings['lightbox'].".lte",	//	template-filename
	$data							//	template-data
);


?>