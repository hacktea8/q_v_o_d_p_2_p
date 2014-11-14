<?php

$APPPATH = dirname(__FILE__).'/';
include_once($APPPATH.'../config.php');
include_once($APPPATH.'../function.php');
include_once($APPPATH.'/function.php');
include_once($APPPATH.'config.php');
include_once($APPPATH.'../db.class.php');
include_once($APPPATH.'../model.php');

$nopassword = 1;
$m = new Model();

/*============ Get Cate article =================*/


for($ovid = 1; ;$ovid++){
// check local exists
  $check = $m->checkid97vid($ovid);
  if($check){
   echo "\n=== $ovid already exists! ====\n";continue;
  }
  $infoUrl = sprintf('%svideos/play/mid/%d.html',$_root,$ovid);
  $title = trim($titlePool[$uk]);
  $sourceUrl = sprintf('%svideos/resource/id/%d',$_root,$ovid);
  $data = getinfodetail($sourceUrl);
  $data['name'] = $title;
  $data['ourl'] = $ovid;
  $data['thum'] = $picPool[$uk];
  $vinfo = getParseVideoInfo($infoUrl);
  $data['vols'] = $vinfo;
//var_dump($data);exit;
  if(empty($vinfo)){
   echo "\n==== Get Parse Info Failed Ourl: $infoUrl Purl: $sourceUrl  Page: $start_page =====\n";exit;
  }
  $aid = checkArticleByOname($data['name']);
  if($aid){
   $vdata = array('name'=>$data['name'],'vols'=>$data['vols']);
   $aid = addArticleVols($vdata);
   echo "{$aid}已存在更新! ovid: $ovid Page: $start_page \r\n";
   continue;
  }
  $aid = addArticle($data);
  if($aid){
   $m->addid97vid($ovid);
   echo "\n=== Add Aid: $aid  ovid: $ovid Page: $start_page OK ====\n";
  }else{
   var_dump($data);echo "\r\n添加失败! Ourl: $infoUrl \r\n";
   exit;
  }
//exit;
  sleep(6);
 }

// exit;
}



?>
