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

/**
 *	Leptoken hash
 *
 */
$leptoken = isset($_GET['leptoken'])
	? "&leptoken=".$_GET['leptoken']
	: ""
	;

$file_names = array(
    '/modules/foldergallery/backend.functions.php',
    '/include/phplib/template.inc'
);
LEPTON_handle::include_files ($file_names);

$MOD_FOLDERGALLERY = foldergallery::getInstance()->language;

$settings = getSettings($section_id);

/**
 *	Some 'shortcuts'
 */
$mod_folder_url = LEPTON_URL.'/modules/foldergallery';

// Falls noch keine Einstellungen gemacht wurden auf die Einstellungsseite umleiten
if($settings['root_dir'] == 'd41d8cd98f00b204e9800998ecf8427e') {
	?>
		<script language="javascript">
			function Weiterleitung() {
   				location.href= '<?php echo $mod_folder_url; ?>/modify_settings.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id.$leptoken; ?>';
			}
			window.setTimeout("Weiterleitung()", 2000); // in msecs 1000 => eine Sekunde
		</script>
	<?php
	echo $MOD_FOLDERGALLERY['REDIRECT'];
} else {

echo '
<div>
<script type="text/javascript">
var LEPTON_URL = "'.LEPTON_URL.'";
</script>
<div>
';

// Template
$t = new Template(dirname(__FILE__).'/templates', 'remove');
$t->halt_on_error = 'no';
$t->set_file('modify', 'modify.htt');
// clear the comment-block, if present
$t->set_block('modify', 'CommentDoc'); $t->clear_var('CommentDoc');
$t->set_block('modify', 'ListElement', 'LISTELEMENT');
$t->clear_var('ListElement'); // Löschen, da dies über untenstehende Funktion erledigt wird.

// Links im Template setzen
$t->set_var(array(
	'SETTINGS_ONCLICK'	=> 'javascript: window.location = \''.$mod_folder_url.'/modify_settings.php?page_id='.$page_id.'&amp;section_id='.$section_id.'\';',
	'SYNC_ONKLICK'		=> 'javascript: window.location = \''.$mod_folder_url.'/sync.php?page_id='.$page_id.'&amp;section_id='.$section_id.'\';',
	'HELP_ONCLICK'      => 'javascript: window.location = \''.$mod_folder_url.'/help.php?page_id='.$page_id.'&amp;section_id='.$section_id.'\';',	
	'EDIT_PAGE'			=> $page_id,
	'EDIT_SECTION'		=> $section_id,
	'LEPTON_URL'			=> LEPTON_URL
));

// Text im Template setzten
$t->set_var(array(
	'TITEL_BACKEND_STRING'	=> $MOD_FOLDERGALLERY['TITEL_BACKEND'],
	'TITEL_MODIFY'			=> $MOD_FOLDERGALLERY['TITEL_MODIFY'],
	'SETTINGS_STRING'		=> $MOD_FOLDERGALLERY['SETTINGS'],
	'FOLDER_IN_FS_STRING'	=> $MOD_FOLDERGALLERY['FOLDER_IN_FS'],
	'CAT_TITLE_STRING'		=> $MOD_FOLDERGALLERY['CAT_TITLE'],
	'ACTIONS_STRING'		=> $MOD_FOLDERGALLERY['ACTION'],
	'SYNC_STRING'			=> $MOD_FOLDERGALLERY['SYNC'],
	'EDIT_CSS_STRING'		=> $MOD_FOLDERGALLERY['EDIT_CSS'],
	'HELP_STRING'           => $MOD_FOLDERGALLERY['HELP_INFORMATION'],	
));

// Template ausgeben
$t->pparse('output', 'modify');

// Kategorien von der obersten Ebene aus DB hohlen
$sql = "SELECT * FROM ".TABLE_PREFIX."mod_foldergallery_categories WHERE section_id=".$section_id." AND niveau=0;";
$query = $database->query($sql);
while($result = $query->fetchRow( )){
	$results[] = $result;
}

if (!function_exists("display_categories")) {
function display_categories($parent_id, $section_id , $tiefe = 0) {
	
	global $database;
	global $url;
	global $page_id;
	
	$padding = $tiefe*20;
	
	$list = "\n";
	$sql = 'SELECT * FROM '.TABLE_PREFIX.'mod_foldergallery_categories WHERE parent_id='.$parent_id.' AND section_id ='.$section_id.' ORDER BY `position` ASC;';
	$query = $database->query($sql);
	$zagl = $query->numRows();
	
	$arrup = false;
	$arrdown = true;
//	if ($zagl > 1) {}
	
	$counter = 0;	
	while($result = $query->fetchRow( )){
		$counter ++;
		if ($counter > 1) {$arrup = true;}
		if ($counter == $zagl) {$arrdown = false;}
		
		if ($parent_id != "-1") $cursor = ' cursor: move;';
		else $cursor = '';

		if($result['has_child']){
			$list .= "<li id='recordsArray_".$result['id']."' style='padding: 1px 0px 1px 0px;".$cursor."'>\n"
					."<table width='720' cellpadding='0' cellspacing='0' border='0' class='cat_table'>\n"
					.'<tr onmouseover="this.style.backgroundColor = \'#F1F8DD\';" onmouseout="this.style.backgroundColor = \'#ECF3F7\';">'
					."<td width='20px' style='padding-left:".$padding."px'>\n"
					// Pluszeichen Darsellen
					.'<a href="javascript: toggle_visibility(\'p'.$result['id'].'\');" title="Erweitern/Reduzieren">'
					.'<img src="'.LEPTON_URL.'/modules/lib_lepton/backend_images/plus_16.png" onclick="toggle_plus_minus(\''.$result['id'].'\');" name="plus_minus_'.$result['id'].'" border="0" alt="+" />'
					.'</a>'
					// Pluszeichen Ende
					."</td>\n"


					// Zeile Mit allen Angaben
					."<td><a href='".$url['edit'].$result['id']."' title='Kategorie bearbeiten'>"
					.'<img src="'.LEPTON_URL.'/modules/lib_lepton/backend_images/visible_16.png" alt="edit" border="0" align="left" class="lepsem_fg" style="margin-right:5px;" />'
					.htmlentities($result['categorie'])."</a></td>"
					."<td align='left' width='415'>".htmlentities($result['cat_name'])."</td>"
					
					//Active:
					.'<td width="30"><img src="'.LEPTON_URL.'/modules/foldergallery/images/active'.$result['active'].'.gif" border="0" alt="" title="active" />&nbsp;&nbsp;</td>'
					
					
					// Aktionen Buttons
					."<td width='20'>";					
					if ($arrup == true) {$list .="<a href='".LEPTON_URL."/modules/foldergallery/move_up.php?page_id=".$page_id."&section_id=".$section_id."&id=".$result['id']."' title='Aufw&auml;rts verschieben'>"
					."<img src='".LEPTON_URL."/modules/lib_lepton/backend_images/up_16.png' border='0' alt='v' /></a>";
					}					
					$list .= "</td>"
					."<td width='20'>";
					
					if ($arrdown == true) {$list .="<a href='".LEPTON_URL."/modules/foldergallery/move_down.php?page_id=".$page_id."&section_id=".$section_id."&id=".$result['id']."' title='aAbw&auml;rts verschieben'>"
					."<img src='".LEPTON_URL."/modules/lib_lepton/backend_images/down_16.png' border='0' alt='u' />"
					."</a>";}
					
					$list .= "</td>"
					
					."<td width='20'>"
					."<a href='javascript: confirm_link(\"Sind sie sicher, dass Sie die ausgew&auml;hlte Kategorie mit allen Unterkategorien und Bilder l&ouml;schen m&ouml;chten?\", \"".LEPTON_URL."/modules/foldergallery/delete_cat.php?page_id=".$page_id."&section_id=".$section_id."&cat_id=".$result['id']."\");' >"
					."<img src='".LEPTON_URL."/modules/lib_lepton/backend_images/delete_16.png' border='0' alt='X'></a>";
					// Ende Zeile mit allen Angaben
					


					$list .= "</tr></table>\n"
					."<ul id='p".$result['id']."'style='padding: 1px 0px 1px 0px;' class='cat_subelem'>";
			$list .= display_categories($result['id'], $section_id, $tiefe+1);
			$list .= "</ul></li>\n ";
		} else {
			$list .= "<li id='recordsArray_".$result['id']."' style='padding: 1px 0px 1px 0px;".$cursor."'>\n"
					."<table width='720' cellpadding='0' cellspacing='0' border='0' class='cat_table'>\n"
					.'<tr onmouseover="this.style.backgroundColor = \'#F1F8DD\';" onmouseout="this.style.backgroundColor = \'#ECF3F7\';">'
					."<td width='20px' style='padding-left:".$padding."px'></td>\n"
					// Zeile Mit allen Angaben
					."<td><a href='".$url['edit'].$result['id']."' title='Kategorie bearbeiten'>"
					.'<img src="'.LEPTON_URL.'/modules/lib_lepton/backend_images/visible_16.png" alt="edit" border="0" align="left" class="lepsem_fg" style="margin-right:5px;" />'
					.htmlentities($result['categorie'])."</a></td>"
					."<td align='left' width='415'>".htmlentities($result['cat_name'])."</td>"
					
					//Active:
					.'<td width="30"><img src="'.LEPTON_URL.'/modules/foldergallery/images/active'.$result['active'].'.gif" border="0" alt="" title="active" />&nbsp;&nbsp;</td>'
					// Aktionen Buttons
					."<td width='20'>";					
					if ($arrup == true) {$list .="<a href='".LEPTON_URL."/modules/foldergallery/move_up.php?page_id=".$page_id."&section_id=".$section_id."&id=".$result['id']."' title='Aufw&auml;rts verschieben'>"
					."<img src='".LEPTON_URL."/modules/lib_lepton/backend_images/up_16.png' border='0' alt='v' /></a>";
					}					
					$list .= "</td>"
					."<td width='20'>";
					
					if ($arrdown == true) {$list .="<a href='".LEPTON_URL."/modules/foldergallery/move_down.php?page_id=".$page_id."&section_id=".$section_id."&id=".$result['id']."' title='Abw&auml;rts verschieben'>"
					."<img src='".LEPTON_URL."/modules/lib_lepton/backend_images/down_16.png' border='0' alt='u' />"
					."</a>";}
					
					$list .= "</td>"
					
					."<td width='20'>"
					."<a href='javascript: confirm_link(\"Sind sie sicher, dass Sie die ausgew&auml;hlte Kategorie mit allen Unterkategorien und Bilder l&ouml;schen m&ouml;chten?\", \"".LEPTON_URL."/modules/foldergallery/delete_cat.php?page_id=".$page_id."&section_id=".$section_id."&cat_id=".$result['id']."\");' >"
					."<img src='".LEPTON_URL."/modules/lib_lepton/backend_images/delete_16.png' border='0' alt='X'></a>";
					// Ende Zeile mit allen Angaben

					$list .= "</tr></table>\n";
		}
	}	
	return $list;
}
}

$url = array(
	'edit'	=> LEPTON_URL."/modules/foldergallery/modify_cat.php?page_id=".$page_id."&section_id=".$section_id."&cat_id=",
);

echo '<div><script type="text/javascript">
		var the_parent_id = "0";			
		var LEPTON_URL = "'.LEPTON_URL.'";
	</script><div>
<div style="display: block; width: 90%; height: 15px; padding: 5px;"><div id="dragableResult"> </div></div>
	<ul>
		'.display_categories(-1, $section_id).'
	</ul>
<div id="dragableCategorie">
	<ul>
		'.display_categories(0, $section_id).'
	</ul>
</div>
';

// Schluss vom else Teil ganz oben!
}
?>