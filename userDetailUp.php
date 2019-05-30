<?php
  require_once("easyCRUD/easyCRUD.class.php");
  require_once("Db.class.php");
  $db = new Db();


  $id=$_POST['id'];
  $declaration=$_POST['declaration'];
//  $peopleHeight=$_POST['peopleHeight'];
//  $peopleWeight=$_POST['peopleWeight'];
//  $peopleOld=$_POST['peopleOld'];
//  $peopleState=$_POST['peopleState'];
//  $peopleJob=$_POST['peopleJob'];
//  $peopleIll=$_POST['peopleIll'];


 $update1 = $db->query("UPDATE bang SET declaration = :declaration  WHERE id = :id", array("declaration"=>$declaration,"id"=>$id));	

  //$update1 = $db->query("UPDATE bang SET peopleHeight = :peopleHeight  WHERE id = :id", array("peopleHeight"=>$peopleHeight,"id"=>$id));
  //$update2 = $db->query("UPDATE bang SET peopleWeight = :peopleWeight  WHERE id = :id", array("peopleWeight"=>$peopleWeight,"id"=>$id));      
  //$update3 = $db->query("UPDATE bang SET peopleOld = :peopleOld  WHERE id = :id", array("peopleOld"=>$peopleOld,"id"=>$id)); 
  //$update4 = $db->query("UPDATE bang SET peopleState = :peopleState  WHERE id = :id", array("peopleState"=>$peopleState,"id"=>$id)); 
  //$update5 = $db->query("UPDATE bang SET peopleJob = :peopleJob  WHERE id = :id", array("peopleJob"=>$peopleJob,"id"=>$id)); 
  //$update6 = $db->query("UPDATE bang SET peopleIll = :peopleIll  WHERE id = :id", array("peopleIll"=>$peopleIll,"id"=>$id)); 

    //echo "$luruTime <br>";
    //echo "$jieseTime <br>";
  echo 'sucess';

?>