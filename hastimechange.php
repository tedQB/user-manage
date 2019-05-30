<?php
  require_once("easyCRUD/easyCRUD.class.php");
  require_once("Db.class.php");
  $db = new Db();
  $obj=(object)null;	
  
  $id=$_POST['id'];
  $inputhastime=$_POST['inputhastime'];
  $pojiecishu = $_POST['pojiecishu'];
  $nowtime=date("Y-m-d");  
  $luruTime=date("Y-m-d",strtotime("-".$inputhastime."day",strtotime($nowtime)));
  
  if($inputhastime==0){
      $db->query("UPDATE bang SET pojieTime = :pojieTime  WHERE id = :id", array("pojieTime"=>$luruTime,"id"=>$id));
      $db->query("UPDATE bang SET pojiecishu = :pojiecishu  WHERE id = :id", array("pojiecishu"=>$pojiecishu+1,"id"=>$id));  
      $obj->pojiecishu = $pojiecishu+1; 
      $obj->pojietime = $luruTime;
  }else{
      if($pojiecishu){ 
         $db->query("UPDATE bang SET pojieTime = :pojieTime  WHERE id = :id", array("pojieTime"=>$luruTime,"id"=>$id));
      }else{ 
         $db->query("UPDATE bang SET luruTime = :luruTime  WHERE id = :id", array("luruTime"=>$luruTime,"id"=>$id));
      }
  }

   

  //$hasTime=intval((strtotime($nowtime)-30)/86400)+1;
  
  
  //$update1 = $db->query("UPDATE bang SET weixinName = :weixinName  WHERE id = :id", array("weixinName"=>$weixinName,"id"=>$id));
  
  $obj->state='sucess';
  $obj->inputhastime = $inputhastime;
  echo json_encode($obj);
  

?>