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
	public $section_id = 0;	
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
    
    //  Max MB for thumbnais: if an image-file size is greater than this value (in MB) no thumbnais are generated.
    const FG_MEGAPIXEL_LIMIT = 6;
    
	/**
	 * Please modify these lines only if you know what you do!
	 * '.' and '..' are forbidden!
	 * More invisibleFileNames can be defined directly in the backend.
	 */

	// exclude all core directories
	const CORE_FOLDERS = array('account','admins','framework','include','languages','modules',self::FG_PAGES,'search','temp','templates');
	const INVISIBLE_FILE_NAMES = array('.', '..', self::FG_THUMBDIR1);

	public static $instance;
	
	public function initialize() 
	{
		
		$this->database = LEPTON_database::getInstance();	
		$this->admin = LEPTON_admin::getInstance();
		global $page_id, $section_id;
		$this->init_section( $page_id, $section_id);		
	}
	
	public function init_section( $iPageID = 0, $iSectionID = 0 )
	{
		$this->page_id = $iPageID;
		$this->section_id = $iSectionID;
		//get array of settings
		$this->fg_settings = array();
		$this->database->execute_query(
			"SELECT * FROM ".TABLE_PREFIX."mod_foldergallery_settings WHERE section_id=". $iSectionID." ",
			true,
			$this->fg_settings,
			false
		);	
echo($this->database->get_error());
		//get all categories on section
		$this->fg_category_all = array();
		$this->database->execute_query(
			"SELECT * FROM `".TABLE_PREFIX."mod_foldergallery_categories` WHERE `section_id`=". $iSectionID." ORDER BY `position` ",
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

    /**
     *  Handle the 'move' of given entries "up" or "down" (the position).
     *
     *  @return boolean True if success, otherwise false.
     */
	public function move()  
	{
		$admin = LEPTON_admin::getInstance();
		$order = new LEPTON_order( TABLE_PREFIX."mod_foldergallery_categories", 'position','id', 'parent_id' );
		
		switch(true)
		{			
		    case (isset($_POST['move_up']) && is_numeric($_POST['move_up'])):				
			    $bSuccess = $order->move_up(intval($_POST['move_up']));
				break;
			
			case (isset($_POST['move_down']) && is_numeric($_POST['move_down'])):
			    $bSuccess = $order->move_down(intval($_POST['move_down']));
			    break;
			    
			default:
			    return false;
		}
		
		if(true === $bSuccess)
		{
            $admin->print_success($this->language['SAVE_SETTINGS'], ADMIN_URL.'/pages/modify.php?page_id='.$this->page_id.'');
            return true;
        } else {
            $admin->print_error($this->language['DB_ERROR'] ."<br />". $order->errorMessage, ADMIN_URL.'/pages/modify.php?page_id='.$this->page_id);
            return false;
        }
	}
	
		
	public function buildCatTree( $iParentID = 0, &$aStorrage, $iDeep = 0)
	{
	    foreach($this->fg_category_all as &$ref)
	    {
	        if($ref['parent_id'] == $iParentID)
	        {
	           $aTemp = array();
	           $this->buildCatTree( $ref['id'], $aTemp, $iDeep + 1);
	           $ref['subcategories'] = $aTemp;
	           
	           $aStorrage[] = $ref;
	        }
	    }
	
	}	
	
}
