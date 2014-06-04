<?php
ini_set('display_error',1);
error_reporting(E_ALL);
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'usrbase.php';
class Maindex extends Usrbase {
  public function __construct(){
    parent::__construct();
  }
  public function index()
  {
    $view = BASEPATH.'../';
    if(!is_writeable($view)){
       die($view.' is not write!');
    }
    $view .= 'index.html';
    $lock = $view . '.lock';
    if( !file_exists($view) || (time() - filemtime($view)) > 1*3600 ){
      if(!file_exists($lock)){
        $qvodIndex = $this->emulemodel->getIndexData();
        $this->assign(array('_a'=>'index','qvodIndex'=>$qvodIndex));
        $this->view('index_index');
        $output = $this->output->get_output();
        file_put_contents($lock, '');
        file_put_contents($view, $output);
        @unlink($lock);
        @chmod($view, 0777);
        echo $output;
exit;
        return true;
      }
    }
    exit();
  }
  public function setvipdown($page = 1){
    if( !isset($this->userInfo['uid']) || !$this->userInfo['uid']){
      header('Location: /');
    }
    $page = intval($page);
    $limit = 20;
    $lists = $this->emulemodel->getNoVIPDownList($limit);
    $this->assign(array(
    'infolist'=>$lists));
    $this->view('index_setvipdown');
  }
  public function fav($page = 1){
    if( !isset($this->userInfo['uid']) || !$this->userInfo['uid']){
      header('Location: /');
    }
    $page = intval($page);
    $limit = 30;
    $total = $this->emulemodel->getUserCollectTotal($this->userInfo['uid']);
    $endP = ceil($total/$limit);
    if($total && $endP >= $page){
      $lists = $this->emulemodel->getUserCollectList($this->userInfo['uid'],$order = 'new',$page,$limit);
    }
    $this->load->library('pagination');
    $config['base_url'] = sprintf('/maindex/collect/');
    $config['total_rows'] = $total;
    $config['cur_page'] = $page;

    $this->pagination->initialize($config);
    $page_string = $this->pagination->create_links();
    $this->assign(array(
    'page_string'=>$page_string,'infolist'=>$lists));
    $this->view('index_collect');
  }
  public function addCollect($aid){
    $data = array('status'=>0);
    if($this->userInfo['uid']){
      $f = $this->emulemodel->addUserCollect($this->userInfo['uid'],$aid);
      $data['status'] = $f;
    }
    die(json_encode($data));
  }
  public function lists($cid,$order = 0,$page = 1){
    $page = intval($page);
    $cid = intval($cid);
    $cid = $cid < 1 ?1:$cid;
    $order = intval($order);
    $page = $page > 0 ? $page: 1;
    $data = $this->emulemodel->getArticleListByCid($cid,$order,$page);
    $data = is_array($data) ? $data : array();
    $this->load->library('pagination');
    $config['base_url'] = sprintf('/maindex/lists/%d/%d/',$cid,$order);
    $config['total_rows'] = $atotal;
    $config['cur_page'] = $page;
    $this->pagination->initialize($config); 
    $page_string = $this->pagination->create_links();
    $_key = 'list_left_video'.$cid;
    $list_left_video = $this->mem->get($_key);
    if(!$list_left_video){
       $left_hot = $this->emulemodel->getArticleListByCid($cid,2,2,18);
       $left_new = $this->emulemodel->getArticleListByCid($cid,1,2,20);
       $list_left_video = array('hot'=>$left_hot,'new'=>$left_new);
       $this->mem->set($_key,$list_left_video,$this->expirettl['12h']);
    }
// seo setting
    $title = $kw = '';
    $keywords = $kw.$this->seo_keywords;
    $this->assign(array('seo_title'=>$title,'seo_keywords'=>$keywords,'infolist'=>$data
    ,'page_string'=>$page_string,'cid'=>$cid,'hotRankList'=>$list_left_video['hot'],'hotRecomList'=>$list_left_video['new']));
    $this->view('index_lists');
  }
  public function views($aid){
    $aid = intval($aid);
    $data = $this->emulemodel->getEmuleTopicByAid($aid,0,$this->userInfo['uid'], $this->userInfo['isadmin'],0);
    if(empty($data)){
       header('Location: '.$this->url404);
       exit;
    }
    $cid = $data['info']['cid'] ? $data['info']['cid'] : 0;
    $_key = 'view_rightHot'.$cid;
    $viewHot = $this->mem->get($_key);
    if(!$viewHot){
       $viewHot = $this->emulemodel->getArticleListByCid($cid,2,2,18);
       $this->mem->set($_key,$viewHot,$this->expirettl['12h']);
    }
// seo setting
    $kw = '';
    $keywords = $data['name'].','.$kw.$this->seo_keywords;
    $title = $data['name'];
    $isCollect = $this->emulemodel->getUserIscollect($this->userInfo['uid'],$data['info']['id']);
    $this->assign(array('isCollect'=>$isCollect,'verifycode'=>$verifycode,'seo_title'=>$title
    ,'seo_keywords'=>$keywords,'cid'=>$cid,'cpid'=>$cpid,'info'=>$data['info'],'aid'=>$aid
    ,'videovols'=>$data['vols'],'viewHot'=>$viewHot
    )); 
//echo "<pre>";var_dump($this->viewData);exit;
    $this->view('index_view');
  }
  public function playdata($vid,$sid,$vol){
    $vid = intval($vid);
    $sid = intval($sid);
    $vol = intval($vol);
    $data = $this->emulemodel->getVideoPlayDataByAid($vid);
    $videoListJason = $data;
    $view_data = array('sid'=>$sid,'vol'=>$vol,'videoListJason'=>$videoListJason,'vid'=>$vid);
    $this->load->view('index_playdata',$view_data);
  }
  public function play($aid,$sid,$vol){
    $aid = intval($aid);
    $sid = intval($sid);
    $vol = intval($vol);
    $data = $this->emulemodel->getEmuleTopicByAid($aid,$sid,$this->userInfo['uid'], $this->userInfo['isadmin'],0);
    $cid = $data['info']['cid'] ? $data['info']['cid'] : 0;
    $_key = 'play_bottomHot'.$cid;
    $playRelate = $this->mem->get($_key);
    if(!$playRelate){
       $playRelate = $this->emulemodel->getArticleListByCid($cid,1,2,6);
       $this->mem->set($_key,$playRelate,$this->expirettl['12h']);
    }
// seo setting
    $kw = '';
    $keywords = $data['name'].','.$kw.$this->seo_keywords;
    $title = $data['name'];
    $isCollect = $this->emulemodel->getUserIscollect($this->userInfo['uid'],$data['info']['id']);
    $this->assign(array('isCollect'=>$isCollect,'seo_title'=>$title,'sid'=>$sid,'vol'=>$vol
    ,'seo_keywords'=>$keywords,'cid'=>$cid,'cpid'=>$cpid,'info'=>$data['info'],'aid'=>$aid
    ,'videovols'=>$data['vols'],'playRelate'=>$playRelate
    )); 
    $ip = $this->input->ip_address();
    $key = sprintf('emuhitslog:%s:%d',$ip,$aid);
//var_dump($this->redis->exists($key));exit;
    if(!$this->redis->exists($key)){
       $this->redis->set($key, 1, $this->expirettl['6h']);
    }
    $this->view('index_play');
  }
  public function crontab(){
    $lock = BASEPATH.'/../crontab_loc.txt';
    if(file_exists($lock) && time()-filemtime($lock)<6*3600){
       return false;
    }
    $this->emulemodel->autoSetVideoOnline(3);
    $this->emulemodel->setCateVideoTotal();
    file_put_contents($lock,'');
    chmod($lock,0777);
    echo 1;exit;
  }
  public function search($q='',$order = 0,$page = 1){
    $q = $q ? $q:$this->input->get('q');
    $q = urldecode($q);
    $q = htmlentities($q);
    $page = intval($page);
    $page = $page < 1 ? 1: $page;
    $list = array();
    $pageSize = 12;
    if($q){
      $this->load->library('yunsearchapi');
      $opt = array('query'=>$q,'start'=>$page,'hits'=>$pageSize);
      $this->yunsearchapi->search($list,$opt);
      $hotKeywords = $this->yunsearchapi->getTopQuery($num=8,$days=30);
      //var_dump($hotKeywords);exit;
      if('OK' == $hotKeywords['status']){
         $hotKeywords = $hotKeywords['result']['items']['emu_hacktea8'];
      }
    }
/*
echo '<pre>';
var_dump($q);
var_dump($hotKeywords);
var_dump($list);exit;
/**/
    $hot_search = array();
    $recommen_topic = array();
    $recommen_topic[1] = array();
    $recommen_topic[2] = array();
    $hot_topic = array();
    $hot_topic['hit'] = array();
    $hot_topic['focus'] = array();
    $this->load->library('pagination');
    $config['base_url'] = sprintf('/maindex/search/%s/%d/',urlencode($q),$order);
    $config['total_rows'] = $list['result']['viewtotal'];
    $config['per_page'] = $pageSize;
    $config['cur_page'] = $page;
    $this->pagination->initialize($config);
    $page_string = $this->pagination->create_links();
    $this->assign(array('searchlist'=>$list['result'],'kw'=>$q,'q'=>$q,'page_string'=>$page_string,'hot_search'=>$hot_search,'recommen_topic'=>$recommen_topic,'hot_topic'=>$hot_topic));
    $this->load->view('index_search',$this->viewData);
  }
  public function show404($goto = ''){
    $goto = '/';
    $this->assign(array('goto'=>$goto,'seo_title' =>'找不到您需要的页面..现在为您返回首页..'));
    $this->view('index_show404');
  }
  public function login(){
//var_dump($_SERVER);exit;
    $url = $this->viewData['login_url'].urlencode($_SERVER['HTTP_REFERER']);
//echo $url;exit;
    redirect($url);
  }
  public function loginout(){
    $this->session->unset_userdata('user_logindata');
    setcookie('hk8_auth','',time()-3600,'/');
    $url = $_SERVER['HTTP_REFERER'];
//echo $url;exit;
    redirect($url);
  }
  public function isUserInfo(){
    $data = array('status'=>0);
    if( isset($this->userInfo['uid']) && $this->userInfo['uid']){
       $data['status'] = 1;
    }
    die(json_encode($data));
  }
  
}
