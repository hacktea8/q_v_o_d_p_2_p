<?php
  
function getAllcate(){
  global $model,$_root;
  $html = getHtml($_root.'/list/index33.html');
  $html = iconv("GBK","UTF-8//IGNORE",$html) ;
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
  global $model,$_root,$cid;
  for($i=1;$i<=60;$i++){
//通过 atotal计算i的值
    $suf = $i == 1?'':'_'.$i;
    $url = $cateurl.$suf.'.html';
    $html = getHtml($url);
    $html = iconv("GBK","UTF-8//IGNORE",$html) ;
    preg_match_all('#<li onmousemove="[^"]+" onmouseout="[^"]+"><a href="[^"]+" class="aimg l" target="_blank"><img src="([^"]+)" alt="[^"]+" /></a>\s+<h2><a href="(/view/index\d+\.html)" target="_blank">([^<]+)</a></h2>\s+<p>主演：([^<]+)</p>\s+<p>分类：([^<]+)</p>\s+<p>人气：\d+</p>\s+<p>时间：[^<]+</p>\s+<p><a href="(/player/index\d+\.html\?\d+-\d+-\d+)" class="btn1" target="_blank">马上观看</a></p></li>#Uis',$html,$matchs,PREG_SET_ORDER);
echo '<pre>';var_dump($matchs);exit;
    if(empty($matchs)){
       preg_match_all('##Uis',$html,$matchs,PREG_SET_ORDER);
    }
    if(empty($matchs)){
      echo ('Cate list Failed '.$cateurl."/第{$i}页\r\n");
      return 6;
    }
    foreach($matchs as $list){
      $oid = preg_replace('#[^\d]+#','',$list[1]);
      $oname = trim($list[2]);
//在判断是否更新
      $aid = checkArticleByOname($oname);
      if($aid){
         echo "{$aid}已存在未更新!\r\n";
 //        continue;
        return 6;
      }
      $purl = $_root.$list[1].'.html';
      $ainfo = array('ourl'=>$purl,'name'=>$oname,'oid'=>$oid,'cid'=>$cid);
      getinfodetail($ainfo);
sleep(1);
    }
//test data
  }
//if($i>30)
//  break;
//sleep(1);
return 0;
}

function getinfodetail(&$data){
  global $model,$cid,$strreplace,$pregreplace;
  $html = getHtml($data['ourl']);
  $html = iconv("GBK","UTF-8//IGNORE",$html) ;
  if(!$html){
    echo "获取html失败";exit;
  }
  //kw
  preg_match('#<meta name="keywords" content="(.+)" />#U',$html,$match);
  $data['keyword']=trim($match[1]);
  //
  preg_match($bookimg,$html,$match);
//  var_dump($match);exit;
  $data['thum']=trim($match[1]);
  //
  $data['ptime']=time();
  $data['utime']=time();
  $data['downurl']=$str;
  foreach($strreplace as $val){
    $data['downurl']=str_replace($val['from'],$val['to'],$data['downurl']);
  }
  foreach($pregreplace as $val){
    $data['downurl']=preg_replace($val['from'],$val['to'],$data['downurl']);
  }
  $data['downurl']=trim($data['downurl']);
  //
  for($mk=0;$mk<2;$mk++){
    $start=stripos($html,$head)+strlen($head);
    $html=substr($html,$start);
  }
  $html=$head.$html;
//  getTagpair($str,$html,$head,$end,$same);
  $data['intro']=$str;
//echo $str;exit;
  foreach($strreplace as $val){
    $data['intro']=str_replace($val['from'],$val['to'],$data['intro']);
  }
  foreach($pregreplace as $val){
    $data['intro']=preg_replace($val['from'],$val['to'],$data['intro']);
  }
  $data['intro']=trim($data['intro']);
  if(!$data['name'] || !$data['downurl']){
     echo "抓取失败 $data[ourl] \r\n";
     return false;
  }
  //echo '<pre>';var_dump($data);exit;
  $aid = addArticle($data);
//echo '|',$aid,'|';exit;
  if( !$aid){
    echo "添加失败! $data[ourl] \r\n";
    return false;
  }
  echo "添加成功! $aid \r\n";
}

