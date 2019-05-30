<?php
  require_once("easyCRUD/easyCRUD.class.php");
  require_once("Db.class.php");
  $db = new Db();
  $obj=(object)null;	
  
  $id=$_POST['id'];
  $weixinName=$_POST['wxName'];
  
  $update1 = $db->query("UPDATE bang SET name = :name  WHERE id = :id", array("name"=>$weixinName,"id"=>$id));
  
  $obj->state='sucess';
  $obj->weixinName=$weixinName;
  
  echo json_encode($obj);

?>