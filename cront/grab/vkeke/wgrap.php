<?php

$APPPATH=dirname(__FILE__).'/';
include_once($APPPATH.'../config.php');
include_once($APPPATH.'../function.php');
include_once($APPPATH.'/function.php');
include_once($APPPATH.'config.php');


/*============ Get Cate article =================*/

$lastgrab = basename(__FILE__);
$path = $APPPATH.'config/';

//152

$num = 11;
foreach($cate_config as $_cate){
  $i = $_cate['cid'];
  //3,7,11,15,19,47 isok
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
