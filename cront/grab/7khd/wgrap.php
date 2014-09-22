<?php

$APPPATH=dirname(__FILE__).'/';
include_once($APPPATH.'../config.php');
include_once($APPPATH.'../function.php');
include_once($APPPATH.'/function.php');
include_once($APPPATH.'config.php');


/*============ Get Cate article =================*/

$lastgrab = basename(__FILE__);
$path = $APPPATH.'config/';

$i = 0;
$num = 2;
$start_page = 1;
foreach($cate_config as $k => $_cate){
  $i = $_cate['cid'];
  //3,7,11,15 isok
  if($k > $num){
    break;
  }
  if($k != $num){
    continue;
  }
  $cid = $i;
  getinfolist($_cate);
  echo "\n==== 抓取任务结束! =====\n";
}



?>
