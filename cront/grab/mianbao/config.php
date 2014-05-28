<?php

$_root='http://www.mianbao.com/';
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

$cate_list_url = '/vod-showlist-id-%d-order-time-c-67320-p-%d.html';
$cate_config = array(
array('cid'=>1,'ourl'=>'8','name'=>'动作片')
,array('cid'=>2,'ourl'=>'2','name'=>'喜剧片')
,array('cid'=>3,'ourl'=>'11','name'=>'科幻片')
,array('cid'=>4,'ourl'=>'12','name'=>'恐怖片')
,array('cid'=>5,'ourl'=>'13','name'=>'战争片')
,array('cid'=>6,'ourl'=>'10','name'=>'爱情片')
,array('cid'=>7,'ourl'=>'14','name'=>'剧情片')
,array('cid'=>8,'ourl'=>'31','name'=>'动漫片')
,array('cid'=>9,'ourl'=>'19','name'=>'综艺片')
,array('cid'=>10,'ourl'=>'23','name'=>'纪录片')
,array('cid'=>11,'ourl'=>'15','name'=>'大陆剧')
,array('cid'=>12,'ourl'=>'25','name'=>'香港剧')
,array('cid'=>13,'ourl'=>'16','name'=>'台湾剧')
,array('cid'=>14,'ourl'=>'18','name'=>'日本剧')
,array('cid'=>15,'ourl'=>'4','name'=>'韩国剧')
,array('cid'=>16,'ourl'=>'17','name'=>'欧美剧')
,array('cid'=>17,'ourl'=>'33','name'=>'海外剧')
,array('cid'=>20,'ourl'=>'24','name'=>'泰国剧')

);
$movieCid = array(1,2,3,4,5,6,7,8,9,10);
$cids = array(8,9,10,11,12,13,14,15,15,17);
$cids = array(1);

?>
