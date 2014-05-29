<?php
  
function getAllcate(){
  global $model,$_root;
  $html = getHtml($_root.'/list/index33.html');
  //$html = iconv("GBK","UTF-8//TRANSLIT",$html) ;
  $html = mb_convert_encoding($html,"UTF-8","GBK");
  preg_match_all('#<li><a href="(/list/index\d+)\.html" >([^<]+)</a></li>#Uis',$html,$match,PREG_SET_ORDER);
  $pcate = $match;
//var_dump($pcate);exit;
  foreach($pcate as $pc){
    $pinfo = addCateByname(trim($pc[2]),0,trim($pc[1]));
    $pid = $pinfo['id'];
//var_dump($pinfo);exit;
    if( !$pid){
      continue;
    }
    echo "Parent Cate id $pid\r\n";
    continue;
    $html = getHtml($_root.$pc[1]);
    preg_match_all($subcatelistPattern,$html,$match,PREG_SET_ORDER);
    foreach($match as $cate){
      $sid = addCateByname(trim($cate[2]),$pid,trim($cate[1]));
      echo "cate id $sid\r\n";
    }
sleep(2);
  }

}

function getinfolist(&$cateurl){
  global $_root,$cid;
  for($i=1; $i<=5000; $i++){
//通过 atotal计算i的值
    $suf = $i == 1?'':'_'.$i;
    $url = $cateurl.$suf.'.html';
echo "\n++++ ",$url," ++++\n";
    $html = getHtml($url);
  //  $html = iconv("GBK","UTF-8//TRANSLIT",$html) ;
  $html = mb_convert_encoding($html,"UTF-8","GBK");
    preg_match_all('#<li onmousemove="[^"]+" onmouseout="[^"]+"><a href="[^"]+" class="aimg l" target="_blank"><img src="([^"]+)" alt="[^"]+" /></a>\s+<h2><a href="(/view/index\d+\.html)" target="_blank">([^<]+)</a></h2>\s+<p>主演：([^<]+)</p>\s+<p>分类：([^<]+)</p>\s+<p>人气：\d+</p>\s+<p>时间：[^<]+</p>\s+<p><a href="(/player/index\d+\.html\?\d+-\d+-\d+)" class="btn1" target="_blank">马上观看</a></p></li>#Uis',$html,$matchs,PREG_SET_ORDER);
//echo '<pre>';var_dump($matchs);exit;
    if(empty($matchs)){
       file_put_contents('match_error_list'.$cid.'.html',$html);
       //preg_match_all('##Uis',$html,$matchs,PREG_SET_ORDER);
    }
    if(empty($matchs)){
      echo ('Cate list Failed '.$url."\r\n");
      return 6;
    }
    foreach($matchs as $list){
      $oid = preg_replace('#[^\d]+#','',$list[2]);
      $oname = trim($list[3]);
/*
//在判断是否更新
      $aid = checkArticleByOname($oname);
      if($aid){
         echo "{$aid}已存在未更新!\r\n";
         continue;
        return 6;
      }
*/
      $ourl = $_root.$list[2];
      $purl = $_root.$list[6];
      $ainfo = array('thum'=>$list[1],'ourl'=>$ourl,'purl'=>$purl,'actor'=>$list[4],'name'=>$oname,'oid'=>$oid,'cid'=>$cid);
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
/*/
  preg_match('#<meta name="keywords" content="(.+)" />#U',$html,$match);
  $data['keyword']=trim($match[1]);
  /**/
  $data['keyword'] = '';
  //
  $data['ptime']=time();
  $data['utime']=time();
  preg_match('#<h3 class="ph3">影片介绍</h3>\s+<ul>(.+)</ul>\s+</div>\s+</div>#Uis',$html,$match);
  $match[1] = isset($match[1])?$match[1]:'';
  $match[1] = @iconv("UTF-8","UTF-8//TRANSLIT",$match[1]);
//echo $match[1],"\n";
  $data['intro'] = strip_tags($match[1]);
  $data['intro'] = preg_replace('#&\S+;#Uis','',$data['intro']);
  $data['intro'] = trim($data['intro']);
  $playhtml = getArticlePlayData($data['purl']);
  if(empty($playhtml)){
    echo ("\n++ Ourl:$data[ourl] Purl:$data[purl] playdata vols decode error!++\n");
    return 0;
  }
  $data['vols'] = jsary2phpary($playhtml);
  unset($data['purl']);
  if(!$data['name'] || empty($data['vols'])){
     echo "抓取失败 $data[ourl] \r\n";
     return false;
  }
  $data['ourl'] = str_replace($_root,'',$data['ourl']);
//  echo '<pre>';var_dump($data);exit;
//在判断是否更新
  $oname = $data['name'];
  $aid = checkArticleByOname($oname);
  if($aid){
    $vdata = array('name'=>$data['name'],'vols'=>$data['vols']);
    $aid = addArticleVols($vdata);
    echo "{$aid}已存在更新!\r\n";
    return 6;
  }

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
  //$html = iconv("GBK","UTF-8//TRANSLIT",$html) ;
  $html = mb_convert_encoding($html,"UTF-8","GBK");
  preg_match('#<div class="play[^"]+">\s+<script type="text/javascript" src="(/playdata/[^"]+)"></script>#Uis',$html,$match);
  $url = $_root.$match[1];
  $html = getHtml($url);
  //$html = iconv("GBK","UTF-8//TRANSLIT",$html) ;
  $html = mb_convert_encoding($html,"UTF-8","GBK");
  preg_match('#VideoListJson=(.+),urlinfo=#Uis',$html,$match);
  return $match[1];
}
