<?php

require_once 'basemodel.php';

class userModel extends baseModel{

 public function __construct(){
  parent::__construct();

 }
 public function getUserInfo($uinfo){
  if( !isset($uinfo['uid']) || !$uinfo['uid']){
   return false;
  }
  $sql = sprintf("SELECT * FROM `%s` WHERE `uid`=%d LIMIT 1", $this->db->dbprefix('user'), $uinfo['uid']);
  $row = $this->db->query($sql)->row_array();
  $uinfo['isvip'] = 0;
  if($uinfo['groupid'] == 21){
   $uinfo['isvip'] = 1;
  }elseif( in_array($uinfo['groupid'] ,array(22,1,2)) ){
    $uinfo['isvip'] = 2;
  }elseif( in_array($uinfo['groupid'] ,array(1,2)) ){
    $uinfo['isadmin'] = 1;
  }
  $ip = get_client_ip();
  if(isset($row['uid'])){
   $update = array();
   if($row['loginip'] != $ip){
    $row['loginip'] = $update['loginip'] = $ip;
   }
   if($row['logintime'] != date('Ymd')){
    $row['logintime'] = $update['logintime'] = date('Ymd');
   }
   if($row['isvip'] != $uinfo['isvip']){
    $row['isvip'] = $update['isvip'] = $uinfo['isvip'];
   }
   if($row['uname'] != $uinfo['uname']){
    $row['uname'] = $update['uname'] = $uinfo['uname'];
   }
   if(count($update)){
    $where = sprintf(" `uid` =%d LIMIT 1", $uinfo['uid']);
    $sql = $this->db->update_string($this->db->dbprefix('user'),$update,$where);
    $this->db->query($sql);
   }
   return $row;
  }else{
   $sql = sprintf("INSERT INTO %s(`uid`, `uname`, `isvip`, `loginip`, `logintime`, `collectcount`, `bmarkcount`,point) VALUES (%d,'%s',%d,'%s',%d,0,0,24)", $this->db->dbprefix('user'), $uinfo['uid'],mysql_real_escape_string($uinfo['uname']),$uinfo['isvip'],mysql_real_escape_string($ip),date('Ymd'));
   $this->db->query($sql);
  }
  return $uinfo;
 }
 public function updateUserPoint($uid, $point = 0){
  $sql = sprintf('UPDATE %s SET point=point+%d WHERE uid=%d LIMIT 1',$this->db->dbprefix('user'),$point,$uid);
  $this->db->query($sql);
  return $uid;
 }
}
