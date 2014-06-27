<?php

$_root='http://www.77vcd.com/';
$_devStatus = 'OK';
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
array('cid'=>1,'ourl'=>'/Action/','name'=>'动作片')
,array('cid'=>2,'ourl'=>'/Comedy/','name'=>'喜剧片')
,array('cid'=>3,'ourl'=>'/Sci-Fi/','name'=>'科幻片')
,array('cid'=>4,'ourl'=>'/Horror/','name'=>'恐怖片')
,array('cid'=>5,'ourl'=>'/War/','name'=>'战争片')
,array('cid'=>6,'ourl'=>'/Romance/','name'=>'爱情片')
,array('cid'=>7,'ourl'=>'/Drama/','name'=>'剧情片')
,array('cid'=>8,'ourl'=>'/Animation/','name'=>'动漫片')
,array('cid'=>9,'ourl'=>'/Varietyshow/','name'=>'综艺片')
#,array('cid'=>10,'ourl'=>'/17/','name'=>'纪录片')
,array('cid'=>11,'ourl'=>'/Mainland/','name'=>'大陆剧')
,array('cid'=>12,'ourl'=>'/HongKong/','name'=>'香港剧')
,array('cid'=>13,'ourl'=>'/Taiwan/','name'=>'台湾剧')
,array('cid'=>14,'ourl'=>'/Japan/','name'=>'日本剧')
,array('cid'=>15,'ourl'=>'/Korea/','name'=>'韩国剧')
,array('cid'=>16,'ourl'=>'/Occident/','name'=>'欧美剧')
,array('cid'=>17,'ourl'=>'/Singapore/','name'=>'海外剧')
,array('cid'=>20,'ourl'=>'/Thailand/','name'=>'泰国剧')

);

$cids = array(1,2,3,4,5,6,7,8,9,11,12,13,14,15,16,17,20);
$cids = array(17);

?>
