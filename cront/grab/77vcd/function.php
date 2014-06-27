<?php

function getinfolist($_cate){
  global $_root,$cid;
  for($i=1; $i<=2000; $i++){
//通过 atotal计算i的值
    $suf = $i == 1?'':'index'.$i.'.html';
    $url = $_root.$_cate['ourl'].$suf;
echo "\n++++ ",$url," ++++\n";
    $html = getHtml($url);
  //  $html = iconv("GBK","UTF-8//TRANSLIT",$html) ;
    $html = mb_convert_encoding($html,"UTF-8","GBK");
    $matchs = getParseListInfo($html);
#echo '<pre>';var_dump($matchs);exit;
    if(empty($matchs)){
       file_put_contents('match_error_list'.$cid.'.html',$html);
       //preg_match_all('##Uis',$html,$matchs,PREG_SET_ORDER);
    }
    if(empty($matchs)){
      echo ('Cate list Failed '.$url."\r\n");
      return 6;
    }
    foreach($matchs as $list){
      $oid = preg_replace('#[^\d]+#','',$list['ourl']);
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
      $ourl = $_root.$list['ourl'];
      $purl = '';
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
  preg_match('#<div class="description b mb">\s*<h2>.+剧情介绍：</h2>(.+)</div>#Uis',$html,$match);
  $match[1] = isset($match[1])?$match[1]:'';
  $match[1] = @iconv("UTF-8","UTF-8//TRANSLIT",$match[1]);
#echo $match[1],"\n";exit;
  $data['intro'] = strip_tags($match[1]);
  $data['intro'] = preg_replace('#&\S+;#Uis','',$data['intro']);
  $data['intro'] = preg_replace('#《[^》]+》全集在线观看由琪琪影院www.77vcd.com提供如果您觉得本站不错 请推荐给您的好友#Uis','',$data['intro']);
  $data['intro'] = str_replace('琪琪影院','web_title',$data['intro']);
  $data['intro'] = str_replace('www.77vcd.com','web_domain',$data['intro']);
  $data['intro'] = mb_strlen($data['intro'])>300?mb_substr($data['intro'],0,256,'UTF-8'):$data['intro'];
  $data['intro'] = trim($data['intro']);
  #var_dump($data['intro']);exit;
  preg_match('#<ul><li><a title=\'[^\']*\' href=\'(/[^\']+/player-\d+-\d+\.html)\' target="_blank">.*</a></li></ul>#Uis',$html,$match);
  $purl = isset($match[1])?$match[1]:'';
#var_dump($match);exit;  
  $playhtml = getArticlePlayData($purl);
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
  echo '<pre>';var_dump($data);exit;

/*
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
  $purl = $_root.$purl;
  $html = getHtml($purl);
  //$html = iconv("GBK","UTF-8//TRANSLIT",$html) ;
  $html = mb_convert_encoding($html,"UTF-8","GBK");
  preg_match("#var VideoInfoList=unescape\('(.+)'\);#Uis",$html,$match);;
  $vlist = isset($match[1])?$match[1]:'';
#var_dump($match);exit;
  if(!$vlist){
   return array();
  }
  $playjs = urldecode($vlist);
#var_dump($playjs);exit;
  $playjs = str_replace(array('%u','www.77vcd.com'),array('\u','www.emubt.com'),$playjs);
  $playjs = explode('$$$',$playjs);
  $return = array();
  foreach($playjs as &$v){
    $player = '';
	$v = mb_convert_encoding($v,"UTF-8","UTF-8");
    $v = str_replace('$$','',$v);
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
	}else{
	  echo "\n++ $v ++\n";
	  continue;
	}
    $return[] = array($player,$v);
  }
  return $return;
}
function getParseListInfo($html){
 $return = array();
 preg_match('#<ul>\s*<li onmouseover=(.+)</ul>#Uis',$html,$match);
 $html = $match[1];
 preg_match_all('# <a href="([^"]+)" class="pica" title="([^"]+)" target="_blank"><img src="([^"]+)"#Uis',$html,$match);
 $urlPool = $match[1];
 $titlePool = $match[2];
 $coverPool = $match[3];
 preg_match_all('#<p>主演：(.*)</p>#Uis',$html,$match);
 $actorPool = $match[1];
 preg_match_all('# <p>导演：(.*)</p>#Uis',$html,$match);
 $lanagePool = $match[1];
 
 foreach($titlePool as $k => &$v){
   $str = str_replace('  ',',',$actorPool[$k]);
   $str = str_replace('，',',',$str);
   $str = str_replace(' ',',',$str);
   $str = str_replace(',,',',',$str);
   $str = str_replace(',,',',',$str);
   $tmp = str_replace('  ',',',$lanagePool[$k]);
   $tmp = str_replace('，',',',$tmp);
   $tmp = str_replace(' ',',',$tmp);
   $tmp = str_replace(',,',',',$tmp);
   $tmp = str_replace(',,',',',$tmp);
   $str = trim($str,',');
   $tmp = trim($tmp,',');
   $actor = $str.'|'.$tmp;
   $return[] = array('name'=>$v,'ourl'=>$urlPool[$k],'actor'=>$actor,'thum'=>$coverPool[$k]);
 }
 return $return;
}
