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


$oFG = foldergallery::getInstance();
$oTWIG = lib_twig_box::getInstance();
$oTWIG->registerModule('foldergallery');
LEPTON_handle::include_files ('/modules/foldergallery/functions.php');


if(isset($_POST['edit']) && is_numeric($_POST['edit'])) {
	$file_id = $_POST['edit'];
	$cat_id = $_POST['cat_id'];
	$settings = $oFG->fg_settings;
	$root_dir = $settings['root_dir'];

	//get current image data
	$current_image = array();
	$oFG->database->execute_query(
			"SELECT * FROM ".TABLE_PREFIX."mod_foldergallery_files WHERE id=".$file_id." ",
			true,
			$current_image,
			false
	);

	$bildfilename = $current_image['file_name'];

	//get current cat data
	$current_cat = array();
	$oFG->database->execute_query(
			"SELECT * FROM ".TABLE_PREFIX."mod_foldergallery_categories WHERE id=".$current_image['parent_id']." ",
			true,
			$current_cat,
			false
	);
	// why??		
	if ($current_cat['parent'] != "-1") {
		$parent   = $current_cat['parent'].'/'.$current_cat['categorie'];
	}
	else $parent = '';
	
		
	$full_file_link = foldergallery::FG_URL.$root_dir.$parent.'/'.$bildfilename;
	$full_file = foldergallery::FG_PATH.$root_dir.$parent.'/'.$bildfilename;
	$thumb_file = foldergallery::FG_PATH.$root_dir.$parent.foldergallery::FG_THUMBDIR.'/'.$bildfilename;

			
	// check if event handler filled the form
	if(isset($_POST['w']))			
	{
//		die(LEPTON_tools::display($thumb_file,'pre','ui message'));
		//delete current thumb and create a new one
		LEPTON_handle::delete_obsolete_files ($thumb_file);
		if(generateThumb($full_file, $thumb_file, $settings['thumb_size'], 1, $settings['ratio'], $_POST['x'], $_POST['y'], $_POST['w'], $_POST['h']) )
		{
			$oFG->admin->print_success('Thumb erfolgreich geändert', LEPTON_URL.'/modules/foldergallery/modify_cat.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id);
		}
		
	}
	else 
	{
		list($width, $height, $type, $attr) = getimagesize($full_file); //str_replace um auch Datein oder Ordner mit leerzeichen bearbeiten zu können.
			
		// erstellt ein passendes Vorschaufenster zum eingestellten Verhältniss
		if ($settings['ratio'] > 1) {
			$previewWidth = $settings['thumb_size'];
			$previewHeight = $settings['thumb_size'] / $settings['ratio'];
		}
		else 
		{
			$previewWidth = $settings['thumb_size'] * $settings['ratio'];
			$previewHeight = $settings['thumb_size'];
		}
			
		$data = array(
			'oFG'	=> $oFG,
			'cat_id'	=> $cat_id,
			'file_id'	=> $file_id,
			'full_file_link'	=> $full_file_link,
			'previewWidth'	=> $previewWidth,
			'previewHeight'	=> $previewHeight,	
			'page_id'	=> $_POST['page_id'],
			'section_id'=> $_POST['section_id'],
			'relWidth'=> $width,
			'relHeight'=> $height,				
			'leptoken'	=> get_leptoken()
		);
					
		echo $oTWIG->render( 
			"@foldergallery/modify_thumb.lte",	//	template-filename
			$data								//	template-data
		);
	}

}
else 
{
	$oFG->admin->print_error($oFG->language['ERROR_MESSAGE'], LEPTON_URL.'/modules/foldergallery/modify_cat.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id);
}

$oFG->admin->print_footer();

?>