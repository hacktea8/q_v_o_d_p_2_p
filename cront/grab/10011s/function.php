<?php

function getinfolist(&$_cate){
 global $_root,$cid,$startPage;
 for($i=$startPage; $i<=20; $i++){
//通过 atotal计算i的值
  $suf = $i == 1?'':'_'.$i;
  $url = $_root.$_cate['ourl'].$suf.'.html';
echo "\n++++ ",$url," ++++\n";
  $html = getHtml($url);
  //  $html = iconv("GBK","UTF-8//TRANSLIT",$html) ;
  $html = mb_convert_encoding($html,"UTF-8","GBK");
file_put_contents('list_match.html',$html);
  $matchs = getParseListInfo($html);
//echo '<pre>';var_dump($matchs);exit;
  if(empty($matchs)){
   file_put_contents('match_error_list'.$cid.'.html',$html);
   echo ('Cate list Failed '.$url."\r\n");
   return 6;
  }
  foreach($matchs as $list){
   $oid = preg_replace('#[^\d]+#','',$list['ourl']);
   $oname = trim($list['title']);
/**/
//在判断是否更新
   $aid = checkArticleByOname($oname);
   if($aid){
    echo "{$aid}已存在未更新!\r\n";
    continue;
    return 6;
   }
/**/
    $ourl = $_root.$list['ourl'];
    $purl = $_root.'player/index'.$oid.'.html?'.$oid.'-0-0?'.$oid.'-0-0';
    $ainfo = array('thum'=>$_root.$list['thum'],'ourl'=>$ourl,'purl'=>$purl,'actor'=>'','name'=>$oname,'oid'=>$oid,'cid'=>$cid);
    getinfodetail($ainfo);
sleep(1);
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
  $html = mb_convert_encoding($html,"UTF-8","GBK");
  if(!$html){
    echo "获取html失败";exit;
  }
  //kw
  $data['keyword'] = '';
  //
  $data['ptime']=time();
  $data['utime']=time();
  preg_match('#<DIV class=n_bd>(.+)</div>#Uis',$html,$match);
  $match[1] = @$match[1];
  $match[1] = @iconv("UTF-8","UTF-8//TRANSLIT",$match[1]);
//echo $match[1],"\n";
  $r = mstrip_tags($match[1]);
  $data['intro'] = $r['intro'];
//  $data['thum'] = $r['thum'];
  $playhtml = getArticlePlayData($data['purl']);
  if(empty($playhtml)){
    echo ("\n++ Ourl:$data[ourl] Purl:$data[purl] playdata vols decode error!++\n");
    return 0;
  }
  $data['vols'] = jsary2phpary($playhtml);
  unset($data['purl']);
  if(!$data['name'] || empty($data['vols'])){
    echo "抓取失败 $data[ourl] \r\n";
    return 1;exit;
  }
  $data['ourl'] = str_replace($_root,'',$data['ourl']);
//  echo '<pre>';var_dump($data);exit;
//在判断是否更新
/*
  $oname = $data['name'];
  $aid = checkArticleByOname($oname);
  if($aid){
    $vdata = array('name'=>$data['name'],'vols'=>$data['vols']);
    $aid = addArticleVols($vdata);
    echo "{$aid}已存在更新!\r\n";
    return 6;
  }
*/
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
 $html = getHtml($purl);
 $html = mb_convert_encoding($html,"UTF-8","GBK");
 preg_match('#<div class="player"><script type="text/javascript" src="(/playdata/[^"]+)"></script>#Uis',$html,$match);
 if(!@$match[1]){
  echo "Get Purl Failed! Purl: $purl \r\n";exit;
 }
 $url = $_root.$match[1];
 $html = getHtml($url);
 $html = mb_convert_encoding($html,"UTF-8","GBK");
 preg_match('#VideoListJson=(.+),urlinfo=#Uis',$html,$match);
 return $match[1];
}
function getParseListInfo($html){
 preg_match_all('#<LI><A class=pic href="([^"]*)" target=_blank><IMG alt="([^"]*)" onerror="[^"]*" src="([^"]*)"></A>#Uis',$html,$match);
 $r = array();
 foreach($match[1] as $k =>$v){
  $r[] = array('ourl'=>$v,'title'=>trim($match[2][$k]),'thum'=>trim($match[3][$k]));
 }
 return $r;
}
function mstrip_tags($str){
 preg_match('#<\s*img [^>]*src="([^"]+)"[^>]*>#Uis',$str,$match);
 $thum = @$match[1];
 $str = preg_replace('#</?\s*a[^>]*>#Uis','',$str);
 $str = preg_replace('#<\s*img[^>]*>#Uis','',$str);
 return array('intro'=>trim($str),'thum'=>$thum);
}
