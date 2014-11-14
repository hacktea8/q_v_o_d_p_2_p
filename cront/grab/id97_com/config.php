<?php

$_root='http://www.id97.com/';
$_devStatus = 'OK';
#$http_proxy = '211.138.121.37:82';
$http_proxy = '';
//
$strreplace=array(
array('from'=>'id97.com','to'=>'qvdhd.com')
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
'动作'=>array('cid'=>1,'ourl'=>'/movie/dz/','name'=>'动作片')
,'喜剧'=>array('cid'=>2,'ourl'=>'/movie/xj/','name'=>'喜剧片')
,'科幻'=>array('cid'=>3,'ourl'=>'/movie/kh/','name'=>'科幻片')
,'恐怖'=>array('cid'=>4,'ourl'=>'/movie/kb/','name'=>'恐怖片')
,'战争'=>array('cid'=>5,'ourl'=>'/movie/zhanzheng/','name'=>'战争片')
,'爱情'=>array('cid'=>6,'ourl'=>'/movie/aq/','name'=>'爱情片')
,'剧情'=>array('cid'=>7,'ourl'=>'/movie/jq/','name'=>'剧情片')
,'动漫'=>array('cid'=>8,'ourl'=>'/anime/','name'=>'动漫片')
,'综艺'=>array('cid'=>9,'ourl'=>'/zypd/','name'=>'综艺片')
#,array('cid'=>10,'ourl'=>'/32','name'=>'纪录片')
,'大陆'=>array('cid'=>11,'ourl'=>'/teleplay/guochan/','name'=>'大陆剧')
,'香港'=>array('cid'=>12,'ourl'=>'/teleplay/xianggang/','name'=>'香港剧')
,'台湾'=>array('cid'=>13,'ourl'=>'/teleplay/taiwan/','name'=>'台湾剧')
,'日本'=>array('cid'=>14,'ourl'=>'/teleplay/riben/','name'=>'日本剧')
,'韩国'=>array('cid'=>15,'ourl'=>'/teleplay/hanguo/','name'=>'韩国剧')
,'欧美'=>array('cid'=>16,'ourl'=>'/teleplay/oumei/','name'=>'欧美剧')
,'海外'=>array('cid'=>17,'ourl'=>'/teleplay/taiguo/','name'=>'海外剧')
,'老电影'=>array('cid'=>49,'ourl'=>'/movie/laodianying/','name'=>'老电影')

);

$cids = array(1,2,3,4,5,6,7,8,9,11,12,13,14,15,16,17,49);
//$cids = array(12,13,14,15,16,17,49);

?>
