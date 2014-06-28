<?php

require_once 'upyun.class.php';

class Upai{
 public $api = '';
 public $optUinfo = array(array('bucket'=>'cdn-emubt','user'=>'emubt','pwd'=>'iloveemubt'));
 public $sT = 0;

 public function __construct($config = array()){
  foreach($config as $k => $v){
   if(isset($this->$k)){
	$this->$k = $v;
   }
  }
  $uinfo = isset($this->optUinfo[$this->sT])?$this->optUinfo[$this->sT]:$this->optUinfo[0];
  $this->api = new UpYun($uinfo['bucket'], $uinfo['user'], $uinfo['pwd']);
  return true;
 }
 function uploadFile2Upai($fname,$targetName){
  if( !file_exists($fname)){
   return array('err_msg'=>'File '.$fname.' is not exists!');
  }
  $con = file_get_contents($fname);
  $opts = array(
   UpYun::CONTENT_MD5 => md5($con)
  );
  $rsp = $this->api->writeFile($targetName, $con, True, $opts);   // 上传图片，自动创建目录
  return $rsp;
 }
}
