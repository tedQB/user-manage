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
	<link rel="stylesheet" href="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://a.alipayobjects.com/arale/calendar/1.0.0/calendar.css">	
	<link charset="utf-8" rel="stylesheet" href="https://a.alipayobjects.com/arale/dialog/1.2.6/dialog.css" />	
	<script type="text/javascript" src="https://a.alipayobjects.com/seajs/seajs/2.2.0/sea.js"></script>
	<script type="text/javascript" src="https://a.alipayobjects.com/seajs/seajs-style/1.0.2/seajs-style.js"></script>
	<script type="text/javascript" src="http://www.jiese360.cn/js/hammer.js"></script>	
	<style type="text/css">
		.input-group{margin:5px 0;}
		#search-box{ background:url(http://code.jquery.com/mobile/1.0a3/images/icon-search-black.png) 12px 8px no-repeat; padding-left: 38px; margin-bottom: 10px;  }
		.weixinName span{ display:block; }
		.hasTime span{ display:block;  }
		.hasTime input{ width:50px; }
	</style>
</head>
	<body>		
<h1><a href="add.php">添加</a></h1>
<input type="text" class="form-control" placeholder="Text input" id="search-box">
<table class="table table-bordered">
	<thead>
		<tr>
			<td>操作</td>
			<td style="width:230px">微信Id</td>
			<td>本人姓名</td>
			<td style="width:50px">是否为Id会成员</td>
			<td>养生榜姓名</td>
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

  function changeGroups($leftTime){ 
	$groupst = '';

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
  
  function calculatePojie($leftTime,$pojieshengyuTime){
	//echo $leftTime;
	//echo $pojieshengyuTime;
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
  };

  $persons = $db->query("SELECT * FROM bang where leftTime<=0 ORDER BY id desc");

foreach ($persons as $key => $rs) {

	$leftTime = intval((strtotime($rs['endTime']) - strtotime($nowtime))/86400);
	$saveleftTime = $rs['leftTime'];
	$state = $rs['state'];
	$savestate = $rs['state'];
	$groups = $rs['groups'];
	$savegroups = $rs['groups'];
	$idhui = $rs['idhui'];
	$savehasTime =$rs['hasTime'];
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
	}
	if($state=='养生养成期'){ 
		//$state='习惯养成期';
	}	
	if($rs['pojiecishu']){ 
		$hasTime = intval((strtotime($nowtime)-strtotime($rs['pojieTime']))/86400)+1;
	}else{
		$hasTime = intval((strtotime($nowtime)-strtotime($rs['luruTime']))/86400)+1;
	}
?>
<tr class="<?=$expiresClass?>">
	<td><a data-id='<?=$rs['id']?>' href="edit.php?id=<?=$rs['id']?>" target="_blank">修改</a> <a href="#" data-id='<?=$rs['id']?>' class="deleteId">删除</a> <a href="pojie.php?id=<?=$rs['id']?>" target="_blank">破戒</a> <a href="userDetailAdd.php?id=<?=$rs['id']?>" target="_blank">详细资料添加</a></td>
	<td class="weixinName"><span><?=$rs['weixinName']?></span><input type="text" class="modwx" modid="<?=$rs['id']?>" /><button class="cgId">提交</button></td>
	<td class="name"><?=$rs['name']?></td>
	<td><button type="button" class="btn <?=$idhuiClass?> idhui" data-id='<?=$rs['id']?>'><?=$idhui?></button></td>
	<td class="nickName"><?=$rs['nickName']?></td>
	<td class="jieseTime"><?=$rs['jieseTime']?></td>
	<td class="luruTime"><?=$rs['luruTime']?></td>
	<td class="endTime"><?=$rs['endTime']?></td>
	<td class="leftTime"><?=$leftTime?></td>
	<td class="state"><?=$state?></td>
	<td class="groups"><?=$groups?></td>
	<td class="pojieTime"><?=$rs['pojieTime']?></td>
	<td class="hasTime"><span><?=$hasTime?></span><input type="text" class="modwx" modid="<?=$rs['id']?>" pojiecishu="<?=$rs['pojiecishu']?>" /><button class="edithastime">提交</button>
	<td class="pojiecishu"><?=$rs['pojiecishu']?></td>		
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

<div class="input-append"> 
    <input type="text" class="span2 search-query">
        <button type="submit" class="btn">Search</button>
</div>

		<script type="text/javascript">
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
			} 
			seajs.config({
			  alias: {
			    $: 'https://a.alipayobjects.com/jquery/jquery/1.9.1/jquery.js'
			  }
			});	

			seajs.use(['$','https://a.alipayobjects.com/arale/dialog/1.2.6/confirmbox.js'], function($,ConfirmBox) { 
			/*到期后置*/
				(function($, Hammer, dataAttr) {
					function hammerify(el, options) {
						var $el = $(el);
						if(!$el.data(dataAttr)) {
							$el.data(dataAttr, new Hammer($el[0], options));
						}
					}

					$.fn.hammer = function(options) {
						return this.each(function() {
							hammerify(this, options);
						});
					};

					// extend the emit method to also trigger jQuery events
					Hammer.Manager.prototype.emit = (function(originalEmit) {
						return function(type, data) {
							originalEmit.call(this, type, data);
							jQuery(this.element).triggerHandler({
								type: type,
								gesture: data
							});
						};
					})(Hammer.Manager.prototype.emit);
				})(jQuery, Hammer, "hammer");					
				
				var parentEle=$('#view-list');
				var elems=parentEle.find(".expires");
				parentEle.append(elems);
			/*到期后置*/
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
				
				$('.edithastime').click(function(){ 
					var elem=$(this).prev();
					if(!elem.val()){ 
						alert("不能为空");
					}
					$.post("hastimechange.php",{
			    		id:elem.attr('modid'),		
						inputhastime:elem.val(),
						pojiecishu:elem.attr('pojiecishu')
			    	},function(data){
						//console.log(data);
						var data=eval('('+data+')');
			    		if(data.state=='sucess'){ 
							elem.prev().html(data.inputhastime);							
						}
					})	
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
					$.post("deleteId.php",{
			    		id:elem.attr('data-id')					
			    	},function(data){
			    		if(data=='sucess'){ 
						    elem.closest('tr').slideUp();
					    	var cb = new ConfirmBox({
						        trigger: '#dialog',
						        title: '成功提示',
						        message: "<div>删除成功</div>",
						        confirmTpl: '<button class="ui-dialog-button-orange">确定</button>',
						        cancelTpl: '<button>取消</button>',
						        onConfirm:function(){ 
						        	this.hide();

						        }

					    	}).show();
			    		}
			    	})
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
