<?php 
if(!defined('ACCESS_PERMIT')) {
	 header('HTTP/1.0 401 Unauthorized');
	 die;
} 
class ImageModel{
	private $id;
	private $name;
	private $description;
	private $image_url;
	private $image_thumb_url;
	private $db_conn;

	public function __construct($assoc_array=array()){
		$this->id              = isset($assoc_array)?$assoc_array['id']:"";
		$this->name            = isset($assoc_array)?$assoc_array['name']:"";
		$this->description     = isset($assoc_array)?$assoc_array['description']:"";
		$this->image_url       = isset($assoc_array)?$assoc_array['imageURL']:"";
		$this->image_thumb_url = isset($assoc_array)?$assoc_array['imageThumbURL']:"";
		$db_conn 			   = new PDO('mysql:host=localhost;dbname=test', 'root', '');
	}

	static public function show($keyword='', $offset='0',$limit='5'){
		
		if(empty($offset)){
			$offset = 0;
		}
		if(empty($limit)){
			$limit = 5;
		}
	
		$db_conn = new PDO('mysql:host=localhost;dbname=test', 'root', '');
		$image_list = array();
		
		if(empty($keyword)){
			$sql  = "SELECT SQL_CALC_FOUND_ROWS * FROM Images ORDER BY id LIMIT $limit OFFSET $offset;";	
		}else{
			$sql  = "SELECT SQL_CALC_FOUND_ROWS * FROM Images WHERE name LIKE '%$keyword%' or description LIKE '%$keyword%' ORDER BY id LIMIT $limit OFFSET $offset;";	
		}
		
		$sql2 = "SELECT FOUND_ROWS() AS COUNT;";
		//TODO finish the sql 
		$stmt = $db_conn->prepare($sql);
		$stmt->execute();
		$image_list = $stmt->fetchAll();
		
		$stmt  = $db_conn->prepare($sql2);
		$stmt->execute();
		$count = $stmt->fetch();
		
		$images = array('count' =>  $count , 'image_list'=> array(), 'offset' => $offset, 'limit' => $limit, 'keyword' => $keyword);

		//For loop to cast the object.
		foreach ($image_list as $key => $value) {
			
			$image  = new ImageModel($value);
			array_push($images['image_list'], $image);
		}
		
		return $images ;
	}

	static public function findById($id,$keyword=''){

		if(!empty($keyword)){
			$keyword_condition = " and (name LIKE '%$keyword%' or description LIKE '%$keyword%' )";
		}
		$db_conn = new PDO('mysql:host=localhost;dbname=test', 'root', '');
		$sql = "SELECT * FROM Images WHERE id = $id $keyword_condition ";

		$stmt = $db_conn->prepare($sql);
		$stmt->execute();
		$image = $stmt->fetch();
		$image  = new ImageModel($image);

		$sql = "SELECT * FROM Images WHERE id > $id $keyword_condition LIMIT 1";
		$stmt = $db_conn->prepare($sql);
		$stmt->execute();
		$imageNext = $stmt->fetch();
		$imageNext  = new ImageModel($imageNext);


		$sql = "SELECT * FROM Images WHERE id < $id $keyword_condition LIMIT 1";
		$stmt = $db_conn->prepare($sql);
		$stmt->execute();
		$imagePrev = $stmt->fetch();
		$imagePrev  = new ImageModel($imagePrev);


		return $image = array('image' => $image, 'imageNext' => $imageNext, 'imagePrev' => $imagePrev );;
	}

	public function id($value=''){
		if(empty($value)){
			return $this->id;
		}else{
			$this->id = $value;
		}
	}
	public function name($value=''){
		if(empty($value)){
			return $this->name;
		}else{
			$this->name = $value;
		}
	}
	public function description($value=''){
		if(empty($value)){
			return $this->description;
		}else{
			$this->description = $value;
		}
	}
	public function imageURL($value=''){
		if(empty($value)){
			return $this->image_url;
		}else{
			$this->image_url = $value;
		}
	}
	public function imageThumbURL($value=''){
		if(empty($value)){
			return $this->image_thumb_url;
		}else{
			$this->image_thumb_url = $value;
		}
	}
}