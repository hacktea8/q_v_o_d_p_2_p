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


$start_page = 1;
for(; $start_page<5;$start_page++){
 $listUrl = sprintf('%svideos/movie/page/%d',$_root,$start_page);
 $html = getHtml($listUrl);
 preg_match_all('#<a href="([^"]*)">\s*<img src="([^"]*)" height="280" width="180">\s*<div class="meta lh180">\s*<p>([^<]*)</p>\s*<em>[^<]*</em>\s*</div>\s*</a>#Uis',$html,$mhList);
// var_dump($mhList);
 $urlPool = $mhList[1];
 $picPool = $mhList[2];
 $titlePool = $mhList[3];
 foreach($urlPool as $uk => $uv){
  preg_match('#/(\d+)\.html#is',$uv,$mh);
  $ovid = @$mh[1];
  if( !$ovid){
   echo "\n==== get ovid failed Ourl: $uv Page: $start_page ====\n";continue;
  }
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
  $vinfo = getParseVideoInfo($uv);
  $data['vols'] = $vinfo;
//var_dump($data);exit;
  if(empty($vinfo) ){
   echo "\n==== Get Parse Info Failed Ourl: $infoUrl Purl: $sourceUrl  Page: $start_page =====\n";
   if(stripos($uv,'/resource/id/') !== false){
    continue;
   }
   exit;
  }
  $aid = checkArticleByOname($data['name']);
  if($aid){
   $vdata = array('name'=>$data['name'],'vols'=>$data['vols']);
   $aid = addArticleVols($vdata);
   echo "{$aid}已存在更新! ovid: $ovid Page: $start_page \r\n";
   $m->addid97vid($ovid);
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
