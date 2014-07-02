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

$num = 39;
foreach($cate_config as $_cate){
  $i = $_cate['cid'];
  //3,7,11,15,35,39,43,47 isok
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
