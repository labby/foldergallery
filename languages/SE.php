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

//  Sorting tumbnails
	'REORDER_IMAGES_STRING' => 'Sort images',
	'QUICK_SORT_STRING'		=> 'Sort images by filename.',
	'QUICK_ASC_STRING'		=> 'Filename asc.',
	'QUICK_DESC_STRING'		=> 'Filename desc.',
	'MANUAL_SORT'			=> 'Per drag and drop.',
    
//  Errors durinbg thumbnail generation	
	'ERROR_THUMBNAILS_CANT_CREATE_DIR'  => "Can't create thumbnail-directory!",
	'ERROR_THUMBNAILS_FILE_TOO_LAGE' => "File is too big! (Over ".foldergallery::FG_MEGAPIXEL_LIMIT.")",
	'ERROR_THUMBNAILS_NO_TYPE_MATCH' => "No mime-type match! (File type has to be 'jpeg', 'png', or 'gif'.)",

// Tooltips
    'ROOT_FOLDER_STRING_TT' 	=> 'Rotmappen f&ouml;r att s&ouml;ka efter bilder rekursivt.'
                                            . 'Om rotmappen &Auml;ndras vid ett senare tillf&auml;lle f&ouml;rloras alla bildinst&auml;llningar!',
    'EXTENSIONS_STRING_TT' 	=> 'Definiera de fil&auml;ndelser du vill till&aring;ta. (Skiftl&auml;gesok&auml;nsligt.) Anv&auml;nd "," (komma) som avgr&auml;nsare.',
    'INVISIBLE_STRING_TT' 	=> 'Foldrar som visas h&auml;r kommer inte att skannas.',
    'DELETE_TITLE_TT' 		=> 'Varning: Alla kategorier och bilder raderas! (&Auml;ven bilderna kommer att tas bort'
);
?>