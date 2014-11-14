<?php

function getinfodetail($ourl){
  global $_root,$strreplace,$pregreplace,$cate_config;
echo $ourl,"\n";
  $html = getHtml($ourl);
  if(!$html){
    echo "获取html失败";exit;
  }
  $data = array();
  $data['ptime']=time();
  $data['utime']=time();
  preg_match('#<span class="x-m-label">导演</span></td> <\!\-\- <td>([^<]*)</td>\-\->#Uis',$html,$match);
  $director = trim(@$match[1]);
  $director = '导演:'.str_replace(' / ',',',$director);
  preg_match('#<span class="x-m-label">主演</span></td> <!-- <td>([^<]*)</td>-->\s*<td>#Uis',$html,$match);
  $actor = trim(@$match[1]);
  $actor = '演员:'.str_replace(' / ',',',$actor);
  preg_match('#<span class="x-m-label">类型</span></td> <!-- <td>([^<]*)</td>-->\s*<td>#Uis',$html,$match);
  $type = trim(@$match[1]);
  $cids = explode(' / ',$type);
  $ckey = count($cids);
  $ck = mt_rand(0,$ckey-1);
  $ckey = $cids[$ck];
  $cid = getCidByname($ckey);
  $data['cid'] = $cid;
  $type = '类型:'.str_replace(' / ',',',$type);
  preg_match('#<span class="x-m-label">别名</span></td> <!-- <td>([^<]*)</td>-->\s*<td>#Uis',$html,$match);
  $alias = trim(@$match[1]);
  $alias = '别名:'.str_replace(' / ',',',$alias);
  $data['actor'] = $director.'|'.$actor.'|'.$type.'|'.$alias;
  $data['keyword'] = '';
  preg_match('#<div class="x-m-summary">(.+)</div>#Uis',$html,$match);
  $match[1] = @$match[1];
//echo $match[1],"\n";
  $data['intro'] = strip_tags($match[1]);
  $data['intro'] = preg_replace('#&\S+;#Uis','',$data['intro']);
  $data['intro'] = mb_strlen($data['intro'])>300?mb_substr($data['intro'],0,300,'utf-8'):$data['intro'];
  $data['intro'] = str_replace('?','',$data['intro']);
  $data['intro'] = trim($data['intro']);
  $data['intro'] = preg_replace("#(\r\n|\r|\n)+#is","\r\n",$data['intro']);
  $data['intro'] = @iconv("UTF-8","UTF-8//TRANSLIT",$data['intro']);
  $data['intro'] = str_replace('?','',$data['intro']);
  return $data;
}
function getFullPath($url){
  if( !stripos($url,'://')){
    global $_root;
    $url = $_root.$url;
  }
  return $url;
}
function getParseVideoInfo($purl){
 global $_root;
 $html = getHtml($purl);
  if( !$html){
    return array();
  }
  $html = urldecode($html);
  $html = iconv('UTF-8',"UTF-8//TRANSLIT",$html);
 preg_match_all('#<script[^>]*>(.+)</script>#Uis',$html,$match);
//var_dump($match);exit;
 $jsArr = @$match[1];
 $jsArr = is_array($jsArr)?$jsArr:array();
 $return = array();
 foreach($jsArr as $js){
  if(stripos($js,'flashvars')>0){
   $player = '';
   if(false !== stripos($js,'/cmp4xml/')){
    $player = 'cmp4';
    preg_match('#lists : "([^"]+)"#is',$js,$match);
    $link = trim(@$match[1]);
    $link = str_replace($_root,'/',$link);
    $v = array(sprintf('在线观看$%s',$link));
    $return[] = array($player,$v);
   }elseif(false !== stripos($js,'/iqiyixml/')){
    $player = 'online';
    preg_match("#f:'/videos/iqiyixml/iqy/([^']+)'#is",$js,$match);
    $link = trim(@$match[1]);
    $link = str_replace($_root,'/',$link);
    $v = array(sprintf('在线观看$%s',$link));
    $return[] = array($player,$v);
   }
  }
 }
 preg_match('#<embed src="[^"]*plugins/youku/loader.swf\?VideoIDS=([^"]+)&amp;[^"]*" type="application/x-shockwave-flash"#is',$html,$match);
 $youku = @$match[1];
 if($youku){
  $v = array(sprintf('在线观看$%s',$youku));
  $return[] = array('youku',$v);
 }
 
  
 
 return $return;
}
function getCidByname($name){
 global $cate_config;
 $cid = 49;
 foreach($cate_config as $k => $v){
  if($k == $name){
   $cid = $v['cid'];
   break;
  }
 }
 return $cid;
}
