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

//Modul Description
$module_description = 'Skapa ett bildgalleri med foldrar och kategorier.';


$MOD_FOLDERGALLERY = array(
//Variables for the Frontend
    'VIEW_TITLE' 		=> 'Bildgalleri',
    'CATEGORIES_TITLE' 	=> 'Kategorier',
    'BACK_STRING' 		=> 'Tillbaka till &ouml;versikt',
    'FRONT_END_ERROR' 	=> 'Antingen finns inte kategorin eller s&aring; inneh&aring;ller den varken bilder eller subkategorier.',
    'PAGE'             => 'Sida',


//Variables for the Backend
    'PICS_PP'  => 'Bilder per sida',
    'LIGHTBOX'  => 'Lightbox',

    'MODIFY_CAT_TITLE' 	=> '&Auml;ndra kategorier och bildinformation',
    'MODIFY_CAT' 			=> '&Auml;ndra informationen f&ouml;r kategorin:',
    'CAT_NAME' 			=> 'Kategori -namn/-titel:',
    'CAT_DESCRIPTION' 	=> 'Kategorins beskrivning:',
    'MODIFY_IMG' 			=> '&Auml;ndra bilder:',
    'IMAGE' 				=> 'Bild',
    'IMAGE_NAME' 			=> 'Bildens namn',
    'IMG_CAPTION' 			=> 'Beskrivning av bilden',


    'REDIRECT'   			=> 'Du beh&ouml;ver utf&ouml;ra n&aring;gra inst&auml;llningar innan du anv&auml;nder galleriet.'
											. ' Du kommer att vidarebefordras innom tv&aring; sekunder (JavaScript beh&ouml;ver vara aktiverat)',
    'TITEL_BACKEND'  		=> 'Foldergallery Admin',
    'TITEL_MODIFY'  		=> '&Auml;ndra kategorier och bilder:',
    'SETTINGS'  			=> 'Inst&auml;llningar',
    'ROOT_DIR'  			=> 'Rootmapp',
    'EXTENSIONS' 			=> 'Till&aring;tna fil&auml;ndelser',
    'INVISIBLE' 			=> 'G&ouml;mda foldrar',
    'NEW_SCANN_INFO' 		=> 'Databasposterna har skapats. Tumnaglarna skapas n&auml;r kategorin visas f&ouml;rsta g&aring;ngen.',
    'FOLDER_NAME' 		=> 'Folderns namn',
    'DELETE' 				=> 'Radera?',
    'ERROR_MESSAGE' 		=> 'Inga uppgifter',
    'DB_ERROR' 			=> 'Database error!',
    'FS_ERROR' 			=> 'Kan inte radera foldern.',
    'NO_FILES_IN_CAT' 	=> 'Kategorin saknar bilder.',
    'SYNC' 				=> 'Synkronisera databas med filsystem',
    'EDIT_CSS' 			=> 'Redigera CSS',
    'FOLDER_IN_FS' 		=> 'Filesystemfolder:',
    'CAT_TITLE' 			=> 'Kategorins titel:',
    'ACTION' 				=> '&Aring;tg&auml;rder:',
    'NO_CATEGORIES'  		=> 'Kategorier (subfoldrar) saknas.<br /><br />Galleriet fungerar &auml;nd&aring;, men inga kategorier visas.',
    'EDIT_THUMB'  		=> 'Redigera tumnagel',
    'EDIT_THUMB_DESCRIPTION' 		=> '<strong>V&auml;lj en ny bild</strong>',
    'EDIT_THUMB_BUTTON' 			=> 'Dra upp tumnageln',
    'THUMB_SIZE' 			=> 'Tumnaglarnas storlek',
    'THUMB_RATIO' 		=> 'Tumnaglarnas sidof&ouml;rh&aring;llande',
    'THUMB_NOT_NEW' 		=> '&Aring;terskapa ej tumnaglarna',
    'CHANGING_INFO' 		=> '&Auml;ndrar <strong>tumnaglarnas storlek</strong> eller <strong>sidof&ouml;rh&aring;llande.</strong> Raderar och &aring;terskapar alla tumnaglar.',
    'SYNC_DATABASE' 		=> 'Synkronisera databas med filsystem...',
    'SAVE_SETTINGS' 		=> 'Inst&auml;llningarna sparas...',
    'SORT_IMAGE' 			=> 'Sortera bilder',
    'BACK' 				=> 'Back',
    'REORDER_INFO_STRING'    => 'Reorder result will be displayed here.',
    'HELP_INFORMATION'       => 'Help / Info',

    'Ration_square'       => 'square',
// Tooltips
    'ROOT_FOLDER_STRING_TT' 	=> 'Rotmappen f&ouml;r att s&ouml;ka efter bilder rekursivt.'
                                            . 'Om rotmappen &Auml;ndras vid ett senare tillf&auml;lle f&ouml;rloras alla bildinst&auml;llningar!',
    'EXTENSIONS_STRING_TT' 	=> 'Definiera de fil&auml;ndelser du vill till&aring;ta. (Skiftl&auml;gesok&auml;nsligt.) Anv&auml;nd "," (komma) som avgr&auml;nsare.',
    'INVISIBLE_STRING_TT' 	=> 'Foldrar som visas h&auml;r kommer inte att skannas.',
    'DELETE_TITLE_TT' 		=> 'Varning: Alla kategorier och bilder raderas! (&Auml;ven bilderna kommer att tas bort',

// Helppage
    'TITLE'            => 'Foldergallery: Help- and Infopage',
    'VERSION'          => 'Release-info',
    'YOUR_VERSION'     => 'You are using Version %s.',
    'NOUPDATES'        => 'There are no updates aviable at the moment!',
    'UPDATE'           => 'Version %s is aviable, a update is recommeded.',
    'VERSION_TEXT'     => 'You can find latest release on <a href="http://www.lepton-cms.com/lepador/modules/foldergallery.php" target="_blank">LEPTON Homepage</a>'
                            .' or on <a href="http://cms-lab.com/lab/en/modules/standard-modules/foldergallery-jquery.php" target="_blank" >CMS-LAB</a>',
    'HOMEPAGE_TEXT'    => 'On <a href="https://github.com/labby/foldergallery" target="_blank">GITHUB</a> you can find the whole changelog, current development and older releases.',                  
    'HELP_TITLE'       => 'Help and Support',
    'HELP_TEXT'        => 'You get support on the <a href="http://forum.lepton-cms.org" target="_blank">LEPTON CMS Addons Forum</a>.',
    'BUG_TITLE'        => 'Report a bug',
    'BUG_TEXT'         => 'Bugs can be reported on <a href="http://forum.lepton-cms.org/" target="_blank">LEPTON CMS Addons Forum</a> or directly on <a href="https://github.com/labby/foldergallery" target="_blank">GITHUB</a>',

    'BACK_STRING'      => 'Back'
);
?>