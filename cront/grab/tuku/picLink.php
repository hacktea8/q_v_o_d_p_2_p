<?php

$root = dirname(__FILE__).'/';
require_once $root.'config.php';
require_once $root.'sdk.class.php';
$uinfo = $ttk_config[date('w')];

$picConfig = array();

$picConfig['sdk'] = new tietusdk($uinfo['accesskey'],$uinfo['secretkey']);
$picConfig['curl'] = new phpCurl();
$picConfig['curl']->config['cookie'] = 'picLink_'.$uinfo['uid'].'_cookie';


class Piclink{
 protected $curl = null;
 protected $sdk = null;
 public $uinfo = array();
 public $picPostUrl = 'http://tietuku.com/Pic/asyncloadimg';
 public $picPostReferer = 'http://tietuku.com/network';
 public $ttkApi = 'http://api.tietuku.com/v1/';

 public function __construct($picConfig = array()){
  foreach($picConfig as $k => $v){
   if(!isset($this->$k)){
    $this->$k = $v;
   }
  }
  
  return true;
 }
 /**
  *$param['action'] = 'get';
  *$param['action'] = 'create';
  *$param['albumname'] = '这里是相册名字';
  */
 public function album($param = array()){
  $param['deadline'] = time()+60*60;
  $Token = $this->sdk->Dealparam($param)->Token();
  $url = $this->ttkApi.'Album';
  $this->curl->config['url'] = $url;
  $this->curl->postVal = array(
   'Token' => $Token
  );
  $html = $this->curl->getHtml();
  return $html;
 }
 /**
  *$param['album'] = '你的相册ID';
  *$param['deadline'] = time()+3600*72;
  */
 public function upFileToken($param = array()){
  $param['deadline'] = isset($param['deadline'])?$param['deadline']:(time()+3600*72);
  $param['return'] = isset($param['return'])?$param['return']:'';
  if($param['return'] == 'all'){
   $param['returnBody'] = array(
   'height' => 'h',//	选填 返回图片高度名字
   'width' => 'w',//	选填 返回图片宽度名字
   'ubburl' => 'url',//	选填 url 返回UBB格式连接名字
   'htmlurl' => 'url2',//选填 url2 返回HTML格式连接名字
   'type' => 'type',//选填 type 返回图片扩展名
   's_url' => 's_url',//选填 s_url 返回图片展示图地址
   't_url' => 't_url'//	选填 t_url 返回图片缩略图地址
   );
  }elseif($param['return'] == 'ubb'){
   $param['returnBody'] = array('ubburl' => 'url');
  }else{
   $param['returnBody'] = array('htmlurl' => 'url2');
  }
  unset($param['return']);
  $Token = $this->sdk->Dealparam($param)->Token();
  return $Token;
 }
 public function upFile($param = array()){
  $this->curl->config['url'] = $this->ttkApi.'Up';
  $this->curl->postVal = array(
   'Token' => $param['token']
   
  );
  $file = $param['file'];
  if($param['from'] == 'web'){
   $this->curl->postVal['fileurl'] = $file;
  }else{
   $this->curl->postVal['file'] = '@'.$file;
  }
  $html = $this->curl->getHtml();
  return $html;
 }
 public function initToken(){
  
 }
 public function login(){
  $l = count($this->uinfo) -1;
  $k = mt_rand(0,$l);
  $uinfo = $this->uinfo[$k];
  $this->curl->config['cookie'] = 'picUrl_'.$uinfo['uid'].'_cookie';
  $this->curl->config['url'] = $this->picPostUrl;
  $this->curl->config['referer'] = $this->picPostReferer;
  $this->curl->http_header[] = 'X-Requested-With: XMLHttpRequest';
  $this->curl->postVal = array(
  'link' => $link
  );
  $html = $this->curl->getHtml();

 }
 public function getUrl($link){
  if(empty($link)){
   return 0;
  }
  $this->login();
#  $this->curl->config['header'] = 1;
  $this->curl->config['url'] = $this->picPostUrl;
  $this->curl->config['referer'] = $this->picPostReferer;
  $this->curl->http_header[] = 'X-Requested-With: XMLHttpRequest';
  $this->curl->postVal = array(
   'link' => $link
  );
  $html = $this->curl->getHtml();
  file_put_contents('post_html.html',$html);
 }
}

?>
