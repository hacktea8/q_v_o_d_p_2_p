<?php

function getinfolist($_cate){
  global $_root,$cid;
  for($i=1; $i<=2; $i++){
//通过 atotal计算i的值
    $suf = $i == 1?'':'index'.$i.'.html';
    $url = $_root.$_cate['ourl'].$suf;
echo "\n++++ ",$url," ++++\n";
  for($ei=0;$ei<3;$ei++){
    $html = getHtml($url);
    if($html){
      break;
    }
    sleep(12);
  }
  //  $html = iconv("GBK","UTF-8//TRANSLIT",$html) ;
    $html = mb_convert_encoding($html,"UTF-8","GBK");
    $matchs = getParseListInfo($html);
//echo '<pre>';var_dump($matchs);exit;
    if(empty($matchs)){
       $html .= "\r\n\r\n+++++++\r\n $i";
       file_put_contents('match_error_list'.$cid.'.html',$html);
       //preg_match_all('##Uis',$html,$matchs,PREG_SET_ORDER);
    }
    if(empty($matchs)){
      echo ('Cate list Failed '.$url."\r\n");
      return 6;
    }
    foreach($matchs as $list){
      $ovid = explode('/',$list['ovid']);
      $ovid = array_pop($ovid);
      $oid = intval($ovid);
      $oname = trim($list['name']);
/*/
//在判断是否更新
      $aid = checkArticleByOname($oname);
      if($aid){
         echo "{$aid}已存在未更新!\r\n";
         continue;
        return 6;
      }
#echo "\n|",$oname,"|{$aid}|\n";
/**/
      $ourl = $_root.$list['ourl'];
      $purl = $list['ovid'];
      $ainfo = array('thum'=>$list['thum'],'ourl'=>$ourl,'purl'=>$purl,'actor'=>$list['actor'],'name'=>$oname,'oid'=>$oid,'cid'=>$cid);
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
  $data['keyword'] = '';
  $data['actor'] = @iconv("UTF-8","UTF-8//TRANSLIT",$data['actor']);
  //
  $data['ptime']=time();
  $data['utime']=time();
  preg_match('#<div class="introduction" itemprop="description"><p>(.+)</p></div>#Uis',$html,$match);
  $match[1] = isset($match[1])?$match[1]:'';
  $match[1] = @iconv("UTF-8","UTF-8//TRANSLIT",$match[1]);
//echo $match[1],"\n";
  $data['intro'] = strip_tags($match[1]);
  $data['intro'] = preg_replace('#&\S+;#Uis','',$data['intro']);
  $data['intro'] = mb_strlen($data['intro'])>300?mb_substr($data['intro'],0,256,'UTF-8'):$data['intro'];
  $data['intro'] = trim($data['intro']);
  $playhtml = getArticlePlayData($data['purl']);
  if(empty($playhtml)){
    echo ("\n++ Ourl:$data[ourl] Purl:$data[purl] playdata vols decode error!++\n");
    return 0;
  }
  $data['vols'] = $playhtml;
  unset($data['purl']);
  if(!$data['name'] || empty($data['vols'])){
     echo "抓取失败 $data[ourl] \r\n";
exit;
     return false;
  }
  $data['ourl'] = str_replace($_root,'',$data['ourl']);
#  echo '<pre>';var_dump($data);exit;

/**/
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
  $purl = $_root.$purl.'.js';
  $html = getHtml($purl);
  //$html = iconv("GBK","UTF-8//TRANSLIT",$html) ;
  $html = mb_convert_encoding($html,"UTF-8","GBK");
  preg_match("#stringReplaceAll\('(.+)','(.+)',(.+)\)\)\)#Uis",$html,$match);;
  if( !isset($match[1])){
    return array();
  }
  $match[1] = str_replace("'+'",'',$match[1]);
  $match[1] = str_replace("'",'',$match[1]);
  $match[2] = str_replace("'+'",'',$match[2]);
  $match[2] = str_replace("'",'',$match[2]);
  $match[3] = str_replace("unescape('",'',$match[3]);
  $match[3] = str_replace("')+",'',$match[3]);
  $match[3] = str_replace("'",'',$match[3]);
  $place = urldecode($match[3]);
  $from = $match[2];
  $playjs = str_replace($from,$place,$match[1]);
  $playjs = urldecode($playjs);
  $playjs = str_replace('%u','\u',$playjs);
  $playjs = explode('$$$',$playjs);
  $return = array();
  foreach($playjs as &$v){
    $player = '';
    $v = mb_convert_encoding($v,"UTF-8","UTF-8");
    $v = trim($v,'#');
    if(false !== stripos($v,'qvod://')){
      $v = str_replace('qvod$$','',$v);
      $v = unicode_encode($v);
      $v = explode('#',$v);
      $player = 'qvod';
    }elseif(false !== stripos($v,'bdhd://')){
      $v = unicode_encode($v);
      $v = explode('#',$v);
      $player = 'bdhd';
    }elseif(false != stripos($v,'gbl.114s.com')){
      $v = unicode_encode($v);
      $v = explode('#',$v);
      $player = 'xigua';
    }elseif(false != stripos($v,'jjhd://')){
      $v = unicode_encode($v);
      $v = explode('#',$v);
      $player = 'jjhd';
    }elseif(false != stripos($v,'$youku')){
      $v = unicode_encode($v);
      $v = explode('#',$v);
      $player = 'youku';
    }else{
      echo "\n++ $v ++\n";
      continue;
    }
    $v = str_replace('$$','',$v);
    $return[] = array($player,$v);
  }
  return $return;
}
function getParseListInfo($html){
 $return = array();
 preg_match('#<div class="channel-content">(.+)</div>#Uis',$html,$match);
 $html = isset($match[1])?$match[1]:'';
 if( !$html){
   return array();
 }
 preg_match_all('#<a href="([^"]+)" title="[^"]+" class="ah"><img src="([^"]+)" alt="([^"]+)">#Uis',$html,$match);
 $urlPool = $match[1];
 $titlePool = $match[3];
 $coverPool = $match[2];
 preg_match_all('#<p><b>主演：</b>(.+)</p>#Uis',$html,$match);
 $actorPool = $match[1];
 preg_match_all('#<p><b>语言：</b>(.+)</p>#Uis',$html,$match);
 $lanagePool = $match[1];
 preg_match_all('#<a href="(/film\d+/\d+/\d+)_\d+_\d+.html" class="bf bg"></a></p>#Uis',$html,$match);
 $vidPool = $match[1];
 
 foreach($titlePool as $k => &$v){
   $str = preg_replace('#\s+#',',',$actorPool[$k]);
   $tmp = preg_replace('#\s+#',',',$lanagePool[$k]);
   $actor = $str.'|'.$tmp;
   $return[] = array('name'=>$v,'ourl'=>$urlPool[$k],'ovid'=>$vidPool[$k],'actor'=>$actor,'thum'=>$coverPool[$k]);
 }
 return $return;
}
