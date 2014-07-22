<?php

function getinfolist($_cate){
  global $_root,$cid;
  for($i=1; $i<=2; $i++){
//通过 atotal计算i的值
    $suf = $i == 1?'.html':'-'.$i.'.html';
    $url = $_root.$_cate['ourl'].$suf;
echo "\n++++ ",$url," ++++\n";
    $html = getHtml($url);
  //  $html = iconv("GBK","UTF-8//TRANSLIT",$html) ;
    $html = mb_convert_encoding($html,"UTF-8","UTF-8");
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
/*/
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
  $html = mb_convert_encoding($html,"UTF-8","UTF-8");
  if(!$html){
    echo "获取html失败";exit;
  }
  $data['keyword'] = '';
  $data['actor'] = @iconv("UTF-8","UTF-8//TRANSLIT",$data['actor']);
  //
  $data['ptime']=time();
  $data['utime']=time();
  preg_match('#<div class="content">(.+)</div>#Uis',$html,$match);
  $match[1] = isset($match[1])?$match[1]:'';
#  $match[1] = @iconv("UTF-8","UTF-8//TRANSLIT",$match[1]);
//echo $match[1],"\n";
  $data['intro'] = strip_tags($match[1]);
  $data['intro'] = preg_replace('#&\S+;#Uis','',$data['intro']);
  $data['intro'] = mb_strlen($data['intro'])>300?mb_substr($data['intro'],0,256,'UTF-8'):$data['intro'];
  $data['intro'] = trim($data['intro']);
  preg_match('#<script type="text/javascript" src="(/movie/\d+/\d+\.js\?t=\d+)"></script>#Uis',$html,$match);
  $data['purl'] = isset($match[1])?$match[1]:'';
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
  if( !$purl){
   return array();
  }
  $purl = $_root.$purl;
  $html = getHtml($purl);
  //$html = iconv("GBK","UTF-8//TRANSLIT",$html) ;
  $html = mb_convert_encoding($html,"UTF-8","UTF-8");
  $st = strlen('var playdata=');
  $pjs = substr($html,$st,-1);
#echo $pjs,"\n";exit;
  $place = json_decode($pjs,1);
//var_dump($place);exit;
  $playjs = array();
  if( !is_array($place)){
    return array();
  }
  foreach($place as $item){
   $tmp = array();
   foreach($item['data'] as $it){
	$url = str_replace('xigua=','',$it[1]);
	$tmpurl = unicode_encode($it[0]).'$'.unicode_encode($url);
	$tmpurl = mb_convert_encoding($tmpurl,"UTF-8","UTF-8");
	$tmp[] = $tmpurl;
   }
   $playjs[] = implode('#',$tmp);
  }
#    var_dump($playjs);exit;
  $return = array();
  foreach($playjs as &$v){
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
	  echo "\n++ $v ++\n";
	  continue;
	}
    $return[] = array($player,$v);
  }
  return $return;
}
function getParseListInfo($html){
 $return = array();
 preg_match_all('#<div class="detail-item-list">(.+)</div>#Uis',$html,$match);
 $item_list = $match[1];
 # var_dump($item_list);exit;
 foreach($item_list as $item){
  preg_match('#<a href="([^"]+)" title="[^"]+" target="_blank" class="thumb">\s*<img id="img_\d+" src="([^"]+)" alt="[^"]+" title="([^"]+)" />#Uis',$item,$match);
  $info = array();
  $info['name'] = $match[3];
  $info['ourl'] = $match[1];
  $info['thum'] = $match[2];
  preg_match('#<li class="mt5"><span>主演：</span>([^<]*)</li>\s*<li><span>类型：</span>([^<]*)</li>#Uis',$item,$match);
  $actor = @str_replace('  ',',',$match[1]);
  $actor = str_replace(' ',',',$actor);
  $type = @str_replace('  ',',',$match[2]);
  $type = str_replace(' ',',',$type);
  $info['actor'] = $actor.'|'.$type;
  $return[] = $info;
 }
 return $return;
}
