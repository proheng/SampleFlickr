<?php
define('ACCESS_PERMIT', 1);
$GLOBALS['SITE_BASE_PATH'] = __DIR__;
$GLOBALS['DS']             = '/';
try {
    require_once 'controller/errorcode.php';
    require_once 'controller/controllerloader.php';

    $request = new Request();
    $request->url_elements = array();
    if(isset($_SERVER['PATH_INFO'])) {
        $request->url_elements = explode('/', $_SERVER['PATH_INFO']);
    }

    $request->verb = $_SERVER['REQUEST_METHOD'];
    switch($request->verb) {
        case 'GET':
            $request->parameters = $_GET;
            break;
        default:
            $request->parameters = array();
    }

    file_put_contents('log/request.log', serialize($request)); 

    if($request->url_elements) {
        $controller_name = ucfirst($request->url_elements[1]) . 'Controller';
        if(class_exists($controller_name)) {
            $controller = new $controller_name();
            $action_name = ucfirst($request->verb) . "Action";
            $response = $controller->$action_name($request);
            exit;
        } else {            
            $message = "Unknown Request for " . $request->url_elements[1];
            throw new Exception($message, 400);
        }
    } 
} catch (Exception $e) {
    header(Errorcode::getError($e->getCode()));
    echo $response = $e->getMessage();
}
?>
<a href="/images" >Gallery</a> 