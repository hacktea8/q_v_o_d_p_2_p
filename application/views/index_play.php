<div class="box playbox mb bg">
<div class="playerbox">
<div class="playert">
<h1>正在播放：<a href='/'>首页</a>&nbsp;&nbsp;&raquo;&nbsp;&nbsp;<a href='<?php echo $channel[$cid]['url'];?>' ><?php echo $channel[$cid]['name'];?></a>&nbsp;&nbsp;&raquo;&nbsp;&nbsp;<a href='<?php echo $info['url'];?>'>><?php echo $info['name'];?></a><span class="more">
<?php if($uinfo['uid'] === $info['uid'] || $uinfo['isadmin']){echo "<a href='$editeUrl/$info[id]'>编辑</a>"; }?>
</span></h1>
</div>
<div class="play655">
<iframe width="960px" height="550px"  frameborder="0" scrolling="no" src="/maindex/playdata/<?php echo $info['id'],'/',$sid,'/',$vol;?>"></iframe>
<div class="playerb">
<div class="pcomment r"><a href="javascript:void(0)" onclick="reportErr(<?php echo $info['id'];?>)">报 错</a></div>
</div>
</div>

<div class="ad300">
<!-- 广告位置开始//End -->
<!-- 广告位置结束//End -->
</div>
<div class="ad250">
<!-- 广告位置开始//End -->
<!-- 广告位置结束//End -->
</div>
</div>
</div>
<!-- 播放地址开始/End -->
<div class="vlist bg mb">
<?php foreach($videovols as $k => &$v){?>
<h5><span class="vplay l"></span><?php echo $playMod[$k]['title'];?><em class="more"> <a onclick="return false;" href="<?php echo $playMod[$k]['url'];?>" target="_blank" title="<?php echo $playMod[$k]['title'];?>"><?php echo $playMod[$k]['title'];?></a></em></h5>
<ul>
<?php foreach($v as &$r){?>
<li><a class="<?php if($sid == $k && $r['vol'] == $vol){echo 'current';}?>" title="<?php echo $r['volname'];?>" href='<?php echo $r['url'];?>' target="_blank"><?php echo $r['volname'];?></a></li>
<?php }?>
</ul>
<?php }?>
</div>
<!-- 播放地址结束/End  -->
<div class="all960 wrap mb">
</div>
<div class="relatedinfo mb bg">
<h5>相关资源</h5>
<ul id="relatedinfo">
<?php foreach($playRelate as &$v){?>
<li>
<h3><?php echo $v['name'];?></h3>
<p><a target="_blank" href="<?php echo $v['url'];?>" target="_blank"><img alt="<?php echo $v['name'];?>" title="<?php echo $v['name'];?>" src="<?php echo $v['cover'];?>" /></a></p>
<strong><a target="_blank" href="<?php echo $v['url'];?>" title="<?php echo $v['name'];?>"><?php echo $v['name'];?></a></strong></li>
<?php }?>
</ul>
</div>
<div class="bg mb box description">
<h3 class="ph3">影片介绍</h3>
<span property="v:summary">
<?php echo $info['intro'];?>
</span>
</div>
<div class="all960 mb"></div>
<!-- 广告位置开始//End  -->
<!-- 广告位置结束//End  -->
</div>
</div>
