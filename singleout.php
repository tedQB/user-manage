
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
	<style type="text/css">
		.input-group{margin:5px 0;}
		#search-box{ background:url(http://code.jquery.com/mobile/1.0a3/images/icon-search-black.png) 12px 8px no-repeat; padding-left: 38px; margin-bottom: 10px;  }
	</style>
</head>
	<body>		
<h1>展示</h1>
<input type="text" class="form-control" placeholder="Text input" id="search-box">
<table class="table table-bordered">
	<thead>
		<tr>
			<td>微信Id</td>
			<td>本人姓名</td>
			<td>养生榜姓名</td>
			<td>身高</td>
			<td>体重</td>
			<td>上学or工作</td>
			<td>年龄</td>
			<td>职业专业</td>
			<td>身体异样</td>
		</tr>
	</thead>
	<tbody id="view-list">
<?php
  require_once("easyCRUD/easyCRUD.class.php");
  require_once("Db.class.php");
  $db = new Db();
  $nowtime=date("Y-m-d");



  $persons = $db->query("SELECT * FROM bang ORDER BY id desc");

  foreach ($persons as $key => $rs) {

 

?>
	<tr>
		<td class="weixinName"><?=$rs['weixinName']?></td>
		<td class="name"><?=$rs['name']?></td>
		<td class="nickName"><?=$rs['nickName']?></td>		
		<td class="peopleWeight"><?=$rs['peopleWeight']?></td>
		<td class="peopleHeight"><?=$rs['peopleHeight']?></td>
		<td class="peopleState"><?=$rs['peopleState']?></td>
		<td class="peopleOld"><?=$rs['peopleOld']?></td>
		<td class="peopleJob"><?=$rs['peopleJob']?></td>
		<td class="peopleIll"><?=$rs['peopleIll']?></td>	
	</tr>
<?php 
	}
?>
	</tbody>
	</table>
		<script type="text/javascript">
			seajs.config({
			  alias: {
			    $: 'https://a.alipayobjects.com/jquery/jquery/1.9.1/jquery.js'
			  }
			});	

			seajs.use(['$','https://a.alipayobjects.com/arale/dialog/1.2.6/confirmbox.js'], function($,ConfirmBox) { 
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

				})					

			})
		</script>

	</body>
	
</html>
