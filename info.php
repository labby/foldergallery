<?php

/**
 *  @module         foldergallery_jq
 *  @version        see info.php of this module
 *  @author         Jürg Rast, schliffer, Bianka Martinovic, Chio, Pumpi, Aldus, erpe
 *  @copyright      2009-2017 Jürg Rast, schliffer, Bianka Martinovic, Chio, Pumpi, Aldus, erpe 
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

$module_directory	= 'foldergallery_jq';
$module_name		= 'Foldergallery-jQuery';
$module_function	= 'page';
$module_version		= '2.3.1';
$module_platform	= '3.x';
$module_author		= 'Jürg Rast, schliffer, Bianka Martinovic, Chio, Pumpi, Aldus, erpe';
$module_license		= 'GNU General Public License';
$module_description	= 'Bildergalerie anhand der Ordnerstruktur erstellen.';
$module_home		= 'http://cms-lab.com/';
$module_guid		= 'c362eb43-878d-492f-906f-57a07da6d0f6';

/**
 *  IMPORTANT
 *  Jquery core and eventually jquery migrate
 *  have to be loaded via frontend template.
 *  Both files are not loaded via this addon since version 2.2.0
**/ 
 
/**
 *  Pfad und URL zum Stammverzeichnis der Foldergallery
 *  Das Stammverzeichnis ist das höchste Verzeichnis
 *  auf welches die Foldergallery zugriff hat.
 *  Die Werte müssen auf das gleiche Verzeichnis zeigen.
 *  Diese Verzeichnisse kann man natürlich ändern!
 *  (z.B) für externe Ordner
**/

$path = LEPTON_PATH.MEDIA_DIRECTORY; // alternativ: LEPTON_PATH;
$url = LEPTON_URL.MEDIA_DIRECTORY; // alternativ: LEPTON_URL.;
$thumbdir = '/fg-thumbs';
// Des gleiche wie oben, aber ohne Slash
// Wird für die Suche benötigt
$thumbdir1 = 'fg-thumbs'; 
$pages = substr(PAGES_DIRECTORY, 1);

/**
 * Diese Zeilen nur ändern wenn du genau weisst was du tust! 
 * '.' und '..' dürfen nicht entfernt werden!
 * Weitere invisibleFileNames können direkt im Backend der Foldergallery definiert werden.
 */

//Alle Ordner ausschliessen, welche zum Core gehören
$wbCoreFolders = array('account','admins','framework','include','languages','modules',$pages,'search','temp','templates');
$invisibleFileNames = array('.', '..', $thumbdir1);

$megapixel_limit = 2; // Ab dieser Größe wird kein Thumb mehr erzeugt.

?>