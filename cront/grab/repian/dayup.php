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

$abort = 0;
$lastK = 0;
  
foreach($cate_config as $k => $_cate){
 $i = $_cate['cid'];
 echo "\n==== Current Index $k Cid $i =====\n";
 if($abort && $lask < $k){
  continue;
 }

 #var_dump($_cate);exit;
 $cid = $_cate['cid'];
 getinfolist($_cate);
 sleep(10);
 echo "\n++ Grab Cate Cid:$cid Is OK! ++\n";
 }

?>
