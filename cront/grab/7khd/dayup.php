<?php

$APPPATH=dirname(__FILE__).'/';
include_once($APPPATH.'../config.php');
include_once($APPPATH.'../function.php');
include_once($APPPATH.'/function.php');
include_once($APPPATH.'config.php');

/*/
/**/

/*============ Get Cate article =================*/

$lastgrab = basename(__FILE__);
$path = $APPPATH.'config/';

$num=0;
$len = count($cate_config);
for($num = 0;$num<$len;$num++){
foreach($cate_config as $k => $_cate){
  $i = $_cate['cid'];
  //0, isok
  if($k > $num){
    break;
  }
  if($k != $num){
    continue;
  }

//var_dump($_cate);exit;
  $cid = $i;
  getinfolist($_cate);
  echo "\n==== 抓取任务结束! =====\n";
}
}

?>
