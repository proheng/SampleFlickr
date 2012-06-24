<?php
if(!defined('ACCESS_PERMIT')) {
	 header('HTTP/1.0 401 Unauthorized');
	 die;
} 

class Errorcode{
	static function getError($code){
		$error_code = 
		array(
				'400' => 'HTTP/1.0 400 Bad Request', 
				'404' => 'HTTP/1.0 404 Not Found',
				'401' => 'HTTP/1.0 401 Unauthorized'
			);
		return $error_code[$code];
	}


}