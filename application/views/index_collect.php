<div class="box" id="jq">
<!-- 分类列表开始//End -->
<div class="">
<div class="channellist box mb bg">
<h3 class="ppv"><?php echo $channel[$cid]['name'];?>列表</h3>
<ul>
<?php foreach($infolist as &$v){?>
<li onmousemove="this.className='thisli'" onmouseout="this.className=''"><a href="<?php echo $v['url'];?>" class="aimg l" target="_blank"><img class="lazy" title="<?php echo $v['name'];?>" alt="<?php echo $v['name'];?>" data-original="<?php echo $showimgapi,$v['cover'];?>" alt="<?php echo $v['name'];?>" /></a>
<h2><a href="<?php echo $v['url'];?>" target="_blank"><?php echo $v['name'];?></a></h2>
<p>分类：<?php echo $channel[$v['cid']]['name'];?></p>
<p>人气：<?php echo $v['hits'];?></p>
<p>时间：<?php echo $v['atime'];?></p>
<p><a href="<?php echo $v['url'];?>" class="btn1" target="_blank">马上观看</a></p></li>
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
