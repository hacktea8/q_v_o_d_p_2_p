<!-- 影片信息开始/End -->
<div class="box" id="jq">
<div class="l w704">
<div class="bg box content mb">
<h3 class="ph3">影片信息</h3>
<div class="infobox box">
<img src="<?php echo $info['cover'];?>" alt="<?php echo $info['name'];?>" class="pic l" />
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

<p>时间：<?php echo $info['onlinedate'];?></p>
<!-- 影片信息结束/End -->
<!-- JiaThis Button BEGIN -->
<div id="ckepop">
</div>
<!-- JiaThis Button END -->
</div>
</div>
<div class="score">评分：<script type="text/javascript">markVideo(<?php echo $info['id'];?>,1,0,5,5,1);</script></div>
</div>
<!-- 播放地址开始/End -->
<div class="vlist bg mb">
<h5><span class="vplay l"></span>Qvod<em class="more"><a href="http://www.qvod.com" target="_blank"> Qvod</a>百度影音 <a href="http://player.baidu.com" target="_blank">需要下载百度影音播放器</a></a></em></h5>
<ul><li><a title='DVD' href='<?php echo $info['purl'];?>' target="_blank">开始观看</a></li>
</ul></div>

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
18
<?php foreach($viewHot as $k => &$v){?>
<li><em  class="on"><?php echo $k+1;?></em>
<p><a href="<?php echo $v['url'];?>" target="_blank"><?php echo $v['name'];?></a><strong></strong></p><span><?php echo $v['hits'];?></span></li>
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
