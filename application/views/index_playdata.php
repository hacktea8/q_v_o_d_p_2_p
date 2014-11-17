<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>影片播放</title>
<script>
var cdn_url = '';
</script>
</head>
<body>
<?php if(in_array($sid,array(8))){?>
<div id="a1"></div>
<script type="text/javascript" src="<?php echo $cdn_url;?>/public/ckplayer/ckplayer.js" charset="utf-8"></script>
<script type="text/javascript">
function loadedHandler(){
 //alert('加载已完成')
}
var flashvars={
f:'/videos/iqiyixml/iqy/<?php echo $playInfo['url'];?>',
s:2,
loaded:'loadedHandler',
};
var params={bgcolor:'#FFF',allowFullScreen:true,allowScriptAccess:'always',wmode:'transparent'};
CKobject.embedSWF('<?php echo $cdn_url;?>/public/ckplayer/ckplayer.swf','a1','ckplayer_a1','690','550',flashvars,params);
</script>
<?php }else if(in_array($sid,array(7))){?>
<div id="movieid">
 <embed src="/public/player/youku/loader.swf?VideoIDS=<?php echo $playInfo['url'];?>&amp;isAutoPlay=true" type="application/x-shockwave-flash" width="100%" height="550" align="middle" allowFullScreen="true" quality="high" allowScriptAccess="always"/>
</div>
<div id="maskvid" onclick="return false;" style="display:none;position: absolute;"></div>
<script>
window.setTimeout("maskdiv('movieid')", 3000);
function maskdiv(objid){
 obj = document.getElementById(objid);
 opt = document.getElementById('maskvid');
 _top = obj.offsetHeight;
 _lft = obj.offsetWidth;
 _optW = 105;_optH=36;
 opt.style.display = "block";
 opt.style.left = _lft-_optW-5+"px";
 opt.style.top = _top-_optH+"px";
 opt.style.width = _optW+'px';
 opt.style.height = _optH+'px';
}
</script>
<?php }else if(in_array($sid,array(9))){?>
<script type="text/javascript" src="<?php echo $cdn_url;?>/public/cmp4/cmp.js" charset="utf-8"></script>
<div style="height:550px;" class="player" id="player">
</div>
<script type="text/javascript">
var flashvars = {
 name : "CMP4",
 skin : "skins/mini/vplayer.zip",
 lists : "<?php echo $playInfo['url'];?>"
};
var htm = CMP.create("cmp", "100%", "100%", cdn_url+"/public/cmp4/cmpn.swf",flashvars);
document.getElementById("player").innerHTML = htm;
</script>
<?php }else if(in_array($sid,array(5))){?>
<script language="javascript">
var XgPlayer = {
'Url': "<?php echo $playInfo['url'];?>", //本集播放地址，需更改
'NextcacheUrl': "<?php echo $playInfo['nexturl'];?>", //缓冲下一集，需更改
'LastWebPage': '<?php echo $playInfo['pre'];?>',
'NextWebPage': "<?php echo $playInfo['next'];?>", //下一集播放页面地址，需更改
'Buffer': '/public/player/xigua/xg_loading.html', // 播缓冲AD，需更改
'Pase': '/public/player/xigua/xg_loading.html', // 暂停AD，需更改
'Width': 690, // 播放器显示宽度
'Height': 550, // 播放器显示高度
'Second': 8, // 缓冲时间
"Installpage":'http://static.xigua.com/installpage.html'
};
document.write('<script language="javascript" src="http://static.xigua.com/xiguaplayer.js?'+new Date().getTime()+'" charset="utf-8"><\/script>');
</script>
<?php }elseif(in_array($sid,array(20))){ ?>
<script language="javascript">
var BdPlayer = new Array();
BdPlayer['time'] = 8;//缓冲广告展示时间(如果设为0,则根据缓冲进度自动控制广告展示时间)
BdPlayer['buffer'] = '/public/player/bdhd/bd_loading.html';//贴片广告网页地址
BdPlayer['pause'] = '/public/player/bdhd/bd_loading.html';//暂停广告网页地址
BdPlayer['end'] = '/public/player/bdhd/bd_loading.html';//影片播放完成后加载的广告
BdPlayer['tn'] = '12345678';//播放器下载地址渠道号
BdPlayer['width'] = 690;//播放器宽度(只能为数字)
BdPlayer['height'] = 550;//播放器高度(只能为数字)
BdPlayer['showclient'] = 1;//是否显示拉起拖盘按钮(1为显示 0为隐藏)
BdPlayer['url'] = '<?php echo $playInfo['url'];?>';//当前播放任务播放地址
BdPlayer['nextcacheurl'] = '<?php echo $playInfo['nexturl'];?>';//下一集播放地址(没有请留空)
BdPlayer['lastwebpage'] = '<?php echo $playInfo['pre'];?>';//上一集网页地址(没有请留空)
BdPlayer['nextwebpage'] = '<?php echo $playInfo['next'];?>';//下一集网页地址(没有请留空)
</script>
<script language="javascript" src="<?php echo $cdn;?>/public/js/bdplayer.js" charset="utf-8"></script>
<?php }elseif(in_array($sid,array(1,2))){ ?>
<script type="text/javascript">
var qvod_setup = 1;
var qvod_url = "<?php echo $playInfo['url'];?>";
var qvod_next_page = "";
var pWidth = '690px';
var pHeight = '550px';
function QvodInstall(){
 qvod_setup = 0;
 if(!qvod_setup){
  qvod_html = '<iframe id="iframe_down" name="iframe_down" scrolling="no" frameborder="0" style="position:absolute; z-index:1; top:0; margin: 0;width: '+pWidth+'; height: '+pHeight+';" src="/public/player/qvod/install.html"></iframe>';
 }
 document.body.innerHTML=qvod_html;
}
var qvod_html='<object id="QvodPlayer" name="QvodPlayer" width="'+pWidth+'" height="'+pHeight+'" onerror="QvodInstall();"  classid="clsid:F3D0D36F-23F8-4682-A195-74C92B03D4AF">';
qvod_html+='<PARAM NAME="URL" VALUE="'+qvod_url+'">';
qvod_html+='<PARAM NAME="Showcontrol" VALUE="1">';
qvod_html+='<PARAM NAME="Autoplay" VALUE="1">';
if(qvod_next_page){
 qvod_html+='<PARAM NAME="NextWebPage" VALUE="'+qvod_next_page+'">';
}
qvod_html+='</object>';
var ll =0;
if(!window.ActiveXObject){
 if (navigator.plugins) {		
  for (var i=0;i<navigator.plugins.length;i++) {
   if(navigator.plugins[i].name == 'QvodInsert'){
    ll= true;
    break;
   }
  }
 }
 if(ll!=false){
  qvod_html='<embed id="QvodPlayer" onerror="QvodInstall();" name="QvodPlayer" URL="'+qvod_url+'" type="application/qvod-plugin" width="100%" height="'+pHeight+'" Showcontrol="1" Autoplay="1" ></embed>';
 }else{
  qvod_setup=0;
 }	
}
if(!qvod_setup){
 qvod_html = '<iframe id="iframe_down" name="iframe_down" scrolling="no" frameborder="0" style="position:absolute; z-index:1; top:0; margin: 0;width: '+pWidth+'; height: '+pHeight+';" src="/public/player/qvod/install.html"></iframe>';
}
document.body.innerHTML=qvod_html;
</script>
<?php }elseif(in_array($sid,array(6))){?>
<script type="text/javascript">
var jjvod_url = '<?php echo $playInfo['url'];?>';//播放视频地址
var jjvod_w = 690;//播放器宽度
var jjvod_h = 550;//播放器高度
var jjvod_ad = '/public/player/jjvod/jj_loading.html';//缓冲和暂停调用广告地址，如http://www.abc.com/ad.html
var jjvod_c = '<?php echo $domain;?>'; //吉吉影音推广渠道，一般为域名简写，如baidu
var jjvod_install = 'http://player.jjvod.com/js/jjplayer_install.html?v=1&c='+jjvod_c;
var jjvod_weburl = unescape(window.location.href);
</script>
<script type="text/javascript" src="http://player.jjvod.com/jjplayer_v2.js" charset="utf-8"></script>
<?php }else{?>
<script type="text/javascript">
function Xf_Complete(){
  <!--  播放完成后调用 -->
}
</script>
<IFRAME id=xframe_mz name=xframe_mz style="MARGIN: 0px; WIDTH: 100%; DISPLAY: none; HEIGHT: 100%" src="http://error.xfplay.com/error.htm" frameBorder=0 scrolling=no></IFRAME>
<!--先锋播放器-->
<OBJECT id=Xfplay name=Xfplay  onerror="document.getElementById('Xfplay').style.display='none';document.getElementById('xframe_mz').style.display='';document.getElementById('xframe_mz').src='http://error.xfplay.com/error.htm';" 
              CLASSID="CLSID:E38F2429-07FE-464A-9DF6-C14EF88117DD" width="690" height="550">
<!--IE 浏览器-->
<PARAM NAME="URL" VALUE="<?php echo $playInfo['url'];?>">
  <!--火狐，谷歌 等浏览器-->
<embed type="application/xfplay-plugin" id="Xfplay2" name="Xfplay2" PARAM_URL="<?php echo $playInfo['url'];?>"  Event_Xf_Complete="Xf_Complete" width="690" height="550" ></embed>
</OBJECT>
<SCRIPT language=JavaScript src="http://error.xfplay.com/Player.js"></SCRIPT>
<!--  IE 浏览器 播放完成后调用 -->
<script for="Xfplay" language="JavaScript" event="Xf_Complete()"> {
  Xf_Complete();
}   
</script>
<?php }?>
</body>
</html>
