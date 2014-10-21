<?php

$_root='http://www.7khd.com/';
$_devStatus = 'OK';
#$http_proxy = '211.138.121.37:82';
$http_proxy = '';
//
$strreplace=array(
array('from'=>'www.7khd.com','to'=>'www.qvdhd.com')
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
array('cid'=>1,'ourl'=>'/list/5','name'=>'动作片')
,array('cid'=>2,'ourl'=>'/list/6','name'=>'喜剧片')
,array('cid'=>3,'ourl'=>'/list/8','name'=>'科幻片')
,array('cid'=>4,'ourl'=>'/list/9','name'=>'恐怖片')
,array('cid'=>5,'ourl'=>'/list/11','name'=>'战争片')
,array('cid'=>6,'ourl'=>'/list/7','name'=>'爱情片')
,array('cid'=>7,'ourl'=>'/list/10','name'=>'剧情片')
,array('cid'=>8,'ourl'=>'/list/4','name'=>'动漫片')
,array('cid'=>9,'ourl'=>'/list/3','name'=>'综艺片')
#,array('cid'=>10,'ourl'=>'/32','name'=>'纪录片')
,array('cid'=>11,'ourl'=>'/list/12','name'=>'大陆剧')
,array('cid'=>12,'ourl'=>'/list/13','name'=>'香港剧')
#,array('cid'=>13,'ourl'=>'/list/13','name'=>'台湾剧')
,array('cid'=>14,'ourl'=>'/list/14','name'=>'日本剧')
#,array('cid'=>15,'ourl'=>'/list/14','name'=>'韩国剧')
,array('cid'=>50,'ourl'=>'/list/16','name'=>'音乐MV')
,array('cid'=>51,'ourl'=>'/list/17','name'=>'QMV热片')
,array('cid'=>51,'ourl'=>'/list/18','name'=>'QMV热片')
,array('cid'=>52,'ourl'=>'/list/21','name'=>'微电影')

);

$cids = array();
//$cids = array(12,13,14,15,16,17,49);

?>
