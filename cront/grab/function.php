<?php

define('ROOTPATH',$APPPATH.'../');
include_once($APPPATH.'../db.class.php');
include_once($APPPATH.'../model.php');
require_once ROOTPATH.'phpCurl.php';

$apicurl = new phpCurl();
$apicurl->config['cookie'] = 'cookie_api';

$model=new Model();

/*
获取配对的标签的内容
*/
function getTagpair(&$str,&$string,$head,$end,$same){
  $str='';
  $start=stripos($string, $head);
  if($start===false){
    return false;
  }
//第一个包含head标签位置的剩下字符串
  $string=substr($string,$start);
//第一次结尾的end标签的位置
  $start=stripos($string, $end)+strlen($end);
  if($start===false){
    return false;
  }
  $str=substr($string,0,$start);
  $others=substr($string, $start+1);
//开始标签出现的次数
  $count_head=substr_count($str,$same);
//结束标签出息的次数
  $count_tail=substr_count($str, $end);
//echo $others,exit;
  while($count_head!=$count_tail &&$count_tail){
    //$start=stripos($others, $same);
    $length=stripos($others, $end)+strlen($end);
    $str.=substr($others, 0,$length);
    $others=substr($others, $length);
    $count_head=substr_count($str,$same);
    $count_tail=substr_count($str, $end);	
  }
}
/*
*/

function getsubcatelist(&$subcate){
  global $model;
  $subcate=$model->getsubcatelist();
}

function getlastgrabinfo($mode=1,$config=array()){
  global $lastgrab,$cateid,$pageno;
  if($mode){
     if(!file_exists($lastgrab)){
        return false;
     }
     include($lastgrab);
     return true;
  }
  $text="<?php\r\n";
  $text.="\$cateid=$config[cateid];\r\n";
  $text.="\$pageno=$config[pageno];\r\n";
  
  file_put_contents($lastgrab,$text);
  return true;
}

function getCatearticle($pid=0){
  if(!$pid){
    return false;
  }
  global $model,$_root,$cid;
  
  $cateList=$model->getCateInfoBypid($pid);
  foreach($cateList as $cate){
    if($cate['id']!=$cateid &&$flag){
         continue;
    }
    if($cate['id']==$cateid){
       $flag=false;
    }
    $cateurl=$_root.$cate['url'];
    $cid=$cate['id'];
    $status = getinfolist($cateurl);
    if(6 == $status){
       break;
    }
sleep(30);
  }
}

function getSubCatearticle($cate){
   global $model,$_root,$cid;
   $cateurl=$_root.$cate['url'];
   $cid=$cate['id'];
   getinfolist($cateurl);
}
function addCateByname($name,$pid,$ourl){
  global $apicurl,$apiurl;
  $url = $apiurl.'addCateByname';
  $apicurl->config['url'] = $url;
  $apicurl->postVal = array(
  'cate_info' => array('name'=>$name,'pid' => $pid, 'ourl' => $ourl)
  );
  $html = $apicurl->getHtml();
  return json_decode($html,1);
}
function checkArticleByOname($oname){
  global $apicurl,$apiurl;
  $url = $apiurl.'checkArticleByOname';
  $apicurl->config['url'] = $url;
  $apicurl->postVal = array(
  'oname' => $oname
  );
  $html = $apicurl->getHtml();
  return json_decode($html,1);
}
function addArticle($data){
  global $apicurl,$apiurl;
  $url = $apiurl.'addArticleInfo';
  $apicurl->config['url'] = $url;
  $apicurl->postVal = array(
  'article_data' => $data
  );
  $html = $apicurl->getHtml();
  return json_decode($html,1);
}
function getHtml($url){
  global $http_proxy;
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.3 (Windows; U; Windows NT 5.3; zh-TW; rv:1.9.3.25) Gecko/20110419 Firefox/3.7.12');
  if($http_proxy){
    curl_setopt($curl, CURLOPT_PROXY ,"http://$http_proxy");
  }
  curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
  curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
  curl_setopt($curl, CURLOPT_HEADER, 0);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  $tmpInfo = curl_exec($curl);
  if(curl_errno($curl)){
    echo 'error',curl_error($curl),"\r\n";
    return false;
  }
  curl_close($curl);
  return $tmpInfo;
}

?>
