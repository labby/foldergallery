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
 * Delete existing tables
 */
$database->query("DROP TABLE IF EXISTS `" .TABLE_PREFIX ."mod_foldergallery_jq_settings`");
$database->query("DROP TABLE IF EXISTS `" .TABLE_PREFIX ."mod_foldergallery_jq_files`");
$database->query("DROP TABLE IF EXISTS `" .TABLE_PREFIX ."mod_foldergallery_jq_categories`");

// create a new, clean module DB-table

$sql = 'CREATE TABLE `' .TABLE_PREFIX .'mod_foldergallery_jq_settings` ( '
	. '`section_id` INT NOT NULL DEFAULT \'0\','
	. '`page_id` INT NOT NULL DEFAULT \'0\','
	. '`root_dir` VARCHAR(255) NOT NULL DEFAULT \'\','
	. '`extensions` VARCHAR(255) NOT NULL DEFAULT \'\','
	. '`invisible` VARCHAR( 255 ) NOT NULL DEFAULT \'\','
	. '`background` VARCHAR(50) NOT NULL DEFAULT \'#FFFFFF\','
	. '`thumb_size` INT NOT NULL DEFAULT \'150\','
	. '`ratio` VARCHAR(10) NOT NULL DEFAULT \'\','
	. '`pics_pp` INT NOT NULL DEFAULT \'15\','
	. '`lightbox` VARCHAR(50) NOT NULL DEFAULT \'shutter\','
	. '`catpic` TINYINT NOT NULL DEFAULT \'0\','
	. 'PRIMARY KEY (section_id)'
	. ' );';
$database->query($sql);

$sql = 'CREATE TABLE `'.TABLE_PREFIX .'mod_foldergallery_jq_files` ( '
	.'`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,'
	.'`parent_id` INT NOT NULL DEFAULT \'0\','
	.'`file_name` VARCHAR(255) NOT NULL DEFAULT \'\','
	.'`position` INT NOT NULL DEFAULT \'0\', '
	.'`caption` TEXT NOT NULL DEFAULT \'\');';
$database->query($sql);

$sql = 'CREATE TABLE `'.TABLE_PREFIX.'mod_foldergallery_jq_categories` ( '
	.'`id` INT AUTO_INCREMENT,'
	.'`section_id` INT NOT NULL DEFAULT \'0\','
	.'`parent_id` INT NOT NULL DEFAULT \'0\','
	.'`categorie` VARCHAR(255) NOT NULL DEFAULT \'\','
	.'`parent` VARCHAR(255) NOT NULL DEFAULT \'\','
	.'`cat_name` VARCHAR(255) NOT NULL DEFAULT \'\','
	.'`active` TINYINT NOT NULL DEFAULT \'1\','
	.'`is_empty` INT NOT NULL DEFAULT \'1\','
	.'`position`INT NOT NULL DEFAULT \'0\','
	.'`niveau` INT NOT NULL DEFAULT \'-1\','
	.'`has_child` INT NOT NULL DEFAULT \'0\','
	.'`childs` VARCHAR(255) NOT NULL DEFAULT \'\','
	.'`description` VARCHAR(255) NOT NULL DEFAULT \'\','
	.'PRIMARY KEY (id));';
$database->query($sql);
?>