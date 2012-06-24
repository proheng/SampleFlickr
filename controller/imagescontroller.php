<?php
if(!defined('ACCESS_PERMIT')) {
     header('HTTP/1.0 401 Unauthorized');
     die;
} 
require_once $GLOBALS['SITE_BASE_PATH'].$GLOBALS['DS'].'model'.$GLOBALS['DS'].'imagemodel.php';


class ImagesController
{
    private $keyword;
    private $offset;
    private $limit;
    private $id;
    private $request;

    public function GETAction($request) {   

        $this->request = $request;
        $this->validateRequest();
       

        if(!empty($this->id)){
            $this->id = $request->url_elements[2];
            //Show individual image
            $data = ImageModel::findById($this->id,$this->keyword);
            array_push($data, array('keyword' => $this->keyword ));
            $this->renderView('ImageView',$data);
        }else{
            //Show image
            $data = ImageModel::show($this->keyword,$this->offset,$this->limit);
            $this->renderView('ImagesView',$data);
        }
        
    }

    private function renderView($view_name, $data){
        $filename = $GLOBALS['SITE_BASE_PATH'].$GLOBALS['DS'].'view'.$GLOBALS['DS'].strtolower($view_name).'.php';
        if(file_exists($filename)){
            require_once $filename;
            $view = new $view_name();
            $view->render($data);
        }else{
            throw new Exception("Front End Page Missing", 500);
            
        }
    }

    private function validateRequest(){
        $request = $this->request;
        $this->keyword = isset($request->parameters['keyword'])?$request->parameters['keyword']:"";
        $this->offset = isset($request->parameters['offset'])?$request->parameters['offset']:"";
        $this->limit = isset($request->parameters['limit'])?$request->parameters['limit']:"";

        $this->id = $request->url_elements[2];

        if(!filter_var($this->id ,FILTER_VALIDATE_INT) && !empty($this->id)){
            throw new Exception("parameters invalid", 400);
        }
        if(!filter_var($this->offset ,FILTER_VALIDATE_INT) && !empty($this->offset)){
            throw new Exception("parameters invalid", 400);
        }
        if(!filter_var($this->limit ,FILTER_VALIDATE_INT) && !empty($this->limit)){
            throw new Exception("parameters invalid", 400);
        }
        if(preg_match('/[^A-Za-z0-9$]/',$this->keyword) == 1 && !empty($this->keyword)){
            throw new Exception("parameters invalid", 400);
        }
    }
}