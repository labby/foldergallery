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
	public $page_id = 0;
	public $fg_settings = array();
	public $fg_category_all = array();
	public $addon_color = 'orange';
	public $fg_extensions ='jpg,jpeg,gif,png';
	public $folder_url = LEPTON_URL.'/modules/foldergallery/';
	public $modify_url = ADMIN_URL.'/pages/modify.php';

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
		
		$this->database = LEPTON_database::getInstance();		
		$this->init_section();		
	}
	
	public function init_section( $iPageID = 0, $iSectionID = 0 )
	{
		$this->page_id = $iPageID;
		//get array of settings
		$this->fg_settings = array();
		$this->database->execute_query(
			"SELECT * FROM ".TABLE_PREFIX."mod_foldergallery_settings WHERE section_id=". $iSectionID." ",
			true,
			$this->fg_settings,
			false
		);	

		//get all categories on section
		$this->fg_category_all = array();
		$this->database->execute_query(
			"SELECT * FROM ".TABLE_PREFIX."mod_foldergallery_categories WHERE section_id=". $iSectionID." ORDER BY position ",
			true,
			$this->fg_category_all,
			true
		);	
				
	}

	public function toggle_active( $id )   // Function to switch between active/inactive
	{
		$admin = LEPTON_admin::getInstance();
		$database = LEPTON_database::getInstance();
		$data = $database->get_one( "SELECT `active` FROM ".TABLE_PREFIX."mod_foldergallery_categories WHERE id = ".$id." " );

		$new = ( $data == 1 ) ? 0 : 1;

		$database->simple_query( "UPDATE ".TABLE_PREFIX."mod_foldergallery_categories SET active=".$new." WHERE id = ".$id." " );
		
		// Check if there is a db error, else success
		if($database->is_error()) {
			$admin->print_error($database->get_error());
		} else {
			$admin->print_success($this->language['SAVE_SETTINGS'], ADMIN_URL.'/pages/modify.php?page_id='.$this->page_id.'');
		}		
	} 

	public function move()  
	{
		$admin = LEPTON_admin::getInstance();
		$order = new LEPTON_order(TABLE_PREFIX."mod_foldergallery_categories", 'position','id', 'parent_id');			
		if(isset($_POST['move_up']) && is_numeric ($_POST['move_up'])) {				
			if($order->move_up($_POST['move_up'])) {
				$admin->print_success($this->language['SAVE_SETTINGS'], ADMIN_URL.'/pages/modify.php?page_id='.$this->page_id.'');
				return true;
			} else {
				$admin->print_error($this->language['DB_ERROR'] ."<br />". $order->error, ADMIN_URL.'/pages/modify.php?page_id='.$this->page_id);
				return false;
			}
		} elseif (isset($_POST['move_down']) && is_numeric ($_POST['move_down'])) {	
			//die(LEPTON_tools::display($order,'pre','ui message'));
			if($order->move_down($_POST['move_down'])) {
				$admin->print_success($this->language['SAVE_SETTINGS'], ADMIN_URL.'/pages/modify.php?page_id='.$this->page_id.'');
				return true;
			} else {
				$admin->print_error($this->language['DB_ERROR']."<br />".$order->error, ADMIN_URL.'/pages/modify.php?page_id='.$this->page_id);
				return false;
			}		
		} 	
	}
}
