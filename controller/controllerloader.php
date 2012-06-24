<?php
if(!defined('ACCESS_PERMIT')) {
	 header('HTTP/1.0 401 Unauthorized');
	 die;
} 
function __autoload($classname) {
	$filename = $GLOBALS['SITE_BASE_PATH'].$GLOBALS['DS'].'controller'.$GLOBALS['DS'].strtolower($classname) . '.php';
	if(file_exists($filename)){
		require strtolower($classname) . '.php';		
	}else{
		throw new Exception("file not found", 404);	
	}
}