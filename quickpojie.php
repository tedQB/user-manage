<?php
  require_once("easyCRUD/easyCRUD.class.php");
  require_once("Db.class.php");
  $db = new Db();
  $obj=(object)null;	
  

  $id=$_POST['id'];
  $endTime=$_POST['endTime'];
  $pojiecishu=$_POST['pojiecishu'];
  $pojieTime=$_POST['pojieTime'];
  $pojieshengyuTime=$_POST['pojieshengyuTime'];
  $groups = '破戒反省区';
  
  $update1 = $db->query("UPDATE bang SET endTime = :endTime  WHERE id = :id", array("endTime"=>$endTime,"id"=>$id));  
  $update2 = $db->query("UPDATE bang SET pojiecishu = :pojiecishu  WHERE id = :id", array("pojiecishu"=>$pojiecishu,"id"=>$id));  
  $update3 = $db->query("UPDATE bang SET pojieTime = :pojieTime  WHERE id = :id", array("pojieTime"=>$pojieTime,"id"=>$id));  
  $update5 = $db->query("UPDATE bang SET pojieshengyuTime = :pojieshengyuTime  WHERE id = :id", array("pojieshengyuTime"=>$pojieshengyuTime,"id"=>$id));  
  $update4 = $db->query("UPDATE bang SET groups = :groups WHERE id = :id", array("groups"=>$groups,"id"=>$id));	

    //echo "$luruTime <br>";
    //echo "$jieseTime <br>";
    
  $endTime1 = $db->query("SELECT endTime,pojiecishu,pojieTime,leftTime FROM bang where id = :id",array("id"=>$id)); 

   
  //array(1) {[0]=> array(1) { ["endTime"]=> string(19) "2015-02-16 00:00:00" } }  
   $nowtime=date("Y-m-d");
   
   $obj->endTime = $endTime1[0]['endTime'];
   $obj->pojiecishu = $endTime1[0]['pojiecishu'];
   $obj->pojieTime = $endTime1[0]['pojieTime'];  
   $obj->pojieshengyuTime = ceil((strtotime($endTime1[0]['endTime']) - strtotime($nowtime))/86400);
   $obj->state='sucess';
  header("Content-type:application/json");
  echo json_encode($obj);
  

?>