<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META HTTP-EQUIV="pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
<META HTTP-EQUIV="expires" CONTENT="0"> 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $seo_title,'-',$web_title;?><?php if( in_array($_a,array('index'))){?>-影音先锋-快播-吉吉影音-西瓜影音-百度影音-最新电影-最新电视剧-在线观看-迅雷下载-BT下载-网盘下载<?php }echo '-',$domain;?></title>
<meta name="keywords" content="<?php echo $seo_keywords,',',$web_title;?>" />
<meta name="description" content="<?php echo $seo_title,'-',$web_title,$seo_description;?>" />
<link href="<?php echo $cdn_url;?>/public/css/common.css?v=<?php echo $version;?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $cdn_url;?>/public/css/maindex.css?v=<?php echo $version;?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $cdn_url;?>/public/css/global.css?v=<?php echo $version;?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
<script>var sitePath='public/';//$.noConflict();</script>
<script src="<?php echo $cdn_url;?>/public/js/lanage.js?v=<?php echo $version;?>"></script>
<script src="<?php echo $cdn_url;?>/public/js/function.js?v=<?php echo $version;?>"></script>
<?php if(in_array($_a,array('index','lists','views','play','fav','search'))){ ?>
<script type="text/javascript" src="<?php echo $js_url;?>jquery.lazyload.min.js?v=<?php echo $version;?>"></script>
<?php } ?>
<?php if(in_array($_a,array('play'))){?>
<?php }?>
<script type="text/javascript">
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-43439571-5', 'auto');
ga('send', 'pageview');

</script>
</head>
<body>
<div class="wrap">
<?php if(0){?>
<div class="toptools mb">
<div class="notice">欢迎访问<?php echo $web_title;?>。<font color="#FF0000">重要通知:因快播倒闭,本站发布的新电影改用"影音先锋"播放器发布,站长亲测无毒,速度快!<a href='http://www.xfplay.com/xfplay.exe'>点此下载</a>影音先锋播放器!(之前电影不受影响!)</font></div>
</div>
<?php }?>
<div id="user_login">
   <span class="user">Œ</span>
   <div class="iconList" style="display: none;">
   <ul>
<?php if(0){ ?>
    <li><a href="/history/" title="我看過的"><em class="watch">图片</em>我看過的</a></li>
    <li><a href="/bookmark/" title="我的書簽"><em class="iconfont">ŷ</em><cite>我的書簽</cite></a></li>
<?php } ?>
    <li><a href="/maindex/fav/" onclick="ga('send','event', 'user','我的收藏');" title="我的收藏"><em class="iconfont">ũ</em><cite>我的收藏</cite></a></li>
    <li><a href="/maindex/loginout" onclick="ga('send','event', 'user','登出');" title="登出"><em class="iconfont">ơ</em><cite>登出</cite></a></li>
   </ul>
   </div>
   <div class="dropMenu" style="display: none;">
   <ul>
    <li><a class="btn" title="登入" href="/maindex/login" onclick="ga('send','event', 'user','登入');" target="_blank">登入</a></li>
   </ul>
   </div>
  </div>

<div class="box mb"> <a href="/" title="<?php echo $web_title;?>" onclick="ga('send','event', 'site','logo');" target="_self" class="l logo"><img src="<?php echo $cdn_url;?>/public/images/qvdlogo.jpg?v=<?php echo $version;?>" alt="<?php echo $web_title;?>" /></a>
<div class="r banner">
<!-- 广告位置开始//End -->
<!-- 广告位置结束//End -->
</div></div>
</div>
<!-- 导航标签开始//End -->
<div class="nav_wrap">
<div class="nav">
<ul>
<li class="current"><a href='/' onclick="ga('send','event', 'chennel','首頁');">网站首页</a></li>
<?php foreach($channel as &$v){
if(19 != $v['pid']){
continue;
}
?>
<li <?php if($cid == $v['id']){echo 'class="current"';}?>><a href="<?php echo $v['url'];?>" onclick="ga('send','event', 'channel','<?php echo $v['name'];?>');" ><?php echo $v['name'];?></a></li>
<?php }?>
<li>
<a style="color: blue;font-size: medium;" href="javascript:transformLan();" id="a-lang" title="點擊以繁體中文>方式浏覽" onclick="ga('send','event', 'site','简繁转换');" name="a-lang">繁體中文切換</a>
</li>
</ul>
</div>
<div class="nav">
<ul>
<?php foreach($channel as &$v){
if(18 != $v['pid']){
continue;
}
?>
<li <?php if($cid == $v['id']){echo 'class="current"';}?>><a href="<?php echo $v['url'];?>" onclick="ga('send','event', 'channel','<?php echo $v['name'];?>');" ><?php echo $v['name'];?></a></li>
<?php }?>
</ul>
</div>
<!--综艺-->
<div class="nav">
<ul>
<?php 
foreach($channel as &$v){
 if(9 != $v['pid'] && 9 != $v['id']){
  continue;
 }
?>
<li <?php if($cid == $v['id']){echo 'class="current"';}?>><a href="<?php echo $v['url'];?>" onclick="ga('send','event', 'channel','<?php echo $v['name'];?>');" ><?php echo $v['name'];?></a></li>
<?php }//end foreach
?>
</ul>
</div>
<!--动漫-->
<div class="nav">
<ul>
<?php 
foreach($channel as &$v){
 if(8 != $v['pid'] && 8 != $v['id']){
  continue;
 }
?>
<li <?php if($cid == $v['id']){echo 'class="current"';}?>><a href="<?php echo $v['url'];?>" onclick="ga('send','event', 'channel','<?php echo $v['name'];?>');" ><?php echo $v['name'];?></a></li>
<?php }//end foreach
?>
</ul>
</div>
<div class="nav">
<ul>
<?php 
if($uinfo['isadult']){
foreach($channel as &$v){
 if(19 != $v['pid']){
  continue;
 }
?>
<li <?php if($cid == $v['id']){echo 'class="current"';}?>><a href="<?php echo $v['url'];?>" onclick="ga('send','event', 'channel','<?php echo $v['name'];?>');" ><?php echo $v['name'];?></a></li>
<?php }//end foreach
 }//end if
?>
</ul>
</div>
</div>
</div>

<!-- 导航标签结束//End -->
<div class="Search">
<form name="formsearch" id="formsearch" method="get" action="/maindex/search" target="_blank">
<div class="r searchbar">
<input type="text" class="text" id="searchword" name="q" value="请输入要搜索的关键词..." onblur="if(this.value=='') this.value='请输入要搜索的关键词...';" onfocus="if(this.value=='请输入要搜索的关键词...') this.value='';"/>
<input type="submit" class="submit" value="搜 索" onclick="ga('send','event', 'site','搜索');" />
</div>
 </form>
<div class="l seach_tag"><strong>猜你喜欢看：</strong>
<?php foreach($youMayLike as &$v){?>
<a href="<?php echo $v['url'];?>" onclick="ga('send','event', 'youMayLike','<?php echo $v['name'];?>');" ><?php echo $v['name'];?></a>
<?php }?>
</div>
</div><!--Search end-->
<div class="wrap">
<div class="all960 mb">
<!-- 广告位置开始//End -->
<!-- 广告位置结束//End -->
</div>
