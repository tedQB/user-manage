<?php  
	@session_start(); 
	
	if(!isset($_SESSION['username'])){
		
		if(!isset($_COOKIE['username'])) 
		{	
			header("Location:login.html");
			exit();
		}
		
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<title></title>
	<link rel="stylesheet" href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://a.alipayobjects.com/arale/calendar/1.0.0/calendar.css">	
	<link charset="utf-8" rel="stylesheet" href="https://a.alipayobjects.com/arale/dialog/1.2.6/dialog.css" />	
	<script type="text/javascript" src="https://a.alipayobjects.com/seajs/seajs/2.2.0/sea.js"></script>
	<script type="text/javascript" src="https://a.alipayobjects.com/seajs/seajs-style/1.0.2/seajs-style.js"></script>
	<!--
	<script type="text/javascript" src="http://www.jiese360.cn/js/hammer.js"></script>	
	-->
	<style type="text/css">
		.input-group{margin:5px 0;}
		#search-box{ background:url(http://code.jquery.com/mobile/1.0a3/images/icon-search-black.png) 12px 8px no-repeat; padding-left: 38px; margin-bottom: 10px;  }
		.weixinName span{ display:block;  word-break: break-word;}
		.name span{ display:block; word-break: break-word;}
		.hasTime span{ display:block;  }
		.hasTime input{ width:50px; }
		.isShowOrNot{ display:block; }
		.pojieTime{ position: relative; }
		.pojieBt{ position: absolute; bottom:10px; left:5px; }
		.nickName,.name{ position: relative;}
		.nickName .isShowOrNot,.name .sex{ position: absolute; right:2px; top:2px; }
		.weixinName .modwx{ width:100px;  }
		.name .modwx{ width:100px;  }
		.hasDec{ color:red; }
	</style>
</head>
	<body>		
<h1><a href="add.php">添加</a></h1>
<input type="text" class="form-control" placeholder="Text input" id="search-box">
<table class="table table-bordered">
	<thead>
		<tr>
			<td>操作</td>
			<td style="width:120px">微信识别码</td>
			<td style="width:140px">微信id</td>
			<td style="width:50px">发送方法</td>
			<td style="width:180px">养生榜姓名</td>
			<td>养生时间</td>
			<td>录入时间</td>
			<td>养生到期时间</td>
			<td>剩余天数</td>
			<td>所处的状态</td>
			<td>榜单所在区域</td>
			<td>破戒日期</td>
			<td>已经戒的天数</td>
			<td>破戒次数</td>
		</tr>
	</thead>
	<tbody id="view-list">
<?php
  require_once("easyCRUD/easyCRUD.class.php");
  require_once("Db.class.php");
  $db = new Db();
  $nowtime=date("Y-m-d");
	$array1=0; 
	$array2=0;
	$array3=0;
	$array4=0;

  function changeGroups($leftTime){ 
	$groupst='';
	if($leftTime<=120&&$leftTime>110){ 	
		$groupst = '最新加入区';
	}
	if($leftTime<=110&&$leftTime>15){ 
		$groupst = '奋斗考察区';
	}
	if($leftTime>=0&&$leftTime<=15){ 
		$groupst = '即将成功区';
	}
	return $groupst;  
  }
  function changeGroups2($leftTime){ 
	
	if($leftTime<=365&&$leftTime>350){ 	
		$groupst = '最新加入区';
		return $groupst; 		
	}
 
  }
  
  function changeGroups3($leftTime){ 
	
	if($leftTime<=730&&$leftTime>720){ 	
		$groupst = '最新加入区';
		return $groupst;  		
	}

  }  
  
  function changeGroup4($leftTime,$jieseTime){
  	
  	$groupst='';
	if($jieseTime>1000){
		if($leftTime<=$jieseTime&&$leftTime>100){ 
			$groupst = '高级vip区';
		}
		if($leftTime>=0&&$leftTime<=15){ 
			$groupst = '即将成功区';
		}		
		
	}else{
		if($leftTime<=$jieseTime&&$leftTime>15){ 
			$groupst = '奋斗考察区';
		}
		if($leftTime>=0&&$leftTime<=15){ 
			$groupst = '即将成功区';
		}
	}
	return $groupst;  	

  }
  
  function calculatePojie($leftTime,$pojieshengyuTime){
	//echo $leftTime;
	//echo $pojieshengyuTime;
	$state='';
	if($leftTime<=$pojieshengyuTime&&$leftTime>$pojieshengyuTime-30){ 
		$state = '习惯养成期';
	}
	if($leftTime<=$pojieshengyuTime-30&&$leftTime>$pojieshengyuTime-60){ 
		$state = '信心建立期';
	}
	if($leftTime<=$pojieshengyuTime-60&&$leftTime>$pojieshengyuTime-90){
		$state = '背水一战期';
	}
	if($leftTime<=$pojieshengyuTime-90){ 
		$state = '蜕变成功期';
	} 		
	return $state;
  }

  function getPrevWeekData($slug=FALSE,$db,$leftTime,$jieseTime){
    	if($slug===FALSE||$slug==='no'||$slug==='archizheng'){
		 	return;			
		}
		else if($jieseTime-$leftTime<30){ 
			return; //新入会员7天内不需要严格汇报
		} 
		else{ 
			//$where = "YEARWEEK(date_format(subDate,'%Y-%m-%d')) = YEARWEEK(now())-2 group by subDate";
			//$where = " DATE_SUB(CURDATE(), INTERVAL 30 DAY) <= date(subDate)";
			$where = "TO_DAYS(CURDATE()) - TO_DAYS(subDate) <= 30";
			$result = $db->query("SELECT subDate FROM huibao where weixinName=".$slug." and ".$where);
			//$this->db->select('sum,subDate');
			//$this->db->where('weixinName',$slug);
			//$this->db->where($where);
			//echo $slug;
			if(!count($result)){
				$db->query("UPDATE bang SET isShow = :isShow WHERE weixinName = :weixinName", array("isShow"=>1,"weixinName"=>$slug));
			}else{ 
				//echo $slug;
				$db->query("UPDATE bang SET isShow = :isShow WHERE weixinName = :weixinName", array("isShow"=>0,"weixinName"=>$slug));

			}

		}

  }
  $persons = $db->query("SELECT * FROM bang where leftTime>0 ORDER BY id desc");
//逻辑 从昨天到过去7天，如果没有汇报数据，把养生榜单和群排行隐藏掉
//隐藏掉之后，如果今天汇报了，立即生效，明天自动回复，还是立刻恢复呢？
//新人120天，30天，1,2，如果没有汇报，必须过7个自然日才有判定的逻辑。
foreach ($persons as $key => $rs) {
	$leftTime = ceil((strtotime($rs['endTime']) - strtotime($nowtime))/86400);
	
	$saveleftTime = $rs['leftTime'];
	$state = $rs['state'];
	$savestate = $rs['state'];
	$groups = $rs['groups'];
	$savegroups = $rs['groups'];
	$idhui = $rs['idhui'];
	$savehasTime =$rs['hasTime'];
	$declaration = $rs['declaration'];
	getPrevWeekData($rs['weixinName'],$db,$leftTime,$rs['jieseTime']);
	$isShow = $rs['isShow'];
	$sex = $rs['sex'];
	if(count($declaration)){ 
		$hasDec='hasDec';
	}else{ 
		$hasDec='noDec';
	}

	$expiresClass= '';
	//echo $rs['jieseTime'].' ';
	//echo gettype($leftTime).' ';
	//echo $groups.' ';
	if(!$idhui){ 
		$idhui='否';
		$idhuiClass='btn-default';
	}else if($idhui){ 
		$idhui='是';
		$idhuiClass='btn-info';
	}
	if(!$isShow){ 
		$isShow='显示';
		$isShowClass='btn-default';
	}else if($isShow){ 
		$isShow='不显示';
		$isShowClass='btn-danger';
	}	
	if(!$sex){ 
		$sex = "男";
		$isSexClass='btn-default';
	}else{ 
		$sex = "女";
		$isSexClass='btn-danger';
	}
	if($rs['jieseTime']==120){ 
		if($leftTime<=120&&$leftTime>90){ 
			$state = $rs['state'];
		}
		if($leftTime<=90&&$leftTime>60){ 
			$state = '信心建立期';
		}
		if($leftTime<=60&&$leftTime>30){
			$state = '背水一战期';
		}
		if($leftTime<=30){ 
			$state = '蜕变成功期';
		} 	
		$groups = changeGroups($leftTime);		
		
		//echo $rs['pojieTime'];
		if($rs['pojieTime']){ //破戒走的是这一套系统
			//echo intval((strtotime($nowtime)-strtotime($rs['pojieTime']))/86400);
			
			if(intval((strtotime($nowtime)-strtotime($rs['pojieTime']))/86400)<11){
				$groups = '破戒反省区'; //10天的破解反省区。
			}else{ //10天后状态更改。。90 ，60-90的习惯养成，30-60的背水一战
				if($rs['pojieshengyuTime']&&$rs['pojieshengyuTime']>0){ 
					$state = calculatePojie($leftTime,$rs['pojieshengyuTime']);
				}
			}
		}
		
		if($leftTime<0){ 
			$expiresClass='expires';
		}		
	}
	else if($rs['jieseTime']==730){ 
		if($leftTime<=730&&$leftTime>700){ 
			$state = $rs['state'];
		}
		if($leftTime<=700&&$leftTime>670){ 
			$state = '信心建立期';
		}
		if($leftTime<=670&&$leftTime>610){
			$state = '背水一战期';
		}
		if($leftTime<=610){ 
			$state = '蜕变成功期';
		} 	
		$groups = '高级vip区';
		if(changeGroups3($leftTime)){ 
			$groups = changeGroups3($leftTime);
		}			
		
		if($rs['pojieTime']){ //破戒走的是这一套系统
			//echo intval((strtotime($nowtime)-strtotime($rs['pojieTime']))/86400);
			
			if(intval((strtotime($nowtime)-strtotime($rs['pojieTime']))/86400)<11){
				$groups = '破戒反省区'; //10天的破解反省区。
			}else{ //10天后状态更改。。90 ，60-90的习惯养成，30-60的背水一战
				if($rs['pojieshengyuTime']&&$rs['pojieshengyuTime']>0){ 
					$state = calculatePojie($leftTime,$rs['pojieshengyuTime']);
				}
			}
		}		
	}
	else if($rs['jieseTime']==365){ 
		if($leftTime<=365&&$leftTime>335){ 
			$state = $rs['state'];
		}
		if($leftTime<=335&&$leftTime>305){ 
			$state = '信心建立期';
		}
		if($leftTime<=305&&$leftTime>260){
			$state = '背水一战期';
		}
		if($leftTime<=260){ 
			$state = '蜕变成功期';
		} 	
		$groups = '高级vip区';	
		//echo changeGroups2($leftTime).'ssssw';
		if(changeGroups2($leftTime)){ 
			$groups = changeGroups2($leftTime);
			//echo $groups;
		}	
		
		if($rs['pojieTime']){ //破戒走的是这一套系统
			//echo intval((strtotime($nowtime)-strtotime($rs['pojieTime']))/86400);
			
			if(intval((strtotime($nowtime)-strtotime($rs['pojieTime']))/86400)<11){
				$groups = '破戒反省区'; //10天的破解反省区。
			}else{ //10天后状态更改。。90 ，60-90的习惯养成，30-60的背水一战
				if($rs['pojieshengyuTime']&&$rs['pojieshengyuTime']>0){ 
					$state = calculatePojie($leftTime,$rs['pojieshengyuTime']);
				}
			}
		}		
	}else{
		
		if($leftTime<=$rs['jieseTime']&&$leftTime>$rs['jieseTime']-30){ 
			$state = $rs['state'];
		}
		if($leftTime<=$rs['jieseTime']-30&&$leftTime>$rs['jieseTime']-60){ 
			$state = '信心建立期';
		}
		if($leftTime<=$rs['jieseTime']-60&&$leftTime>$rs['jieseTime']-90){
			$state = '背水一战期';
		}
		if($leftTime<=$rs['jieseTime']-90){ 
			$state = '蜕变成功期';
		} 	
		$groups = changeGroup4($leftTime,$rs['jieseTime']);		
		
		//echo $rs['pojieTime'];
		if($rs['pojieTime']){ //破戒走的是这一套系统
			//echo intval((strtotime($nowtime)-strtotime($rs['pojieTime']))/86400);
			
			if(intval((strtotime($nowtime)-strtotime($rs['pojieTime']))/86400)<11){
				$groups = '破戒反省区'; //10天的破解反省区。
			}else{ //10天后状态更改。。90 ，60-90的习惯养成，30-60的背水一战
				if($rs['pojieshengyuTime']&&$rs['pojieshengyuTime']>0){ 
					$state = calculatePojie($leftTime,$rs['pojieshengyuTime']);
				}
			}
		}
		
		if($leftTime<0){ 
			$expiresClass='expires';
		}				
	}
	if($state=='养生养成期'){ 
		//$state='习惯养成期';
	}	
	if($rs['pojiecishu']){ 
		$hasTime = ceil((strtotime($nowtime)-strtotime($rs['pojieTime']))/86400);
	}else{
		$hasTime = ceil((strtotime($nowtime)-strtotime($rs['luruTime']))/86400)+1;
		//echo '$hasTime'.$hasTime .'<br />';
	}
?>
<tr class="<?=$expiresClass?>">
	<td><a data-id='<?=$rs['id']?>' href="edit.php?id=<?=$rs['id']?>" target="_blank">修改</a> <span style="cursor:pointer" data-id='<?=$rs['id']?>' class="deleteId">删除</span> <a href="pojie.php?id=<?=$rs['id']?>" target="_blank">破戒</a> <a href="userDetailAdd.php?id=<?=$rs['id']?>" class="<?=$hasDec ?>" target="_blank">详细资料添加</a></td>
	<td class="weixinName">
		<span><?=$rs['weixinName']?></span>
		<input type="text" class="modwx" modid="<?=$rs['id']?>" />
		<button class="cgId">提交</button>
	</td><!--微信识别码-->
	<td class="name">
		<span><?=$rs['name']?></span>
		<input type="text" class="modwx" modid="<?=$rs['id']?>" />
		<button class="cgId2">提交</button>
		<button type="button" class="btn <?=$isSexClass?> sex" data-id='<?=$rs['id']?>'><?=$sex ?></button>
	</td><!--微信id-->
	<td><button type="button" class="btn <?=$idhuiClass?> idhui" data-id='<?=$rs['id']?>'><?=$idhui?></button></td>
	<td class="nickName">
		<button type="button" class="btn <?=$isShowClass?> isShowOrNot" data-id='<?=$rs['id']?>'><?=$isShow ?></button>
		<span><?=$rs['nickName']?></span>
		<input type="text" class="modwx" modid="<?=$rs['id']?>" />
		<button class="cgId3">提交</button>		
		
	</td><!--养生榜姓名-->
	<td class="jieseTime"><?=$rs['jieseTime']?></td><!--养生时间-->
	<td class="luruTime"><?=$rs['luruTime']?></td><!--录入时间-->
	<td class="endTime"><?=$rs['endTime']?></td><!--养生到期时间-->
	<td class="leftTime"><?=$leftTime?></td><!--剩余天数-->
	<td class="state"><?=$state?></td><!--所处的状态-->
	<td class="groups"><?=$groups?></td><!--榜单所在区域-->
	<td class="pojieTime">
		<span class="pojieTimeM"><?=$rs['pojieTime']?></span>
		<button class="pojieBt" data-id='<?=$rs['id']?>'>破戒</button></td>
	</td><!--破戒日期-->
	<td class="hasTime"><span><?=$hasTime?></span><input type="text" class="modwx" modid="<?=$rs['id']?>" pojiecishu="<?=$rs['pojiecishu']?>" /><button class="edithastime">提交</button></td><!--已经戒的天数-->
	<td class="pojiecishu"><?=$rs['pojiecishu']?></td><!--破戒次数-->
</tr>

 
<?php 	
	//echo $groups;

	if($saveleftTime!=$leftTime){
		$array1=$array1+1;

		$update1 = $db->query("UPDATE bang SET leftTime = :leftTime WHERE id = :id", array("leftTime"=>$leftTime,"id"=>$rs['id']));	
	}if($savestate!=$state){
		$array2=$array2+1;
		$update2 = $db->query("UPDATE bang SET state = :state WHERE id = :id", array("state"=>$state,"id"=>$rs['id']));
	}if($savegroups!=$groups){	
		$array3=$array3+1;
		$update3 = $db->query("UPDATE bang SET groups = :groups WHERE id = :id", array("groups"=>$groups,"id"=>$rs['id']));	
	}if($savehasTime!=$hasTime){
		$array4=$array4+1;
		$update4 = $db->query("UPDATE bang SET hasTime = :hasTime WHERE id = :id", array("hasTime"=>$hasTime,"id"=>$rs['id']));	
	 }
		

		
	}
	
	
?>
	</tbody>
</table>
<span style="position: absolute; top:0px; right:0px; ">
<?php 
	
	echo $array1;
	 if($array1){ echo "时间已经更新 ,"; }
	 if($array2){ echo "id已经更改 ,";}
	 if($array3){ echo "用户所在榜单区域已经修改 ,";}
	 if($array4){ echo "用户已戒天数更改 ," ;}
?>
</span>

<div class="input-append">
    <input type="text" class="span2 search-query">
        <button type="submit" class="btn">Search</button>
</div>

		<script type="text/javascript">
			Date.prototype.Format = function (fmt) { //author: meizz 
			    var o = {
			        "M+": this.getMonth() + 1, //月份 
			        "d+": this.getDate(), //日 
			        "h+": this.getHours(), //小时 
			        "m+": this.getMinutes(), //分 
			        "s+": this.getSeconds(), //秒 
			        "q+": Math.floor((this.getMonth() + 3) / 3), //季度 
			        "S": this.getMilliseconds() //毫秒 
			    };
			    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
			    for (var k in o)
			    if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
			    return fmt;
			};		
			function decDays(date,days){
				var nd = new Date(date);
				nd = nd.valueOf();
				nd = nd - days * 24 * 60 * 60 * 1000;
				nd = new Date(nd);
				//alert(nd.getFullYear() + "年" + (nd.getMonth() + 1) + "月" + nd.getDate() + "日");
				var y = nd.getFullYear();
				var m = nd.getMonth()+1;
				var d = nd.getDate();
				if(m <= 9) m = "0"+m;
				if(d <= 9) d = "0"+d; 
				var cdate = y+"-"+m+"-"+d;
				return cdate;
			};			
			var browser={ 
				versions:function(){ 
					var u = navigator.userAgent, app = navigator.appVersion; 
					return { //移动终端浏览器版本信息 
						trident: u.indexOf('Trident') > -1, //IE内核 
						presto: u.indexOf('Presto') > -1, //opera内核 
						webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核 
						gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //火狐内核 
						mobile: !!u.match(/AppleWebKit.*Mobile.*/), //是否为移动终端 
						ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端 
						android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android终端或uc浏览器 
						iPhone: u.indexOf('iPhone') > -1 , //是否为iPhone或者QQHD浏览器 
						iPad: u.indexOf('iPad') > -1, //是否iPad 
						webApp: u.indexOf('Safari') == -1 //是否web应该程序，没有头部与底部 
					}; 
				}(), 
				language:(navigator.browserLanguage || navigator.language).toLowerCase() 
			}; 
			seajs.config({
			  alias: {
			    $: 'https://a.alipayobjects.com/jquery/jquery/1.9.1/jquery.js'
			  }
			});	

			seajs.use(['$','https://a.alipayobjects.com/arale/dialog/1.2.6/confirmbox.js'], function($,ConfirmBox) { 
				var parentEle=$('#view-list');
				var elems=parentEle.find(".expires");
				parentEle.append(elems);
				
			/*快速破戒按钮*/
			$('.pojieBt').click(function(){ 
				
				var item = $(this);		
				var endTime1 = item.closest('tr').find('.endTime');
				var pojiecishu1 = item.closest('tr').find('.pojiecishu');
				var pojieshengyuTime1 = item.closest('tr').find('.leftTime');
				var pojieTimeM = item.closest('tr').find('.pojieTimeM');
				var editFix = item.closest('tr').find('.hasTime');

				
				$.extend({ 
	                handleContentType:function(data){
	                    if(data.length && typeof data === "string" ){ 
	                        return $.parseJSON(data);
	                    }
	                    if(typeof data === "object"){ 
	                        return data;
	                    }
	                }
	            })

				$.post("quickpojie.php",{
		    		id:item.attr('data-id'),
		    		endTime:decDays(endTime1.text(),10),
		    		pojiecishu:parseInt(pojiecishu1.text())+1,	    		   					
		    		pojieTime:new Date().Format("yyyy-MM-dd"),
		    		pojieshengyuTime:pojieshengyuTime1.text()		    		
		    	},function(data){

		    		//console.log(data);
					//var data=eval('('+data+')');		



					var data=$.handleContentType(data);	

		    		if(data.state=='sucess'){ 
		    			endTime1.html(data.endTime);
		    			pojiecishu1.html(data.pojiecishu);
		    			pojieshengyuTime1.html(data.pojieshengyuTime);
		    			pojieTimeM.html(data.pojieTime);
		    			editFix.find("span").html('0');
		    			editFix.find(".modwx").attr('pojiecishu',data.pojiecishu);
						//elem.prev().html(data.weixinName);							
					}
				})				
								
			
			})
			
				
			/*更改微信uid*/
				$('.cgId').click(function(){ 
					var elem=$(this).prev();
					$.post("wxidchange.php",{
			    		id:elem.attr('modid'),		
						wxId:elem.val()
			    	},function(data){
						var data=eval('('+data+')');
			    		if(data.state=='sucess'){ 
							elem.prev().html(data.weixinName);							
						}
					})				
				
				})

			/*更改微信id*/
				$('.cgId2').click(function(){ 
					var elem=$(this).prev();
					$.post("wxnamechange.php",{
			    		id:elem.attr('modid'),		
						wxName:elem.val()
			    	},function(data){
						var data=eval('('+data+')');
			    		if(data.state=='sucess'){ 
							elem.prev().html(data.weixinName);							
						}
					})				
				
				})
	
			/*更改养生榜姓名*/
				$('.cgId3').click(function(){ 
					var elem=$(this).prev();
					$.post("nicknamechange.php",{
			    		id:elem.attr('modid'),		
						nickname:elem.val()
			    	},function(data){
						var data=eval('('+data+')');
			    		if(data.state=='sucess'){ 
							elem.prev().html(data.nickName);							
						}
					})				
				
				})
				
				
				/*id会会员设置*/
				$('.idhui').click(function(){ 
					var elem=$(this);
					var state;
					if(elem.hasClass('btn-default')){ 
						elem.removeClass('btn-default');
						elem.addClass('btn-info');
						state=1;					
					}else{ 
						elem.removeClass('btn-info');
						elem.addClass('btn-default');

						state=0;
					}
					
					$.post("idhuistate.php",{
			    		id:elem.attr('data-id'),
						state:state
			    	},function(data){
						if(data==1){ 
							elem.html("是");							
						}else if(data==0){ 
							elem.html("否");							
						}
						
					})			
				})					

				/*是否显示在养生榜单上*/
				$('.isShowOrNot').click(function(){ 
					var elem=$(this);
					var state;
					if(elem.hasClass('btn-default')){ 
						elem.removeClass('btn-default');
						elem.addClass('btn-danger');
						state=1;//状态为1，显示隐藏				
					}else{ 
						elem.removeClass('btn-danger');
						elem.addClass('btn-default');

						state=0;//状态为0, 表示显示在养生榜单上
					}
					
					$.post("isShowState.php",{
			    		id:elem.attr('data-id'),
						state:state
			    	},function(data){
						if(data==1){ 
							elem.html("不显示");							
						}else if(data==0){ 
							elem.html("显示");							
						}
						
					})			
				})					
				
				$('.sex').click(function(){
					var elem=$(this);
					var state;
					if(elem.hasClass('btn-default')){ 
						elem.removeClass('btn-default');
						elem.addClass('btn-danger');
						state=1;//状态为1，显示隐藏				
					}else{ 
						elem.removeClass('btn-danger');
						elem.addClass('btn-default');
						state=0;//状态为0, 表示显示在养生榜单上
					}
					
					$.post("isSexState.php",{
			    		id:elem.attr('data-id'),
						state:state
			    	},function(data){
						if(data==1){ 
							elem.html("女");							
						}else if(data==0){ 
							elem.html("男");							
						}
						
					})			
				})					
				
				
				$('.edithastime').click(function(){ 
					var elem=$(this).prev();
					if(!elem.val()){ 
						alert("不能为空");
					}else{
						$.post("hastimechange.php",{
				    		id:elem.attr('modid'),		
							inputhastime:elem.val(),
							pojiecishu:elem.attr('pojiecishu')
				    	},function(data){
							//console.log(data);
							var data=eval('('+data+')');
				    		if(data.state=='sucess'){ 
								elem.prev().html(data.inputhastime);						
								if(data.pojiecishu){ 
									elem.attr("pojiecishu",data.pojiecishu);		
									elem.parent().prev().find(".pojieTimeM").html(data.pojietime);
									elem.parent().next().html(data.pojiecishu);
								}
							}

						})
					}	
				})
				
				/*id会会员设置*/
				$(document).keypress(function(event){  
					if($('.arale-dialog-1_2_6').is(':visible')){	
					    var keycode = (event.keyCode ? event.keyCode : event.which);  
					    if(keycode == '13'||keycode=='32'){  
					       	$('.arale-dialog-1_2_6').remove(); 
					    }  
					}
				});  

				$('.deleteId').click(function(){ 
					//console.log($(this).attr('data-id'));
					var elem=$(this);
			    	var cb = new ConfirmBox({
				        trigger: '#dialog',
				        title: '成功提示',
				        message: "<div>确认删除？</div>",
				        confirmTpl: '<button class="ui-dialog-button-orange">确定</button>',
				        cancelTpl: '<button>取消</button>',
				        onConfirm:function(){ 
							var self=this;
							$.post("deleteId.php",{
					    		id:elem.attr('data-id')					
					    	},function(data){
					    		if(data=='sucess'){ 
								    elem.closest('tr').slideUp();
									
					    		}
					    		self.hide();
					    	})				        	

				        }

			    	}).show();					
					

				});
				if(browser.versions.android){
					$('#search-box').hammer({}).bind('tap',function(ev){ 
						var val=$(this).val()
						var reg= new RegExp(val,'g');
						
						$('#view-list').find('.nickName').each(function(i,obj){ 
							//$(obj).html($(obj).html().replace(/(\s*)/g, ""));
							var elem=$(obj).html();
							var elemId=$(obj).prev().prev().html();
							var parenLi=$(obj).closest('tr');
							if(!reg.test(elem)){ 
								if(!reg.test(elemId)){
									parenLi.hide();
								}
							}else{ 
								parenLi.show();
							}
						})
						//$(this).val(val);								
						
					});
					$('#search-box').keyup(function(){ 

						var val=$(this).val()
						var reg= new RegExp(val,'g');
						
						$('#view-list').find('.nickName').each(function(i,obj){ 
							//$(obj).html($(obj).html().replace(/(\s*)/g, ""));
							var elem=$(obj).html();
							var elemId=$(obj).prev().prev().html();
							var parenLi=$(obj).closest('tr');
							if(!reg.test(elem)){ 
								if(!reg.test(elemId)){
									parenLi.hide();
								}
							}else{ 
								parenLi.show();
							}
						})
						//$(this).val(val);					

					});					
				}else{				
					$('#search-box').keyup(function(){ 

						var val=$(this).val()
						var reg= new RegExp(val,'g');
						
						$('#view-list').find('.nickName').each(function(i,obj){ 
							//$(obj).html($(obj).html().replace(/(\s*)/g, ""));
							var elem=$(obj).html();
							var elemId=$(obj).prev().prev().html();
							var parenLi=$(obj).closest('tr');
							if(!reg.test(elem)){ 
								if(!reg.test(elemId)){
									parenLi.hide();
								}
							}else{ 
								parenLi.show();
							}
						})
						//$(this).val(val);					

					});
				}


			});
			
		</script>

	</body>
	
</html>
