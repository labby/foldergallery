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
 
class foldergallery extends LEPTON_abstract
{
	 
	/**
	 *  Pfad und URL zum Stammverzeichnis der Foldergallery
	 *  Das Stammverzeichnis ist das höchste Verzeichnis
	 *  auf welches die Foldergallery zugriff hat.
	 *  Die Werte müssen auf das gleiche Verzeichnis zeigen.
	 *  Diese Verzeichnisse kann man natürlich ändern!
	 *  (z.B) für externe Ordner
	**/
	const FG_PATH = LEPTON_PATH.MEDIA_DIRECTORY; // alternativ: LEPTON_PATH;
	const FG_URL = LEPTON_URL.MEDIA_DIRECTORY; // alternativ: LEPTON_URL.;
	const FG_THUMBDIR = '/fg-thumbs';
	// Des gleiche wie oben, aber ohne Slash
	// Wird für die Suche benötigt
	const FG_THUMBDIR1 = 'fg-thumbs'; 
 	const FG_PAGES = PAGES_DIRECTORY;

	/**
	 * Diese Zeilen nur ändern wenn du genau weisst was du tust! 
	 * '.' und '..' dürfen nicht entfernt werden!
	 * Weitere invisibleFileNames können direkt im Backend der Foldergallery definiert werden.
	 */

	// Alle Ordner ausschliessen, welche zum Core gehören
	const CORE_FOLDERS = array('account','admins','framework','include','languages','modules',self::FG_PAGES,'search','temp','templates');
	const INVISIBLE_FILE_NAMES = array('.', '..', self::FG_THUMBDIR1);

	const FG_MB_LIMIT = 2; // Ab dieser Größe des Images wird kein Thumb mehr erzeugt.

	public static $instance;
	
	public function initialize() 
	{

	}
}
