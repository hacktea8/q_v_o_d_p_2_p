<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'webbase.php';
class Viewbase extends Webbase {
 public $url404 = '/maindex/show404'; 
 public $seo_title = '首页'; 
 public $seo_keywords = 'bt之家,最新电影网,好看的电视剧,BT之家,西瓜影音,吉吉影音,影音先锋,快播,百度影音,最新电影,最新电视剧,网盘下载';
 public $seo_description = '提供最全的2014最新电影,百度影音电影网站以及各种好看的电视剧、动漫、综艺的在线观看,在线观看分为普通视频模式和百度影音高清播放模式,每天第一时间更新,放送最新好看的免费电影。';
 public $imguploadapiurl = 'http://img.hacktea8.com/imgapi/upload/?seq=';
 public $showimgapi = 'http://img.hacktea8.com/showfile.php?key=';
 public $playMod = array(1=>array('title'=>'qvod','url'=>''),3=>array('title'=>'影音先锋','url'=>''),2=>array('title'=>'百度影音','url'=>''),5=>array('title'=>'西瓜影音','url'=>''),6=>array('title'=>'吉吉影音','url'=>''),7=>array('title'=>'优酷在线','url'=>''),8=>array('title'=>'在线播放','url'=>'')
 ,9=>array('title'=>'在线播放','url'=>''));

 public function __construct(){
  parent::__construct();  
  $this->load->helper('rewrite');
  $this->load->model('emulemodel');
  $_key = 'top_youMayLike';
  $youMayLike = $this->mem->get($_key);
//var_dump($hotTopic);exit;
  if(empty($youMayLike)){
   $youMayLike = $this->emulemodel->getTopYouMayLike(10);
   $this->mem->set($_key,$youMayLike,self::$ttl['2h']);
  }
  $channel = $this->mem->get('channel');
  if( empty($channel)){
   $channel = $this->emulemodel->getAllChannel();
   $this->mem->set('channel',$channel,self::$ttl['12h']);
  } 
  $this->assign(array(
  'seo_keywords'=>$this->seo_keywords,'seo_description'=>$this->seo_description,'seo_title'=>$this->seo_title
  ,'showimgapi'=>$this->showimgapi,'error_img'=>'/public/images/show404.jpg'
  ,'youMayLike'=>$youMayLike,'channel'=>$channel,'isShowPoint'=>1
  ,'cpid'=>0,'cid'=>0,'playMod'=>$this->playMod
  ,'editeUrl' => '/edite/index/emuleTopicAdd'
  ));
  $this->_get_postion();
//var_dump($this->viewData);exit;
 }
 protected function _get_postion($postion = array()){
  $this->assign(array('postion'=>$postion));
 }
 protected function view($view_file){
  $this->load->view('header',$this->viewData);
  $this->load->view($view_file);
  $this->load->view('footer');
 }
 protected function checkAge($adult = 0,$goReferer = ''){
  if($this->userInfo['isvip'] || $this->userInfo['isadmin']){
   return 1;
  }
  if( $this->robot || !$adult){
   return 0;
  }
  $isAdult = $this->cookie('isAdult');
  if($isAdult){
   return 1;
  }
  $this->cookie('goReferer', $goReferer, $ttl = 86400);
  redirect('/checkage');
 }
}
