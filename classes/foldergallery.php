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
 
class foldergallery extends LEPTON_abstract
{
	public $database = 0;
	public $admin = 0;
	public $fg_settings = array();
	public $fg_category_zero = array();	
	public $addon_color = 'orange';
	public $fg_extensions ='jpg,jpeg,gif,png';
	public $folder_url = LEPTON_URL.'/modules/foldergallery/';
	public $cat_url = LEPTON_URL.'/modules/foldergallery/modify_cat.php';

	/**
	 *  Path and url to root directory of Foldergallery
	 *  Root directory is the highest level that foldergallery can display
	**/
	const FG_PATH = LEPTON_PATH.MEDIA_DIRECTORY; // alternative: LEPTON_PATH;
	const FG_URL = LEPTON_URL.MEDIA_DIRECTORY; // alternative: LEPTON_URL.;
	const FG_THUMBDIR = '/fg-thumbs';
	
	// The same as above but without "slash", used by search
	const FG_THUMBDIR1 = 'fg-thumbs'; 
 	const FG_PAGES = PAGES_DIRECTORY;

	/**
	 * Please modify these lines only if you know what you do!
	 * '.' and '..' are forbidden!
	 * More invisibleFileNames can be defined directly in the backend.
	 */

	// exclude all core directories
	const CORE_FOLDERS = array('account','admins','framework','include','languages','modules',self::FG_PAGES,'search','temp','templates');
	const INVISIBLE_FILE_NAMES = array('.', '..', self::FG_THUMBDIR1);

	const FG_MB_LIMIT = 2; // max image-size to display thumbs.

	public static $instance;
	
	public function initialize() 
	{
//		global $admin;
		$this->database = LEPTON_database::getInstance();		
		$this->init_section();		
	}
	
	public function init_section( $iPageID = 0, $iSectionID = 0 )
	{
		//get array of settings
		$this->fg_settings = array();
		$this->database->execute_query(
			"SELECT * FROM ".TABLE_PREFIX."mod_foldergallery_settings WHERE section_id=". $iSectionID." ",
			true,
			$this->fg_settings,
			false
		);	
		
		//get categories on section
		$this->fg_category_zero = array();
		$this->database->execute_query(
			"SELECT * FROM ".TABLE_PREFIX."mod_foldergallery_categories WHERE section_id=". $iSectionID." AND niveau = 0 ",
			true,
			$this->fg_category_zero,
			true
		);			
	}	
}
