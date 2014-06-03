<?php
class baseModel extends CI_Model{
  public $db;
  
  public function __construct(){
     parent::__construct();
     $this->db  = $this->load->database('default', TRUE);
     
  }
  
  public function geturl($mod,$p1=0,$p2=0;$p3=0;$p4=0){
     $url = '';
     $suf = '.shtml';
     $site_url = '';
     if('lists' == $mod){
       $url = sprintf('%s/maindex/lists/%d/%d/%d%s',$site_url,$p1,$p2,$p3,$suf);
     }elseif('views' == $mod){
       $url = sprintf('%s/maindex/views/%d%s',$site_url,$p1,$p2,$suf);
     }elseif('play' == $mod){
       $url = sprintf('%s/maindex/play/%d%s',$site_url,$p1,$p2,$suf);
     }
     return $url;
  }

  public function getdata(){
     return $this->db->query('select * from test limit 20')->result_array();
  }

}
?>
