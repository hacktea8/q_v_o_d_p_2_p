<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('display_errors',1);
error_reporting(E_ALL);
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
  public function addpv(){
    $key = 'play_auth'.$ip;
    $this->redis->set($key,1,$this->expirettl['12h']);
    echo 1;
  }
}
