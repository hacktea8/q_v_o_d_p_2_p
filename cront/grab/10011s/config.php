<?php

$_root='http://www.10011s.info/';
#$http_proxy = '211.138.121.37:82';
$http_proxy = '';
$_statusType = 'Error';
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
array('cid'=>24,'ourl'=>'/list/index16','name'=>'亚洲情色')
,array('cid'=>30,'ourl'=>'/list/index17','name'=>'劲爆欧美')
,array('cid'=>26,'ourl'=>'/list/index18','name'=>'制服丝袜')
,array('cid'=>48,'ourl'=>'/list/index19','name'=>'经典三级')
,array('cid'=>28,'ourl'=>'/list/index21','name'=>'偷拍自拍')
,array('cid'=>33,'ourl'=>'/list/index22','name'=>'成人动漫')
,array('cid'=>27,'ourl'=>'/list/index23','name'=>'变态另类')
,array('cid'=>32,'ourl'=>'/list/index24','name'=>'无码专区')

);

$cids = array(24,30,26,48,28,33,27,32);
//$cids = array(17);

?>
