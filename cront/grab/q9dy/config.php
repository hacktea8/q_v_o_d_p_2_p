<?php

$_root='http://www.q9dy.com/';
#$_root='http://xigua.wzyy.la/llp/';
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
array('cid'=>1,'ourl'=>'/list/index1','name'=>'动作片')
,array('cid'=>2,'ourl'=>'/list/index2','name'=>'喜剧片')
,array('cid'=>3,'ourl'=>'/list/index3','name'=>'科幻片')
,array('cid'=>4,'ourl'=>'/list/index4','name'=>'恐怖片')
,array('cid'=>5,'ourl'=>'/list/index5','name'=>'战争片')
,array('cid'=>6,'ourl'=>'/list/index6','name'=>'爱情片')
,array('cid'=>7,'ourl'=>'/list/index7','name'=>'剧情片')
,array('cid'=>8,'ourl'=>'/list/index8','name'=>'动漫片')
,array('cid'=>9,'ourl'=>'/list/index9','name'=>'综艺片')
,array('cid'=>10,'ourl'=>'/list/index32','name'=>'纪录片')
,array('cid'=>11,'ourl'=>'/list/index10','name'=>'大陆剧')
,array('cid'=>12,'ourl'=>'/list/index11','name'=>'香港剧')
,array('cid'=>13,'ourl'=>'/list/index12','name'=>'台湾剧')
,array('cid'=>14,'ourl'=>'/list/index13','name'=>'日本剧')
,array('cid'=>15,'ourl'=>'/list/index14','name'=>'韩国剧')
,array('cid'=>16,'ourl'=>'/list/index15','name'=>'欧美剧')
,array('cid'=>17,'ourl'=>'/list/index30','name'=>'海外剧')
,array('cid'=>18,'ourl'=>'/list/index34','name'=>'全部电视剧')

);

$cids = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17);
//$cids = array(17);

?>
