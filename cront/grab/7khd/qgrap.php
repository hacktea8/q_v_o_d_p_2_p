<?php
$start_page = 1;

$APPPATH=dirname(__FILE__).'/';
include_once($APPPATH.'../config.php');
include_once($APPPATH.'../function.php');
include_once($APPPATH.'/function.php');
include_once($APPPATH.'config.php');


/*============ Get Cate article =================*/


$num=16;
foreach($cate_config as $k => $_cate){
  $i = $_cate['cid'];
  //0,4,8,12,16 isok
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
