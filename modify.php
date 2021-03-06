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
$oFG->init_section( $page_id, $section_id );
LEPTON_handle::include_files ( '/modules/foldergallery/backend.functions.php');
$oTWIG = lib_twig_box::getInstance();
$oTWIG->registerModule('foldergallery');


if(isset($_POST['toggle']) && is_numeric($_POST['toggle'])) {
	$oFG->toggle_active($_POST['toggle']);
}
if(isset($_POST['move_down']) || isset($_POST['move_up'])) {
	$oFG->move();
}

//  Build categories-tree
$aAllCartegories = array();
$oFG->buildCatTree( 0, $aAllCartegories);

// Add "root" to the top of the tree
$oFG->fg_category_all[0]['subcategories'] = $aAllCartegories;
$aAllCartegories = array(
    $oFG->fg_category_all[0]
);

$data = array(
	'oFG'	=> $oFG,
	'page_id'	=> $page_id,
	'section_id'=> $section_id,
	'AllCartegories' => $aAllCartegories,	
	'leptoken'	=> get_leptoken()
);
		
echo $oTWIG->render( 
	"@foldergallery/backend/modify.lte",	//	template-filename
	$data							//	template-data
);

?>