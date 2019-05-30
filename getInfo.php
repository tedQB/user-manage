<?php
  require_once("easyCRUD/easyCRUD.class.php");
  require_once("Db.class.php");
  $db = new Db();

  
  
  $array=array(); 
  $persons = $db->query("SELECT * FROM bang where leftTime >= 0 ORDER BY id desc");
  $nowtime=date("Y-m-d");
 

  $obj=(object)null;	
  $objs = (object)null;
  function level($hasTime){ 
	 if($hasTime>=0&&$hasTime<=7){ 
		return "鄂焕";
	 }else if($hasTime>=8&&$hasTime<=15){ 
		return "华雄";
	 }else if($hasTime>=16&&$hasTime<=23){ 
		return "邓艾";
	 }else if($hasTime>=24&&$hasTime<=31){ 
		return "高览";
	 }else if($hasTime>=32&&$hasTime<=39){ 
		return "周泰";
	 }else if($hasTime>=40&&$hasTime<=47){ 
		return "夏侯渊";
	 }else if($hasTime>=48&&$hasTime<=55){ 
		return "姜维";
	 }else if($hasTime>=56&&$hasTime<=63){ 
		return "魏延";
	 }else if($hasTime>=64&&$hasTime<=71){ 
		return "文鸯";
	 }else if($hasTime>=72&&$hasTime<=79){ 
		return "关平";
	 }else if($hasTime>=80&&$hasTime<=87){ 
		return "曹彰";
	 }else if($hasTime>=88&&$hasTime<=95){ 
		return "徐晃";
	 }else if($hasTime>=96&&$hasTime<=103){ 
		return "张郃";
	 }else if($hasTime>=104&&$hasTime<=111){ 
		return "甘宁";
	 }else if($hasTime>=112&&$hasTime<=119){ 
		return "夏侯惇";
	 }else if($hasTime>=120&&$hasTime<=127){ 
		return "张辽";
	 }else if($hasTime>=128&&$hasTime<=135){ 
		return "孙策";
	 }else if($hasTime>=136&&$hasTime<=143){ 
		return "太史慈";
	 }else if($hasTime>=144&&$hasTime<=151){ 
		return "黄忠";
	 }else if($hasTime>=152&&$hasTime<=159){ 
		return "越兮";
	 }else if($hasTime>=160&&$hasTime<=167){ 
		return "庞德";
	 }else if($hasTime>=168&&$hasTime<=175){ 
		return "许褚";
	 }else if($hasTime>=176&&$hasTime<=183){ 
		return "文丑";
	 }else if($hasTime>=184&&$hasTime<=191){ 
		return "张飞";
	 }else if($hasTime>=192&&$hasTime<=199){ 
		return "关羽";
	 }else if($hasTime>=200&&$hasTime<=207){ 
		return "典韦";
	 }else if($hasTime>=208&&$hasTime<=215){ 
		return "颜良";
	 }else if($hasTime>=216&&$hasTime<=223){ 
		return "马超";
	 }else if($hasTime>=224&&$hasTime<=231){ 
		return "赵云";
	 }else if($hasTime>=232&&$hasTime<=239){ 
		return "吕布";
	 }else if($hasTime>=240&&$hasTime<=247){ 
		return "诸葛瑾";
	 }else if($hasTime>=248&&$hasTime<=255){ 
		return "陈宫";
	 }else if($hasTime>=256&&$hasTime<=263){ 
		return "张昭";
	 }else if($hasTime>=264&&$hasTime<=271){ 
		return "程昱";
	 }else if($hasTime>=272&&$hasTime<=279){ 
		return "法正";
	 }else if($hasTime>=280&&$hasTime<=287){ 
		return "田丰";
	 }else if($hasTime>=288&&$hasTime<=295){ 
		return "鲁肃";
	 }else if($hasTime>=296&&$hasTime<=303){ 
		return "荀攸";
	 }else if($hasTime>=304&&$hasTime<=311){ 
		return "陆逊";
	 }else if($hasTime>=312&&$hasTime<=319){ 
		return "徐庶";
	 }else if($hasTime>=320&&$hasTime<=327){ 
		return "荀彧";
	 }else if($hasTime>=328&&$hasTime<=335){ 
		return "毒士——贾诩";
	 }else if($hasTime>=336&&$hasTime<=343){ 
		return "周瑜";
	 }else if($hasTime>=344&&$hasTime<=351){ 
		return "凤雏——庞统";
	 }else if($hasTime>=352&&$hasTime<=359){ 
		return "鬼才——郭嘉";
	 }else if($hasTime>=360&&$hasTime<=367){ 
		return "宣皇帝——司马懿";
	 }else if($hasTime>=368){ 
		return "卧龙——诸葛亮";
	 }
		
  
  }
  
  
  foreach ($persons as $key => $rs) { 
	$obj2=(object)null;
	$obj3=(object)null;
	if($rs['pojiecishu']){ 
		$hasTime = ceil((strtotime($nowtime)-strtotime($rs['pojieTime']))/86400)+1;
	}else{
		$hasTime = ceil((strtotime($nowtime)-strtotime($rs['luruTime']))/86400)+1;
	}
	$obj->$rs['weixinName']= $obj2;
	//array_push($array,$obj);
	$obj2->hasTime = $hasTime;
	$obj2->level = level($hasTime);
	$obj2->wxId=$rs['weixinName'];
	$obj2->endDate = substr($rs['endTime'],0,10);	
	if($rs['isShow']){
		$obj2->nickName = '不 '.$rs['nickName'];
		//$obj2->nickName = preg_replace('/不/','',$rs['nickName']);
		$obj2->isShow = false;	
	}else{
		$obj2->nickName = $rs['nickName'];	
		$obj2->isShow = true;	
	}
	if($rs['leftTime']<=10){
		$obj2->leftTime = $rs['leftTime'];
		$obj2->needChangeDate = true; 	
			
	}
	if($rs['declaration']){ 
		$obj2->declaration = $rs['declaration'];
	}
	$nickName = trim(preg_replace("/(不)/","",$rs['nickName'])); //只匹配不带不子的结果，便于匹配微信uid
	
	$objs->$nickName = $rs['weixinName'];
  }
  
  echo 'var dataT='.json_encode($objs).';<br />';
  
  echo 'var data='.json_encode($obj);
  

    //echo "$luruTime <br>";
    //echo "$jieseTime <br>";
  //echo 'sucess';

?>
