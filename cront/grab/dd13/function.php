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
      $ovid = preg_replace('#[^\d]+#','',$list['ourl']);
#      $ovid = array_pop($ovid);
      $oid = intval($ovid);
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
  //
  $data['ptime']=time();
  $data['utime']=time();
  preg_match('#<div class="intro">(.+)</div>\s*</div>#Uis',$html,$match);
  $match[1] = isset($match[1])?$match[1]:'';
  $match[1] = @iconv("UTF-8","UTF-8//TRANSLIT",$match[1]);
//echo $match[1],"\n";exit;
  $data['intro'] = preg_replace('#<script.*>.*</script>#Uis','',$match[1]);
  $data['intro'] = strip_tags($data['intro']);
  $data['intro'] = preg_replace('#&\S+;#Uis','',$data['intro']);
  $data['intro'] = trim($data['intro']);
  $data['intro'] = mb_strlen($data['intro'])>300?mb_substr($data['intro'],0,300):$data['intro'];
  //var_dump($data['intro']);exit;
  $playhtml = getArticlePlayData($html,$data['ourl']);
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
function getArticlePlayData($html,$ourl){
  global $_root;
  preg_match_all("#<ul class=\"compress\" id=\"Url\d+\">(.+)</ul>#Uis",$html,$match);;
  $playUrl = empty($match[1])?array():$match[1];
//var_dump($match);exit;
  $pUrls = array();
  foreach($playUrl as &$pu){
   preg_match_all('#<li><a .*href="(play_\d+_\d+\.html)".*>(.+)</a></li>#Uis',$pu,$match);
#   var_dump($match);exit;
   $purlPool = $match[1];
   $titlePool = $match[2];
   $pjs = array();
   foreach($purlPool as $k => &$v){
	$purl = $ourl.'/'.$v;
	$phtml = getHtml($purl);
	$phtml = mb_convert_encoding($phtml,"UTF-8","GBK");
	preg_match('#<script>view\(\'([^\']+)\',\'[^\']+\'\)</script>#Uis',$phtml,$match);
//file_put_contents('phtml.html',$phtml);exit;
#	var_dump($match);exit;
	$pl = $match[1];
    $pl = preg_replace('#\w\.\w\.[\.\w]+#Uis','',$pl);
	$cmp = substr($pl,0,7);
	if($cmp != 'qvod://' && $cmp != 'bdhd://'){
	  echo $cmp,"\n";
	  break;
	}
    if($cmp == 'qvod://'){
	 $suf = 'qvod';
	}else{
	 $suf = 'bdhd';
	}
    $pjs[] = unicode_encode($titlePool[$k]).'$'.unicode_encode($pl).'$'.$suf;
	sleep(10);
   }
   $pjs = implode('#',$pjs);
   $pUrls[] = $pjs; 
  }
  $return = array();
  foreach($pUrls as &$v){
	if(empty($v)){
	 continue;
	}
    if(false !== stripos($v,'qvod://')){
      $v = explode('#',$v);
      $player = 'qvod';
    }elseif(false !== stripos($v,'bdhd://')){
      $v = explode('#',$v);
      $player = 'bdhd';
    }elseif(false != stripos($v,'gbl.114s.com')){
      $v = explode('#',$v);
      $player = 'xigua';
	}else{
	  $player = '';
	}
    $return[] = array($player,$v);
  }
  return $return;
}
function getParseListInfo($html){
 $return = array();
 preg_match('#<div class="listBox"><ul>(.+)</ul>#Uis',$html,$match);
 $html = $match[1];
 preg_match_all('#<a href="([^"]+)" target="_blank"><img src="([^"]+)" onerror="src=\'\.\./template/new/images/nopic\.gif\'" alt="([^"]+)" /></a>#Uis',$html,$match);
 $urlPool = $match[1];
 $titlePool = $match[3];
 $coverPool = $match[2];
 preg_match_all('#<P>主演：([^<]+)</p>#Uis',$html,$match);
 $actorPool = $match[1];
# preg_match_all('#<p><b>语言：</b>(.+)</p>#Uis',$html,$match);
# $lanagePool = $match[1];
# preg_match_all('#<a href="(/film\d+/\d+/\d+)_\d+_\d+.html" class="bf bg"></a></p>#Uis',$html,$match);
# $vidPool = $match[1];
 
 foreach($titlePool as $k => &$v){
   $actorPool[$k] = trim($actorPool[$k]);  
   #$str = preg_replace('#\s+#',',',$actorPool[$k]);
   $str = explode('  ',$actorPool[$k]);
   $str = count($str)==1?explode(' ',$actorPool[$k]):$str;
   
   #$tmp = preg_replace('#\s+#',',',$lanagePool[$k]);
   $actor = $str;
   $return[] = array('name'=>$v,'ourl'=>$urlPool[$k],'actor'=>$actor,'thum'=>$coverPool[$k]);
 }
 return $return;
}
