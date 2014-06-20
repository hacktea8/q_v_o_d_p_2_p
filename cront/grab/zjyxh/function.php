<?php

function getinfolist($_cate){
  global $_root,$cid;
  for($i=1; $i<=2000; $i++){
//通过 atotal计算i的值
    $suf = $i == 1?'':'-'.$i;
    $url = $_root.'/list/'.$_cate['ourl'].$suf.'.html';
echo "\n++++ ",$url," ++++\n";
    $html = getHtml($url);
  //  $html = iconv("GBK","UTF-8//TRANSLIT",$html) ;
#    $html = mb_convert_encoding($html,"UTF-8","GBK");
    $matchs = getParseListInfo($html);
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
      $purl = $list['purl'];
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
#  $html = mb_convert_encoding($html,"UTF-8","GBK");
  if(!$html){
    echo "获取html失败";exit;
  }
  $data['keyword'] = '';
  //
  $data['ptime']=time();
  $data['utime']=time();
  preg_match('#<div id="idDIV">(.+)</div>#Uis',$html,$match);
  $match[1] = isset($match[1])?$match[1]:'';
#  $match[1] = @iconv("UTF-8","UTF-8//TRANSLIT",$match[1]);
//echo $match[1],"\n";
  $data['intro'] = strip_tags($match[1]);
  $data['intro'] = preg_replace('#&\S+;#Uis','',$data['intro']);
  $data['intro'] = trim($data['intro']);
  $playhtml = getArticlePlayData($data['purl']);
  if(empty($playhtml)){
    echo ("\n++ Ourl:$data[ourl] Purl:$data[purl] playdata vols decode error!++\n");
    return 0;
  }
  $data['vols'] = $playhtml;
  unset($data['purl']);
  $data['thum'] = preg_replace('#\?.+#','',$data['thum']);
  $data['thum'] = preg_replace('#\#.+#','',$data['thum']);
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
#  $html = mb_convert_encoding($html,"UTF-8","GBK");
  preg_match('#<script>var VideoInfoList="(.+)"</script>#Uis',$html,$match);;
  $playjs = explode('$$$',$match[1]);
#var_dump($playjs);exit;
  $return = array();
  foreach($playjs as &$v){
    $v = preg_replace('#.+\$\$#Uis','',$v);
    $v = trim($v,'#');
    if(false !== stripos($v,'qvod://')){
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
	}elseif(false != stripos($v,'xfplay://')){
      $v = unicode_encode($v);
      $v = explode('#',$v);
      $player = 'xfplay';
    }

    $return[] = array($player,$v);
  }
  return $return;
}
function getParseListInfo($html){
 $return = array();
 preg_match_all('#<UL>\s*<LI onMouseOver=(.+)</UL>#Uis',$html,$match);
 $item_list = $match[1];
# var_dump($item_list);exit;
 $info = array();
 foreach($item_list as $item){
  preg_match('#<A href="(/movie/[^"]+)">\s*<img src="([^"]+)" alt="([^"]+)" />\s*</A>#Uis',$item,$match);
  $info['thum'] = $match[2];
  $info['name'] = $match[3];
  $info['ourl'] = $match[1];
  preg_match('#<P>主演：(.+)</P>#Uis',$item,$match);
  $actor = $match[1];
  $actor = preg_replace('#<a.*>#Uis','',$actor);
  $actor = str_replace('</a>&nbsp;&nbsp;',',',$actor);
  $actor = preg_replace('#[,]{2,}#Uis',',',$actor);
  $actor = str_replace(',,',',',$actor);
  $actor = trim($actor,',');
  preg_match('#<P>分类：(.+)</P>#Uis',$item,$match);
  $type = $match[1];
  $info['actor'] = $actor.'|'.$type;
  preg_match('#<a href="(/video/\d+-\d+-\d+\.html)" >#Uis',$item,$match);
  $info['purl'] = $match[1];
  $return[] = $info;
 }

 return $return;
}
