<?php

$APPPATH=dirname(__FILE__).'/';
include_once($APPPATH.'../config.php');
include_once($APPPATH.'../function.php');
include_once($APPPATH.'/function.php');
include_once($APPPATH.'config.php');


/*============ Get Cate article =================*/


$startPage = 1;
$num = 7;
foreach($cate_config as $k => $_cate){
  //3,7 isok
  if($k > $num){
    break;
  }
  if($k != $num){
    continue;
  }
  $cid = $_cate['cid'];
  getinfolist($_cate);
  sleep(10);
}
echo "\n++ Grab List Cid:$cid Is OK! ++\n";


?>
