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
<h3 class="ph3">喜剧片热门排行</h3>
<ul>
<li><em  class="on">01</em>
<p><a href="/view/index14716.html" target="_blank">人再囧途之泰囧</a><strong>DVDRIP高清国语中字</strong></p><span>154519</span></li>

<li><em  class="on">02</em>
<p><a href="/view/index16817.html" target="_blank">西游降魔篇/大话西游之除魔传奇/大话西游3</a><strong>HD1280高清国语中英双字</strong></p><span>129184</span></li>

<li><em  class="on">03</em>
<p><a href="/view/index17542.html" target="_blank">内裤之穴</a><strong>DVD中字</strong></p><span>57581</span></li>

<li><em >04</em>
<p><a href="/view/index13481.html" target="_blank">厨子戏子痞子/厨子·戏子·痞子</a><strong>DVDscr国语中字</strong></p><span>29274</span></li>

<li><em >05</em>
<p><a href="/view/index17825.html" target="_blank">笑功震武林</a><strong>HD1280高清国语中字</strong></p><span>18053</span></li>

<li><em >06</em>
<p><a href="/view/index17249.html" target="_blank">北京遇上西雅图/情定西雅图</a><strong>TC清晰国语中英双字</strong></p><span>17738</span></li>

<li><em >07</em>
<p><a href="/view/index14393.html" target="_blank">请叫我英雄</a><strong>BD1280高清版</strong></p><span>15980</span></li>

<li><em >08</em>
<p><a href="/view/index16398.html" target="_blank">激情热线(未分级版)</a><strong>BD蓝光720P中英双字</strong></p><span>15560</span></li>

<li><em >09</em>
<p><a href="/view/index16558.html" target="_blank">我老公不靠谱/我老婆未满十八岁2</a><strong>BD蓝光720P国粤语中字</strong></p><span>14974</span></li>

<li><em >10</em>
<p><a href="/view/index16716.html" target="_blank">快Le到家</a><strong>HD1280高清国语中字</strong></p><span>14194</span></li>

<li><em >11</em>
<p><a href="/view/index17617.html" target="_blank">百星酒店</a><strong>BD蓝光720P国粤语中字</strong></p><span>13358</span></li>

<li><em >12</em>
<p><a href="/view/index17254.html" target="_blank">越来越好之村晚/越来越好·村晚</a><strong>HD720P高清完美版国语中字</strong></p><span>10933</span></li>

<li><em >13</em>
<p><a href="/view/index16084.html" target="_blank">不宜生育/儿童不宜</a><strong>DVD中英双字</strong></p><span>10821</span></li>

<li><em >14</em>
<p><a href="/view/index18007.html" target="_blank">囧人之越挠越痒</a><strong>HD1280高清国语中英双字</strong></p><span>10313</span></li>

<li><em >15</em>
<p><a href="/view/index17908.html" target="_blank">神偷艳贼</a><strong>BD蓝光720P中英双字</strong></p><span>9164</span></li>

<li><em >16</em>
<p><a href="/view/index17957.html" target="_blank">四十而惑(未分级版)/这就是四十岁</a><strong>BD蓝光720P高清中字</strong></p><span>8974</span></li>

<li><em >17</em>
<p><a href="/view/index16844.html" target="_blank">愤怒的小孩</a><strong>HD1280高清国语中英双字</strong></p><span>8034</span></li>

<li><em >18</em>
<p><a href="/view/index14407.html" target="_blank">泰迪熊/贱熊30</a><strong>BD蓝光720P高清中字</strong></p><span>7873</span></li>
 
</ul>
</div>
<!-- 热门排行结束//End -->
</div>
</div>
<span class="none">
<span id="hit">加载中</span></span>
<div class="all960 wrap mb">
<!-- 广告位置开始//End -->
<script type="text/javascript" language="javascript" src="/js/ads/content-dibu.js"></script><!-- 广告位置结束//End -->
</div>
</div>
