<?php
$abort = 1;
$lastK = 17;

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

  
foreach($cate_config as $k => $_cate){
 $i = $_cate['cid'];
 echo "\n==== Current Index $k Cid $i =====\n";
 if($abort && $lastK > $k){
  continue;
 }

 #var_dump($_cate);exit;
 $cid = $_cate['cid'];
 getinfolist($_cate);
 sleep(10);
 echo "\n++ Grab Cate Cid:$cid Is OK! ++\n";
}

?>
