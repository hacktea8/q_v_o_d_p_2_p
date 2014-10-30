<div id="jq">
<div class="box mb">
<!-- 今日推荐标签开始//End -->
<div class="w704 r bg">
<h3 class="ph3">今日推荐必看<em class="more">
为了下次能快速打开我们的网站，请加入收藏：
<a id="join" href="javascript:void(0)" onclick="addFavorite('http://<?php echo $domain;?>','<?php echo $web_title;?>');ga('send','event', 'site','favsite');" >【添加到浏览器收藏夹】</a>
<a onclick="ga('send','event', 'site','qqfavsite');" href="javascript:window.open('http://shuqian.qq.com/post?from=3&title='+encodeURIComponent(document.title)+'&uri='+encodeURIComponent(document.location.href)+'&jumpback=2&noui=1','favit','width=930,height=470,left=50,top=50,toolbar=no,menubar=no,location=no,scrollbars=yes,status=yes,resizable=yes');void(0)">【添加到QQ收藏】</a></em>
</h3>
<ul class="cpic">
<?php foreach($qvodIndex['topRecomData'] as &$v){?>
<li><a href="<?php echo $v['url'];?>" target="_blank" onclick="ga('send','event', 'index_topRecomData','img_<?php echo $v['name'];?>');" class="aimg" title="<?php echo $v['name'];?>"><img class="lazy" title="<?php echo $v['name'];?>" alt="<?php echo $v['name'];?>" data-original="<?php echo $showimgapi,$v['cover'];?>"/></a>
<strong><a href="<?php echo $v['url'];?>" onclick="ga('send','event', 'index_topRecomData','<?php echo $v['name'];?>');" ><?php echo $v['name'];?></a></strong><span><?php echo $v['onlinedate'];?></span></li>
<?php }?>

</ul>
</div>
<!-- 今日推荐标签结束//End -->
<!-- 今日更新左侧开始//End -->
<div class="l w250 bg slist">
<div class="new l">
<h3 class="ph3">今日最新入库<em class="more"><a href="javascript:void(0);">昨日入库<img src="<?php echo $cdn_url;?>/public/images/hot.gif?v=<?php echo $version;?>" alt="24小时内更新" class="hot"/></a></em></h3>
<ul>
<?php foreach($qvodIndex['todayNewData'] as $k => &$v){?>
<li><em  class="on"><?php echo $k+1;?></em>
<p><a href="<?php echo $v['url'];?>" onclick="ga('send','event', 'index_todayNewData','<?php echo $v['name'];?>');" target="_blank"><?php echo $v['name'];?></a>
<strong></strong></p><span></span></li>
<?php }?>
</ul>
</div>
</div>
</div>
<!-- 今日更新左侧结束//End -->
<div class="all960 mb">
<!-- 广告位置开始//End  -->
<!-- 广告位置结束//End  -->
</div>
<div class="box mb">
<div class="w704 r bg">
<!-- 最新电影标签开始//End -->
<h3 class="ph3">最新电影频道</h3>
<ul class="cpic ulbl">
<?php foreach($qvodIndex['todayMovieNewData'] as &$v){?>
 <li><a href="<?php echo $v['url'];?>" target="_blank" class="aimg" title="<?php echo $v['name'];?>" onclick="ga('send','event', 'index_todayMovieNewData','img_<?php echo $v['name'];?>');"> 
<img class="lazy" title="<?php echo $v['name'];?>" alt="<?php echo $v['name'];?>" data-original="<?php echo $showimgapi,$v['cover'];?>" alt="<?php echo $v['name'];?>" /></a><strong>
<a href="<?php echo $v['url'];?>" onclick="ga('send','event', 'index_todayMovieNewData','<?php echo $v['name'];?>');"><?php echo $v['name'];?></a></strong><span><?php echo $v['onlinedate'];?></span></li>
<?php }?>
 </ul>
<ul class="ctext">
<?php foreach($qvodIndex['todayMovieNewDataTxt'] as &$v){?>
<li>&bull;&nbsp;
<a href="<?php echo $channel[$v['cid']]['url'];?>" target="_blank" onclick="ga('send','event', 'index_tMNDT_Cate','<?php echo $channel[$v['cid']]['name'];?>');">[ <?php echo $channel[$v['cid']]['name'];?>]
<a href="<?php echo $v['url'];?>" target="_blank" onclick="ga('send','event', 'index_tMNDT','<?php echo $v['name'];?>');"><?php echo $v['name'];?></a></li>
<?php }?>
</ul>
</div>
<!-- 最新电影标签结束//End -->
<!-- 电影排行榜代码开始//End -->
<div class="l w250 bg slist">
<div class="new l">
<h3 class="ph3">电影频道排行榜</h3>
<ul>
<?php foreach($qvodIndex['movieHotData'] as $k => &$v){?>
<li><em  class="on"><?php echo $k+1;?></em>
<p><a href="<?php echo $v['url'];?>" target="_blank" onclick="ga('send','event', 'index_mHD','<?php echo $v['name'];?>');" ><?php echo $v['name'];?></a>
<strong><?php echo $v['onlinedate'];?></strong></p><span><?php echo $v['hits'];?></span></li>
<?php }?>
</ul>
</div>
</div>
</div>
<!-- 电影排行榜代码结束//End -->
<!-- 电视剧场代码开始//End -->
<div class="box mb">
<div class="w704 r bg">
<h3 class="ph3">最新电视剧场</h3>
<ul class="cpic ulbl">
<?php foreach($qvodIndex['todayNewTV'] as &$v){?>
 <li><a href="<?php echo $v['url'];?>" target="_blank" onclick="ga('send','event', 'index_tNTV','img_<?php echo $v['name'];?>');" class="aimg" title="<?php echo $v['name'];?>"><img class="lazy" title="<?php echo $v['name'];?>" alt="<?php echo $v['name'];?>" data-original="<?php echo $showimgapi,$v['cover'];?>" alt="<?php echo $v['name'];?>" /></a>
<strong><a href="<?php echo $v['url'];?>" onclick="ga('send','event', 'index_tNTV','<?php echo $v['name'];?>');"><?php echo $v['name'];?></a></strong><span></span></li>
<?php }?>
</ul>
<ul class="ctext">
<?php foreach($qvodIndex['todayNewTVtxt'] as &$v){?>
<li>&bull;&nbsp;
<a href="<?php echo $channel[$v['cid']]['url'];?>" target="_blank" onclick="ga('send','event', 'index_tNTVt_Cate','<?php echo $channel[$v['cid']]['name'];?>');">[ <?php echo $channel[$v['cid']]['name'];?>]
<a href="<?php echo $v['url'];?>" target="_blank" onclick="ga('send','event', 'index_tNTVt','<?php echo $v['name'];?>');"><?php echo $v['name'];?></a></li>
<?php }?>
</ul>
</div>
<!-- 电视剧场代码结束//End -->
<!-- 电视排行榜代码开始//End -->
<div class="l w250 bg slist">
<div class="new l">
<h3 class="ph3">电视剧场排行榜</h3>
<ul>
<?php foreach($qvodIndex['tvHotData'] as $k => &$v){?>
<li><em  class="on"><?php echo $k+1;?></em>
<p><a href="<?php echo $v['url'];?>" target="_blank" onclick="ga('send','event', 'index_tvHD','<?php echo $v['name'];?>');"><?php echo $v['name'];?></a><strong>
全集</strong></p><span><?php echo $v['hits'];?></span></li>
<?php }?>
</ul>
</div>
</div></div>
<!-- 电视排行榜代码开始//End -->
<div class="all960 mb">
<!-- 广告位置开始//End  -->
<!-- 广告位置结束//End  -->
</div>
<!-- 综艺节目代码开始//End -->
<div class="box mb">
<div class="w704 r bg">
<h3 class="ph3">最新综艺节目</h3>
<ul class="cpic ulbl">
<?php foreach($qvodIndex['varietyNewData'] as &$v){?>
 <li><a href="<?php echo $v['url'];?>" target="_blank" class="aimg" title="<?php echo $v['name'];?>" onclick="ga('send','event', 'index_varND','img_<?php echo $v['name'];?>');" ><img class="lazy" title="<?php echo $v['name'];?>" alt="<?php echo $v['name'];?>" data-original="<?php echo $showimgapi,$v['cover'];?>" alt="<?php echo $v['name'];?>" /></a>
<strong><a href="<?php echo $v['url'];?>" onclick="ga('send','event', 'index_varND','<?php echo $v['name'];?>');"><?php echo $v['name'];?></a></strong><span></span></li>
<?php }?>
</ul>
<ul class="ctext">
<?php foreach($qvodIndex['varietyNewDatatxt'] as &$v){?>
<li>&bull;&nbsp;
<a href="<?php echo $channel[$v['cid']]['url'];?>" target="_blank" onclick="ga('send','event', 'index_varNDt','<?php echo $channel[$v['cid']]['name'];?>');">[ <?php echo $channel[$v['cid']]['name'];?>]
<a href="<?php echo $v['url'];?>" target="_blank" onclick="ga('send','event', 'index_varNDt','<?php echo $v['name'];?>');"><?php echo $v['name'];?></a></li>
<?php }?>
</ul>
</div>
<!-- 综艺节目代码结束//End -->
<!-- 综艺排行榜开始//End -->
<div class="l w250 bg slist">
<div class="new l">
<h3 class="ph3">综艺节目排行榜</h3>
<ul>
<?php foreach($qvodIndex['varietyHotData'] as $k => &$v){?>
<li><em  class="on"><?php echo $k+1;?></em>
<p><a href="<?php echo $v['url'];?>" target="_blank" onclick="ga('send','event', 'index_varHD','<?php echo $v['name'];?>');" ><?php echo $v['name'];?></a>
<strong></strong></p><span><?php echo $v['hits'];?></span></li>
<?php }?>
 </ul>
</div>
</div>
</div>
<!-- 综艺排行榜结束//End -->
<!-- 综艺排行榜开始//End -->
<div class="box mb">
<div class="w704 r bg">
<h3 class="ph3">最新动漫片</h3>
<ul class="cpic ulbl">
<?php foreach($qvodIndex['animeNewData'] as &$v){?>
 <li><a href="<?php echo $v['url'];?>" target="_blank" class="aimg" title="<?php echo $v['name'];?>" onclick="ga('send','event', 'index_aniND','img_<?php echo $v['name'];?>');"><img class="lazy" title="<?php echo $v['name'];?>" alt="<?php echo $v['name'];?>" data-original="<?php echo $showimgapi,$v['cover'];?>" alt="<?php echo $v['name'];?>" /></a>
<strong><a href="<?php echo $v['url'];?>" onclick="ga('send','event', 'index_aniND','<?php echo $v['name'];?>');"><?php echo $v['name'];?></a></strong><span></span></li>
<?php }?>
</ul>
<ul class="ctext">
<?php foreach($qvodIndex['animeNewDatatxt'] as &$v){?>
<li>&bull;&nbsp;
<a href="<?php echo $channel[$v['cid']]['url'];?>" target="_blank" onclick="ga('send','event', 'index_aniNDt','<?php echo $channel[$v['cid']]['name'];?>');">[ <?php echo $channel[$v['cid']]['name'];?>]
<a href="<?php echo $v['url'];?>" target="_blank" onclick="ga('send','event', 'index_aniNDt','<?php echo $v['name'];?>');"><?php echo $v['name'];?></a></li>
<?php }?>
</ul>
</div>
<!-- 综艺排行榜结束//End -->
<!-- 动漫排行榜开始//End -->
<div class="l w250 bg slist">
<div class="new l">
<h3 class="ph3">动漫排行榜</h3>
<ul>
<?php foreach($qvodIndex['animeHotData'] as $k => &$v){?>
<li><em  class="on"><?php echo $k+1;?></em>
<p><a href="<?php echo $v['url'];?>" target="_blank" onclick="ga('send','event', 'index_aniHD','<?php echo $v['name']; ?>');"><?php echo $v['name'];?></a>
<strong></strong></p><span><?php echo $v['hits'];?></span></li>
<?php }?>
 </ul>
</div>
</div>
</div>
<!-- 动漫排行榜结束//End -->
<div class="all960">
<!-- 广告位置开始//End  -->
<!-- 广告位置结束//End  -->
</div>
</div>
<div class="bg flink mb">
<h5>友情链接</h5>
<ul>
<?php foreach($friend_link as &$v){?>
<li><a href="" target="_blank" onclick="ga('send','event', 'site','friendLink_');"></a></li>
<?php }?>
</ul>
</div>
</div>
