<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Webbase extends CI_Controller {
 static public $ttl = array('5m'=>300,'15m'=>900,'30m'=>1800,'1h'=>3600,'3h'=>10800,'6h'=>21600,'9h'=>32400,'12h'=>43200,'1d'=>86400,'3d'=>253200,'5d'=>432000,'7d'=>604800);
 protected $mem = '';
 protected $redis = '';
 public $viewData = array();
 protected $userInfo = array('uid'=>0,'uname'=>'','isvip'=>0,'isadmin'=>0);
 public $adminList = array(1);
 protected $_c = 'index'; 
 protected $_a = 'index'; 
 protected $robot = 0;
 static protected $static_html = '0';

 public function __construct(){
  parent::__construct();
  $this->load->library('memcached');
  $this->mem = &$this->memcached;
  $this->load->library('rediscache');
  $this->redis = &$this->rediscache;
  $session_uinfo = $this->session->userdata('user_logindata');
  //var_dump($session_uinfo);exit;
  if(empty($session_uinfo)){
   //解析UID
   $uinfo = getSynuserUid();
   if($uinfo){
    $this->userInfo['uname'] = $uinfo['uname'];
    $uinfo = getSynuserInfo($uinfo['uid']);
    $uinfo['uname'] = $this->userInfo['uname'];
    $uinfo = $this->usermodel->getUserInfo($uinfo);
    if($uinfo){
     $this->userInfo = array_merge($this->userInfo,$uinfo);
     $this->session->set_userdata(array('user_logindata'=>$this->userInfo));
    }
   }
  }else{
   $this->userInfo = $session_uinfo;
  }
 // var_dump($this->userInfo);exit;
  $this->_c = $this->uri->segment(1,'index');
  $this->_a = $this->uri->segment(2,'index');
  $c = isset($_GET['c'])?$_GET['c']:'';
  if($c){
   $this->_a = 'list' == $c ? 'lists' : 'topic';
  }
  $current_url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  $this->checkIsrobot();
  $this->assign(array('domain'=>$this->config->item('domain'),
   'base_url'=>$this->config->item('base_url'),'css_url'=>$this->config->item('css_url'),
   'admin_email'=>$this->config->item('admin_email'),'errorimg'=>'/public/images/show404.jpg',
   'img_url'=>$this->config->item('img_url'),'js_url'=>$this->config->item('js_url'),
   'toptips'=>$this->config->item('toptips'),'web_title'=>$this->config->item('web_title')
   ,'version'=>20140109,'login_url'=>$this->config->item('login_url'),'uinfo'=>$this->userInfo
   ,'_c'=>$this->_c,'_a'=>$this->_a,'current_url'=>$current_url
  ));
 }
  
 protected function checkLogin(){
  if(isset($this->userInfo['uid']) &&$this->userInfo['uid']>0){
   return true;
  }else{
   return false;
  }
 }
 protected function checkIsadmin($return = 0){
  if( !($return || $this->checkLogin())){
   redirect($this->config->item('login_url').$this->config->item('base_url'));
  }
  if(in_array($this->userInfo['groupid'],$this->adminList)){
   return true;
  }
  foreach($this->userInfo['groups'] as $gid){
   if(in_array($gid,$this->adminList)){
    return true;
   }
  }
  return false;
 }
 protected function assign($data){
  foreach($data as $key => $val){
   $this->viewData[$key] = $val;
  }
 }
 protected function checkIsrobot(){
  if(false !== stripos($_SERVER['HTTP_USER_AGENT'],'spider')){
   $this->robot = 1;
  }
 }
 protected function cookie($name,$value = '', $ttl = 3600){
  if($value){
   $cookie = array(
   'name'   => $name,
   'value'  => $value,
   'expire' => $ttl,
   'domain' => '',
   'path'   => '/',
   'prefix' => '',
   'secure' => false
   );
   $this->input->set_cookie($cookie);
   return 1;
  }
  $cookie = $this->input->cookie($name);
  return $cookie;
 }
}
