<?php

$_root='http://www.repian.com/';
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
array('cid'=>1,'ourl'=>'/film1/','name'=>'动作片')
,array('cid'=>2,'ourl'=>'/film2/','name'=>'喜剧片')
,array('cid'=>3,'ourl'=>'/film4/','name'=>'科幻片')
,array('cid'=>4,'ourl'=>'/film5/','name'=>'恐怖片')
,array('cid'=>5,'ourl'=>'/film14/','name'=>'战争片')
,array('cid'=>6,'ourl'=>'/film3/','name'=>'爱情片')
,array('cid'=>7,'ourl'=>'/film6/','name'=>'剧情片')
,array('cid'=>8,'ourl'=>'/film7/','name'=>'动漫片')
,array('cid'=>9,'ourl'=>'/film8/','name'=>'综艺片')
,array('cid'=>10,'ourl'=>'/film17/','name'=>'纪录片')
,array('cid'=>11,'ourl'=>'/film9/','name'=>'大陆剧')
,array('cid'=>12,'ourl'=>'/film10/','name'=>'香港剧')
,array('cid'=>13,'ourl'=>'/film11/','name'=>'台湾剧')
,array('cid'=>14,'ourl'=>'/film12/','name'=>'日本剧')
,array('cid'=>15,'ourl'=>'/film15/','name'=>'韩国剧')
,array('cid'=>16,'ourl'=>'/film13/','name'=>'欧美剧')
,array('cid'=>17,'ourl'=>'/film19/','name'=>'海外剧')
,array('cid'=>20,'ourl'=>'/film16/','name'=>'泰国剧')

);

$cids = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17);
$cids = array(17);

?>
