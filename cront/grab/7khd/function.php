<?php
  

function getinfolist(&$_cate){
  global $_root,$cid,$start_page;
  $start_page = $start_page?$start_page:1;
  for($i=$start_page; $i<=2; $i++){
//通过 atotal计算i的值
    $suf = $i == 1?'':'-'.$i;
    $url = $_root.$_cate['ourl'].$suf.'.html';
echo "\n++++ ",$url," ++++\n";
//exit;
    $html = getHtml($url);
//    $html = mb_convert_encoding($html,"UTF-8","GBK");
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
      $oid = intval(preg_replace('#[^\d]+#','',$list['ourl']));
      $oname = trim($list['name']);
/*/
//在判断是否更新
      $aid = checkArticleByOname($oname);
      if($aid){
         echo "{$aid}已存在未更新!\r\n";
         continue;
        return 6;
      }
/**/
      $ourl = getFullPath($list['ourl']);
      $purl = '/play/'.$oid.'-1-1.html';
      $purl = getFullPath($purl);
      $ainfo = array('thum'=>$list['cover'],'ourl'=>$ourl,'purl'=>$purl,'actor'=>$list['actor'],'name'=>$oname,'oid'=>$oid,'cid'=>$cid);
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
//  $html = mb_convert_encoding($html,"UTF-8","GBK");
  if(!$html){
    echo "获取html失败";exit;
  }
  //kw
  $data['keyword'] = '';
  //
  $data['ptime']=time();
  $data['utime']=time();
  preg_match('#<span class="more" txt="([^"]+)"\s*>#Uis',$html,$match);
  $match[1] = isset($match[1])?$match[1]:'';
//echo $match[1],"\n";exit;
  $data['intro'] = strip_tags($match[1]);
  $data['intro'] = preg_replace('#&\S+;#Uis','',$data['intro']);
  $data['intro'] = mb_strlen($data['intro'])>300?mb_substr($data['intro'],0,300,'utf-8'):$data['intro'];
  $data['intro'] = str_replace('?','',$data['intro']);
  $data['intro'] = trim($data['intro']);
  $data['intro'] = preg_replace("#(\r\n)+#is","\r\n",$data['intro']);
  $data['intro'] = preg_replace("#\n+#is","\n",$data['intro']);
  $playhtml = getArticlePlayData($data['purl']);
  if(empty($playhtml)){
    echo ("\n++ Ourl:$data[ourl] Purl:$data[purl] playdata vols decode error!++\n");
    return 0;
  }
  $data['vols'] = getParseVideoInfo($playhtml);
  unset($data['purl']);
  if(!$data['name'] || empty($data['vols'])){
     echo "抓取失败 $data[ourl] \r\n";
     return false;
  }
  $data['ourl'] = str_replace($_root,'',$data['ourl']);
//  echo '<pre>';var_dump($data);exit;
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
  $html = getHtml($purl);
//  $html = mb_convert_encoding($html,"UTF-8","GBK");
  preg_match('#var maccms_playlist = \'([^\']+)\';#Uis',$html,$match);
  $htm = @$match[1];
  return $htm;
}
function getParseListInfo($html){
  preg_match('#<div id="videoData" class="jsonPP boxList"><ul>(.+)</ul>#Uis',$html,$match);
  $html = isset($match[1])?$match[1]:'';
  if( !$html){
    die("\n+++++ Get Video List Is Empty! ++++\n");
  }
  preg_match_all('#<a title="[^"]+" href="(/read/\d+\.html)" class="pic"><img src="([^"]+)" alt="([^"]+)" class="imgpic"/></a>#Uis',$html,$match);
  $titlePool = $match[3];
  $urlPool = $match[1];
  $coverPool = $match[2];
  preg_match_all('#<span>主演：([^<]+) </span>#Uis',$html,$match);
  $actorPool = $match[1];
  $return = array();
  foreach($titlePool as $k => $title){
    $title = trim($title);
    $cover = getFullPath($coverPool[$k]);
    $cover = preg_replace('#\?.+#is','',$cover);
    $cover = preg_replace('#\#.+#is','',$cover);
    $actor = trim($actorPool[$k]);
    $actor = str_replace('   ',',',$actor);
    $actor = str_replace('  ',',',$actor);
    $actor = str_replace(' ',',',$actor);
    $actor = str_replace('、',',',$actor);
    $return[] = array('name'=>$title,'ourl'=>$urlPool[$k],'actor'=>$actor,'cover'=>$cover);
  }
  return $return;
  var_dump($return);exit;
   
}
function getFullPath($url){
  if( !stripos($url,'://')){
    global $_root;
    $url = $_root.$url;
  }
  return $url;
}
function getParseVideoInfo($html){
  if( !$html){
    return array();
  }
  $charset = mb_detect_encoding($html, 'UTF-8');
  $html = iconv('UTF-8',"UTF-8//TRANSLIT",$html);
  $html = preg_replace('#\[[^\[]+\.[a-z]+\]#is','[www.qvdhd.com]',$html);
  $playType = explode('$$$',$html);
  $return = array();
  foreach($playType as $v){
    $player = '';
    if(false !== stripos($v,'qvod://')){
      $player = 'qvod';
    }elseif(false !== stripos($v,'bdhd://')){
      $player = 'bdhd';
    }elseif(false !== stripos($v,'gbl.114s.com')){
      $player = 'xigua';
    }elseif(false !== stripos($v,'jjhd://')){
      $player = 'jjhd';
    }elseif(false !== stripos($v,'xfplay://')){
      $player = 'xfplay';
    }else{
      echo "\n++ $v ++\n";
      continue;
    }
    $v = str_replace(array('null$$','$$'),array('',' '),$v);
    $v = preg_replace('#\s+\$#','$',$v);
    $v = explode('#',$v);
    $return[] = array($player,$v);
  }
  if('UTF-8' === $charset){
    return $return;
  }
  echo $charset,"\n";
  var_dump($return);exit;
}
