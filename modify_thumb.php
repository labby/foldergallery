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

$admin = new LEPTON_admin('Pages', 'pages_modify');

$file_names = array(
'/modules/foldergallery/backend.functions.php',
'/modules/foldergallery/register_language.php',
'/include/phplib/template.inc'
);
LEPTON_handle::include_files ($file_names);

//get the Jcrop CSS
echo '<link rel="stylesheet" type="text/css" href="'.LEPTON_URL.'/modules/foldergallery/scripts/jcrob/css/jquery.Jcrop.css" /> ';

$cat_id = $_GET['cat_id'];

if(isset($_GET['id']) && is_numeric($_GET['id'])) {
	/**
	 *	Get leptoken hash
	 */
	$leptoken = (isset($_GET['leptoken'])) ? "&leptoken=".$_GET['leptoken'] : "";
	
	$settings = getSettings($section_id);
	$root_dir = $settings['root_dir']; //Chio
	
	$sql = 'SELECT * FROM '.TABLE_PREFIX.'mod_foldergallery_files WHERE id='.$_GET['id'].';';
	if($query = $database->query($sql)){
		$result = $query->fetchRow( );
		$bildfilename = $result['file_name'];
		$parent_id = $result['parent_id'];
		
		$query2 = $database->query('SELECT * FROM '.TABLE_PREFIX.'mod_foldergallery_categories WHERE id='.$parent_id.' LIMIT 1;');
		$categorie = $query2->fetchRow( );
		
		if ($categorie['parent'] != "-1") {
			$parent   = $categorie['parent'].'/'.$categorie['categorie'];
		}
		else $parent = '';
		
		$full_file_link = foldergallery::FG_URL.$root_dir.$parent.'/'.$bildfilename;
		$full_file = foldergallery::FG_PATH.$root_dir.$parent.'/'.$bildfilename;
		$thumb_file = foldergallery::FG_PATH.$root_dir.$parent.foldergallery::FG_THUMBDIR.'/'.$bildfilename;
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{	
			// Löscht das bisherige Thumbnail
			deleteFile($thumb_file);
			
			//Neues Thumb erstellen
			if (generateThumb($full_file, $thumb_file, $settings['thumb_size'], 1, $settings['ratio'], $_POST['x'], $_POST['y'], $_POST['w'], $_POST['h'])) {
				$admin->print_success('Thumb erfolgreich geändert', LEPTON_URL.'/modules/foldergallery/modify_cat.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id);
			}
		}
		else {
			list($width, $height, $type, $attr) = getimagesize($full_file); //str_replace um auch Datein oder Ordner mit leerzeichen bearbeiten zu können.
			
			// erstellt ein passendes Vorschaufenster zum eingestellten Verhältniss
			if ($settings['ratio'] > 1) {
				$previewWidth = $settings['thumb_size'];
				$previewHeight = $settings['thumb_size'] / $settings['ratio'];
			}
			else {
				$previewWidth = $settings['thumb_size'] * $settings['ratio'];
				$previewHeight = $settings['thumb_size'];
			}
			
			echo '
			<!-- Gives the Jcrop the variable to work -->
			<script type="text/javascript">
				var relWidth = \''.$width.'\';
				var relHeight = \''.$height.'\';
				var thumbSize = \''.$settings['thumb_size'].'\';
				var settingsRatio = \''.$settings['ratio'].'\';
				var LEPTON_URL =\''.LEPTON_URL.'\';
			</script>
			<h2>'.$MOD_FOLDERGALLERY_JQ['EDIT_THUMB'].'</h2>
			<p>'.$MOD_FOLDERGALLERY_JQ['EDIT_THUMB_DESCRIPTION'].'</p>
			<p>'.$full_file_link.'</p>
			<div style="float: left; padding: 0 20px 0 20px;">
				<img src="'.$full_file_link.'" id="cropbox" style="max-width: 500px; max-height: 500px;"/>
			</div>
			<div style="float:left;" align="center">
				<div style="overflow: hidden; width: '.$previewWidth.'px; height: '.$previewHeight.'px;">
					<img src="'.$full_file_link.'" id="preview">
				</div>
				<br />
				<!-- This is the form that our event handler fills -->
				<form action="'.LEPTON_URL.'/modules/foldergallery/modify_thumb.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id.'&id='.$_GET['id'].'" method="post" onsubmit="return checkCoords();">
					<input type="hidden" id="x" name="x" />
					<input type="hidden" id="y" name="y" />
					<input type="hidden" id="w" name="w" />
					<input type="hidden" id="h" name="h" />
					<input class="lepsem_save fg_interface_button" type="submit" value="'.$MOD_FOLDERGALLERY_JQ['EDIT_THUMB_BUTTON'].'" /><br />
					<input class="lepsem_reset fg_interface_button" type="button" value="'.$TEXT['CANCEL'].'" onClick="parent.location=\''.LEPTON_URL.'/modules/foldergallery/modify_cat.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id.$leptoken.'\'"/>
				</form>
			</div>';
		}
	}
}
else {
	$admin->print_error($MOD_FOLDERGALLERY_JQ['ERROR_MESSAGE'], LEPTON_URL.'/modules/foldergallery/modify_cat.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id);
}

$admin->print_footer();

?>