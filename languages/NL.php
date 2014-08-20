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
$module_description = 'Maak een foto gallery met fotoalbums (categorie&euml;n) gebaseerd op mappen.';

//Variables for the Frontend
$MOD_FOLDERGALLERY['VIEW_TITLE']		= 'Fotogalerij';
$MOD_FOLDERGALLERY['CATEGORIES_TITLE']	= 'categorie&euml;n';
$MOD_FOLDERGALLERY['BACK_STRING']		= 'Terug naar overzicht';
$MOD_FOLDERGALLERY['FRONT_END_ERROR']	= 'Deze categorie bestaat niet of bevat geen foto\'s en/of categorie&euml;n!';
$MOD_FOLDERGALLERY['PAGE']            = 'Pagina';


//Variables for the Backend
$MOD_FOLDERGALLERY['PICS_PP'] = 'Foto\'s per pagina';
$MOD_FOLDERGALLERY['LIGHTBOX'] = 'Lightbox';

$MOD_FOLDERGALLERY['MODIFY_CAT_TITLE']		= 'Bewerk categorie&euml;n en foto\'s';
$MOD_FOLDERGALLERY['MODIFY_CAT']			= 'Bewerk categorie details:';
$MOD_FOLDERGALLERY['CAT_NAME']				= 'Titel categorie:';
$MOD_FOLDERGALLERY['CAT_DESCRIPTION']		= 'Categorie beschrijving:';
$MOD_FOLDERGALLERY['MODIFY_IMG']			= 'Foto\'s bewerken:';
$MOD_FOLDERGALLERY['IMAGE']					= 'Foto';
$MOD_FOLDERGALLERY['IMAGE_NAME']			= 'Naam foto';
$MOD_FOLDERGALLERY['IMG_CAPTION']			= 'Foto beschrijving';


$MOD_FOLDERGALLERY['REDIRECT']  			= 'Voordat je gebruik kunt maken van de fotogalerij moet je eerst het nodige instellen.'
											. ' Je wordt binnen een paar seconden doorgelinkt (als javascript is geactiveerd)';
$MOD_FOLDERGALLERY['TITEL_BACKEND'] 		= 'Fotoalbum bewerken';
$MOD_FOLDERGALLERY['TITEL_MODIFY'] 			= 'Bewerk categorie&euml;n en foto\'s:';
$MOD_FOLDERGALLERY['SETTINGS'] 				= 'Algemene instellingen';
$MOD_FOLDERGALLERY['ROOT_DIR'] 				= 'Hoofdmap';
$MOD_FOLDERGALLERY['EXTENSIONS']			= 'Toegestane extensies';
$MOD_FOLDERGALLERY['INVISIBLE']				= 'Mappen verbergen';
$MOD_FOLDERGALLERY['NEW_SCANN_INFO']		= 'Deze bewerking is opgeslagen in de database. De miniaturen zullen gemaakt worden wanneer de categorie voor het eerst bekeken wordt.';
$MOD_FOLDERGALLERY['FOLDER_NAME']			= 'Naam map';
$MOD_FOLDERGALLERY['DELETE']				= 'Verwijderen?';
$MOD_FOLDERGALLERY['ERROR_MESSAGE']			= 'Geen data!';
$MOD_FOLDERGALLERY['DB_ERROR']				= 'Database error!';
$MOD_FOLDERGALLERY['FS_ERROR']				= 'Map verwijderen mislukt!';
$MOD_FOLDERGALLERY['NO_FILES_IN_CAT']		= 'Deze categorie bevat geen foto\'s!';
$MOD_FOLDERGALLERY['SYNC']					= 'Synchroniseer database met de huidige veranderingen.';
$MOD_FOLDERGALLERY['EDIT_CSS']				= 'Bewerk CSS';
$MOD_FOLDERGALLERY['FOLDER_IN_FS']			= 'Huidige map:';
$MOD_FOLDERGALLERY['CAT_TITLE']				= 'Titel categorie:';
$MOD_FOLDERGALLERY['ACTIONS']				= 'Acties:';
$MOD_FOLDERGALLERY['NO_CATEGORIES'] = 'Geen categorie (=submappen) gevonden<br /><br />De fotogalerij zal werken, maar er zullen geen categorie&euml;n getoont kunnen worden.';
$MOD_FOLDERGALLERY['EDIT_THUMB'] 			= 'Bewerk thumbnail';
$MOD_FOLDERGALLERY['EDIT_THUMB_DESCRIPTION']		= '<strong>Selecteer nieuwe afbeelding aub</strong>';
$MOD_FOLDERGALLERY['EDIT_THUMB_BUTTON']			= 'Maak nieuwe thumbnail';
$MOD_FOLDERGALLERY['THUMB_SIZE']			= 'Thumbnail grootte';
$MOD_FOLDERGALLERY['THUMB_RATIO']			= 'Thumbnail verhouding';
$MOD_FOLDERGALLERY['THUMB_NOT_NEW']			= 'Geen thumbnails genereren';
$MOD_FOLDERGALLERY['CHANGING_INFO']			= 'Grootte of Verhouding aanpassen van de thumbnails, verwijderd de huidige thumnails en wordt opnieuw gegenereerd.';
$MOD_FOLDERGALLERY['SYNC_DATABASE']			= 'Synchroniseer bestanden met database...';
$MOD_FOLDERGALLERY['SAVE_SETTINGS']			= 'Veranderingen zijn opgeslagen...';
$MOD_FOLDERGALLERY['BACK']					= 'Back';
$MOD_FOLDERGALLERY['REORDER_INFO_STRING']   = 'Reorder result will be displayed here.';


// Tooltips
$MOD_FOLDERGALLERY['ROOT_FOLDER_STRING_TT']	= 'Dit is de hoofdmap (root) waar gezocht wordt naar foto\'s en mappen. '
                                            . ' Verander deze map niet meer! Alle instellingen en gegevens van de foto\'s zullen verloren gaan!';
$MOD_FOLDERGALLERY['EXTENSIONS_STRING_TT']	= 'Definieer de extensies die je beschikbaar wilt maken. (Hoofdlettergevoelig.) Gebruik "," (komma) als scheidingsteken.';
$MOD_FOLDERGALLERY['INVISIBLE_STRING_TT']	= 'Mappen die hier aangegeven worden zullen niet zichtbaar zijn in de gallery.';
$MOD_FOLDERGALLERY['DELETE_TITLE_TT']		= 'Waarschuwing: Dit verwijderd alle categorie&euml;n en foto\'s! (De foto\'s zullen dus ook verwijderd worden!)';
?>