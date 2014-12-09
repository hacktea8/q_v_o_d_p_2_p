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

$startPage = 1;
$abort = 0;
$index = 0;
foreach($cate_config as $k => $_cate){
 $cid = $_cate['cid'];
 echo "=== Current Index $k Cid $cid =======\n";
 // isok
 if($abort && $k < $index){
  continue;
 }

//var_dump($_cate);exit;
 getinfolist($_cate);
 sleep(10);
}
echo "=== Grab List Is OK! ".count($cate_config)." ======\n";

?>
