<?php

$_root='http://www.ninikan.com/';
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
array('cid'=>1,'ourl'=>'/action/','name'=>'动作片')
,array('cid'=>2,'ourl'=>'/comedy/','name'=>'喜剧片')
,array('cid'=>3,'ourl'=>'/sciencefiction/','name'=>'科幻片')
,array('cid'=>4,'ourl'=>'/terrorist/','name'=>'恐怖片')
,array('cid'=>5,'ourl'=>'/war/','name'=>'战争片')
,array('cid'=>6,'ourl'=>'/love/','name'=>'爱情片')
,array('cid'=>7,'ourl'=>'drama/','name'=>'剧情片')
,array('cid'=>8,'ourl'=>'/anime/','name'=>'动漫片')
,array('cid'=>9,'ourl'=>'/arts/','name'=>'综艺片')
#,array('cid'=>10,'ourl'=>'/list/index32','name'=>'纪录片')
,array('cid'=>11,'ourl'=>'/domestic/','name'=>'大陆剧')
,array('cid'=>12,'ourl'=>'/hongkong/','name'=>'香港剧')
,array('cid'=>13,'ourl'=>'/taiwan/','name'=>'台湾剧')
,array('cid'=>14,'ourl'=>'/japan/','name'=>'日本剧')
,array('cid'=>15,'ourl'=>'/korea/','name'=>'韩国剧')
,array('cid'=>16,'ourl'=>'/united/','name'=>'欧美剧')
,array('cid'=>17,'ourl'=>'/overseas/','name'=>'海外剧')
,array('cid'=>21,'ourl'=>'/cantonese/','name'=>'粤语片')
#,array('cid'=>0,'ourl'=>'/last/','name'=>'最近更新')

);

$cids = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17);
$cids = array(17);

?>
