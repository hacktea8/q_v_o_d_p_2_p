<?php

$APPPATH=dirname(__FILE__).'/';
include_once($APPPATH.'../config.php');
include_once($APPPATH.'../function.php');
include_once($APPPATH.'/function.php');
include_once($APPPATH.'config.php');

/*============ Get Cate article =================*/

$lastgrab = basename(__FILE__);
$path = $APPPATH.'config/';
// 
// En site

$num=9;
foreach($cate_config as $_cate){
  $i = $_cate['cid'];
  //1,5,9,13,17 isok
  if($i > $num){
    break;
  }
  if($i != $num){
    continue;
  }
  $cid = $i;
  getinfolist($_cate);
  sleep(10);
}
echo "\n++ Grab Cate Cid:$cid Is OK! ++\n";


?>
