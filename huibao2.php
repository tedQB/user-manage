<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, user-scalable=0, width=device-width"/>
	<meta name="format-detection" content="telephone=no"/>
	<title>每日汇报(试运营)</title>
	<link rel="stylesheet" href="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/css/bootstrap.min.css">
	<script type="text/javascript" src="https://a.alipayobjects.com/seajs/seajs/2.2.0/sea.js"></script>
	<script type="text/javascript" src="http://www.jiese360.cn/jiesebang/ZeroClipboard.js"></script>	
	<style type="text/css">
		body,ol,ul,h1,h2,h3,h4,h5,h6,p,th,td,dl,dd,form,fieldset,legend,input,textarea,select,label{margin:0;padding:0}
		body{font:12px "黑体","Arial Narrow",HELVETICA;background:#fff;-webkit-text-size-adjust:; }
		li{list-style:none}
		html{-webkit-text-size-adjust:;}		
		.input-group label{ line-height:30px; font-size:16px;  }
		.input-group .form-control{ font-size:12px; }
		#out{ padding:10px; border:1px solid #999; border-radius:5px; font-size:18px;  margin:10px 0 0 5px; }
		body{ padding:5px;  padding-bottom:40px;}
		#control{ margin-top:10px; }
		#control2{ font-size:14px; display:block; line-height:30px; -webkit-user-select: none;-khtml-user-select: none; user-select: none;}
		#tuiguang{ font-size:14px; color:#333; margin-top:5px; display:none; }
	</style>
</head>
	<body>		
		<div>
		  <div class="input-group">
			<label for="">1.今天我是否接触了黄源(黄色信息，视频，图片，文字)？若接触了？接触多长时间[负能量]？</label>
			<input type="text" class="form-control" id="" placeholder="请如实回答" style="width:100%" />
		  </div>
		</div>
		<div>
		  <div class="input-group">
			<label for="">2.今天是否意淫？意淫了多长时间？性幻想有哪些内容？[负能量]</label>
			<input type="text" class="form-control" id="" placeholder="请如实回答" />
		  </div>		
		</div>
		<div>
		  <div class="input-group">
			<label for="">3.今天我是否成功阻止了自己沉沦在黄源里？若成功，用了什么方法？没有成功导致破戒，是什么原因？有没有遵守【2倍法则】</label>
			<input type="text" class="form-control" id="" placeholder="【2倍法则】我接收了10分钟的负能量；那我就必须去主动做20分钟的正能量的事情，去抵消这个负能量。" />
		  </div>					
		 </div>		
		<div>
		  <div class="input-group">
			<label for="">4.今天有无特别大的挫折感和痛苦？是因为什么事情？生活遇到挫折是好事情，证明你在成长，通过思考和行动解决它就OK</label>
			<input type="text" class="form-control" id="" placeholder="天天无所事事，空虚无聊那才是最危险的。" />
		  </div>					
		 </div>		
		<div>
		  <div class="input-group">
			<label for="">5.我今天是否做了四大锻炼?做了多长时间？</label>
			<input type="text" class="form-control" id="" placeholder="身体和心理同时坚固，才能戒的快，恢复的快。" style="width:100%; "/>
		  </div>					
		 </div>				
		<div>
		  <div class="input-group">
			<label for="">6.今天有可以分享的戒色/生活/学习/工作感悟吗，或者我今天看到，接触了什么新的事和物让我有心得体会？</label>
			<input type="text" class="form-control" id="" placeholder="若没有，你证明你今天过的一点都没有积累" />
		  </div>				
		</div>
		<div>
		  <div class="input-group">
			<label for="">7.今天是否想看了戒色文章，是否帮助了别人，为戒色事业做了贡献？是否听闻，接触了正能量的事情，是否展示了自己的正能量？</label>
			<input type="text" class="form-control" id="" placeholder="一切能够推动社会进步，能够照亮人心，让别人主动感恩的的事情都叫正能量" />
		  </div>				
		</div>			
		<button type="button" class="btn btn-danger" id="control">生成戒色日报</button>
		<span id="control2" style="display:none; color:red; ">请手动复制以下日报，帮助小戒顶贴一次，然后发微信给小戒</span>
		<div id="out">
			
		</div>
	</body>
	<script>
	seajs.config({
	  alias: {
		Z: 'https://a.alipayobjects.com/jquery/jquery/1.9.1/jquery.js'
	  }
	});
	seajs.use(['Z','http://style.aliexpress.com/js/6v/lib/gallery/store/store.js'], function(Z,store) {
		
		Z('.form-control').each(function(i,obj){ 
			var key='key'+(i+1);
			Z(obj).val(store.get(key));		
		})
		
		Z('#control').click(function(){ 
			Z("#out").empty();
			Z("#control2").show();
			Z("#tuiguang").show();
			Z('.form-control').each(function(i,obj){
				var other = Z(obj).val();
				var key='key'+(i+1);
				store.set(key,other);
				if(other){
					Z("#out").append('<div>'+(i+1)+'.'+other+'</div>');
				}
				else{ 
					Z("#out").append('<div>'+(i+1)+'.无'+'</div>');
				}
			});
			Z("#out").append("<div><a href='http://url.cn/JAT4kI'> 顶贴地址http://url.cn/JAT4kI</a></div>");
		});
		
	})		
	</script>
</html>
