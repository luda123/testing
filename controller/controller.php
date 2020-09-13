<?php

include_once("model/model.php");
class Controller {
public $model;
public function __construct()
{
        $this->model = new Model();
}
    
    
public function invoke()
{
     if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {  
        switch ($_REQUEST['ajax']) {
           case "getCities":
             $cities =  $this->model->getCities($_REQUEST["reg_id"]);
             $res = array();
             $res["status"] =  0;
             $res["content"] = array();
             for($i=0;$i<count($cities);$i++) { 
               $res["content"][] = "<option value=".$cities[$i]["ter_id"].">".$cities[$i]["ter_name"]."</option>";
             }
             if (count($res) > 0)
             $res["status"] = 1;
             die(json_encode($res));
             break; 
             
           case "getDistricts":
             $cities =  $this->model->getDistricts($_REQUEST["reg_id"],$_REQUEST["city_id"]);
             $res = array();
             $res["status"] =  0;
             $res["content"] = array();
             for($i=0;$i<count($cities);$i++) { 
               $res["content"][] = "<option value=".$cities[$i]["ter_id"].">".$cities[$i]["ter_name"]."</option>";
             }
             if (count($res) > 0)
             $res["status"] = 1;
             die(json_encode($res));
             break;   
             
           case "SaveForm":
              $res =  $this->model->SaveUser($_REQUEST);
              if ($res["status"] == 0)
              {
                $user_id = $res["user"][0]["id"];
                setcookie("user_id", $user_id);
              }  
              else
              {
               unset($_COOKIE["user_id"]);
              }
 
               die(json_encode($res));
             break;
           }
    }


    $regs = $this->model->getRegions();
    
    $reslt = $this->model->getlogin();     
    
 
    if($reslt == 'login')
{
    $user_id = $_COOKIE["user_id"];
    $user = $this->model->getUserInfo($user_id);
    $reg = $this->model->getRegions($user['region']);
    $cities = $this->model->getCities($user['region']);
    $city = $user['city']; 
    $distr = $user['district'];
    $districts =  $this->model->getDistricts($user['region'],$user['city']);
      
    include 'view/login.php';
}
else
{
    include 'view/register.php';
}
}
}
?>