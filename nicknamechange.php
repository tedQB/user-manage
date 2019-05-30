<?php
  require_once("easyCRUD/easyCRUD.class.php");
  require_once("Db.class.php");
  $db = new Db();
  $obj=(object)null;	
  
  $id=$_POST['id'];
  $nickName=$_POST['nickname'];
  
  $update1 = $db->query("UPDATE bang SET nickname = :nickname  WHERE id = :id", array("nickname"=>$nickName,"id"=>$id));

  $obj->state='sucess';
  $obj->nickName=$nickName;
  
  echo json_encode($obj);

?>