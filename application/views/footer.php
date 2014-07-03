<div id="footer">
<div class="sitedescription">
&copy;2013 - <script type="text/javascript">
   var copyrightdate = new Date();
   document.write(copyrightdate.getFullYear());
</script>
免责声明:本站所有视频均来自互联网收集而来，版权归原创者所有，如果侵犯了你的权益，请通知我们，我们会及时删除侵权内容，谢谢合作！<?php echo $admin_email;?><br/>
<strong style="color:green;">如果影片无法观看,请换用IE浏览器！</strong>
</div>
</div>
<div style="display:none;">
<script type="text/javascript">
function _loadIndex(){jQuery.get("/maindex/index");
jQuery.get("/maindex/crontab");
}
jQuery(document).ready(function(){
<?php if(in_array($_a,array('index','lists','fav','views','play','search'))){ ?>
$("img.lazy").show().lazyload({ 
    effect : "fadeIn",
    //placeholder : "img/grey.gif",
    placeholder : '<?php echo $errorimg;?>',
    threshold : 60
});
<?php }?>
<?php if('index' == $_a){ ?>
window.setTimeout("_loadIndex()",5000);
<?php } ?>
});
<?php if(in_array($_a,array('topic'))){ ?>

<?php } ?>
function _Userlogin(){
 var timer=null;
 var _hide=function(){
  jQuery('.iconList').hide();jQuery('.dropMenu').hide();}
 var init=function(){
  jQuery('#user_login').mouseout(function(){
  timer=setTimeout(_hide,500);});
  jQuery('#user_login').mouseover(function(){
  clearTimeout(timer);
  if(jQuery('.iconList').is(":visible") || jQuery('.dropMenu').is(":visible")){
   return false;}
  jQuery.get('/maindex/isUserInfo/',function(data){
  if(data.status==1){
   jQuery('.iconList').show();jQuery('.dropMenu').hide();
  }else{
   jQuery('.iconList').hide();jQuery('.dropMenu').show();}
  },"json");});}
  init();}
_Userlogin();

</script>
<div class="hide">
<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_5944562'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com/stat.php%3Fid%3D5944562%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));</script>
</div>
<?php if(in_array($_a,array('lists','views','play'))){ ?>
<script  src="<?php echo $js_url,'moneysad.js?v=',$version;?>" ></script>
<?php } ?>
<?php if(in_array($_a,array('views','play'))){ ?>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"32"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"将<?php echo $info['name'];?>分享到：","viewSize":"24"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
<?php } ?>
</div>
</body>
</html>
