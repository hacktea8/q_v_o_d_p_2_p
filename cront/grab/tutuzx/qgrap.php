<?php

$APPPATH=dirname(__FILE__).'/';
include_once($APPPATH.'../config.php');
include_once($APPPATH.'../function.php');
include_once($APPPATH.'/function.php');
include_once($APPPATH.'config.php');

/*/
$cateurl = '/list/index33';
$cateurl = '/list/index1';
$cid = 1;
getinfolist($cateurl);exit;
getAllcate();exit;
/**/

/*============ Get Cate article =================*/

$lastgrab = basename(__FILE__);
$path = $APPPATH.'config/';

$i=0;
$num=13;
foreach($cate_config as $_cate){
  $i++;
  //1,5,9,13,17 isok
  if($i > $num){
    break;
  }
  if($i != $num){
    continue;
  }
  $lastgrab = $path.$_cate['cid'].'_'.$lastgrab;
  getSubCatearticle($_cate);
  sleep(10);
}



?>
