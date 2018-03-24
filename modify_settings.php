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
$oFG->init_section( $page_id, $section_id );
$oTWIG = lib_twig_box::getInstance();
$oTWIG->registerModule('foldergallery');

// prepare folders to show
if ( ! empty( $oFG->fg_settings['invisible'] ) ) {
    $invisibleFileNames = array_merge( foldergallery::INVISIBLE_FILE_NAMES, explode( ',', $oFG->fg_settings['invisible'] ) );
}
// Do not display system directories
$invisibleFileNames = array_merge(foldergallery::INVISIBLE_FILE_NAMES, foldergallery::CORE_FOLDERS);

LEPTON_handle::register( "directory_list");
$aTempFolders = array();
$sStripFromPath = LEPTON_PATH.MEDIA_DIRECTORY."/";

directory_list(
    LEPTON_PATH.MEDIA_DIRECTORY."/", // leading slash is ugly! (old mess)
    false,
    0,
    $aTempFolders,
    $sStripFromPath
);

// Strip the thumbnail(-dirs) from the list
$folders = array();
foreach($aTempFolders as &$ref)
{
    $aTemp = explode("/", $ref);
    if( array_pop($aTemp) != foldergallery::FG_THUMBDIR1 )
    {
        $folders[] = $ref;
    }
}

//Ratio array
$ratio = array(
	$oFG->language['Ration_square'] => 1, 
	"4:3" => round(4/3, 4), 
	"3:4" => round(3/4, 4), 
	"16:9" => round(16/9, 4), 
	"9:16" => round(9/16, 4)
	);

// available lightboxes	
$lightbox_select = '';
if ( $dh = opendir(dirname(__FILE__).'/templates/frontend') ) {
    while ( ($file = readdir($dh)) !== false ) {
        if ( preg_match( "/^(\w+).lte$/", $file, $matches ) ) {
            $lightbox_select .= '<option value="'
                             .  $matches[1] .'"';
            if ( $matches[1] == $oFG->fg_settings['lightbox'] ) {
                $lightbox_select .= ' selected="selected"';
            }
            $lightbox_select .= '>'
                             .  $matches[1]
                             .  '</option>';
        }
    }
    closedir($dh);
}
$lightbox_select .= '';
	
$data = array(
	'oFG'	=> $oFG,
	'page_id'	=> $page_id,
	'section_id'=> $section_id,
	'folders' => $folders,
	'lightbox' => $lightbox_select,		
	'ratio' => $ratio,	
	'leptoken'	=> get_leptoken()
);
		
echo $oTWIG->render( 
	"@foldergallery/backend/modify_settings.lte",	//	template-filename
	$data							//	template-data
);
?>