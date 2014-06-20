<?php

$_root='http://www.zjyxh.com/';
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
array('cid'=>1,'ourl'=>'5','name'=>'动作片')
,array('cid'=>2,'ourl'=>'6','name'=>'喜剧片')
,array('cid'=>3,'ourl'=>'8','name'=>'科幻片')
,array('cid'=>4,'ourl'=>'10','name'=>'恐怖片')
,array('cid'=>5,'ourl'=>'11','name'=>'战争片')
,array('cid'=>6,'ourl'=>'7','name'=>'爱情片')
,array('cid'=>7,'ourl'=>'9','name'=>'剧情片')
,array('cid'=>8,'ourl'=>'4','name'=>'动漫片')
,array('cid'=>9,'ourl'=>'3','name'=>'综艺片')
,array('cid'=>10,'ourl'=>'12','name'=>'纪录片')
,array('cid'=>11,'ourl'=>'13','name'=>'大陆剧')
,array('cid'=>12,'ourl'=>'14','name'=>'香港剧')
#,array('cid'=>13,'ourl'=>'11/','name'=>'台湾剧')
,array('cid'=>14,'ourl'=>'15','name'=>'日本剧')
#,array('cid'=>15,'ourl'=>'15/','name'=>'韩国剧')
,array('cid'=>16,'ourl'=>'16','name'=>'欧美剧')
#,array('cid'=>17,'ourl'=>'19/','name'=>'海外剧')
#,array('cid'=>20,'ourl'=>'16/','name'=>'泰国剧')

);

$cids = array(1,2,3,4,5,6,7,8,9,10,11,12,14,16);
$cids = array(11);

?>
