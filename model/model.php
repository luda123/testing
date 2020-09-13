<?php

class Model {
    
 protected $db;
    
 public function __construct() {
        $this->db = mysql_connect(HOST,USER,PASSWORD);
        if(!$this->db) {
            exit("Ошибка соединения с базой данных".mysql_error());
        }
        if(!mysql_select_db(DB,$this->db)) {
            exit("Нет такой базы данных".mysql_error());
        }
        mysql_query("SET NAMES 'UTF8'");
        
    }

 public function getRegions($reg = "")
 {
     $reg = ($reg != "")?" AND ter_id='".$reg."' ":"";
     $query = "SELECT *
     FROM t_koatuu_tree
     WHERE ter_level=1".$reg."
     ORDER BY ter_name
     ";
        
        $result = mysql_query($query);
        if(!$result) {
            exit(mysql_error());
        }
        
        for($i = 0;$i < mysql_num_rows($result); $i++) {
            $row[] = mysql_fetch_array($result, MYSQL_ASSOC);
        }
        
        return $row; 
 } 
 
 public function getCities($reg = "", $city = "")
 {
     if ($reg == '8000000000' || $reg == '8500000000')
     $union = "
     UNION
     SELECT *
     FROM t_koatuu_tree
     WHERE  
     ter_id='".$reg."' ";
     
     $city = ($city !="")?" AND ter_id='".$city."' ":"";
     $reg = ($reg != "")?" AND ter_pid='".$reg."' ":"";
     
     $query = "SELECT *
     FROM t_koatuu_tree
     WHERE 
     ter_type_id = 1 ".$reg.$city.$union."
      ORDER BY ter_name";
    
        $result = mysql_query($query);
        if(!$result) {
            exit(mysql_error());
        }
        
        for($i = 0;$i < mysql_num_rows($result); $i++) {
            $row[] = mysql_fetch_array($result, MYSQL_ASSOC);
        }
        
        return $row; 
 } 
 
 public function getDistricts($reg="",$city = "", $distr = "")
 {
     $city = ($city !="")?" AND ter_pid='".$city."' ":"";
     $distr = ($distr !="")?" AND ter_id='".$distr."' ":"";
     
     $query = "SELECT ter_id,ter_name,0
     FROM t_koatuu_tree
     WHERE 1=1
     ".$city.$distr."
     UNION
     SELECT ter_id,ter_name,
     (SELECT count(*) FROM t_koatuu_tree WHERE 1=1 ".$city.") cnt
     FROM t_koatuu_tree 
     WHERE ter_pid ='".$reg."'
     AND ter_type_id = 2
     GROUP BY ter_id,ter_name
     HAVING cnt = 0
     ORDER BY ter_id";
     
        $result = mysql_query($query);
        if(!$result) {
            exit(mysql_error());
        }
        
        for($i = 0;$i < mysql_num_rows($result); $i++) {
            $row[] = mysql_fetch_array($result, MYSQL_ASSOC);
        }
        
        return $row; 
 }  
 
 public function getUserInfo($user_id = "")
 {
     $query = "SELECT * FROM users_test WHERE id = ".$user_id;
     $result = mysql_query($query);
        if(!$result) {
            exit(mysql_error());
        }
     $user = array();
     for($i = 0;$i < mysql_num_rows($result); $i++) {
            $user[] = mysql_fetch_array($result, MYSQL_ASSOC);
      }  
      
      if (count($user) > 0)
      {
          $ter = json_decode($user[0]["territory"], true);
          $user["region"] = $ter["region"];
          $user["city"] = $ter["city"];
          $user["district"] = $ter["distirict"];
      }
      
      return $user;
 }
 
 public function SaveUser($data = array())
 {
     
     $territory = array();
     $territory["region"] = $data["sel_reg"];
     if (isset($data["sel_city"]))
     $territory["city"] = $data["sel_city"];
     if (isset($data["sel_distr"]))
     $territory["distirict"] = $data["sel_distr"];
     
     $query = "SELECT * FROM users_test WHERE email = '". mysql_escape_string($data["email"])."'";
     $result = mysql_query($query);
        if(!$result) {
            exit(mysql_error());
        }
     $row = array();   
     $user = array();
     for($i = 0;$i < mysql_num_rows($result); $i++) {
            $user[] = mysql_fetch_array($result, MYSQL_ASSOC);
      }
     
     if (count($user) == 0)
     {
     $query = "INSERT into users_test
     SET name = '".mysql_escape_string($data["username"])."',
     email = '".mysql_escape_string($data["email"])."',
     territory =  '".json_encode($territory)."'";
     
     $result = mysql_query($query);
       if(!$result) {
            exit(mysql_error());
        }
       else   
       $row["status"] = 1;
     }
     else
     {
       $row["user"] = $user; 
       $row["status"] = 0;
     }
        
          
     return $row;
 }
    
public function getlogin()
{
if(isset($_COOKIE['user_id']) && $_COOKIE['user_id'] !=""
){
return 'login';
}
else{
return;
}


}


}
?>