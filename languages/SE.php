<?php

/**
 *  @module         foldergallery_jq
 *  @version        see info.php of this module
 *  @author         J&uuml;rg Rast; schliffer; Bianka Martinovic; Chio; Pumpi,Aldus; erpe
 *  @copyright      2004-2014 J&uuml;rg Rast; schliffer; Bianka Martinovic; Chio; Pumpi,Aldus; erpe 
 *  @license        GNU General Public License
 *  @license terms  see info.php of this module
 *  @platform       see info.php of this module
 * 
 */
 
// include class.secure.php to protect this file and the whole CMS!
if (defined('WB_PATH')) {	
	include(WB_PATH.'/framework/class.secure.php'); 
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

//Variables for the Frontend
$MOD_FOLDERGALLERY_JQ['VIEW_TITLE']		= 'Bildgalleri';
$MOD_FOLDERGALLERY_JQ['CATEGORIES_TITLE']	= 'Kategorier';
$MOD_FOLDERGALLERY_JQ['BACK_STRING']		= 'Tillbaka till &ouml;versikt';
$MOD_FOLDERGALLERY_JQ['FRONT_END_ERROR']	= 'Antingen finns inte kategorin eller s&aring; inneh&aring;ller den varken bilder eller subkategorier.';
$MOD_FOLDERGALLERY_JQ['PAGE']            = 'Sida';


//Variables for the Backend
$MOD_FOLDERGALLERY_JQ['PICS_PP'] = 'Bilder per sida';
$MOD_FOLDERGALLERY_JQ['LIGHTBOX'] = 'Lightbox';

$MOD_FOLDERGALLERY_JQ['MODIFY_CAT_TITLE']			= '&Auml;ndra kategorier och bildinformation';
$MOD_FOLDERGALLERY_JQ['MODIFY_CAT']			= '&Auml;ndra informationen f&ouml;r kategorin:';
$MOD_FOLDERGALLERY_JQ['CAT_NAME']				= 'Kategori -namn/-titel:';
$MOD_FOLDERGALLERY_JQ['CAT_DESCRIPTION']			= 'Kategorins beskrivning:';
$MOD_FOLDERGALLERY_JQ['MODIFY_IMG']			= '&Auml;ndra bilder:';
$MOD_FOLDERGALLERY_JQ['IMAGE']					= 'Bild';
$MOD_FOLDERGALLERY_JQ['IMAGE_NAME']			= 'Bildens namn';
$MOD_FOLDERGALLERY_JQ['IMG_CAPTION']			= 'Beskrivning av bilden';


$MOD_FOLDERGALLERY_JQ['REDIRECT']  			= 'Du beh&ouml;ver utf&ouml;ra n&aring;gra inst&auml;llningar innan du anv&auml;nder galleriet.'
											. ' Du kommer att vidarebefordras innom tv&aring; sekunder (JavaScript beh&ouml;ver vara aktiverat)';
$MOD_FOLDERGALLERY_JQ['TITEL_BACKEND'] 			= 'Foldergallery Admin';
$MOD_FOLDERGALLERY_JQ['TITEL_MODIFY'] 			= '&Auml;ndra kategorier och bilder:';
$MOD_FOLDERGALLERY_JQ['SETTINGS'] 				= 'Inst&auml;llningar';
$MOD_FOLDERGALLERY_JQ['ROOT_DIR'] 				= 'Rootmapp';
$MOD_FOLDERGALLERY_JQ['EXTENSIONS']			= 'Till&aring;tna fil&auml;ndelser';
$MOD_FOLDERGALLERY_JQ['INVISIBLE']				= 'G&ouml;mda foldrar';
$MOD_FOLDERGALLERY_JQ['NEW_SCANN_INFO']			= 'Databasposterna har skapats. Tumnaglarna skapas n&auml;r kategorin visas f&ouml;rsta g&aring;ngen.';
$MOD_FOLDERGALLERY_JQ['FOLDER_NAME']			= 'Folderns namn';
$MOD_FOLDERGALLERY_JQ['DELETE']				= 'Radera?';
$MOD_FOLDERGALLERY_JQ['ERROR_MESSAGE']			= 'Inga uppgifter';
$MOD_FOLDERGALLERY_JQ['DB_ERROR']				= 'Database error!';
$MOD_FOLDERGALLERY_JQ['FS_ERROR']				= 'Kan inte radera foldern.';
$MOD_FOLDERGALLERY_JQ['NO_FILES_IN_CAT']			= 'Kategorin saknar bilder.';
$MOD_FOLDERGALLERY_JQ['SYNC']				= 'Synkronisera databas med filsystem';
$MOD_FOLDERGALLERY_JQ['EDIT_CSS']				= 'Redigera CSS';
$MOD_FOLDERGALLERY_JQ['FOLDER_IN_FS']			= 'Filesystemfolder:';
$MOD_FOLDERGALLERY_JQ['CAT_TITLE']				= 'Kategorins titel:';
$MOD_FOLDERGALLERY_JQ['ACTION']				= '&Aring;tg&auml;rder:';
$MOD_FOLDERGALLERY_JQ['NO_CATEGORIES'] 			= 'Kategorier (subfoldrar) saknas.<br /><br />Galleriet fungerar &auml;nd&aring;, men inga kategorier visas.';
$MOD_FOLDERGALLERY_JQ['EDIT_THUMB'] 			= 'Redigera tumnagel';
$MOD_FOLDERGALLERY_JQ['EDIT_THUMB_DESCRIPTION']		= '<strong>V&auml;lj en ny bild</strong>';
$MOD_FOLDERGALLERY_JQ['EDIT_THUMB_BUTTON']			= 'Dra upp tumnageln';
$MOD_FOLDERGALLERY_JQ['THUMB_SIZE']			= 'Tumnaglarnas storlek';
$MOD_FOLDERGALLERY_JQ['THUMB_RATIO']			= 'Tumnaglarnas sidof&ouml;rh&aring;llande';
$MOD_FOLDERGALLERY_JQ['THUMB_NOT_NEW']			= '&Aring;terskapa ej tumnaglarna';
$MOD_FOLDERGALLERY_JQ['CHANGING_INFO']			= '&Auml;ndrar <strong>tumnaglarnas storlek</strong> eller <strong>sidof&ouml;rh&aring;llande.</strong> Raderar och &aring;terskapar alla tumnaglar.';
$MOD_FOLDERGALLERY_JQ['SYNC_DATABASE']			= 'Synkronisera databas med filsystem...';
$MOD_FOLDERGALLERY_JQ['SAVE_SETTINGS']			= 'Inst&auml;llningarna sparas...';
$MOD_FOLDERGALLERY_JQ['SORT_IMAGE']			= 'Sortera bilder';
$MOD_FOLDERGALLERY_JQ['BACK']					= 'Back';
$MOD_FOLDERGALLERY_JQ['REORDER_INFO_STRING']   = 'Reorder result will be displayed here.';


// Tooltips
$MOD_FOLDERGALLERY_JQ['ROOT_FOLDER_STRING_TT']	= 'Rotmappen f&ouml;r att s&ouml;ka efter bilder rekursivt.'
                                            . 'Om rotmappen &Auml;ndras vid ett senare tillf&auml;lle f&ouml;rloras alla bildinst&auml;llningar!';
$MOD_FOLDERGALLERY_JQ['EXTENSIONS_STRING_TT']	= 'Definiera de fil&auml;ndelser du vill till&aring;ta. (Skiftl&auml;gesok&auml;nsligt.) Anv&auml;nd "," (komma) som avgr&auml;nsare.';
$MOD_FOLDERGALLERY_JQ['INVISIBLE_STRING_TT']	= 'Foldrar som visas h&auml;r kommer inte att skannas.';
$MOD_FOLDERGALLERY_JQ['DELETE_TITLE_TT']		= 'Varning: Alla kategorier och bilder raderas! (&Auml;ven bilderna kommer att tas bort';
?>
