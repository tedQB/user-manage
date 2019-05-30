<?php
  require_once("easyCRUD/easyCRUD.class.php");
  require_once("Db.class.php");
  $db = new Db();



  $weixinName=$_POST['weixinName'];
  $name=$_POST['name'];
  $nickName=$_POST['nickName'];
  $luruTime=$_POST['luruTime'];
  $jieseTime=$_POST['jieseTime'];
  $endTime=$_POST['endTime'];
  
  $nowtime=date("Y-m-d");

  
  //echo $endTime; echo $nowtime;

//  $leftTime = (strtotime($endTime) - strtotime($nowtime))/86400;
  //$leftTime = intval($leftTime)-1;

  $state = '习惯养成期';	
  $groups = '最新加入区';
  if($jieseTime==30){ 
    $isShow=1;
  }else{ 
    $isShow=0;
  }

  //$insert   =  $db->query("INSERT INTO Persons(Firstname,Age) VALUES(:f,:age)", array("f"=>"Vivek","age"=>"20"));
  
  $inert=$db->query('INSERT INTO
  bang(weixinName,name,luruTime,jieseTime,state,endTime,nickName,leftTime,groups,isShow) VALUES(:weixinName,:name,:luruTime,:jieseTime,:state,:endTime,:nickName,:leftTime,:groups,:isShow)', array(
      'weixinName'=>$weixinName,
      'name'=>$name,
      'luruTime'=>$luruTime,
      'jieseTime'=>$jieseTime,
      'state'=>$state,
      'endTime'=>$endTime,
      'nickName'=>$nickName,
      'leftTime'=>$jieseTime,
	    'groups'=>$groups,
      'isShow'=>$isShow
      )

  );



    //echo "$luruTime <br>";
    //echo "$jieseTime <br>";
  echo 'sucess';

?>