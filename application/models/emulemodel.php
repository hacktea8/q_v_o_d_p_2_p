<?php
require_once 'basemodel.php';
class emuleModel extends baseModel{
  protected $_dataStruct = 'a.`id`, a.`cid`, a.`uid`, a.`name`, a.`collectcount`, a.`ptime`, a.`utime`,a.`onlinedate`, a.`cover`, a.`hits`';
  protected $_datatopicStruct = 'a.`id`, a.`cid`, a.`uid`, a.`name`,a.`collectcount`, ac.`keyword`, a.`onlinedate`, a.`ptime`, a.`utime`, ac.`intro`, a.`cover`, a.`hits`';
  protected $_volsStruct = '`id`, `vid`, `sid`, `vol`, `volname`';
  protected $_volsPlayStruct = '`id`, `vid`, `sid`, `vol`, `volname`, `link`';

  public function __construct(){
     parent::__construct();
  }
  public function getAllChannel(){
    $sql = sprintf("SELECT `id`, `pid`, `name`, `atotal` FROM `qd_emule_cate` WHERE `flag`=1");
    $list = $this->db->query($sql)->result_array();
    $return = array();
    foreach($list as &$v){
      $v['url'] = $this->geturl('lists',$v['id']);
      $return[$v['id']] = $v;
    }
    return $return;
  }
  public function getIndexData(){
    $return = array();

    return $return;
  }
  public function getNoVIPDownList($limit = 30){
    $sql = sprintf("SELECT `id`, `name` FROM %s WHERE `flag`=2 ORDER BY `hits` DESC LIMIT %d",$this->db->dbprefix('emule_article'),$limit);
    $list = $this->db->query($sql)->result_array();
    return $list;
  }

  public function getUserCollectList($uid,$order=0,$page=1,$limit=25){
    if( !$uid){
      return false;
    }
    $ordermap = array('new'=>'ct.`atime` DESC ');
    $order = isset($ordermap[$order]) ? $ordermap[$order] : array_shift($ordermap);
    $order = ' ORDER BY '.$order;
    $page = intval($page) - 1;
    $page = $page ? $page : 0;
    $page *= $limit;
    $limit = sprintf(' LIMIT %d,%d ',$page,$limit);
    $sql = sprintf("SELECT ae.`id`, ae.`cid`, ae.`uid`, ae.`name`, ae.`utime`, ae.`cover`,ct.`atime` FROM %s as ae INNER JOIN %s as ct ON(ae.id=ct.aid) WHERE ct.uid=%d AND ct.`flag`=1 %s %s",$this->db->dbprefix('emule_article'),$this->db->dbprefix('collect'),$uid,$order,$limit);
    $list = $this->db->query($sql)->result_array();
    foreach($list as &$v){
      $v['utime'] = date('Y-m-d H:i:s', $v['utime']);
      $v['atime'] = date('Y-m-d H:i:s', $v['atime']);
    }
    return $list;
  }

  public function renewUserShip($data){
    //collect
    if('collect' === $data['type']){
       $sql = sprintf("UPDATE %s SET `collectcount`=`collectcount` %s WHERE `id`=%d LIMIT 1",$this->db->dbprefix('emule_article'),$data['collect'],$data['aid']);
       return $this->db->query($sql);
    }
  }

  public function addUserCollect($uid,$aid){
    if( !$uid || !$aid){
      return false;
    }
    $table = $this->db->dbprefix('collect');
    $sql = sprintf("SELECT `flag` FROM %s WHERE `aid`=%d AND `uid`=%d LIMIT 1",$table,$aid,$uid);
    $row = $this->db->query($sql)->row_array();
    if(isset($row['flag'])){
      $flag = $row['flag'];
      $flag = $flag ? 0:1;
      $sql = $this->db->update_string($table,array('flag'=>$flag),array('aid'=>$aid,'uid'=>$uid));
      $this->db->query($sql);
      return $flag;
    }
    $data = array('aid'=>$aid,'uid'=>$uid,'flag'=>1,'atime'=>time());
    $sql = $this->db->insert_string($table,$data);
    $this->db->query($sql);
    return 1;
  }

  public function getUserIscollect($uid,$aid){
    if( !$uid || !$aid){
      return false;
    }
    $sql = sprintf("SELECT `flag` FROM %s WHERE `aid`=%d AND `uid`=%d LIMIT 1",$this->db->dbprefix('collect'),$aid,$uid);
    $row = $this->db->query($sql)->row_array();
    return isset($row['flag']) ? $row['flag']:0;
  }

  public function getUserCollectTotal($uid){
    if( !$uid){
      return false;
    }
    $sql = sprintf("SELECT count(*) as total FROM %s WHERE `uid`=%d",$this->db->dbprefix('collect'),$uid);
    $row = $this->db->query($sql)->row_array();
    return isset($row['total']) ? $row['total']: 0;
  }

  public function getArticleListByCid($cid='',$order=0,$page=1,$limit=25){
     switch($order){
       case 1:
       $order=' ORDER BY a.hits ASC '; break;
       case 2:
       $order=' ORDER BY a.hits DESC '; break;
       default:
       $order=' ORDER BY a.ptime DESC ';
     }
     $page = intval($page) - 1;
     $page = $page ? $page : 0;
     $page *= $limit;
     if($cid){
       $cids = $this->getAllCateidsByCid($cid);
       $cids = implode(',',$cids);
       $where = ' a.`cid` in ('.$cids.')  ';
     }
     $sql = sprintf('SELECT %s FROM %s as a WHERE %s AND a.`flag`=1 %s LIMIT %d,%d',$this->_dataStruct,$this->db->dbprefix('emule_article'),$where,$order,$page,$limit);
//echo $sql;exit;
     $data = array();
     $data = $this->db->query($sql)->result_array();
     foreach($data as &$val){
       $val['ptime'] = date('Y-m-d', $val['ptime']);
       $val['utime'] = date('Y/m/d', $val['utime']);
     }
     return $data;
  }

  public function getAllSubcateByCid($cid,$limit = 0){
    $sql = sprintf('SELECT `id`, `pid`, `name`, `atotal` FROM %s WHERE `id`=%d AND `flag`=1 LIMIT 1',$this->db->dbprefix('emule_cate'),$cid);
    $subinfo = $this->db->query($sql)->row_array();
    if( $subinfo['pid']){
      $cid = $subinfo['pid'];
    }
    $limit = intval($limit);
    $limit = $limit ? ' ORDER BY atotal DESC LIMIT '.$limit : '';
    $sql = sprintf('SELECT `id`, `pid`, `name`, `atotal` FROM %s WHERE `pid`=%d AND `flag`=1 %s',$this->db->dbprefix('emule_cate'),$cid,$limit);
    return $this->db->query($sql)->result_array();
  }

  public function getCateListByPid($pid = 0, $limit = 0){
    if( !$pid){
      return false;
    }
    $limit = intval($limit);
    $limit = $limit ? ' ORDER BY atotal DESC LIMIT '.$limit : '';
    $sql = sprintf('SELECT `id`, `pid`, `name`, `atotal` FROM %s WHERE `pid`=%d AND `flag`=1 %s',$this->db->dbprefix('emule_cate'),$pid,$limit);
    return $this->db->query($sql)->result_array();
  }

  public function getsubparentCate($cid = 0){
     if( !$cid){
        return false;
     }
     $sql = sprintf('SELECT `id`, `pid`, `name` FROM %s WHERE `id`=%d AND `flag`=1 LIMIT 1',$this->db->dbprefix('emule_cate'),$cid);
     $subinfo = $this->db->query($sql)->row_array();
     if($subinfo['pid']){
       $parinfo = $this->getsubparentCate($subinfo['pid']);
     }else{
       return array($subinfo);
     }
     return $res = array(array('id'=>$parinfo[0]['id'],'name'=>$parinfo[0]['name']),array('id'=>$subinfo['id'],'name'=>$subinfo['name']));
  }
  public function get_vols_table($id){
    return sprintf('emule_article_vols%d',$id%10);
  }
  public function get_content_table($id){
    return sprintf('emule_article_content%d',$id%10);
  }
  public function getEmuleTopicByAid($aid,$sid=0,$uid=0,$isadmin=false,$edite=1,$view=1){
     $where = '';
     if($uid && !$isadmin && $edite)
       $where = sprintf(' AND `uid`=%d LIMIT 1',$uid);

     $table = $this->get_content_table($aid);
     $sql = sprintf('SELECT %s FROM %s as a LEFT JOIN %s as ac ON (a.id=ac.id) WHERE a.id =%d  %s LIMIT 1',$this->_datatopicStruct,$this->db->dbprefix('emule_article'),$this->db->dbprefix($table),$aid,$where);
     $data = array();
     $data['info'] = $this->db->query($sql)->row_array();
     $data['vols'] = $this->getVideoVolsTitle($aid,$sid,$view);
     return $data;
  }
  public function getVideoVolsTitle($vid,$sid,$view){
    if($sid){
       $serverMod = array(1=>'qvod',2=>'百度影音',3=>'xfplay',4=>'百度影音');
       $sinfo = isset($serverMod[$sid])?$serverMod[$sid]:0;
    }
    if($sinfo){
      $vgroupby = sprintf(' AND `sid`=%d ',$sid);
    }else{
      //$vgroupby = ' GROUP BY `sid` ';
      $vgroupby = ' ';
    }
    $table = $this->get_vols_table($vid);
    if(1 == $view){
      $struct = $this->_volsStruct;
    }else{
      $struct = $this->_volsPlayStruct;
    }
    $sql = sprintf('SELECT %s FROM %s WHERE `vid`=%d %s',$struct,$this->db->dbprefix($table),$vid,$vgroupby);
    $lists = $this->db->query($sql)->result_array();
    $return = array();
//echo '<pre>';echo $sql;var_dump($lists);exit;
    foreach($lists as &$v){
      $return[$v['sid']][$v['vol']] = $v;
      if($v['volname']){
         continue;
      }
      $return[$v['sid']][$v['vol']]['volname'] = $this->updateVolsVolTitle($v['id']);
    }
    return $return;
  }
  public function updateVolsVolTitle($vid,$id){
    if(!$vid || !$id){
      return 0;
    }
    $table = $this->get_vols_table($vid);
    $sql = sprintf('SELECT `link` FROM %s WHERE `id`=%d LIMIT 1',$table,$id);
    $row = $this->db->query($sql)->row_array();
    $volname = '发生错误!';
    if($row){
      $volname = substr($row['link'],0,strpos($row['link'],'$'));
      $volname = trim($volname);
      echo $row['link'],'<br />',$volname,'<br />';
      $volname = $this->unicode_decode($volname);
      echo $volname;exit;
    }
    return $volname;
  }
  // 将UNICODE编码后的内容进行解码，编码后的内容格式：YOKA\u738b （原始：YOKA王）
  public function unicode_decode($name){
  // 转换编码，将Unicode编码转换成可以浏览的utf-8编码
    $pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
    preg_match_all($pattern, $name, $matches);
    if(!empty($matches)){
      $name = '';
      for($j = 0; $j < count($matches[0]); $j++){
        $str = $matches[0][$j];
        if(strpos($str, '\\u') === 0){
          $code = base_convert(substr($str, 2, 2), 16, 10);
          $code2 = base_convert(substr($str, 4), 16, 10);
          $c = chr($code).chr($code2);
          $c = iconv('UCS-2', 'UTF-8', $c);
          $name .= $c;
        }else{
          $name .= $str;
        }
      }
    }
    return $name;
  }
  public function setEmuleTopicByAid($uid=0,$data,$isadmin=false){
     //过滤字段
     $header = array();
     $header['id'] = $data['header']['id'];
     $header['cid'] = $data['header']['cid'];
     $header['name'] = $data['header']['name'];
     $header['cover'] = $data['header']['cover'];
     $header['thum'] = $data['header']['thum'];
     $header['flag'] = $data['header']['flag']?$data['header']['flag']:1;
     $header['utime'] = time();
     $body = array();
     $body['keyword'] = $data['header']['tags'];
     $body['downurl'] = $data['body']['downurl'];
     $body['vipdwurl'] = $data['body']['vipdwurl'];
     $body['intro'] = $data['body']['intro'];
     if(isset($header['id']) && $header['id']){
        $this->_datatopicStruct = ' a.`id` ';
        $check = $this->getEmuleTopicByAid($header['id'],$uid,$isadmin);
        if( !isset($check['info']['id'])){
           return false;
        }
        $where = array('id'=>$header['id']);
        unset($header['id']);
        $sql = $this->db->update_string($this->db->dbprefix('emule_article'),$header,$where);
        $this->db->query($sql);
        $table = $this->get_content_table($where['id']);
        $cinfo = $this->checkArticleContent($where['id']);
        if($cinfo){
          $sql = $this->db->update_string($this->db->dbprefix($table),$body,$where);
        }else{
          $body['id'] = $where['id'];
          $sql = $this->db->insert_string($this->db->dbprefix($table),$body);
        }
        $this->db->query($sql);
        return $data['id'];
     }
     $header['uid'] = $uid;
     unset($header['id']);
     $header['ptime'] = $header['ptime']?$header['ptime']:time();
     $sql = $this->db->insert_string($this->db->dbprefix('emule_article'),$header);
     $this->db->query($sql);
     $id = $this->db->insert_id();
     $body['id'] = $id;
     $table = $this->get_content_table($id);
     $sql = $this->db->insert_string($this->db->dbprefix($table),$body);
     $this->db->query($sql);
     return $id;
  }
  public function checkArticleContent($aid){
     if(!$aid){
       return 0;
     }
     $table = $this->get_content_table($aid);
     $sql = sprintf("SELECT `id` FROM %s WHERE `id`=%d LIMIT 1",$table,$aid);
     $row = $this->db->query($sql)->row_array();
     return $row;
  }
  public function delEmuleTopicByAid($aid = 0,$uid=0,$isadmin=false){
     if( !$aid){
        return false;
     }
     $this->_datatopicStruct = ' `id` ';
     $check = $this->getEmuleTopicByAid($aid,$uid,$isadmin);
     if( !isset($check['id'])){
        return false;
     }
     $where = array('id'=>$aid);
     $sql = $this->db->delete($this->db->dbprefix('emule_article'),$where);
     $this->db->query($sql);
     $table = $this->get_content_table($aid);
     $sql = $this->db->delete($this->db->dbprefix($table),$where);
     $this->db->query($sql);
     return $aid;
  }

  public function getCateAtotal($cid){
     if( !$cid){
        return false;
     }
     $sql = sprintf('SELECT `pid`, `atotal` FROM %s WHERE `id`=%d AND `flag`=1 LIMIT 1',$this->db->dbprefix('emule_cate'),$cid);
     $subinfo = $this->db->query($sql)->row_array();

     if( !$subinfo['pid']){
        $sql = sprintf('SELECT sum(`atotal`) as atotal FROM %s WHERE `pid`=%d AND `flag`=1',$this->db->dbprefix('emule_cate'),$cid);
        $subinfo = $this->db->query($sql)->row_array();
     }
     return $subinfo['atotal'];

  }

  public function getAllCateidsByCid($cid = 0){
     if( !$cid){
        return false;
     }
     $sql = sprintf('SELECT `id` FROM %s WHERE `pid`=%d AND `flag`=1',$this->db->dbprefix('emule_cate'),$cid);
     $cate = $this->db->query($sql)->result_array();
     $res = array();
     foreach($cate as $val){
       $res[] = $val['id'];
     }
     $res = count($res) ? $res : array($cid);
     return $res;
  }

  public function getHotTopic($order = 'hits',$limit=15){
     $order = $order ? ' `ptime` DESC ': ' `hits` DESC ';
     $sql   = sprintf('SELECT `id`, `name`, `thum`,`cover` FROM %s WHERE `flag`=1 ORDER BY %s LIMIT %d', $this->db->dbprefix('emule_article'), $order, $limit); 
     return $this->db->query($sql)->result_array();
  }

  public function getCateByCid($sub=0){
     if($sub){
       $sql = sprintf('SELECT `id`, `pid`, `name`, `atotal` FROM %s WHERE `flag` = 1',$this->db->dbprefix('emule_cate'));
       $list= $this->db->query($sql)->result_array();
       $res = array();
       foreach($list as $val){
         if($val['pid'] == 0){
           $res[$val['id']]['id'] = $val['id'];
           $res[$val['id']]['name'] = $val['name'];
           $res[$val['id']]['atotal'] = $val['atotal'];
         }else{
           $res[$val['pid']]['subcate'][] = $val;
         }
       }
       return $res;
     }

     $sql = sprintf('SELECT `id`, `pid`, `name`, `atotal` FROM %s WHERE `pid` = 0 AND `flag` = 1',$this->db->dbprefix('emule_cate'));
     return $this->db->query($sql)->result_array();
  }
  public function getdata(){
     return 9999999;
  }
}
?>
