<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'webbase.php';
class Ajaxapi extends Webbase {


 public function __construct(){
  parent::__construct();
  //判断referer是否合法
  $allow_referer = $this->config->item('allow_referer');
  $domain_arr = explode('|', $allow_referer);
  $referer = false;
  foreach($domain_arr as $v){
   if(false !== strpos($_SERVER['HTTP_REFERER'], $v)){
    $referer = true;
    break;
   }
  }
  if(!$referer){
   die(0);
  }
  //判断请求是否Ajax
  if( 'XMLHttpRequest' != $_SERVER['HTTP_X_REQUESTED_WITH']){
    die(0);
  }
  $this->load->model('emulemodel');
 }
  
 public function getcate($cid = 0, $pid = 0){
  $return = $this->_getCateListById($id, $pid);
  die(json_encode($return));
 }
 public function article_pv($aid){
  $ip = $this->input->ip_address();
  $key = sprintf('user_hits_check:%s:%d',$ip,$aid);
//var_dump($this->redis->exists($key));exit;
  if( $this->redis->exists($key)){
   return 0;
  }
  $this->redis->set($key, 1,self::$ttl['1d']);
  $key = sprintf('user_topic_hits:%d',$aid);
  $this->redis->incr($key);

 }
 public function addpv(){
  $key = 'play_auth'.$ip;
  $this->redis->set($key,1,self::$ttl['12h']);
  echo 1;
 }
 public function clearcache($type = 'mem',$key = 'all'){
  if($type == 'mem'){
   $key_map = array('top_youMayLike','channel','');
  }
  echo '1';
 }
 public function addUserOnlinePoint(){
  if( !$this->userInfo['uid']){
   return false;
  }
  $k = 'user_online_point_'.$this->userInfo['uid'];
  $ltime = $this->redis->get($k);
  $ctime = time();
  if( !$ltime){
   $this->redis->set($k, $ctime, self::$ttl['15m']);
   return 0;
  }
  $step = $ctime - $ltime;
  if($step < 600){
   return false;
  }
  $point = floor($step/600);
  $this->load->model('userModel');
  $this->userModel->updateUserPoint($this->userInfo['uid'], $point);
  $this->redis->set($k, $ctime, self::$ttl['15m']);
  return 1;
 }
}
