<?php

$APPPATH=dirname(__FILE__).'/';
include_once($APPPATH.'../function.php');
include_once($APPPATH.'/function.php');
include_once($APPPATH.'config.php');

/**/
getAllcate();exit;
/**/

/*============ Get Cate article =================*/

$res='excres.txt';

$lastgrab=basename(__FILE__);
$path=$APPPATH.'config/';

getsubcatelist($subcate);
$i=0;
$num=152;
foreach($subcate as $_cate){
$i++;
//3,6,9,12,15,18,21,,24,27 isok
if($i>$num){
break;
}
if($i!=$num){
continue;
}
   $lastgrab=$path.$_cate['id'].'_'.$lastgrab;
   getSubCatearticle($_cate);
file_put_contents($res,"num $num 已抓取完毕!\r\n",FILE_APPEND);
sleep(10);
}



?>
