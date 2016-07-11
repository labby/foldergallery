<?php

/**
 *  @module         foldergallery_jq
 *  @version        see info.php of this module
 *  @author         Jürg Rast; schliffer; Bianka Martinovic; Chio; Pumpi,Aldus; erpe
 *  @copyright      2009-2016 Jürg Rast; schliffer; Bianka Martinovic; Chio; Pumpi,Aldus; erpe 
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

// Admin Backend erstellen

require(LEPTON_PATH.'/modules/admin.php');
	
// check if backend.css file needs to be included into <body></body>
if(!method_exists($admin, 'register_backend_modfiles') && file_exists(LEPTON_PATH ."/modules/foldergallery_jq/backend.css")) {
	echo '<style type="text/css">';
	include(LEPTON_PATH .'/modules/foldergallery_jq/backend.css');
	echo "\n</style>\n";
}
// check if backend.js file needs to be included into <body></body>
if(!method_exists($admin, 'register_backend_modfiles') && file_exists(LEPTON_PATH ."/modules/foldergallery_jq/backend.js")) {
	echo '<script type="text/javascript">';
	include(LEPTON_PATH .'/modules/foldergallery_jq/backend.js');
	echo "</script>";
}

// check if module language file exists for the language set by the user (e.g. DE, EN)
$lang_file = LEPTON_PATH .'/modules/foldergallery_jq/languages/'.LANGUAGE .'.php';
require_once( file_exists($lang_file) ? $lang_file : LEPTON_PATH .'/modules/foldergallery_jq/languages/EN.php' );

// Files includen
require_once (LEPTON_PATH.'/modules/foldergallery_jq/info.php');
require_once (LEPTON_PATH.'/modules/foldergallery_jq/backend.functions.php');

// --- jQueryAdmin / LibraryAdmin Integration; last edited 27.01.2011 ---
$jqa_lightboxes = array();
if ( file_exists( LEPTON_PATH.'/modules/libraryadmin/foldergallery_include.php' ) ) {
    include_once LEPTON_PATH.'/modules/libraryadmin/foldergallery_include.php';
    $jqa_lightboxes = get_lightboxes();
}
elseif ( file_exists( LEPTON_PATH.'/modules/jqueryadmin/foldergallery_include.php' ) ) {
    include_once LEPTON_PATH.'/modules/jqueryadmin/foldergallery_include.php';
    $jqa_lightboxes = get_lightboxes();
}
// --- end jQueryAdmin / LibraryAdmin Integration ---

// Einstellungen zur aktuellen Foldergallery aus der DB
$settings = getSettings($section_id);

// Template
$t = new Template(dirname(__FILE__).'/templates', 'remove');
$t->halt_on_error = 'no';
$t->set_file('modify_settings', 'modify_settings.htt');
// clear the comment-block, if present
$t->set_block('modify_settings', 'CommentDoc'); $t->clear_var('CommentDoc');

$t->set_block('modify_settings', 'ordner_select', 'ORDNER_SELECT');

$t->set_block('modify_settings', 'ratio_select', 'RATIO_SELECT');

// find lightbox files in template folder
$lightbox_select = '<select name="lightbox" id="lightbox">';
if ( $dh = opendir(dirname(__FILE__).'/templates') ) {
    while ( ($file = readdir($dh)) !== false ) {
        if ( preg_match( "/^view_(\w+).htt$/", $file, $matches ) ) {
            $lightbox_select .= '<option value="'
                             .  $matches[1] .'"';
            if ( $matches[1] == $settings['lightbox'] ) {
                $lightbox_select .= ' selected="selected"';
            }
            $lightbox_select .= '>'
                             .  $matches[1]
                             .  '</option>';
        }
    }
    closedir($dh);
}

// ----- jQueryAdmin / LibraryAdmin Integration; last edited 27.01.2011 -----
if ( count( $jqa_lightboxes ) > 0 ) {
    foreach ( $jqa_lightboxes as $i => $lb ) {
        if ( is_array( $lb ) ) {
            foreach( $lb as $item ) {
                $lightbox_select .= '<option value="'.$i.'/plugins/'.$item.'"';
                if ( $i.'/plugins/'.$item == $settings['lightbox'] ) {
                    $lightbox_select .= ' selected="selected"';
                }
                $lightbox_select .= '> ' . $i . ': '
                                 .  $item
                                 .  '</option>';
            }
        }
        else {
            $lightbox_select .= '<option value="'.$lb.'"';
            if ( $lb == $settings['lightbox'] ) {
                $lightbox_select .= ' selected="selected"';
            }
            $lightbox_select .= '> jQueryAdmin: '
                             .  $lb
                             .  '</option>';
        }
    }
}
// ----- end jQueryAdmin / LibraryAdmin Integration -----

$lightbox_select .= '</select>';

$catpicselect = '<select name="catpic">';
$catpicselect .= '<option value="0"'; if ($settings['catpic'] == 0) {$catpicselect .= ' selected="selected"';} $catpicselect .= '>Random</option>';
$catpicselect .= '<option value="1"'; if ($settings['catpic'] == 1) {$catpicselect .= ' selected="selected"';} $catpicselect .= '>First</option>';
$catpicselect .= '<option value="2"'; if ($settings['catpic'] == 2) {$catpicselect .= ' selected="selected"';} $catpicselect .= '>Last</option>';
$catpicselect .= '</select>';

// Text einsetzten
$t->set_var(array(
	'SETTINGS_STRING'		=> $MOD_FOLDERGALLERY_JQ['SETTINGS'],
	'ROOT_FOLDER_STRING' 	=> $MOD_FOLDERGALLERY_JQ['ROOT_DIR'],
	'EXTENSIONS_STRING'		=> $MOD_FOLDERGALLERY_JQ['EXTENSIONS'],
	'EXTENSIONS_VALUE'		=> $settings['extensions'],
	'INVISIBLE_STRING'		=> $MOD_FOLDERGALLERY_JQ['INVISIBLE'],
	'INVISIBLE_VALUE'		=> $settings['invisible'],
	'SAVE_STRING' 			=> $TEXT['SAVE'],
	'CANCEL_STRING' 		=> $TEXT['CANCEL'],
	'PICS_PP_STRING'    		=> $MOD_FOLDERGALLERY_JQ['PICS_PP'],
	'PICS_PP_VALUE'    		=> $settings['pics_pp'],
	'THUMBSIZE'    			=> $settings['thumb_size'],
	'THUMB_SIZE_STRING'   		=> $MOD_FOLDERGALLERY_JQ['THUMB_SIZE'],
	'THUMB_RATIO_STRING'    	=> $MOD_FOLDERGALLERY_JQ['THUMB_RATIO'],
	'THUMB_NOT_NEW_STRING'    	=> $MOD_FOLDERGALLERY_JQ['THUMB_NOT_NEW'],
	'CHANGING_INFO_STRING'    	=> $MOD_FOLDERGALLERY_JQ['CHANGING_INFO'],
	'LIGHTBOX_STRING' 		=> $MOD_FOLDERGALLERY_JQ['LIGHTBOX'],
	'LIGHTBOX_VALUE' 		=> $lightbox_select,
	'CATPIC_VALUE' 			=> $catpicselect,
));

// Links einsetzen
$t->set_var(array(
	'CANCEL_ONCLICK' 		=> 'javascript: window.location = \''.ADMIN_URL.'/pages/modify.php?page_id='.$page_id.'\';',
	'MODIFY_SETTINGS_LINK'	=> LEPTON_URL.'/modules/foldergallery_jq/save_settings.php?page_id='.$page_id.'&section_id='.$section_id
));

//Tooltips einsetzen
$t->set_var(array(
	'ROOT_FOLDER_STRING_TT' => $MOD_FOLDERGALLERY_JQ['ROOT_FOLDER_STRING_TT'],
	'EXTENSIONS_STRING_TT'	=> $MOD_FOLDERGALLERY_JQ['EXTENSIONS_STRING_TT'],
	'INVISIBLE_STRING_TT'	=> $MOD_FOLDERGALLERY_JQ['INVISIBLE_STRING_TT'],
));

if ( ! empty( $settings['invisible'] ) ) {
    $invisibleFileNames = array_merge( $invisibleFileNames, explode( ',', $settings['invisible'] ) );
}

// WB Systemordner sollen nicht angezeigt werden
$invisibleFileNames = array_merge($invisibleFileNames, $wbCoreFolders);

// Ordnerauswahl für den Root Folder erstellen
$ordnerliste = getFolderData($path, array(), $invisibleFileNames, 2);

foreach($ordnerliste as $ordner) {
	$t->set_var('ORDNER', $ordner);
	if($ordner != $settings['root_dir']) {
		$t->set_var('SELECTED','');
	} else {
		$t->set_var('SELECTED','selected="selected"');
	}
	$t->parse('ORDNER_SELECT', 'ordner_select', true);
}

//Ratio Auswahlliste
$ratioArray = array($MOD_FOLDERGALLERY_JQ['Ration_square'] => 1, "4:3" => round(4/3, 4), "3:4" => round(3/4, 4), "16:9" => round(16/9, 4), "9:16" => round(9/16, 4));
foreach($ratioArray as $ratio => $value) {
	$t->set_var(array(
			'RATIO'		=> $ratio,
			'RATIO_VALUE'	=> $value
			));
	if($value == $settings['ratio']) {
		$t->set_var('SELECTED','selected="selected"');
	} else {
		$t->set_var('SELECTED','');
	}
	$t->parse('RATIO_SELECT', 'ratio_select', true);
}

$t->pparse('Output', 'modify_settings');

$admin->print_footer();
?>