<?php
if(!defined('ACCESS_PERMIT')) {
	 header('HTTP/1.0 401 Unauthorized');
	 die;
} 

class ImagesView{
	public function render($data=''){
		require_once 'imagesviewlayout.php';
	}
}