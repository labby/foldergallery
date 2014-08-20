<?php
/**
 *  @module         foldergallery_jq
 *  @version        see info.php of this module
 *  @author         J&uuml;rg Rast; schliffer; Bianka Martinovic; Chio; Pumpi,Aldus; erpe
 *  @copyright      2004-2014 J&uuml;rg Rast; schliffer; Bianka Martinovic; Chio; Pumpi,Aldus; erpe 
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

require(WB_PATH.'/modules/admin.php');

// check if module language file exists for the language set by the user (e.g. DE, EN)
if(!file_exists(WB_PATH .'/modules/foldergallery_jq/languages/'.LANGUAGE .'.php')) {
// no module language file exists for the language set by the user, include default module language file DE.php
require_once(WB_PATH .'/modules/foldergallery_jq/languages/DE.php');
} else {
// a module language file exists for the language defined by the user, load it
require_once(WB_PATH .'/modules/foldergallery_jq/languages/'.LANGUAGE .'.php');
}

// Files includen
require_once (WB_PATH.'/modules/foldergallery_jq/info.php');
require_once (WB_PATH.'/modules/foldergallery_jq/scripts/backend.functions.php');

//get the CSS
echo '<link rel="stylesheet" type="text/css" href="'.WB_URL.'/modules/foldergallery_jq/scripts/jcrob/css/jquery.Jcrop.css" /> ';

$cat_id = $_GET['cat_id'];

if(isset($_GET['id']) && is_numeric($_GET['id'])) {
	/**
	 *	Get leptoken hash
	 */
	$leptoken = (isset($_GET['leptoken'])) ? "&leptoken=".$_GET['leptoken'] : "";
	
	$settings = getSettings($section_id);
	$root_dir = $settings['root_dir']; //Chio
	
	$sql = 'SELECT * FROM '.TABLE_PREFIX.'mod_foldergallery_jq_files WHERE id='.$_GET['id'].';';
	if($query = $database->query($sql)){
		$result = $query->fetchRow();
		$bildfilename = $result['file_name'];
		$parent_id = $result['parent_id'];
		
		
			$query2 = $database->query('SELECT * FROM '.TABLE_PREFIX.'mod_foldergallery_jq_categories WHERE id='.$parent_id.' LIMIT 1;');
			$categorie = $query2->fetchRow();
		if ($categorie['parent'] != "-1") {
			$parent   = $categorie['parent'].'/'.$categorie['categorie'];
		}
		else $parent = '';
		
		$full_file_link = $url.$root_dir.$parent.'/'.$bildfilename;
		$full_file = $path.$root_dir.$parent.'/'.$bildfilename;
		$thumb_file = $path.$root_dir.$parent.$thumbdir.'/'.$bildfilename;
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{	
			//Löscht das bisherige Thumbnail
			deleteFile($thumb_file);
			
			//Neues Thumb erstellen
			if (generateThumb($full_file, $thumb_file, $settings['thumb_size'], 1, $settings['ratio'], $_POST['x'], $_POST['y'], $_POST['w'], $_POST['h'])) {
				$admin->print_success('Thumb erfolgreich geändert', WB_URL.'/modules/foldergallery_jq/modify_cat.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id);
			}
		}
		else {
			list($width, $height, $type, $attr) = getimagesize($full_file); //str_replace um auch Datein oder Ordner mit leerzeichen bearbeiten zu können.
			
			//erstellt ein passendes Vorschaufenster zum eingestellten Verhältniss
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
				var WB_URL =\''.WB_URL.'\';
			</script>
<!-- Aldus begin -->
<script src="'.WB_URL.'/modules/foldergallery_jq/scripts/jquery/jquery-insert.js" type="text/javascript"></script>
<script src="'.WB_URL.'/modules/foldergallery_jq/scripts/jquery/jquery-include.js" type="text/javascript"></script>
<!--[if lt IE 7]><script type="text/javascript" src="'.WB_URL.'/modules/foldergallery_jq/scripts/jqery/jquery-pngFix.js"></script><![endif]-->
<script src="'.WB_URL.'/modules/foldergallery_jq/scripts/jquery/jquery-plugins.js" type="text/javascript"></script>
<!-- Aldus end -->
			<h2>'.$MOD_FOLDERGALLERY['EDIT_THUMB'].'</h2>
			<p>'.$MOD_FOLDERGALLERY['EDIT_THUMB_DESCRIPTION'].'</p>
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
				<form action="'.WB_URL.'/modules/foldergallery_jq/modify_thumb.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id.'&id='.$_GET['id'].'" method="post" onsubmit="return checkCoords();">
					<input type="hidden" id="x" name="x" />
					<input type="hidden" id="y" name="y" />
					<input type="hidden" id="w" name="w" />
					<input type="hidden" id="h" name="h" />
					<input style="width: 130px;" type="submit" value="'.$MOD_FOLDERGALLERY['EDIT_THUMB_BUTTON'].'" /><br />
					<input style="width: 130px;" type="button" value="'.$TEXT['CANCEL'].'" onClick="parent.location=\''.WB_URL.'/modules/foldergallery_jq/modify_cat.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id.$leptoken.'\'"/>
				</form>
			</div>';
		}
	}
}
else {
	$admin->print_error($MOD_FOLDERGALLERY['ERROR_MESSAGE'], WB_URL.'/modules/foldergallery_jq/modify_cat.php?page_id='.$page_id.'&section_id='.$section_id.'&cat_id='.$cat_id);
}

$admin->print_footer();

?>
