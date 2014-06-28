<!-- 影片信息开始/End -->
<div class="box" id="jq">
<div class="l w704">
<div class="bg box content mb">
<h3 class="ph3">影片信息</h3>
<div class="infobox box">
<img src="<?php echo $showimgapi,$info['cover'];?>" alt="<?php echo $info['name'];?>" class="pic l" />
<div class="info l">
<h1><?php echo $info['name'];?>
<?php if($uinfo['uid'] === $info['uid'] || $uinfo['isadmin']){echo "<a href='$editeUrl/$info[id]'>编辑</a>"; }?>
</h1>
<p> 
<em>热度：<span class="red"><span id="hit"><?php echo $info['hits'];?></span> ℃</em></p>
<p><em>类型：<a href="<?php echo $channel[$cid]['url'];?>" target="_blank"><?php echo $channel[$cid]['name'];?></a></em></p>
<p>主演：
<?php echo $info['actor'];?>
&nbsp;&nbsp;</p>

<p>时间：<?php echo date('Y-m-d',strtotime($info['onlinedate']));?></p>
<!-- 影片信息结束/End -->
<!-- JiaThis Button BEGIN -->
<div id="ckepop">
</div>
<!-- JiaThis Button END -->
</div>
</div>
<?php if(0){?>
<div class="score">评分：<script type="text/javascript">markVideo(<?php echo $info['id'];?>,1,0,5,5,1);</script></div>
<?php }?>
</div>
<!-- 播放地址开始/End -->
<div class="vlist bg mb">
<?php
$_reload_page = 0;$_isbreak = 0;
foreach($videovols as $k => &$r){
if($_isbreak){
break;
}
?>
<h5><span class="vplay l"></span><?php echo $playMod[$k]['title'];?>
<em class="more"><a onclick="return false;" ref="nofollow" href="<?php echo $playMod[$k]['url'];?>" target="_blank"><?php echo $playMod[$k]['title'];?></a></em></h5>
<ul>
<?php foreach($r as &$v){
if(!$v['volname']){
 $_reload_page = $_isbreak = 1;
 break;
}
?>
<li><a title="<?php echo $v['volname'];?>" ref="nofollow" href="<?php echo $v['url'];?>" target="_blank"><?php echo $v['volname'];?></a></li>
<?php }?>
</ul>
<?php }?>
</div>

<!-- 播放地址结束/End  -->
<div class="all728 wrap mb">
</div>

<div class="bg mb box description">
<h3 class="ph3">影片介绍</h3>
<p>
<?php echo $info['intro'];?>
</p>
</div>
</div>
<div class="r w250 bg">
<div class="zz">周边赞助</div>
<!-- 广告位置开始//End -->
<!-- 广告位置结束//End -->
</div>
<div class="r w250 bg">
<!-- 热门排行开始//End -->
<div class="new l">
<h3 class="ph3"><?php echo $channel[$cid]['name'];?>热门排行</h3>
<ul>
<?php foreach($viewHot as $k => &$v){?>
<li><em  class="on"><?php echo $k+1;?></em>
<p><a href="<?php echo $v['url'];?>" target="_blank" title="<?php echo $v['name'];?>"><?php echo $v['name'];?></a><strong></strong></p><span><?php echo $v['hits'];?></span></li>
<?php }?>
</ul>
</div>
<!-- 热门排行结束//End -->
</div>
</div>
<span class="none">
<span id="hit">加载中</span></span>
<div class="all960 wrap mb">
<!-- 广告位置开始//End -->
<!-- 广告位置结束//End -->
</div>
</div>
<div class="hide err_msg_div">
<div id="err_msg_txt"></div>
<?php if(!$uinfo['uid']){ ?>
<div id="fast_login_div"><a href="/maindex/login" rel="nofollow" target="_blank" >立即登陆观看</a></div>
<?php }?>
</div>
<script type="text/javascript">
<?php if($_reload_page){?>
window.location.href="<?php echo $current_url;?>";
<?php }?>
var err_msg = getCookie('err_msg');
if(err_msg){
 //显示 DIV 弹窗
 jQuery('.err_msg_div').removeClass("hide");
 jQuery('#fast_login_div').text(err_msg);
 delCookie('err_msg');
}
</script>
