<div class="box" id="jq">
<div class="l w250 bg slist">
<!-- 热门排行开始//End -->
<div class="new l">
<h3 class="ph3"><?php echo $channel[$cid]['name'];?>热门排行</h3>
<ul>
<?php foreach($hotRankList as $k => &$v){?>
<li><em  class="on"><?php echo $k+1;?></em>
<p><a href="<?php echo $v['url'];?>" onclick="ga('send','event', 'list_hRLC<?php echo $cid;?>','<?php echo $v['name'];?>');" target="_blank"><?php echo $v['name'];?></a><strong><?php echo $v['onlinedate'];?></strong></p><span><?php echo $v['hits'];?></span></li>
<?php }?>
</ul>
</div>
<!-- 热门排行结束//End -->
<!-- 热门推荐开始//End -->
<div class="new l">
<h3 class="ph3"><?php echo $channel[$cid]['name'];?>热门推荐</h3>
<ul>
<ul>
<?php foreach($hotRecomList as $k => &$v){?>
<li><em  class="on"><?php echo $k+1;?></em>
<p><a href="<?php echo $v['url'];?>" target="_blank" onclick="ga('send','event', 'list_hRecomLC<?php echo $cid;?>','<?php echo $v['name'];?>');"><?php echo $v['name'];?></a><strong><?php echo $v['onlinedate'];?></strong></p><span><?php echo $v['hits'];?></span></li>
<?php }?>
</ul>
</div>
</div>
<!-- 热门推荐结束//End -->
<!-- 分类列表开始//End -->
<div class="r w704">
<div class="channellist box mb bg">
<h3 class="ppv"><?php echo $channel[$cid]['name'];?>列表</h3>
<ul>
<?php foreach($infolist as &$v){?>
<li onmousemove="this.className='thisli'" onmouseout="this.className=''"><a href="<?php echo $v['url'];?>" class="aimg l" target="_blank" onclick="ga('send','event', 'listC<?php echo $cid;?>','img_<?php echo $v['name'];?>');"><img class="lazy" title="<?php echo $v['name'];?>" alt="<?php echo $v['name'];?>" data-original="<?php echo $showimgapi,$v['cover'];?>" alt="<?php echo $v['name'];?>" /></a>
<h2><a href="<?php echo $v['url'];?>" target="_blank" onclick="ga('send','event', 'listC<?php echo $cid;?>',''<?php echo $v['name'];?>');"><?php echo $v['name'];?></a></h2>
<p>分类：<?php echo $channel[$v['id']]['name'];?></p>
<p>人气：<?php echo $v['hits'];?></p>
<p>时间：<?php echo $v['onlinedate'];?></p>
<p><a href="<?php echo $v['url'];?>" class="btn1" target="_blank" onclick="ga('send','event', 'listC<?php echo $cid;?>','views_<?php echo $v['name'];?>');">马上观看</a></p></li>
<?php }?>
</div>
<!-- 分类列表结束//End -->
<div class="page">
<?php echo $page_string;?>
<?php if($page_string){?>
<span><input type='input' id='go_page' size='4'/><input type='button' value='跳转' onclick="getPageGoUrl(<?php echo $pageTotal;?>,'page','<?php echo $list_url_tpl;?><page>')" class='btn' /></span>
<?php }?>
</div>
</div>
</div>
</div>
<div class="all960 wrap mb">
<!-- 广告位置开始//End  -->
<!-- 广告位置结束//End  -->
</div>
