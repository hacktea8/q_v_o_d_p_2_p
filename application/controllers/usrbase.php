<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'webbase.php';
class Usrbase extends Webbase {
  public $url404 = '/maindex/show404'; 
  public $seo_title = '首页'; 
  public $seo_keywords = 'bt之家,最新电影网,好看的电视剧,BT之家,西瓜影音,吉吉影音,影音先锋,快播,百度影音,最新电影,最新电视剧,网盘下载';
  public $seo_description = '提供最全的2014最新电影,百度影音电影网站以及各种好看的电视剧、动漫、综艺的在线观看,在线观看分为普通视频模式和百度影音高清播放模式,每天第一时间更新,放送最新好看的免费电影。';
  public $imguploadapiurl = 'http://img.hacktea8.com/imgapi/upload/?seq=';
  public $showimgapi = 'http://i1.hacktea8.com/showfile.php?key=';
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
      $this->mem->set($_key,$youMayLike,$this->expirettl['2h']);
    }
    $channel = $this->mem->get('channel');
    if( empty($channel)){
      $channel = $this->emulemodel->getAllChannel();
      $this->mem->set('channel',$channel,$this->expirettl['12h']);
    } 
    $this->assign(array(
    'seo_keywords'=>$this->seo_keywords,'seo_description'=>$this->seo_description,'seo_title'=>$this->seo_title
    ,'showimgapi'=>$this->showimgapi,'error_img'=>'/public/images/show404.jpg'
    ,'youMayLike'=>$youMayLike,'channel'=>$channel
    ,'cpid'=>0,'cid'=>0,'playMod'=>$this->playMod
    ,'editeUrl' => '/edite/index/emuleTopicAdd'
    ));
    $this->_get_postion();
    $this->_get_ads_link();
//var_dump($this->viewData);exit;
  }
  protected function _get_postion($postion = array()){
    $this->assign(array('postion'=>$postion));
  }
  protected function _get_ads_link(){
   $click_ad_link = '';
   if(!isset($_COOKIE['ahref_click']) && in_array($this->_a,array('lists','topic'))){
    $host = $_SERVER['HTTP_HOST'];
    $url = sprintf("http://c.3808010.com/code1/cpc_0_1_1.asp?w=960&h=130&s_h=1&s_l=6&c1=CCCCCC&c2=c90000&c3=ffffff&pid=264232&u=204756&top=%s&err=&ref=%s/",$this->viewData['current_url'],$host);
    $referer = 'http://'.$this->viewData['current_url'];
    $default_opts = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36\r\n".
    "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\r\n".
    "Accept-Language: zh-cn,zh;q=0.8,en-us;q=0.5,en;q=0.3\r\n".
    "Cache-Control: max-age=0\r\n".
    $referer

  )
);
    $default = stream_context_get_default($default_opts);
    $context = stream_context_create($default_opts);
    $html =  file_get_contents($url, false, $context);
    preg_match_all('#<a .*href="([^"]+)"#Uis',$html,$match);
    $links = $match[1];
    $k = array_rand($links);
    $click_ad_link = $links[$k];
   }
    $this->assign(array('click_ad_link'=>$click_ad_link));
    //echo $links[$k];exit;
  }
  public function view($view_file){
    $this->load->view('header',$this->viewData);
    $this->load->view($view_file);
    $this->load->view('footer');
  }
  public function isrobots(){
    $robots = array('baidu','360','google');
    $return = 0;
    foreach($robots as $v){
     if(FALSE !== stripos($_SERVER['HTTP_USER_AGENT'],$v)){
      $return = 1;
      break;
      
     }
    }
    return $return;
  }
}
