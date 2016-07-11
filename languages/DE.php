<?php

/**
 *  @module         foldergallery_jq
 *  @version        see info.php of this module
 *  @author         Jürg Rast; schliffer; Bianka Martinovic; Chio; Pumpi,Aldus; erpe
 *  @copyright      2009-2016 Jürg Rast; schliffer; Bianka Martinovic; Chio; Pumpi,Aldus; erpe 
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

// Modul Description
$module_description = 'Vollautomatische Bildergalerie mit Ordner als Kategorien erstellen.';

// Variables for the Frontend
$MOD_FOLDERGALLERY_JQ['VIEW_TITLE']		= 'Bildergalerie';
$MOD_FOLDERGALLERY_JQ['CATEGORIES_TITLE']	= 'Kategorien';
$MOD_FOLDERGALLERY_JQ['BACK_STRING']		= 'Zur Übersicht';
$MOD_FOLDERGALLERY_JQ['FRONT_END_ERROR']	= 'Diese Kategorie existiert nicht oder enthält keine Bilder und Unterkategorien!';
$MOD_FOLDERGALLERY_JQ['PAGE']            = 'Seite';

// Variables for the Backend
$MOD_FOLDERGALLERY_JQ['PICS_PP'] = 'Bilder pro Seite';
$MOD_FOLDERGALLERY_JQ['LIGHTBOX'] = 'Lightbox';

$MOD_FOLDERGALLERY_JQ['MODIFY_CAT_TITLE']	= 'Kategorie und Bilddetailes bearbeiten';
$MOD_FOLDERGALLERY_JQ['MODIFY_CAT']			= 'Kategoriedetailes bearbeiten:';
$MOD_FOLDERGALLERY_JQ['CAT_NAME']			= 'Kategoriename/Titel:';
$MOD_FOLDERGALLERY_JQ['CAT_DESCRIPTION']	= 'Kategoriebeschrieb:';
$MOD_FOLDERGALLERY_JQ['MODIFY_IMG']			= 'Bilder bearbeiten:';
$MOD_FOLDERGALLERY_JQ['IMAGE']				= 'Bild';
$MOD_FOLDERGALLERY_JQ['IMAGE_NAME']			= 'Bildname';
$MOD_FOLDERGALLERY_JQ['IMG_CAPTION']		= 'Bildbeschreibung';

$MOD_FOLDERGALLERY_JQ['REDIRECT']  			= 'Sie müssen zuerst die Grundeinstellungen vornehmen.'
											. ' Sie werden in zwei Sekunden weitergeleitet! (Funktioniert nur wenn JavaScript aktiviert!';
$MOD_FOLDERGALLERY_JQ['TITEL_BACKEND'] 		= 'Foldergallery Verwaltung';
$MOD_FOLDERGALLERY_JQ['TITEL_MODIFY'] 		= 'Kategorien und Bilder bearbeiten:';
$MOD_FOLDERGALLERY_JQ['SETTINGS'] 			= 'Allgemeine Einstellungen';
$MOD_FOLDERGALLERY_JQ['ROOT_DIR'] 			= 'Stammverzeichnis';
$MOD_FOLDERGALLERY_JQ['EXTENSIONS']			= 'Erlaubte Dateien';
$MOD_FOLDERGALLERY_JQ['INVISIBLE']			= 'Unsichtbare Ordner';
$MOD_FOLDERGALLERY_JQ['NEW_SCANN_INFO']		= 'Durch diese Aktion wurden erst die Datenbankeintr&auml;ge erstellt. Die Vorschaubilder werden automatisch beim ersten Aufruf der Kategorie erzeugt!';
$MOD_FOLDERGALLERY_JQ['FOLDER_NAME']		= 'Ordnername im Dateisystem';
$MOD_FOLDERGALLERY_JQ['DELETE']				= 'Löschen?';
$MOD_FOLDERGALLERY_JQ['ERROR_MESSAGE']		= 'Keine Daten zum verarbeiten Erhalten!';
$MOD_FOLDERGALLERY_JQ['DB_ERROR']			= 'Datenbank Fehler!';
$MOD_FOLDERGALLERY_JQ['FS_ERROR']			= 'Fehler beim löschen des Ordners!';
$MOD_FOLDERGALLERY_JQ['NO_FILES_IN_CAT']	= 'Diese Kategorie enth&auml;lt keine Bilder!';
$MOD_FOLDERGALLERY_JQ['SYNC']				= 'Datenbank mit Filesystem synchronisieren';
$MOD_FOLDERGALLERY_JQ['EDIT_CSS']			= 'CSS bearbeiten';
$MOD_FOLDERGALLERY_JQ['FOLDER_IN_FS']		= 'Ordner im Dateisystem:';
$MOD_FOLDERGALLERY_JQ['CAT_TITLE']			= 'Kategorietitel:';
$MOD_FOLDERGALLERY_JQ['ACTION']				= 'Aktionen:';
$MOD_FOLDERGALLERY_JQ['NO_CATEGORIES'] 		= 'Keine Kategorien (=Unterverzeichnisse) vorhanden.<br /><br />Die Galerie funktioniert trotzdem, zeigt aber keine Kategorien an.';
$MOD_FOLDERGALLERY_JQ['EDIT_THUMB'] 		= 'Thumbnail bearbeiten';
$MOD_FOLDERGALLERY_JQ['EDIT_THUMB_DESCRIPTION']		= '<strong>Bitte neuen Bildausschnitt wählen</strong>';
$MOD_FOLDERGALLERY_JQ['EDIT_THUMB_BUTTON']			= 'Thumbnail erstellen';
$MOD_FOLDERGALLERY_JQ['THUMB_SIZE']			= 'Thumbnail Größe';
$MOD_FOLDERGALLERY_JQ['THUMB_RATIO']		= 'Thumbnail Verhältniss';
$MOD_FOLDERGALLERY_JQ['THUMB_NOT_NEW']		= 'Keine neuen Thumbnails erzeugen';
$MOD_FOLDERGALLERY_JQ['CHANGING_INFO']		= 'Das ändern von <strong>Thumbnail Größe</strong> oder <strong>Thumbnail Verhältniss</strong> bewirkt das löschen (und neu erstellen) aller Thumbnails.';
$MOD_FOLDERGALLERY_JQ['SYNC_DATABASE']		= 'Synchronisiere Dateisystem mit Datenbank...';
$MOD_FOLDERGALLERY_JQ['SAVE_SETTINGS']		= 'Einstellungen werden gespeichert...';
$MOD_FOLDERGALLERY_JQ['SORT_IMAGE']			= 'Bilder sortieren';
$MOD_FOLDERGALLERY_JQ['BACK']				= 'Zurück';
$MOD_FOLDERGALLERY_JQ['REORDER_INFO_STRING']   = 'Der Erfolg der Neuanordnung wird hier angezeigt.';
$MOD_FOLDERGALLERY_JQ['HELP_INFORMATION']      = 'Hilfe / Info';

$MOD_FOLDERGALLERY_JQ['Ration_square']      = 'quadratisch';

// Tooltips
$MOD_FOLDERGALLERY_JQ['ROOT_FOLDER_STRING_TT']	= 'Dieser Ordner legt den Stammordner fest, in welchem rekursiv nach Bilder gesucht wird. Bitte nur beim installieren ändern, sonst gehen alle Infos zu den Bilder verloren!';
$MOD_FOLDERGALLERY_JQ['EXTENSIONS_STRING_TT']	= 'Legen sie hier die erlaubten Dateierweiterungen fest. Verwenden sie das Koma als Trennzeichen. Auf Gross-/Kleinschreibung wird nicht geachtet.';
$MOD_FOLDERGALLERY_JQ['INVISIBLE_STRING_TT']	= 'Ordner die sie hier eintragen werden nicht durchsucht.';
$MOD_FOLDERGALLERY_JQ['DELETE_TITLE_TT']		= 'Achtung, es werden ALLE Bilder und Unterkategorien mitsamt den Bilder vom Server gelöscht!';

// Helppage
$FG_HELP['TITLE']           = 'Foldergallery-jQuery: Hilfe- und Infoseite';
$FG_HELP['VERSION']         = 'Versionsinfo';
$FG_HELP['YOUR_VERSION']    = 'Sie verwenden Version %s.';
$FG_HELP['NOUPDATES']       = 'Dies ist momentan die aktuellste Version!';
$FG_HELP['UPDATE']          = 'Version %s ist verfügbar, es wird empfohlen ein Update durchzuführen.';
$FG_HELP['VERSION_TEXT']    = 'Die aktuellste Version ist immer auf <a href="http://www.lepton-cms.org/deutsch/addons/freie-addons.php" target="_blank">der LEPTON Homepage</a>'
                            .' oder bei <a href="http://cms-lab.com/lab/de/module/standard-module/foldergallery-jquery.php" target="_blank" >CMS-LAB</a> zu finden!';
$FG_HELP['HOMEPAGE_TEXT']   = 'Auf <a href="https://github.com/aldus/foldergallery_jq" target="_blank">GITHUB</a> finden sie den gesamten Changelog sowie ältere Versionen und den aktuellen Entwicklungsstand.';
                           
$FG_HELP['HELP_TITLE']      = 'Hilfe und Support';
$FG_HELP['HELP_TEXT']       = 'Support wird im <a href="http://forum.lepton-cms.org" target="_blank">LEPTON CMS Addons Forum</a> angeboten.';
$FG_HELP['BUG_TITLE']       = 'Problem melden';
$FG_HELP['BUG_TEXT']        = 'Fehler können ebenso im  <a href="http://forum.lepton-cms.org/" target="_blank">LEPTON CMS Addons Forum</a> oder auf <a href="https://github.com/aldus/foldergallery_jq" target="_blank">GITHUB</a> gemeldet werden!';

$FG_HELP['BACK_STRING']     = 'Zurück';
?>