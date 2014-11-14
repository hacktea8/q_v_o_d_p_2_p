<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'webbase.php';
class Videos extends Webbase {
 static public $api = 'http://www.id97.com/';

 public function __construct(){
  parent::__construct();
 }
 public function index($p1 = '',$p2='',$p3='',$p4='',$p5){
  
  $url_str = 'videos/'.$p1.($p2?'/'.$p2:'').($p3?'/'.$p3:'').($p4?'/'.$p4:'').($p5?'/'.$p5:'');
  $url = self::$api.$url_str;
//echo $url;exit;
  $html = file_get_contents($url);
  die($html);
 }
}
