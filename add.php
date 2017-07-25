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

/*
 * Neuer Eintrag in der DB erstellen
 * $root_dir wird dabei auf 'd41d8cd98f00b204e9800998ecf8427e' gesetzt,
 * damit überprüft werden kann, ob bereits ein Ordner festgelegt wurde
 * (für interessierte: Es ist der MD5-Hashwert einer leeren Zeichenkette) 
 */
$root_dir = 'd41d8cd98f00b204e9800998ecf8427e';
$extensions = 'jpg,jpeg,gif,png';
$database->query("INSERT INTO `" .TABLE_PREFIX ."mod_foldergallery_jq_settings` "
		. "(`page_id`, `section_id`, `root_dir`, `extensions`) VALUES "
		. "('$page_id', '$section_id', '$root_dir', '$extensions')");
?>