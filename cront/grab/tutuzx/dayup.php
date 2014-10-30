<?php
$abort = 0;
$lastK = 15;
$startPage = 1;

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


foreach($cids as $num){
 $i=0;
 if($abort && $num < $lastK){
  continue;
 }
foreach($cate_config as $_cate){
  $i++;
  //1,5,9,13,17 isok
  if($i > $num){
    break;
  }
  if($i != $num){
    continue;
  }
  echo "\n==== Cid $_cate[cid] ====\n";
//var_dump($_cate);exit;
  $lastgrab = $path.$_cate['cid'].'_'.$lastgrab;
  getSubCatearticle($_cate);
  sleep(10);
}
sleep(10);
}


?>
