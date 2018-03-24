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
 
class foldergallery_frontend extends foldergallery
{
	public $database = 0;	
	public static $instance;

	public function initialize() 
	{
		$this->database = LEPTON_database::getInstance();			
	}
	
	public function init_frontend_page( $iPageID = 0, $iSectionID = 0 )
	{
		//get array of settings
		$this->fg_settings = array();
		$this->database->execute_query(
			"SELECT * FROM ".TABLE_PREFIX."mod_foldergallery_settings WHERE section_id=".$iSectionID." ",
			true,
			$this->fg_settings,
			false
		);	

		//get all categories on section
		$this->fg_category_all = array();
		$this->database->execute_query(
			"SELECT * FROM `".TABLE_PREFIX."mod_foldergallery_categories` WHERE `section_id`=". $iSectionID." ORDER BY `position` ",
			true,
			$this->fg_category_all,
			true
		);	
				
	}
	
	/**
	 *
	 *  @param  integer iParentID   The "root" id looking for
	 *  @param  array   aStorrage   An array for the results - pass by reference!
	 *  @param  array   aAll        All given entries - pass by reference!
	 *  @param  integer iDeep       The recursions counter.
	 *
	 */
    public function buildCatTreeFrontend( $iParentID = 0, &$aStorrage, &$aAll, $iDeep = 0)
	{
	    foreach($aAll as &$ref)
	    {
	        if($ref['parent_id'] == $iParentID)
	        {
	           $aTemp = array();
	           $this->buildCatTreeFrontend( $ref['id'], $aTemp, $aAll, $iDeep + 1);
	           $ref['subcategories'] = $aTemp;
	           
	           $aStorrage[] = $ref;
	        }
	    }
	
	}	
} // end of class
