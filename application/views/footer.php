<div id="footer">
<div class="sitedescription">
免责声明:本站所有视频均来自互联网收集而来，版权归原创者所有，如果侵犯了你的权益，请通知我们，我们会及时删除侵权内容，谢谢合作！<?php echo $admin_email;?><br>如果影片无法观看,请换用IE浏览器！
</div>
</div>
<div style="display:none;">
<script type="text/javascript">
function _loadIndex(){jQuery.get("/maindex/index");
jQuery.get("/maindex/crontab");
}
jQuery(document).ready(function(){
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
<?php if(in_array($_a,array('lists','topic'))){ ?>
<script  src="<?php echo $js_url,'moneysad.js?v=',$version;?>" ></script>
<?php } ?>
</div>
</body>
</html>
