<?php
  require_once("easyCRUD/easyCRUD.class.php");
  require_once("Db.class.php");
  $db = new Db();
  $obj=(object)null;	
  
  $id=$_POST['id'];
  $state =$_POST['state'];
 
  $update1 = $db->query("UPDATE bang SET isShow = :isShow WHERE id = :id", array("isShow"=>$state,"id"=>$id));
  
  if($state==1){ 
	echo 1;
   
  }else{ 
	echo 0;
  }
  

?>