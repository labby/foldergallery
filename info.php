<?php

/**
 *  @module         foldergallery_jq
 *  @version        see info.php of this module
 *  @author         J&uuml;rg Rast; schliffer; Bianka Martinovic; Chio; Pumpi,Aldus; erpe
 *  @copyright      2004-2014 J&uuml;rg Rast; schliffer; Bianka Martinovic; Chio; Pumpi; Aldus; erpe 
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

$module_directory	= 'foldergallery_jq';
$module_name		= 'Foldergallery-jQuery';
$module_function	= 'page';
$module_version		= '1.2.3';
$module_platform	= '1.3.x';	
$module_author		= 'J&uuml;rg Rast; schliffer; Bianka Martinovic; Chio; Pumpi; Aldus; erpe';
$module_license		= 'GNU General Public License';
$module_description	= 'Bildergalerie anhand der Ordnerstruktur erstellen.';
$module_home		= 'http://cms-lab.com/';
$module_guid		= 'c3621f10-9e20-49c3-a9b4-2e27b352386d';

/**
 *  Pfad und URL zum Stammverzeichnis der Foldergallery
 *  Das Stammverzeichnis ist das höchste Verzeichnis
 *  auf welches die Foldergallery zugriff hat.
 *  Die Werte müssen auf das gleiche Verzeichnis zeigen.
 *  Diese Verzeichnisse kann man natürlich ändern!
 *  (z.B) für externe Ordner
**/

$path = WB_PATH.MEDIA_DIRECTORY; // alternativ: WB_PATH;
$url = WB_URL.MEDIA_DIRECTORY; // alternativ: WB_URL.;
$thumbdir = '/fg-thumbs';
// Des gleiche wie oben, aber ohne Slash
// Wird für die Suche benötigt
$thumbdir1 = 'fg-thumbs'; 
$pages = substr(PAGES_DIRECTORY, 1);

/**
 * Diese Zeilen nur &auml;ndern wenn du genau weisst was du tust! 
 * '.' und '..' d&uuml;rfen nicht entfernt werden!
 * Weitere invisibleFileNames k&ouml;nnen direkt im Backend der Foldergallery definiert werden.
 */

//Alle Ordner ausschliessen, welche zum Core von WB gehoeren
$wbCoreFolders = array('account','admins','framework','include','languages','modules',$pages,'search','temp','templates');
$invisibleFileNames = array('.', '..', $thumbdir1);

$megapixel_limit = 2; // Ab dieser Größe wird kein Thumb mehr erzeugt.

?>