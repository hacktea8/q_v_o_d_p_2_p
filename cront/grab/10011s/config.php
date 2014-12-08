<?php

$_root='http://www.10011s.info/';
#$http_proxy = '211.138.121.37:82';
$http_proxy = '';
$_statusType = 'Error';
//
$strreplace=array(
array('from'=>'www.10011s.info','to'=>'www.qvdhd.com')
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
array('cid'=>24,'ourl'=>'/list/index1','name'=>'亚洲情色')
,array('cid'=>30,'ourl'=>'/list/index2','name'=>'劲爆欧美')
,array('cid'=>26,'ourl'=>'/list/index3','name'=>'制服丝袜')
,array('cid'=>27,'ourl'=>'/list/index5','name'=>'强奸乱论')
,array('cid'=>28,'ourl'=>'/list/index6','name'=>'偷拍自拍')
,array('cid'=>33,'ourl'=>'/list/index7','name'=>'成人动漫')
,array('cid'=>53,'ourl'=>'/list/index8','name'=>'变态另类')
,array('cid'=>32,'ourl'=>'/list/index9','name'=>'无码专区')
,array('cid'=>31,'ourl'=>'/list/index4','name'=>'人妻熟女')

);


?>
