<?php  
	session_start(); 
	if(!isset($_SESSION['username'])){
		header("Location:login.html");
		exit();
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<title>破戒</title>
	<link rel="stylesheet" href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://a.alipayobjects.com/arale/calendar/1.0.0/calendar.css">	
	<link charset="utf-8" rel="stylesheet" href="https://a.alipayobjects.com/arale/dialog/1.2.6/dialog.css" />	
	<script type="text/javascript" src="https://a.alipayobjects.com/seajs/seajs/2.2.0/sea.js"></script>
	<script type="text/javascript" src="https://a.alipayobjects.com/seajs/seajs-style/1.0.2/seajs-style.js"></script>
	<style type="text/css">
		.input-group{margin:5px 0;}
	</style>

</head>
	<body>	
<h1>破戒记录</h1>
<form role="form" method="post" id="test-form">
<?php
  require_once("easyCRUD/easyCRUD.class.php");
  require_once("Db.class.php");
  $db = new Db();

  $id=$_GET['id'];

  $person = $db->row("SELECT * FROM bang WHERE id=:id",array("id"=>$id));


  ?>		
	
			  <div class="input-group">
			    <label for="weixinName" class="input-group-addon">微信Id</label>
			    <input type="text" class="form-control" id="weixinName" value="<?=$person['weixinName']?>" pubId='<?=$id?>'/>
			  </div>
			  <div class="input-group" class="input-group-addon">
			    <label for="name" class="input-group-addon">本人姓名</label>
			   	<input type="text" class="form-control" id="name" value="<?=$person['name']?>" />
			  </div>
			  <div class="input-group">
			    <label for="nickName" class="input-group-addon">养生榜姓名</label>
			    <input type="text" class="form-control" id="nickName" value="<?=$person['nickName']?>" />
			  </div>
			  <div class="input-group">
			    <label for="luruTime" class="input-group-addon">录入时间</label>
			   	<input id="luruTime" type="text" placeholder="录入时间" class="form-control" value="<?=$person['luruTime']?>" />
			  </div>
			  <div class="input-group">
			    <label for="jieseTime" class="input-group-addon">养生天数</label>
			    <input type="text" class="form-control" id="jieseTime" placeholder="养生天数" value="<?=$person['jieseTime']?>" />
			  </div>
			  <div class="input-group">
			    <label for="endTime" class="input-group-addon">养生结束时间</label>
			    <input type="text" class="form-control" id="endTime" placeholder="养生结束时间" value="<?=$person['endTime']?>" />
			  </div>		
			  <div class="input-group">
			    <label for="leftTime" class="input-group-addon">剩余天数</label>
			   	<input id="leftTime" type="text" placeholder="剩余天数" class="form-control" value="<?=$person['leftTime']?>" />
			  </div>		  
			  <div class="input-group">
			    <label for="pojiecishu" class="input-group-addon">破戒次数</label>
			   	<input id="pojiecishu" type="text" placeholder="破戒次数" class="form-control" value="<?=$person['pojiecishu']?>"/>
			  </div>			  	  
			  <div class="input-group">
			    <label for="pojieTime" class="input-group-addon">破戒日期</label>
			   	<input id="pojieTime" type="text" placeholder="破戒日期" class="form-control"  value="" /> 
			   	<span>上一次破戒时间：<?=$person['pojieTime']?></span>
			  </div>
 			  <div class="input-group">
			    <label for="pojieshengyuTime" class="input-group-addon">破戒之后的天数</label>
			   	<input id="pojieshengyuTime" type="text" placeholder="扣除10天之后的天数" class="form-control"  value="<?=$person['pojieshengyuTime']?>"/>
			  </div>				  
 									  			  
			  <button type="button" class="btn btn-default" id="submitBtn">Submit</button>
			</form>
		<script type="text/javascript">
			seajs.config({
			  alias: {
			    $: 'https://a.alipayobjects.com/jquery/jquery/1.9.1/jquery.js'
			  }
			});
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

			seajs.use(['$','https://a.alipayobjects.com/arale/calendar/1.0.0/calendar.js','https://a.alipayobjects.com/arale/dialog/1.2.6/confirmbox.js'], function($,Calendar,ConfirmBox) {
			    new Calendar({trigger: '#pojieTime'});
			    //计算到期时间		    
			    $('#pojieshengyuTime').focusout(function(){
			    	
			    	var leftTime = $('#leftTime').val();

			    	$('#pojieshengyuTime').val(leftTime-10)

			    	//$('#endTime').val(decDays(endTime,10));

			    })
			    //console.log(Dialog);
 
				$(document).keypress(function(event){  
					if($('.arale-dialog-1_2_6').is(':visible')){	
					    var keycode = (event.keyCode ? event.keyCode : event.which);  
					    if(keycode == '13'||keycode=='32'){  
					       	$('.arale-dialog-1_2_6').remove(); 
					    }  
					}
				});  
				
			    $('#submitBtn').click(function(){

			    	if(confirmForm()){
						var endTime = new Date($('#endTime').val());
			    		endTime = decDays(endTime,10);

				    	$.post("pojieUp.php",{
				    		id:$('#weixinName').attr('pubId'),
				    		endTime:endTime,
				    		pojiecishu:$('#pojiecishu').val(),
				    		pojieTime:$('#pojieTime').val(),
				    		pojieshengyuTime:$('#pojieshengyuTime').val()
						
				    	},function(data){
						
				    		if(data=='sucess'){ 
						    	var cb = new ConfirmBox({
							        trigger: '#dialog',
							        title: '成功提示',
							        message: "<div>添加成功</div>",
							        confirmTpl: '<button class="ui-dialog-button-orange">确定</button>',
							        cancelTpl: '<button>取消</button>',
							        onConfirm:function(){ 
							        	this.hide();
							        }

						    	}).show();
				    		}


				    	})
			    	}
			    })
				function confirmForm(){ 
					var err=[];
			    	$('.form-control').each(function(index,obj){ 
			    		if($(obj).val()==''){ 
						    err.push($(obj));
						    return false; 
			    		}
			    	})

			    	if(err.length){
				    	var cb = new ConfirmBox({
					        trigger: '#dialog',
					        title: '出错提示',
					        message: "<div>"+err[0].attr('id')+"不能为空</div>",
					        confirmTpl: '<button class="ui-dialog-button-orange">确定</button>',
					        cancelTpl: '<button>取消</button>',
					        onConfirm:function(){ 
					        	this.hide();
					        }					        
				    	}).show();
					}else{ 
						return true; 
					}
			    	
				};

			});
		</script>	
	</body>
	
</html>
