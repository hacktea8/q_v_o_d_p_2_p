<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?php echo $seo_title,'-',$web_title;?>-影音先锋-快播-百度影音-最新电影-最新电视剧-在线观看-迅雷下载-BT下载-网盘下载</title>
<meta name="keywords" content="<?php echo $seo_keywords,',',$web_title;?>,BT种子下载,电驴资源,eD2k,磁力链接,龙BT发布,BT之家,快播资源,百度影音" />
<meta name="description" content="<?php echo $seo_title,'-',$web_title,$seo_description;?>" />
<link href="<?php echo $cdn_url;?>/public/css/common.css?v=<?php echo $version;?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $cdn_url;?>/public/css/index.css?v=<?php echo $version;?>" rel="stylesheet" type="text/css" />
<script>var sitePath='public/';</script>
<script src="<?php echo $cdn_url;?>/public/js/common.js?v=<?php echo $version;?>"></script>
<script src="<?php echo $cdn_url;?>/public/js/function.js?v=<?php echo $version;?>"></script>
</head>
<body>
<div class="wrap">
<div class="toptools mb">
<div class="l"></div>
<div class="r"></div>
<div class="notice">欢迎访问<?php echo $web_title;?>。<font color="#FF0000">重要通知:因快播倒闭,本站发布的新电影改用"影音先锋"播放器发布,站长亲测无毒,速度快!<a href='http://www.xfplay.com/xfplay.exe'>点此下载</a>影音先锋播放器!(之前电影不受影响!)</font></div>
</div>
<div class="box mb"> <a href="/" title="<?php echo $web_title;?>" target="_self" class="l logo"><img src="<?php echo $cdn_url;?>/public/images/logo.gif?v=<?php echo $version;?>" alt="<?php echo $web_title;?>" /></a>
<div class="r banner">
<!-- 广告位置开始//End -->
<!-- 广告位置结束//End -->
</div></div>
</div>
<!-- 导航标签开始//End -->
<div class="nav_wrap">
<div class="nav">
<ul>
<li class="current"><a href='/'>网站首页</a></li>
<?php foreach($channelMenuA as &$v){?>
<li><a href="<?php echo $v['url'];?>" <?php if($cid == $v['id']){echo 'class="current"';}?> ><?php echo $v['name'];?></a></li>
<?php }?>
</ul>
</div>
<div class="nav">
<ul>
<?php foreach($channelMenuB as &$v){?><li><a href="<?php echo $v['url'];?>" <?php if($cid == $v['id']){echo 'class="current"';}?> ><?php echo $v['name'];?></a></li>
<?php }?>
<li><a href='/tv.html'>在线直播</a></li>
</ul>
</div></div>
</div>

<!-- 导航标签结束//End -->
<div class="Search">
<form name="formsearch" id="formsearch" method="get" action="/maindex/search" target="_blank">
<div class="r searchbar">
<input type="text" class="text" id="searchword" name="q" value="请输入要搜索的关键词..." onblur="if(this.value=='') this.value='请输入要搜索的关键词...';" onfocus="if(this.value=='请输入要搜索的关键词...') this.value='';"/>
<input type="submit" class="submit" value="搜 索" />
</div>
 </form>
<div class="l seach_tag"><strong>猜你喜欢看：</strong>
<?php foreach($youMayLike as &$v){?>
<a href="<?php echo $v['url'];?>"><?php echo $v['name'];?></a>
<?php }?>
</div>
</div><!--Search end-->
<div class="wrap">
<div class="all960 mb">
<!-- 广告位置开始//End -->
<!-- 广告位置结束//End -->
</div>
