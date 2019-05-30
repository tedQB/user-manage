
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, user-scalable=0, width=device-width"/>
	<meta name="format-detection" content="telephone=no"/>
	<title>小戒id会推荐导师</title>
	<link rel="stylesheet" href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css">
	<link charset="utf-8" rel="stylesheet" href="https://a.alipayobjects.com/arale/dialog/1.2.6/dialog.css" />	
</head>
	<body>		
<!--
<input type="text" class="form-control" placeholder="查找您的名称" id="search-box">
-->
<p>下面是由小戒精挑细选的vip导师，于节假日期间开放，请大家踊跃添加</p>
<table class="table table-bordered">
	<thead>
		<tr>
			<td>Id</td>
			<td>姓名</td>
			<td></td>
		</tr>
	</thead>
	<tbody id="view-list">
<?php
  require_once("easyCRUD/easyCRUD.class.php");
  require_once("Db.class.php");
  $db = new Db();

  $persons = $db->query("SELECT * FROM bang where idhui=1 ORDER BY id desc");	
  foreach ($persons as $key => $rs) {
  
	$state = $rs['state'];
	$groups = $rs['groups'];
	$idhui = $rs['idhui'];
?>

<tr class="<?=$expiresClass?>">
	<td class="name">微信Id：<?=$rs['name']?></td>
	<td class="nickName">导师戒色榜单名称：<?=$rs['nickName']?></td>	
	<td>添加注明：小戒推荐学员</td>
</tr>


<?php	

  }

?>
	</tbody>
</table>
<p>也想成为id会小戒推荐导师吗？点击<a href="http://mp.weixin.qq.com/s?__biz=MjM5ODMyMTI2MA==&mid=10000194&idx=1&sn=12d4e637d78058f5cccc2b69c06c50ec#rd">我也想成为导师</a>进行了解吧</p>
		<script type="text/javascript">
		  function IsPC() 
		   { 
			   var userAgentInfo = navigator.userAgent; 
			   var Agents = new Array("Android", "iPhone", "SymbianOS", "Windows Phone", "iPad", "iPod"); 
			   var flag = true; 
			   for (var v = 0; v < Agents.length; v++) { 
				   if (userAgentInfo.indexOf(Agents[v]) > 0) { flag = false; break; } 
			   } 
			   return flag; 
		   } 		
			function loadjscssfile(filename,filetype){

				if(filetype == "js"){
					var fileref = document.createElement('script');
					fileref.setAttribute("type","text/javascript");
					fileref.setAttribute("src",filename);
				}else if(filetype == "css"){
				
					var fileref = document.createElement('link');
					fileref.setAttribute("rel","stylesheet");
					fileref.setAttribute("type","text/css");
					fileref.setAttribute("href",filename);
				}
			   if(typeof fileref != "undefined"){
					document.getElementsByTagName("head")[0].appendChild(fileref);
				}
			}	
		
		</script>

	</body>
	
</html>
