<?php

$APPPATH=dirname(__FILE__).'/';
include_once($APPPATH.'../config.php');
include_once($APPPATH.'../function.php');
include_once($APPPATH.'/function.php');
include_once($APPPATH.'config.php');

/*============ Get Cate article =================*/

$lastgrab = basename(__FILE__);
$path = $APPPATH.'config/';

//page 268

$num = 6;
foreach($cate_config as $_cate){
  $i = $_cate['cid'];
  //2,6,10,14,18 isok
  if($i > $num){
    break;
  }
  if($i != $num){
    continue;
  }
  $cid = $_cate['cid'];
  getinfolist($_cate);
  sleep(10);
}
echo "\n++ Grab List Cid:$cid Is OK! ++\n";



?>
