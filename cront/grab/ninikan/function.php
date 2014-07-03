<?php

function getinfolist(&$cate){
  global $_root,$cid;
  for($i=1; $i<=2; $i++){
//通过 atotal计算i的值
    $suf = $i == 1?'':'index'.$i.'.html';
    $url = $_root.$cate['ourl'].$suf;
echo "\n++++ ",$url," ++++\n";
    $html = getHtml($url);
  //  $html = iconv("GBK","UTF-8//TRANSLIT",$html) ;
  $html = mb_convert_encoding($html,"UTF-8","GBK");
  $matchs = getParseListInfo($html);
#  echo '<pre>';var_dump($matchs);exit;
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
	$ourl = $list['ourl'];
	if('http://' != substr($ourl,0,7)){
	  $ourl = $_root.$ourl;
	}
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
  //kw
  $data['keyword'] = '';
  //
  $data['ptime']=time();
  $data['utime']=time();
  preg_match('#<div class="plot">(.+)</div>#Uis',$html,$match);
  $match[1] = isset($match[1])?$match[1]:'';
  $match[1] = @iconv("UTF-8","UTF-8//TRANSLIT",$match[1]);
//echo $match[1],"\n";
  $data['intro'] = strip_tags($match[1]);
  $data['intro'] = preg_replace('#&\S+;#Uis','',$data['intro']);
  $data['intro'] = strip_nbsp($data['intro']);
  $data['intro'] = trim($data['intro']);
  $playhtml = getArticlePlayData($html);
  if(empty($playhtml)){
    echo ("\n++ Ourl:$data[ourl] Purl:$data[purl] playdata vols decode error!++\n");
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
function getParseListInfo($html){
  $return = array();
  preg_match_all('#<dl>(.+)</dl>#Uis',$html,$match);
  $item_list = $match[1];
  # var_dump($item_list);exit;
  foreach($item_list as $item){
    preg_match('#<a href="([^"]+)" target="_blank"><img src="([^"]+)" alt="([^"]+)"/><span>.*</span></a>#Uis',$item,$match);
    $info = array();
	$info['name'] = $match[3];
    $info['ourl'] = $match[1];
	$info['thum'] = $match[2];
	$info['thum'] = preg_replace('#\?.*#','',$info['thum']);
	$info['thum'] = preg_replace('#\#.*#','',$info['thum']);
	preg_match('#主演：(.+)<br>#Uis',$item,$match);
	$actor = @str_replace('  ',',',$match[1]);
    $actor = str_replace(' ',',',$actor);
    $actor = str_replace(',/,',',',$actor);
    $info['actor'] = $actor;
    $return[] = $info;
  }
  return $return;
}
function getArticlePlayData($html){
  global $_root;
  $return = array();
  $repM = array('play_youku_','play_tudou_','play_flash_');
  $repR = array('','','');
  $html = str_replace($repM,$repR,$html);
  preg_match_all('#<li><a title="[^"]+" href="(/vid/\d+/play_qvod_.+\.html)" target="_blank">(.*)</a></li>#Uis',$html,$qvod);
  $qvdUrl = isset($qvod[1])?$qvod[1]:array();
  preg_match_all('#<li><a title="[^"]+" href="(/vid/\d+/play_.+\.html)" target="_blank">(.*)</a></li>#Uis',$html,$match);
  $allUrl = isset($match[1])?$match[1]:array();
  $allLen = count($allUrl);
  $pLen = count($qvdUrl);
  if($allLen == 0){
    return array();
  }
  if( $allLen != $pLen){
	echo 'allLen: ',$allLen,' | ',$pLen,"\n";
    die("\nHave New Players Please Add!\n");
  }
  if( !empty($qvdUrl)){
	$qvdTitle = $qvod[2];
	$qvd = array();
	foreach($qvdUrl as $k => $v){
	  $qvd[] = array('url'=>$v,'title'=>$qvdTitle[$k]);
	}
	$qvd = array_reverse($qvd);
#	var_dump($qvd);exit;
    $tmp = getQvodUrls($qvd);
	$return[] = array('qvod',$tmp);
  }
  return $return;
}
function getQvodUrls($qpurl = array()){
  global $_root;
  $return = array();
  foreach($qpurl as $v){
	$purl = getRealUrl($v['url']);
    $html = getHtml($purl);
	$html = mb_convert_encoding($html,"UTF-8","GBK");
	preg_match('#Player\.url = "(qvod://.+)";#Uis',$html,$match);
	$purl = isset($match[1])?$match[1]:'';
	if( !$purl){
	  die("\nGet Qvod Play Url Data Error!\n");
	}
    $title = unicode_encode($v['title']);
	$purl = unicode_encode($purl);
    $return[] = sprintf('%s$%s$qvod',$title,$purl);
    sleep(5);
  }
  return $return;
}
function getRealUrl($url){
  global $_root;
  return substr($url,0,7) == 'http://'?$url:$_root.$url;
}
function strip_nbsp($string){
  $string = preg_replace('#\r\n#',' ',$string);
  $string = preg_replace('#\n#','',$string);
  $string = preg_replace('# +#','',$string);
  $string = preg_replace('# #','',$string);
  $string = preg_replace('#\t+#','',$string); 
  return $string;
}
