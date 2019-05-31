
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<title>用户详细资料</title>
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
<h1>修改资料</h1>
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
			    <label for="declaration" class="input-group-addon">养生宣言</label>
			    <input type="text" class="form-control" id="declaration" value="<?=$person['declaration']?>"/>
			  </div>			  
			  <!--
			  <div class="input-group">
			    <label for="peopleWeight" class="input-group-addon">体重</label>
			   	<input id="peopleWeight" type="text" class="form-control"  />
			  </div>
			  <div class="input-group">
			    <label for="peopleOld" class="input-group-addon">年龄</label>
			   	<input id="peopleOld" type="text" class="form-control"  />
			  </div>			  			  
			  <div class="input-group">
			    <label for="peopleState" class="input-group-addon">上学or工作</label>
			    <select Id="peopleState" class="form-control">
			    	<option>上学</option>
			    	<option>工作</option>
			    </select>			    
			  </div>
			  <div class="input-group">
			    <label for="peopleJob" class="input-group-addon">职业或者学历</label>
			   	<input id="peopleJob" type="text" class="form-control"  />
			  </div>	
			  <div class="input-group">
			    <label for="peopleIll" class="input-group-addon">症状</label>
			   	<input id="peopleIll" type="text" class="form-control"  />
			  </div>			  
			  -->
			  <button type="button" class="btn btn-default" id="submitBtn">Submit</button>
			</form>

		<script type="text/javascript">
			seajs.config({
			  alias: {
			    $: 'https://a.alipayobjects.com/jquery/jquery/1.9.1/jquery.js'
			  }
			});

			seajs.use(['$','https://a.alipayobjects.com/arale/dialog/1.2.6/confirmbox.js'], function($,ConfirmBox) {
   
				$(document).keypress(function(event){  
					if($('.arale-dialog-1_2_6').is(':visible')){	
					    var keycode = (event.keyCode ? event.keyCode : event.which);  
					    if(keycode == '13'||keycode=='32'){  
					       	$('.arale-dialog-1_2_6').remove(); 
					    }  
					}
				});  

			    $('#submitBtn').click(function(){
			    	

				    	$.post("userDetailUp.php",{
				    		id:$('#weixinName').attr('pubId'),
							declaration:$('#declaration').val()
				    		//peopleHeight:$('#peopleHeight').val(),
				    		//peopleWeight:$('#peopleWeight').val(),
				    		//peopleOld:$('#peopleOld').val(),
				    		//peopleState:$('#peopleState').val(),
				    		//peopleJob:$('#peopleJob').val(),
				    		//peopleIll:$('#peopleIll').val()
						
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
