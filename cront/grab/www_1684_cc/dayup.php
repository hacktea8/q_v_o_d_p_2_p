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

$num=17;
foreach($cids as $num){
$i=0;
foreach($cate_config as $_cate){
  $i = $_cate['cid'];
  //1,5,9,13,17 isok
  if($i > $num){
    break;
  }
  if($i != $num){
    continue;
  }

//var_dump($_cate);exit;
  $cid = $i;
  getinfolist($_cate);
  echo "\n==== 抓取任务结束! =====\n";
}
sleep(10);
}


?>
