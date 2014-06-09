<?php

function getinfolist(&$_cate){
  global $_root,$cid;
  for($i=1; $i<=2000; $i++){
//通过 atotal计算i的值
    //$suf = $i == 1?'':'_'.$i;
    $url = sprintf('%s/?s=vod-show-id-%d-p-%d.html',$_root,$_cate['ourl'],$i);
echo "\n++++ ",$url," ++++\n";
    $html = getHtml($url);
  //  $html = iconv("GBK","UTF-8//TRANSLIT",$html) ;
  //  $html = mb_convert_encoding($html,"UTF-8","GBK");
    $matchs = getParseListInfo($html);
//echo '<pre>';var_dump($matchs);exit;
    if(empty($matchs)){
      file_put_contents('match_error_list'.$cid.'.html',$html);
      echo ('Cate list Failed '.$url."\r\n");
      return 6;
    }
    foreach($matchs as $list){
      $oid = preg_replace('#[^\d]+#','',$list['url']);
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
      $ourl = $_root.$list['url'];
      $purl = $_root.$list['purl'];
      $ainfo = array('thum'=>$list['thum'],'ourl'=>$ourl,'purl'=>$purl,'keyword'=>$list['actor'],'name'=>$oname,'oid'=>$oid,'cid'=>$cid);
      getinfodetail($ainfo);
sleep(5);
    }
  }
return 0;
}

function getinfodetail(&$data){
  global $model,$_root,$cid,$strreplace,$pregreplace;
echo $data['ourl'],"\n";
  $html = getHtml($data['ourl']);
//  file_put_contents('error_view.html',$html);
  //$html = iconv("GBK","UTF-8//TRANSLIT",$html) ;
  //$html = mb_convert_encoding($html,"UTF-8","GBK");
  if(!$html){
    echo "获取html失败";exit;
  }
  $data['keyword'] = '';
  //
  $data['ptime']=time();
  $data['utime']=time();
  preg_match('#<div class="vod_content">(.+)</div>#Uis',$html,$match);
  $match[1] = isset($match[1])?$match[1]:'';
  $match[1] = @iconv("UTF-8","UTF-8//TRANSLIT",$match[1]);
//echo $match[1],"\n";
  $data['intro'] = strip_tags($match[1]);
  $data['intro'] = preg_replace('#&\S+;#Uis','',$data['intro']);
  $data['intro'] = trim($data['intro']);
  $data['intro'] = mb_strlen($data['intro'],'UTF-8')>300?mb_substr($data['intro'],0,300,'UTF-8'):$data['intro'];
//  $data['purl'] = '';
  $playhtml = getArticlePlayData($data['purl']);
  if(empty($playhtml)){
    echo ("\n++ Ourl:$data[ourl] Purl:$data[purl] playdata vols decode error!++\n");
exit;
    return 0;
  }
  $data['vols'] = $playhtml;
  unset($data['purl']);
  if(!$data['name'] || empty($data['vols'])){
     echo "抓取失败 $data[ourl] \r\n";
     return false;
  }
  $data['ourl'] = str_replace($_root,'',$data['ourl']);
  echo '<pre>';var_dump($data);exit;
/**
//在判断是否更新
  $oname = $data['name'];
  $aid = checkArticleByOname($oname);
  if($aid){
    $vdata = array('name'=>$data['name'],'vols'=>$data['vols']);
    $aid = addArticleVols($vdata);
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
  if('http://' != substr($purl,0,7)){
    $purl = $_root.$purl;
  }
  $html = getHtml($purl);
  //$html = iconv("GBK","UTF-8//TRANSLIT",$html) ;
  //$html = mb_convert_encoding($html,"UTF-8","GBK");
  preg_match('#<script language="javascript">var ff_urls=\'([^\']+)\';</script>#Uis',$html,$match);
  $pinfo = array();
//var_dump($match);exit;
  $js = $match[1];
  $json = json_decode($js,1);
  $json = $json['Data'];
  foreach($json as &$vv){
    if( !in_array($vv['playname'],array('xigua','qvod','xfplay'))){
      continue;
    }
    $vols = array();
    foreach($vv['playurls'] as &$v){
      $vols[] = unicode_encode($v[0]).'$'.unicode_encode($v[1]).'$'.$vv['playname'];
    }
    $pinfo[] = array($vv['playname'],$vols);
  }
  return $pinfo;
}
function getParseListInfo($html){
  preg_match_all('#<img class="lazy" data-original="([^"]+)" src="[^"]+" alt="[^"]+" />#Uis',$html,$match);
  $coverPool = $match[1];
  preg_match_all('#<h2><a href="/\?s=vod-read-id-\d+\.html">([^<]+)</a>.+</h2>#Uis',$html,$match);
  $titlePool = $match[1];
  preg_match_all('#<p class="space">主演∶(.+)</p>#Uis',$html,$match);
  $actorPool = $match[1];
  preg_match_all('#<p><a href="(/\?s=vod-read-id-\d+\.html)">影片详情</a> \| <a href="(/\?s=vod-play-id-\d+-sid-\d+-pid-\d+\.html)">在线观看</a>.+</p>#Uis',$html,$match);
  $urlPool = $match[1];
  $purlPool = $match[2];
  $return = array();
  foreach($titlePool as $k => &$v){
   $actor = preg_replace('#<a.+>#Uis','',$actorPool[$k]);
   $actor = preg_replace('#</a>\s*#',',',$actor);
   $actor = trim($actor,',');
   $return[] = array('name'=>$v,'thum'=>$coverPool[$k],'actor'=>$actor,'url'=>$urlPool[$k],'purl'=>$purlPool[$k]);
  }
  return $return;
}
