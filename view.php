<?php

/**
 *  @module         foldergallery_jq
 *  @version        see info.php of this module
 *  @author         Jürg Rast; schliffer; Bianka Martinovic; Chio; Pumpi,Aldus; erpe
 *  @copyright      2009-2014 Jürg Rast; schliffer; Bianka Martinovic; Chio; Pumpi,Aldus; erpe 
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
    IMPORTANT!
    
    You will have to install Highslide or NyroModal by yourself! They are NOT
    included with Foldergallery!
    
    If you don't put them into your modules-Subfolder, you will also have to
    modify the paths in the include-Files.
    
    templates/include_highslide.htt - for Highslide
    templates/include_nyromodal.htt - for NyroModal
    
    To include other presentation JavaScript, create a include_XX.htt which
    contains all that has to be done for inclusion. Then, add a case-statement
    below to include this file and set the $gallary variable to the case you
    wish to be used.
*/

// check if module language file exists for the language set by the user (e.g. DE, EN)
$lang_file = dirname(__FILE__)."/languages/".LANGUAGE .".php";
require_once( file_exists($lang_file) ? $lang_file : dirname(__FILE__)."/languages/EN.php" ); 

// check if frontend.css file needs to be included into the <body></body> of view.php
if((!function_exists('register_frontend_modfiles') || !defined('MOD_FRONTEND_CSS_REGISTERED')) && 
	file_exists(LEPTON_PATH .'/modules/foldergallery_jq/frontend.css')) {
	echo '<style type="text/css">';
		include(LEPTON_PATH .'/modules/foldergallery_jq/frontend.css');
	echo "\n</style>\n";
} 
// check if frontend.js file needs to be included into the <body></body> of view.php
if((!function_exists('register_frontend_modfiles') || !defined('MOD_FRONTEND_JAVASCRIPT_REGISTERED')) && 
	file_exists(LEPTON_PATH .'/modules/foldergallery_jq/frontend.js')) {
	echo '<script type="text/javascript" src="'.LEPTON_URL.'/modules/foldergallery_jq/frontend.js"></script>';
} 

$generatethumbscounter = 0;
// Files includen
require_once (LEPTON_PATH.'/modules/foldergallery_jq/info.php');
require_once (LEPTON_PATH.'/modules/foldergallery_jq/functions.php');

// Foldergallery Einstellungen
$settings = getSettings($section_id);
$thumb_size = $settings['thumb_size']; //Chio
$root_dir = $settings['root_dir']; //Chio
$catpic = (int) $settings['catpic']; //Chio
$ratio = $settings['ratio']; //Pumpi

// Einstellungen
// Link zur Seite
$query_pages = $database->query("SELECT link FROM ".TABLE_PREFIX."pages WHERE page_id = '$page_id' LIMIT 1");
$page = $query_pages->fetchRow();
$link = LEPTON_URL.PAGES_DIRECTORY.$page['link'].PAGE_EXTENSION;

$ergebnisse = array(); // Da drin werden dann alle Ergebnisse aus der DB gespeichert
$unterKats = array(); // Hier rein kommen die Unterkategorien der aktuellen Kategorie
$bilder = array(); // hier kommen alle Bilder der aktuellen Kategorie rein
$error = false;
$title = PAGE_TITLE;

/** 
 *	load current jQuery
 */
echo "
<script src=\"". LEPTON_URL. "/modules/lib_jquery/jquery-core/jquery-core.min.js\" type=\"text/javascript\"></script>
<script src=\"". LEPTON_URL. "/modules/lib_jquery/jquery-core/jquery-migrate.min.js\" type=\"text/javascript\"></script>
";

// Wo sind wir?
$aktuelleKat = (isset($_GET['cat']) && is_string($_GET['cat'])) ?
				$_GET['cat'] : '';
$aktuelleKat = htmlspecialchars($aktuelleKat);

// Die id der aktuellen Kategorie herausfinden:
$aktuelleKat_id = 0;
$sql = 'SELECT * FROM '.TABLE_PREFIX.'mod_foldergallery_jq_categories WHERE section_id='.$section_id.' AND is_empty=0 AND active=1 ORDER BY position DESC';
$query = $database->query($sql);
while($ergebnis = $query->fetchRow( MYSQL_ASSOC )){
	$p = $ergebnis['parent'].'/'.$ergebnis['categorie'] ;
	if ($ergebnis['parent'] == '-1') {$p = '';}
	if ($p == $aktuelleKat) {
		$aktuelleKat_id = $ergebnis['id'];
		break;	
	}
}

//	Falls nichts angezeigt wird, wird die Root Kategorie angezeigt
if(!$aktuelleKat){
	$sql = 'SELECT * FROM '.TABLE_PREFIX.'mod_foldergallery_jq_categories WHERE section_id='.$section_id.' AND parent="" AND is_empty=0 AND active=1 ORDER BY position ASC';
} else {
	$where = 'WHERE section_id='.$section_id.' AND parent="'.$aktuelleKat.'" AND is_empty=0 AND active=1'; 
	$sql = 'SELECT * FROM '.TABLE_PREFIX.'mod_foldergallery_jq_categories '.$where.' ORDER BY position DESC';
}

// OK, Angaben aus DB holen
$query = $database->query($sql);
while($ergebnis = $query->fetchRow()){
	// Es gibt also folgende Kategorien mit Inhalt in dieser Kategorie
	$ergebnisse[] = $ergebnis;	
}

if(count($ergebnisse) == 0) {
	$error = true;
} else {
	// Dann können wir nun die Angaben für die Kategorien erstellen
	$catpicstring = 'RAND()';
	if ($catpic == 1)  $catpicstring = 'position';
	if ($catpic == 2)  $catpicstring = 'position DESC';
	
	for($i = 0; $i <= count($ergebnisse)-1; $i++){
		$cat = $ergebnisse[$i]['parent'].'/'.$ergebnisse[$i]['categorie'];
		$unterKats[$i]['link'] = $link.'?cat='.$cat;
		$unterKats[$i]['name'] = $ergebnisse[$i]['cat_name'];
		$parent_id = $ergebnisse[$i]['id'];
		
		$folder = $root_dir.$cat;
		$pathToFolder = $path.$folder.'/';
		
		$bildfilename = 'folderpreview.jpg';
		
		if(!is_file($pathToFolder.$bildfilename )){		
			// Vorschaubild suchen
			$sql = 'SELECT file_name, id, parent_id  FROM '.TABLE_PREFIX.'mod_foldergallery_jq_files WHERE parent_id = '.$parent_id.' ORDER BY '.$catpicstring.' LIMIT 1;';						
			$query = $database->query($sql);			
			if ($query->numRows() < 1) {					
				$sql = 'SELECT file_name, id, parent_id  FROM '.TABLE_PREFIX.'mod_foldergallery_jq_files WHERE parent_id IN ('.$parent_id.$ergebnisse[$i]['childs'].') ORDER BY '.$catpicstring.' LIMIT 1;';						
				$query = $database->query($sql);
			}
			$bildLinks = $query->fetchRow();
			$bildfilename = $bildLinks['file_name'];
			
			//Falls es childs gab, k?nnte das Bild auch aus einem anderen Verzeichnis sein:
			if ($bildLinks['parent_id'] != $parent_id ) {			
				$sql = 'SELECT parent, categorie, active FROM '.TABLE_PREFIX.'mod_foldergallery_jq_categories WHERE id = "'.$bildLinks['parent_id'].'";';
				$query = $database->query($sql);
				$ergebnisseneu = $query->fetchRow();
				$catneu = $ergebnisseneu['parent'].'/'.$ergebnisseneu['categorie'];
				$folder = $root_dir.$catneu;
				
				if ($ergebnisseneu['active'] == 0) {$bildfilename = '';}

			}
		}
		
		$pathToFolder = $path.$folder.'/';
		$pathToThumb = $path.$folder.$thumbdir.'/';
		$urlToFolder = $url.$folder.'/';		
		$urlToThumb = $url.$folder.$thumbdir.'/';
		
		$unterKats[$i]['thumb'] = $urlToThumb.$bildfilename;     //LEPTON_URL.$bildLinks['thumb_link'];
		// Eventuell wird die Gallerie zum ersten mal betrachtet
		// Es gibt also noch kein Thumb. Also prüfen und erstellen
		
		
		if ($bildfilename == '') { // Leer oder ein Ordner
		 	$unterKats[$i]['thumb'] = LEPTON_URL.'/modules/foldergallery_jq/images/folder.jpg';
		 } else {
			$thumb = $pathToThumb.$bildfilename;
			if(!is_file($thumb)){
				$file = $pathToFolder.$bildfilename;				
				$terg = generateThumb($file, $thumb, $thumb_size, 0, $ratio);
				if ($terg < 0) $unterKats[$i]['thumb'] = LEPTON_URL.'/modules/foldergallery_jq/images/broken'.$terg.'.jpg';
			}
		}
		// Chio ENDE
	}
}

// Gibt es Bilder in dieser Kategorie
$sql = 'SELECT * FROM '.TABLE_PREFIX.'mod_foldergallery_jq_files WHERE parent_id="'.$aktuelleKat_id.'" ORDER BY position ASC;';
$query = $database->query($sql);
while($bild = $query->fetchRow()){
	if ($bild['file_name'] == 'folderpreview.jpg') continue;
	$bilder[]= $bild;
}

//echo '<h1>'.$aktuelleKat_id.'</h1>';
if(count($bilder) != 0) {
	
	$error = false;
	$temp = explode('/', $aktuelleKat);
	$bildkat = array_pop($temp);
	$bildparent = implode('/', $temp);
	$sql = 'SELECT * FROM '.TABLE_PREFIX.'mod_foldergallery_jq_categories  WHERE section_id='.$section_id.' AND categorie="'.$bildkat.'" AND parent="'.$bildparent.'" LIMIT 1;';
	$query = $database->query($sql);
	$result = $query->fetchRow();
	$titel = $result['cat_name'];
	$description = $result['description'];
	
	if(!empty($result['categorie'])) $folder = $root_dir.$result['parent'].'/'.$result['categorie'].'/';
	else $folder = $root_dir.$result['parent'].'/';
	$pathToFolder = $path.$folder.'/';	
	$pathToThumb = $path.$folder.$thumbdir.'/';
	
	$urlToFolder = $url.$folder;		
	$urlToThumb = $url.$folder.$thumbdir.'/';
	
}

// Zurück Link
if($aktuelleKat){
	$temp = explode('/', $aktuelleKat);
	array_pop($temp);
	$parent = implode('/',$temp);
	$back_link = $link.'?cat='.$parent;
	$hidden = '';
} else {
	$hidden = 'style="display:none"';
	$back_link = '#';
}

//initialize phplib template engine (needed for LEPTON_2series)
if (!class_exists("Template")) require_once(LEPTON_PATH."/include/phplib/template.inc");

// Template
if (file_exists(dirname(__FILE__).'/templates/view_'.$settings['lightbox'].'.htt')) {
	$viewTemplate = 'view_'.$settings['lightbox'].'.htt';
// --- added by WebBird, 29.07.2010 ---
	$t = new Template(dirname(__FILE__).'/templates', 'remove');
// --- end added by WebBird, 29.07.2010 ---
}
// ----- jQueryAdmin / LibraryAdmin Integration; last edited 27.01.2011 -----
elseif( file_exists( LEPTON_PATH.'/modules/'.$settings['lightbox'].'/foldergallery_template.htt' ) )
{
  $viewTemplate = 'foldergallery_template.htt';
	$t = new Template(LEPTON_PATH.'/modules/'.$settings['lightbox'], 'remove');
	$parts = split( '/', $settings['lightbox'] );
	echo "[[LibInclude?lib=".$parts[0]."&amp;plugin=".$parts[2]."]]";
}
elseif( file_exists( LEPTON_PATH.'/modules/jqueryadmin/plugins/'.$settings['lightbox'].'/foldergallery_template.htt' ) )
{
  $viewTemplate = 'foldergallery_template.htt';
	$t = new Template(LEPTON_PATH.'/modules/jqueryadmin/plugins/'.$settings['lightbox'], 'remove');
	echo "[[jQueryInclude?plugin=".$settings['lightbox']."]]";
}
// --- end added by WebBird, 29.07.2010 ---
else {
	$viewTemplate = 'view.htt';
// --- added by WebBird, 29.07.2010 ---
	$t = new Template(dirname(__FILE__).'/templates', 'remove');
// --- end added by WebBird, 29.07.2010 ---
}

// --- commented by WebBird, 29.07.2010 ---
//$t = new Template(dirname(__FILE__).'/templates', 'remove');
$t->halt_on_error = 'no';
$t->set_file('view', $viewTemplate);
$t->set_block('view', 'CommentDoc'); $t->clear_var('CommentDoc');
$t->set_block('view', 'categories', 'CATEGORIES');
$t->set_block('categories', 'show_categories', 'SHOW_CATEGORIES');
$t->set_block('view', 'images', 'IMAGES');
$t->set_block('images', 'thumbnails', 'THUMBNAILS');
$t->set_block('view', 'hr', 'HR');
$t->set_block('view', 'error', 'ERROR');  // Dieser Fehler wird nicht ausgegeben, BUG
$t->set_block('view', 'pagenav', 'PAGE_NAV' );

if($error) {
	$t->set_var('FRONT_END_ERROR_STRING', $MOD_FOLDERGALLERY_JQ['FRONT_END_ERROR']);
	$t->parse('ERROR', 'error');
} else {
	$t->clear_var('error');
}

$t->set_var(array(
	'VIEW_TITLE'	=> $title,
	'BACK_LINK'		=> $back_link,
	'BACK_STRING'	=> $MOD_FOLDERGALLERY_JQ['BACK_STRING'],
	'HIDDEN'		  => $hidden,
	'THUMB_SIZE'  => $settings['thumb_size'],
));

// Kategorien anzeigen
if($unterKats){
	//$t->set_var('CATEGORIES_TITLE', $MOD_FOLDERGALLERY_JQ['CATEGORIES_TITLE']);
	foreach($unterKats as $kat) {
		$t->set_var(array(
			'CAT_LINK'	=> $kat['link'],
			'THUMB_LINK'	=> $kat['thumb'].'?t='.time(),
			'CAT_CAPTION'	=> $kat['name']
		));		
		$t->parse('SHOW_CATEGORIES', 'show_categories', true);
	}
	$t->parse('CATEGORIES', 'categories',true);
} else {
	// Falls keine Kategorien vorhanden sind kann der Block gel�scht werden
	$t->clear_var('show_categories');
	$t->clear_var('categories');
}
// Fertig Kategorien angezeigt

// Bilder anzeigen
if($bilder){

	/*$folder = $root_dir.$result['parent'].'/'.$result['categorie'];
	$pathToFolder = $path.$folder;	
	$pathToThumb = $pathToFolder.$thumbdir.'/thumb.';
*/
  //figure out how many pages are needed to display all the thumbs
  if ( count( $bilder ) > $settings['pics_pp'] ) {
    $pages = ceil( count( $bilder ) / $settings['pics_pp'] );
  }
  
  $current_page = ( isset( $_GET['p'] ) && is_numeric( $_GET['p'] ) )
                ? $_GET['p']
                : 1;

	$t->set_var('CAT_TITLE', $titel);
	$t->set_var('CAT_DESCRIPTION', $description);

	if ( is_numeric( $pages ) ) {
	      	$pages_navi = '<ul class="fg_pages_nav">';
	    	for ( $i = 1; $i <= $pages; $i++ ) {
	    		//erzeugt nur ein ?cat wenn auch $aktuelleKat nicht leer ist verhindert notice Warunung
	    		if (empty ($aktuelleKat)) $pages_navi .= "<li><a href=\"$link?p=$i\"";
	    		else $pages_navi .= "<li><a href=\"$link?cat=$aktuelleKat&p=$i\"";
	    		
			if ( isset( $_GET['p'] ) && $_GET['p'] == $i ) {
				$pages_navi .= ' class="current"';
		  	}
		  	$pages_navi .= ">$i</a></li>";
	    	}
	    	$pages_navi .= '</ul>';
	    	$t->set_var(
		  array(
		      'PAGE_NAV' => $pages_navi,
		      'PAGE'     => $MOD_FOLDERGALLERY_JQ['PAGE']
		)
      		);
      		$t->parse('PAGE_NAV', 'pagenav' );
  	}
  	else $t->clear_var('pagenav');
  
  	$offset = ( $settings['pics_pp'] * $current_page - $settings['pics_pp'] );

	for($i = $offset; $i < ( $offset + $settings['pics_pp'] ); $i++) {
 

	    	if ( $i >= count( $bilder ) ) { break; }
	
		$bildfilename = $bilder[$i]['file_name'];	
	 	$thumb = $pathToThumb.$bildfilename;
		$tumburl = $urlToThumb.$bildfilename;
		$file = $pathToFolder.$bildfilename;
		if(!is_file($file)){
			//echo '<h1>|'.$bildfilename.'|</h1>';
			$deletesql = 'DELETE FROM '.TABLE_PREFIX.'mod_foldergallery_jq_files WHERE id='.$bilder[$i]['id'];
			$database->query($deletesql);
			continue;
		}	
		if(!is_file($thumb)){			
			$file = $pathToFolder.$bildfilename;
			$terg = generateThumb($file, $thumb, $thumb_size, 0, $ratio);
			if ($terg < 0) $tumburl = LEPTON_URL.'/modules/foldergallery_jq/images/broken'.$terg.'.jpg';
		}

		if ($settings['lightbox'] != 'contentFlow') $timeadd = '?t='.time();
		else $timeadd = '';
		
		$t->set_var(array(
			'ORIGINAL'	=> $urlToFolder.$bildfilename.$timeadd,
			'THUMB'		=> $tumburl.'?t='.time(),
			'CAPTION'	=> $bilder[$i]['caption']
		));
		$t->parse('THUMBNAILS','thumbnails',true);
	}
	$t->parse('IMAGES','images',true);
} else {
$t->clear_var('thumbnails');
$t->clear_var('images');
}

if($bilder && $unterKats){
	$t->parse('HR', 'hr', true);
} else {
	$t->clear_var('hr');
}

// get current cat path
if ( isset( $_GET['cat'] ) ) {
    $path  = explode( '/', $_GET['cat'] );
    $bread = '<ul class="fg_pages_nav">'
           . '<li><a href="'
           . $link
           . '">'
           . $MOD_FOLDERGALLERY_JQ['BACK_STRING']
           . '</a></li>';

    // first element is empty as the string begins with /
    array_shift($path);
    foreach ( $path as $i => $cat_name ) {
        $catres = $database->query("SELECT cat_name FROM ".TABLE_PREFIX."mod_foldergallery_jq_categories WHERE categorie = '$cat_name' LIMIT 1");
        $cat    = $catres->fetchRow();
        $bread .= '<li> <a href="'
               .  $link
               .  '?cat=/'.implode('/', array_slice( $path, 0, ($i+1) ) )
               .  '">'.$cat['cat_name'].'</a></li>';
    }

    $bread .= '</ul><br /><br />';
    $t->set_var( 'CATBREAD', $bread );
    $t->set_var('CATEGORIES_TITLE', $cat['cat_name']);

}

$t->set_var( 'LEPTON_URL', LEPTON_URL );

//überschreibt die fest eingestellte Größe von ul.categories li a auf die Thumbgrößenwerte
$catWidth = $settings['thumb_size'] + 10;
if ($settings['ratio'] > 1) {
	if ($settings['thumb_size']  >= 150) $catHeight = $settings['thumb_size'] + 10;
	else $catHeight = $settings['thumb_size']/$settings['ratio'] + 50 ;
}
else {
	if ($settings['thumb_size']  >= 150) $catHeight = $settings['thumb_size'] + 10;
	else $catHeight = $settings['thumb_size'] + 50 ;
}

echo '<style type="text/css">
ul.categories li a {
	width: '.$catWidth.'px;
	height: '.$catHeight.'px;
}
</style>';

ob_start();
$t->pparse('output','js');
$t->set_file('view', $viewTemplate);
$t->set_var( 'INCLUDE_PRESENTATION_JS', ob_get_clean());
$t->pparse('output', 'view');


?>