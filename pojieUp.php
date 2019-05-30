<?php
  require_once("easyCRUD/easyCRUD.class.php");
  require_once("Db.class.php");
  $db = new Db();


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
  $update4 = $db->query("UPDATE bang SET groups = :groups WHERE id = :id", array("groups"=>$groups,"id"=>$rs['id']));	

    //echo "$luruTime <br>";
    //echo "$jieseTime <br>";
  echo 'sucess';

?>