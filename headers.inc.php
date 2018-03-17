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


$mod_headers = array(
	'backend' => array(
        'css' => array(
            array(
                'media'  => 'all',
                'file'  => 'modules/lib_semantic/dist/semantic.min.css'
			)
 		),				
		'js' => array(
			'modules/lib_jquery/jquery-core/jquery-core.min.js',
			'modules/lib_jquery/jquery-core/jquery-migrate.min.js',			
			'modules/lib_semantic/dist/semantic.min.js'
		)
	),
	'frontend' => array(			
		'js' => array(
			'modules/lib_jquery/jquery-core/jquery-core.min.js',
			'modules/lib_jquery/jquery-core/jquery-migrate.min.js'
		)
	)	
);

// load only on single pages
$aTemp = explode( '/', $_SERVER['SCRIPT_NAME']);
$sFilename = array_pop( $aTemp );

switch( $sFilename )
{
    case "modify_thumb.php":
        $mod_headers['backend']['css'][] = array(
			'media'  => 'all',
			'file'  => 'modules/foldergallery/scripts/jcrob/css/jquery.Jcrop.css'
        );
        
        $mod_headers['backend']['js'][] = 'modules/foldergallery/scripts/jcrob/js/jquery.Jcrop.min.js';
			
        break;

}

?>