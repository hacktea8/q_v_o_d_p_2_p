<?php

$_root='http://www.vkeke.com/';
$_devStatus = '_OK';
#$http_proxy = '211.138.121.37:82';
$http_proxy = '';
//
$strreplace=array(
array('from'=>'www.ed2kers.com','to'=>'emu.hacktea8.com')
,array('from'=>'\"','to'=>'"')
,array('from'=>'\r\n','to'=>'')
,array('from'=>'\n','to'=>'')
);
//
$pregreplace=array(
array('from'=>'#<br>引用.+</td>#Us','to'=>'</td>')
,array('from'=>'#<script [^>]+>.*</script>#','to'=>'')
);

$cate_config = array(
array('cid'=>1,'ourl'=>'/channel/list1','name'=>'动作片')
,array('cid'=>2,'ourl'=>'/channel/list2','name'=>'喜剧片')
,array('cid'=>3,'ourl'=>'/channel/list4','name'=>'科幻片')
,array('cid'=>4,'ourl'=>'/channel/list6','name'=>'恐怖片')
,array('cid'=>5,'ourl'=>'/channel/list5','name'=>'战争片')
,array('cid'=>6,'ourl'=>'/channel/list3','name'=>'爱情片')
,array('cid'=>7,'ourl'=>'/channel/list7','name'=>'剧情片')
,array('cid'=>11,'ourl'=>'/teleplay/list1','name'=>'大陆剧')
,array('cid'=>12,'ourl'=>'/teleplay/list2','name'=>'香港剧')
,array('cid'=>13,'ourl'=>'/teleplay/list3','name'=>'台湾剧')
,array('cid'=>14,'ourl'=>'/teleplay/list5','name'=>'日本剧')
,array('cid'=>15,'ourl'=>'/teleplay/list4','name'=>'韩国剧')
,array('cid'=>16,'ourl'=>'/teleplay/list6','name'=>'欧美剧')
,array('cid'=>20,'ourl'=>'/teleplay/taiguojv','name'=>'泰国剧')
,array('cid'=>34,'ourl'=>'/comic/list1','name'=>'日本动漫')
,array('cid'=>35,'ourl'=>'/comic/list2','name'=>'国产动漫')
,array('cid'=>36,'ourl'=>'/comic/list3','name'=>'欧美动漫')
,array('cid'=>37,'ourl'=>'/zongyi/taiwanzongy','name'=>'台湾综艺')
,array('cid'=>38,'ourl'=>'/zongyi/guochanzongyi','name'=>'内地综艺')
,array('cid'=>39,'ourl'=>'/zongyi/ribenzongyiongyi','name'=>'日本综艺')
,array('cid'=>40,'ourl'=>'/zongyi/xianggangzongyi','name'=>'香港综艺')
,array('cid'=>41,'ourl'=>'/zongyi/hanguozongyi','name'=>'韩国综艺')
,array('cid'=>42,'ourl'=>'/zongyi/oumei','name'=>'欧美综艺')
,array('cid'=>43,'ourl'=>'/zongyi/xiaopin','name'=>'相声小品')
,array('cid'=>44,'ourl'=>'/zongyi/wanhui','name'=>'晚会')
,array('cid'=>45,'ourl'=>'/zongyi/ychi','name'=>'演唱会')
,array('cid'=>46,'ourl'=>'/zongyi/jiangzuo','name'=>'名家讲座')
,array('cid'=>47,'ourl'=>'/zongyi/kejiao','name'=>'科教节目')

);

$cids = array(1,2,3,4,5,6,7,11,12,13,14,15,16,20,34,35,36,37,38,39,40,41,42,43,44,45,46,47);
$cids = array(11);

?>
