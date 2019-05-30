<?php
  require_once("easyCRUD/easyCRUD.class.php");
  require_once("Db.class.php");
  $db = new Db();
  $obj=(object)null;	
  
  $id=$_POST['id'];
  $weixinName=$_POST['wxId'];
  
  $update1 = $db->query("UPDATE bang SET weixinName = :weixinName  WHERE id = :id", array("weixinName"=>$weixinName,"id"=>$id));
  
  $obj->state='sucess';
  $obj->weixinName=$weixinName;
  
  echo json_encode($obj);

?>