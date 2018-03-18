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
$module_description = 'Maak een foto gallery met fotoalbums (categorie&euml;n) gebaseerd op mappen.';

$MOD_FOLDERGALLERY = array(
//Variables for the Frontend
    'VIEW_TITLE' 		=> 'Fotogalerij',
    'CATEGORIES_TITLE' 	=> 'categorie&euml;n',
    'BACK_STRING' 		=> 'Terug naar overzicht',
    'FRONT_END_ERROR' 	=> 'Deze categorie bestaat niet of bevat geen foto\'s en/of categorie&euml;n!',
    'PAGE'             => 'Pagina',

//Variables for the Backend
    'PICS_PP'  => 'Foto\'s per pagina',
    'LIGHTBOX'  => 'Lightbox',

    'MODIFY_CAT_TITLE' 	=> 'Bewerk categorie&euml;n en foto\'s',
    'MODIFY_CAT' 			=> 'Bewerk categorie details:',
    'CAT_NAME' 			=> 'Titel categorie:',
    'CAT_DESCRIPTION' 	=> 'Categorie beschrijving:',
    'MODIFY_IMG' 			=> 'Foto\'s bewerken:',
    'IMAGE' 				=> 'Foto',
    'IMAGE_NAME' 			=> 'Naam foto',
    'IMG_CAPTION' 		=> 'Foto beschrijving',


    'REDIRECT'   			=> 'Voordat je gebruik kunt maken van de fotogalerij moet je eerst het nodige instellen.'
											. ' Je wordt binnen een paar seconden doorgelinkt (als javascript is geactiveerd)',
    'TITEL_BACKEND'  		=> 'Fotoalbum bewerken',
    'TITEL_MODIFY'  		=> 'Bewerk categorie&euml;n en foto\'s:',
    'SETTINGS'  			=> 'Algemene instellingen',
    'ROOT_DIR'  			=> 'Hoofdmap',
    'EXTENSIONS' 			=> 'Toegestane extensies',
    'INVISIBLE' 			=> 'Mappen verbergen',
    'NEW_SCANN_INFO' 		=> 'Deze bewerking is opgeslagen in de database. De miniaturen zullen gemaakt worden wanneer de categorie voor het eerst bekeken wordt.',
    'FOLDER_NAME' 		=> 'Naam map',
    'DELETE' 				=> 'Verwijderen?',
    'ERROR_MESSAGE' 		=> 'Geen data!',
    'DB_ERROR' 			=> 'Database error!',
    'FS_ERROR' 			=> 'Map verwijderen mislukt!',
    'NO_FILES_IN_CAT' 	=> 'Deze categorie bevat geen foto\'s!',
    'SYNC' 				=> 'Synchroniseer database met de huidige veranderingen.',
    'EDIT_CSS' 			=> 'Bewerk CSS',
    'FOLDER_IN_FS' 		=> 'Huidige map:',
    'CAT_TITLE' 			=> 'Titel categorie:',
    'ACTIONS' 			=> 'Acties:',
    'NO_CATEGORIES'  => 'Geen categorie (=submappen) gevonden<br /><br />De fotogalerij zal werken, maar er zullen geen categorie&euml;n getoont kunnen worden.',
    'EDIT_THUMB'  		=> 'Bewerk thumbnail',
    'EDIT_THUMB_DESCRIPTION' 		=> '<strong>Selecteer nieuwe afbeelding aub</strong>',
    'EDIT_THUMB_BUTTON' 			=> 'Maak nieuwe thumbnail',
    'THUMB_SIZE' 			=> 'Thumbnail grootte',
    'THUMB_RATIO' 		=> 'Thumbnail verhouding',
    'THUMB_NOT_NEW' 		=> 'Geen thumbnails genereren',
    'CHANGING_INFO' 		=> 'Grootte of Verhouding aanpassen van de thumbnails, verwijderd de huidige thumnails en wordt opnieuw gegenereerd.',
    'SYNC_DATABASE' 		=> 'Synchroniseer bestanden met database...',
    'SAVE_SETTINGS' 		=> 'Veranderingen zijn opgeslagen...',
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
    'ROOT_FOLDER_STRING_TT' 	=> 'Dit is de hoofdmap (root) waar gezocht wordt naar foto\'s en mappen. '
                                            . ' Verander deze map niet meer! Alle instellingen en gegevens van de foto\'s zullen verloren gaan!',
    'EXTENSIONS_STRING_TT' 	=> 'Definieer de extensies die je beschikbaar wilt maken. (Hoofdlettergevoelig.) Gebruik "," (komma) als scheidingsteken.',
    'INVISIBLE_STRING_TT' 	=> 'Mappen die hier aangegeven worden zullen niet zichtbaar zijn in de gallery.',
    'DELETE_TITLE_TT' 		=> 'Waarschuwing: Dit verwijderd alle categorie&euml;n en foto\'s! (De foto\'s zullen dus ook verwijderd worden!)'
);
?>