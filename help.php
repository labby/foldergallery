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
$admin = LEPTON_admin::getInstance();
$oTWIG = lib_twig_box::getInstance();
$oTWIG->registerModule('foldergallery');

$data = array(
	'oFG'	=> $oFG,
	'image_url'	=> 'http://cms-lab.com/_documentation/media/foldergallery/foldergallery.jpg',
	'readme_link'	=> "<a href='http://cms-lab.com/_documentation/foldergallery/readme.php' class='info' target='_blank'>Readme</a>",
	'page_id'		=> $page_id,
	'leptoken'	=> get_leptoken()
);
		
echo $oTWIG->render( 
	"@foldergallery/info.lte",	//	template-filename
	$data							//	template-data
);

$admin->print_footer();
?>