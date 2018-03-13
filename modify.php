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


$file_names = array(
    '/modules/foldergallery/backend.functions.php'
);
LEPTON_handle::include_files ($file_names);

$oFG = foldergallery::getInstance();
$oFG->init_section( $page_id, $section_id );
$oTWIG = lib_twig_box::getInstance();
$oTWIG->registerModule('foldergallery');


if(isset($_POST['toggle']) && is_numeric($_POST['toggle'])) {
	$oFG->toggle_active($_POST['toggle']);
}
if(isset($_POST['move_down']) || isset($_POST['move_up'])) {
	$oFG->move();
}

//recursiv Aufruf aller childs



$data = array(
	'oFG'	=> $oFG,
	'page_id'	=> $page_id,
	'section_id'=> $section_id,	
	'leptoken'	=> get_leptoken()
);
		
echo $oTWIG->render( 
	"@foldergallery/modify.lte",	//	template-filename
	$data							//	template-data
);

?>