<?php

$APPPATH=dirname(__FILE__).'/';
include_once($APPPATH.'../config.php');
include_once($APPPATH.'../function.php');
include_once($APPPATH.'/function.php');
include_once($APPPATH.'config.php');


/*============ Get Cate article =================*/


$num=17;
$start_page = 1;
foreach($cate_config as $_cate){
  $i = $_cate['cid'];
  //1,5,9,13,17,49 isok
  if($i > $num){
    break;
  }
  if($i != $num){
    continue;
  }
  $cid = $i;
  getinfolist($_cate);
  echo "\n==== 抓取任务结束! =====\n";
}



?>
