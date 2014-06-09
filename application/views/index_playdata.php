<?php if(in_array($sid,array(5))){?>
<script language="javascript">
var XgPlayer = {
'Url': "<?php echo $playInfo['url'];?>", //本集播放地址，需更改
'NextcacheUrl': "<?php echo $playInfo['nexturl'];?>", //缓冲下一集，需更改
'LastWebPage': '<?php echo $playInfo['pre'];?>',
'NextWebPage': "<?php echo $playInfo['next'];?>", //下一集播放页面地址，需更改
'Buffer': '/public/player/xigua/xg_loading.html', // 播缓冲AD，需更改
'Pase': '/public/player/xigua/xg_loading.html', // 暂停AD，需更改
'Width': 680, // 播放器显示宽度
'Height': 490, // 播放器显示高度
'Second': 8, // 缓冲时间
"Installpage":'http://static.xigua.com/installpage.html'
};
document.write('<script language="javascript" src="http://static.xigua.com/xiguaplayer.js?'+new Date().getTime()+'" charset="utf-8"><\/script>');
</script>
<?php }else{?>
<script type="text/javascript">
function Xf_Complete(){
  <!--  播放完成后调用 -->
}
</script>
<IFRAME id=xframe_mz name=xframe_mz style="MARGIN: 0px; WIDTH: 100%; DISPLAY: none; HEIGHT: 100%" src="http://error.xfplay.com/error.htm" frameBorder=0 scrolling=no></IFRAME>
<!--先锋播放器-->
<OBJECT id=Xfplay name=Xfplay  onerror="document.getElementById('Xfplay').style.display='none';document.getElementById('xframe_mz').style.display='';document.getElementById('xframe_mz').src='http://error.xfplay.com/error.htm';" 
              CLASSID="CLSID:E38F2429-07FE-464A-9DF6-C14EF88117DD" width="900" height="550">
<!--IE 浏览器-->
<PARAM NAME="URL" VALUE="<?php echo $playInfo['url'];?>">
  <!--火狐，谷歌 等浏览器-->
<embed type="application/xfplay-plugin" id="Xfplay2" name="Xfplay2" PARAM_URL="<?php echo $playInfo['url'];?>"  Event_Xf_Complete="Xf_Complete" width="900" height="550" ></embed>
</OBJECT>
<SCRIPT language=JavaScript src="http://error.xfplay.com/Player.js"></SCRIPT>
<!--  IE 浏览器 播放完成后调用 -->
<script for="Xfplay" language="JavaScript" event="Xf_Complete()"> {
  Xf_Complete();
}   
</script>
<?php }?>
