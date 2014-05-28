<?php

define('ROOTPATH',$APPPATH.'../');
//include_once($APPPATH.'../db.class.php');
//include_once($APPPATH.'../model.php');
require_once ROOTPATH.'phpCurl.php';

$apicurl = new phpCurl();
$apicurl->config['cookie'] = 'cookie_api';

//$model=new Model();

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
   global $_root,$cid;
   $cateurl = $_root.$cate['ourl'];
   $cid = $cate['cid'];
   getinfolist($cateurl);
}
function addCateByname($name,$pid,$ourl){
  global $apicurl,$POST_API;
  $url = $POST_API.'addCateByname';
  $apicurl->config['url'] = $url;
  $apicurl->postVal = array(
  'cate_info' => json_encode(array('name'=>$name,'pid' => $pid, 'ourl' => $ourl))
  );
  $html = $apicurl->getHtml();
  $return = json_decode($html,1);
  return $return;
}
function checkArticleByOname($oname){
  global $apicurl,$POST_API;
  $url = $POST_API.'checkArticleByOname';
  $apicurl->config['url'] = $url;
  $apicurl->postVal = array(
  'oname' => $oname
  );
  $html = $apicurl->getHtml();
  $return = json_decode($html,1);
//var_dump($return);exit;
  return $return;
}
function addArticleVols($data){
  global $apicurl,$POST_API;
  $url = $POST_API.'addArticleVols';
  $apicurl->config['url'] = $url;
  $apicurl->postVal = array(
  'article_data' => json_encode($data)
  );
  $html = $apicurl->getHtml();
  return json_decode($html,1);
}
function addArticle($data){
  global $apicurl,$POST_API;
  $url = $POST_API.'addArticleInfo';
  $apicurl->config['url'] = $url;
  $apicurl->postVal = array(
  'article_data' => json_encode($data)
  );
  $html = $apicurl->getHtml();
//var_dump($html);exit;
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
function jsary2phpary($jsarray){
  $data = preg_replace("/\]/",")",$jsarray);
  $data = preg_replace("/\[/","(",$data);
  $data = preg_replace("/\(/","array(",$data);
  eval("\$aa = ".$data.';');
  return $aa;
}
function unicode_encode($name)
{
    $name = iconv('UTF-8', 'UCS-2', $name);
    $len = strlen($name);
    $str = '';
    for ($i = 0; $i < $len - 1; $i = $i + 2)
    {
        $c = $name[$i];
        $c2 = $name[$i + 1];
        if (ord($c) > 0)
        {    // 两个字节的文字
            $str .= '\u'.base_convert(ord($c), 10, 16).base_convert(ord($c2), 10, 16);
        }
        else
        {
            $str .= $c2;
        }
    }
    return $str;
}

// 将UNICODE编码后的内容进行解码，编码后的内容格式：YOKA\u738b （原始：YOKA王）
function unicode_decode($name)
{
    // 转换编码，将Unicode编码转换成可以浏览的utf-8编码
    $pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
    preg_match_all($pattern, $name, $matches);
    if (!empty($matches))
    {
        $name = '';
        for ($j = 0; $j < count($matches[0]); $j++)
        {
            $str = $matches[0][$j];
            if (strpos($str, '\\u') === 0)
            {
                $code = base_convert(substr($str, 2, 2), 16, 10);
                $code2 = base_convert(substr($str, 4), 16, 10);
                $c = chr($code).chr($code2);
                $c = iconv('UCS-2', 'UTF-8', $c);
                $name .= $c;
            }
            else
            {
                $name .= $str;
            }
        }
    }
    return $name;
}
?>
