<?php

function getinfolist(&$cate_info){
  global $_root,$cid,$cate_list_url;
  for($i=1; $i<=5000; $i++){
//通过 atotal计算i的值
    $url = sprintf('%s'.$cate_list_url,$_root,$cate_info['ourl'],$i);
echo "\n++++ ",$url," ++++\n";
    $html = getHtml($url);
    preg_match('#<ul class="show-list fn-clear" id="contents">(.+)</ul>#Uis',$html,$matchs);
    $html = $matchs[1];
//echo '<pre>';var_dump($html);exit;
    $matchs = getParseListInfo($html);
    if(empty($matchs)){
       file_put_contents('match_error_list'.$cid.'.html',$html);
       //preg_match_all('##Uis',$html,$matchs,PREG_SET_ORDER);
    }
//echo '<pre>';var_dump($matchs);exit;
    if(empty($matchs)){
      echo ('Cate list Failed '.$url."\r\n");
      return 6;
    }
    foreach($matchs as $list){
//      var_dump($list);exit;
      $oname = trim($list['name']);
/**/
//在判断是否更新
      $aid = checkArticleByOname($oname);
      if($aid){
         echo "{$aid}已存在未更新!\r\n";
         continue;
        return 6;
      }
/**/
      $list['oid'] = 0;
      //$ainfo = array('thum'=>$list['thum'],'ourl'=>$list['ourl'],'actor'=>$list['actor'],'name'=>$oname,'oid'=>$oid,'cid'=>$cid);
      getinfodetail($list);
sleep(1);
    }
  }
return 0;
}

function getinfodetail(&$data){
  global $model,$_root,$cid,$strreplace,$pregreplace,$movieCid;
echo $data['ourl'],"\n";
  $html = getHtml($data['ourl']);
//  file_put_contents('error_view.html',$html);
  if(!$html){
    echo "获取html失败";exit;
  }
  /**/
  $data['keyword'] = '';
  //
  $data['ptime']=time();
  $data['utime']=time();
  preg_match('#<div class="detail-desc-cnt">(.+)</div>#Uis',$html,$match);
  $match[1] = isset($match[1])?$match[1]:'';
  $match[1] = @iconv("UTF-8","UTF-8//TRANSLIT",$match[1]);
//echo $match[1],"\n";
  $data['intro'] = strip_tags($match[1]);
  $data['intro'] = preg_replace('#&\S+;#Uis','',$data['intro']);
  $data['intro'] = trim($data['intro']);
  if(strlen($data['intro']) > 1024){
    $data['intro'] = mb_substr($data['intro'],0,510,'UTF-8').'...';
  }
  preg_match('#<p \s*class="play-list"><a \s*target="_blank" \s*href="(/videos/\d+vod-play-id-\d+-sid-\d+-pid-\d+\.html)">.+</a>#Uis',$html,$match);
  $purl = isset($match[1])?$match[1]:'';
  //$purl = '/videos/57122vod-play-id-57122-sid-0-pid-15.html';
  if(!$purl){
     file_put_contents('play_url_html.html',$html);
     die("\n Ourl: $data[ourl] Get PlayUrl Error!\n");
  }
  $data['purl'] = $_root.$purl;
  $playhtml = getArticlePlayData($data['purl']);
  if(empty($playhtml)){
    echo ("\n++ Ourl:$data[ourl] Purl:$data[purl] playdata vols decode error!++\n");
    //return 0;
  }
  $data['vols'] = $playhtml;
  unset($data['purl']);
  if(!$data['name']){
     echo "抓取失败 $data[ourl] \r\n";
     return false;
  }
  if(empty($data['vols'])){
    $data['status'] = 5;
    echo "\nOurl: $data[ourl] Get PlayVols Empty!\n";
  }
  $data['ourl'] = str_replace($_root,'',$data['ourl']);
  echo '<pre>';var_dump($data);exit;

/**
//在判断是否更新
  $oname = $data['name'];
  $aid = checkArticleByOname($oname);
  if($aid && !empty($data['vols'])){
    $vdata = array('name'=>$data['name'],'vols'=>$data['vols']);
    $aid = addArticleVols($vdata);
    echo "{$aid}已存在更新!\r\n";
    return 6;
  }
  if($aid && empty($data['vols'])){
    echo "{$aid}已存在更新!\r\n";
    return 6;
  }
/**/
  $aid = addArticle($data);
//echo '|',$aid,'|';exit;
  if( !$aid){
    var_dump($data);echo "\r\n添加失败! $data[ourl] \r\n";
    exit;return false;
  }
  echo "添加成功! $aid \r\n";
}
function getArticlePlayData($purl){
  global $_root;
  $count = substr_count($purl,$_root);
  if(1 != $count){
    $purl = str_replace($purl,$_root);
    $purl = $_root.$purl;
  }
  $html = getHtml($purl);
  preg_match('#<div id="player"><script language="javascript">(.+)</script>#Uis',$html,$match);
  $playjs = $match[1];
  if(empty($playjs)){
    die("\nPurl: $purl Get Play Data Empty!\n");
  }
  $count = substr_count($playjs,'pp_play.replace(');
  if($count){
    return array();
  }
  preg_match('#var pp_play="([^"]+)";#Uis',$playjs,$match);
  $pinfo = $match[1];
  if(!$pinfo){
    die("\nPurl: $purl Get pp_play info empty!\n");
  }
  $pinfo = urldecode($pinfo);
  $pinfo = explode('$$$',$pinfo);
  $return = array();
  foreach($pinfo as &$v){
    if(false !== stripos($v,'qvod://')){
      $v = str_replace('++qvod','$qvod',$v);
      $v = str_replace('+++','$qvod+++',$v);
      $v .= '$qvod';
      $v = unicode_encode($v);
      $v = explode('+++',$v);
      $return[] = array('qvod',$v);
    }elseif(false !== stripos($v,'bdhd://')){
      $v = str_replace('++bdhd','$bdhd',$v);
      $v = str_replace('+++','$bdhd+++',$v);
      $v .= '$bdhd';
      $v = unicode_encode($v);
      $v = explode('+++',$v);
      $return[] = array('bdhd',$v);
    }
  }
  return $return;
}
function getParseListInfo($html){
  $return = array();
  $info = array();
  preg_match_all('#<li>(.+)</li>#Uis',$html,$match);
//var_dump($match);exit;
  $match = $match[1];
  foreach($match as $mhtml){
    preg_match('#<a class="play-img" target="_blank" href="([^"]+)"><img src="([^"]+)" alt="([^"]+)" /><label class="score">[^<]+</label></a>#Uis',$mhtml,$match);
    $info['ourl'] = isset($match[1])?$match[1]:'';
    $info['thum'] = isset($match[2])?$match[2]:'';
    $info['thum'] = strlen($info['thum'])>255?'':$info['thum'];
    $info['name'] = isset($match[3])?$match[3]:'';
    if(!$info['name']){
      file_put_contents('list_video_name.html',$html);
      die("\nList info empty!\n");
    }
    preg_match('#<em>主演:</em>(.+)</p>#Uis',$mhtml,$match);
    $actor = isset($match[1])?$match[1]:'';
    $actor = str_replace('</a>',',',$actor);
    $actor = strip_tags($actor);
    $actor = trim($actor,',');
    $info['actor'] = $actor;
    preg_match('#<em>类型：</em>(.+)</p>#Uis',$mhtml,$match);
    $actor = $match[1];
    $actor = str_replace('</a>',',',$actor);
    $actor = strip_tags($actor);
    $actor = trim($actor,',');
    $info['actor'] .= '|'.$actor;
    $info['actor'] = preg_replace('#,\s*,+#',',',$info['actor']);
//var_dump($info);exit;
    $return[] = $info;
  }
  return $return;
}
