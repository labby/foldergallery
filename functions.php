<?PHP

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

/**
 *	Getting the foldergallery-settings from the DB for a given section(-id).
 *
 *	@param	int		A valid section-id. Pass by reference.
 *	@return	array	Assoc. array within the settings.
 *
 */
function getSettings( &$section_id ){
	global $database;
	$sql = 'SELECT * FROM `'.TABLE_PREFIX.'mod_foldergallery_settings` WHERE `section_id` = '.$section_id;
	$result = array();
	$database->execute_query( $sql, true, $result, false);
	return $result;
}

/**
 *  Generiert ein Thumbnail $thumb aus $file, falls dieses noch nicht vorhanden ist. 
 *
 *  @param string $file  Pfadangabe zum original File
 *  @param string $thumb Pfadangabe zum Thumbfile
 *  @param integer $thumb_size
 *  @param integer $showmessage
 *  *********************************************
 *  Anpassung für individuelle Thumb erstellung
 *  @param string $ratio Seitenverhältniss der Thumbs
 *  @param string $positionX Position X von jCrop ansonsten 0
 *  @param string $positionY Position Y von jCrop ansonsten 0
 *  @param string $positionW Position W von jCrop ansonsten 0
 *  @param string $positionH Position H von jCrop ansonsten 0
 *
 *  @return void or true
 *
 */
function generateThumb($file, $thumb, $thumb_size, $showmessage=1, $ratio, $positionX = 0, $positionY = 0, $positionW = 0, $positionH = 0 ){

	//Von Chio eingefügt:
	global $megapixel_limit;
	if ($megapixel_limit < 2)
	{
	    $megapixel_limit = foldergallery::FG_MEGAPIXEL_LIMIT;
	}
	
	static $thumbscounter, $thumbsstarttime, $allthumbssizes;
	if (!$thumbscounter) {$thumbscounter = 0;}
	if (!$thumbsstarttime) {$thumbsstarttime = time();}
	if (!$allthumbssizes) {$allthumbssizes = 0;}
	
	if(!is_file($file)) { if ($showmessage == 1) {echo '<b>Missing file:</b> '.$file.'<br/>'; return -1;} }
	
	$thumbscounter++;
	if ($thumbscounter == 80 AND $showmessage == 1) echo('<h3>stopped.. press F5 to reload</h3>');
	if ($thumbscounter > 80) return -1;
	
	$tgone = time() - $thumbsstarttime;	
	if (time() - $thumbsstarttime > 50) die('<h3>timeout.. press F5 to reload</h3>');
	
	//if ($showmessage==1) {echo "<br/>creating thumb: ".$file;}
	// ENDE Chio
	
	
	// Einige Variablen
	$jpg = '\.jpg$|\.jpeg$';
	$gif = '\.gif$';
	$png = '\.png$';
	//$thumb_size = 140;
	$fontSize = 2;
	$bg = "D1F6FF"; // [3] fixed background?!
	
	$thumbFolder = dirname($thumb);	

	//Verzeichnis erstellen, falls noch nicht vorhanden
	if(!is_dir($thumbFolder)){
		$u = umask(0);
		if(!mkdir($thumbFolder, 0755)){
			echo '<p style="color: red; text-align: center;">Fehler beim Verzeichniss erstellen</p>';
		}
		umask($u);
	}
	
	// Thumb erstellen
	if(!is_file($thumb)) {
		
        list($width, $height, $type, $attr) = getimagesize($file);
        
        $iTempFileSize = ceil( filesize($file) / 1048576); // 1024 * 1024 
        if( $iTempFileSize > $megapixel_limit)
        {
            if ($showmessage == 1) {
                echo "<br/><b>".$iTempFileSize. " Megabyte filesize! Process skipped!</b>";
            }
            return -2;  // !! why negative integer here?
        }

        $original = NULL;
        
        switch( $type )
        {
            case 1: // gif
                $original = imagecreatefromgif($file);
                break;

            case 2: // jpeg
                $original = imagecreatefromjpeg($file);
                break;

		    case 3: // png
			    $original = imagecreatefrompng($file);
			    break;
			    
			default:
			    echo '<br/><b>No type match!</b>';
			    return -3; // ok, another negative number ...
		}
	
		if ( $original != NULL )
		{		
			
			//list( $width, $height, $type, $attr) = getimagesize($file);
			
			
			if ($width >= $height && $width > $thumb_size) {
				//#########
				//Thumbnail verarbeitung verändert um einen Ausschnitt der Größe der $thumbnail_size
				//zu erhalten um ein gleichmäßiges erscheinungsbild im Frontend zu gewährleisten
				//by Pumpi
				//#########
				//$smallwidth = $thumb_size;
				//$smallheight = floor($height / ($width / $smallwidth));
				$smallwidth = intval($width*$thumb_size/$height);
				$smallheight = $thumb_size;
				$ofx = 0;   // [1]
				$ofy = floor(($thumb_size - $thumb_size) / 2);
			} elseif ($width <= $height && $height > $thumb_size) {
				//$smallheight = $thumb_size;
				//$smallwidth = floor($width / ($height / $smallheight));
				$smallheight = intval($height*$thumb_size/$width);
				$smallwidth = $thumb_size;
				$ofx = floor(($thumb_size - $thumb_size) / 2); 
				$ofy = 0; // [2]
			} else {
				$smallheight = $height;
				$smallwidth = $width;
				$ofx = floor(($thumb_size - $thumb_size) / 2);
				$ofy = floor(($thumb_size - $thumb_size) / 2);
			}
			
			if (function_exists('imagecreatetruecolor')) {
				if ($height > $thumb_size && $width > $thumb_size) {
					if ($ratio > 1) $small = imagecreatetruecolor($thumb_size, $thumb_size/$ratio);
					else $small = imagecreatetruecolor($thumb_size*$ratio, $thumb_size);
				}
				else {
					$small = imagecreatetruecolor($smallwidth, $smallheight);
				}
			} else {
				$small = imagecreate($smallwidth, $smallheight);
			}
			
			sscanf($bg, '%2x%2x%2x', $red, $green, $blue); // see [3] above
			
			$b = imagecolorallocate($small, $red, $green, $blue);
			imagefill($small, 0, 0, $b);
			if ($original) {
				//Änderungen der Variablen die für JCrop Thumberstellung anderst sein müssen
				if (!empty ($positionW) && !empty($positionH)) {
					$width = $positionW;
					$height = $positionH;
					
					//wenn ein Ratio eingestellt ist werden die small Atribute des Thumbs angepasst
					//die ist allerdings nur bei JCrop nötig normal wird die größe vom 0Punkt aus errechnet
					if ($ratio > 1) {
						$smallwidth = $thumb_size;
						$smallheight = $thumb_size / $ratio;
					}
					else {
						$smallwidth = $thumb_size * $ratio;
						$smallheight = $thumb_size;
					}
				}
				
				if (function_exists('imagecopyresampled')) {
				    
					imagecopyresampled($small, $original, $ofx, $ofy, $positionX, $positionY, $smallwidth, $smallheight, $width, $height);
				} else {
				
					imagecopyresized($small, $original, $ofx, $ofy, $positionX, $positionY, $smallwidth, $smallheight, $width, $height);
				}
			} else {
			
				$black = imagecolorallocate($small, 0, 0, 0);
				$fw = imagefontwidth($fontSize);
				$fh = imagefontheight($fontSize);
				$htw = ($fw*strlen($filename))/2;
				$hts = $thumb_size/2;
				
				imagestring($small, $fontSize, $hts-$htw, $hts-($fh/2), $filename, $black);
				
				imagerectangle($small, $hts-$htw-$fw-1, $hts-$fh, $hts+$htw+$fw-1, $hts+$fh, $black);
			}
			imagejpeg($small, $thumb);
			imagedestroy($original);
			imagedestroy($small);
			return true;
		}
	}
}
?>