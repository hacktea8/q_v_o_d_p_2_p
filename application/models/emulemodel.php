<?php
require_once 'basemodel.php';
class emuleModel extends baseModel{
  protected $_dataStruct = 'a.`id`, a.`cid`, a.`uid`, a.`name`, a.`collectcount`, a.`ptime`, a.`utime`, a.`thum`, a.`cover`, a.`hits`';
  protected $_datatopicStruct = 'a.`id`, a.`cid`, a.`uid`, a.`name`, a.`vipdown`,a.`collectcount`, ac.`keyword`, ac.`downurl`, ac.`vipdwurl`, a.`ptime`, a.`utime`, ac.`intro`, a.`thum`, a.`cover`, a.`hits`';

  public function __construct(){
     parent::__construct();
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
     $sql = sprintf('SELECT %s,c.`name` as cname,c.atotal FROM %s as a LEFT JOIN %s as c ON (a.cid=c.id) WHERE %s AND a.`flag`=1 AND c.flag=1 %s LIMIT %d,%d',$this->_dataStruct,$this->db->dbprefix('emule_article'),$this->db->dbprefix('emule_cate'),$where,$order,$page,$limit);
//echo $sql;exit;
     $data = array();
     $data['emulelist'] = $this->db->query($sql)->result_array();
     foreach($data['emulelist'] as &$val){
       $val['ptime'] = date('Y-m-d', $val['ptime']);
       $val['utime'] = date('Y/m/d', $val['utime']);
     }
     $data['postion'] = $this->getsubparentCate($cid);
     $data['subcatelist'] = $this->getAllSubcateByCid($cid);
     $data['atotal']   = $this->getCateAtotal($cid);
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
  public function get_content_table($id){
    return sprintf('emule_article_content%d',$id%10);
  }
  public function getEmuleTopicByAid($aid,$uid=0,$isadmin=false,$edite=1){
     $where = '';
     if($uid && !$isadmin && $edite)
       $where = sprintf(' AND `uid`=%d LIMIT 1',$uid);

     $table = $this->get_content_table($aid);
     $sql = sprintf('SELECT %s FROM %s as a LEFT JOIN %s as ac ON (a.id=ac.id) WHERE a.id =%d  %s',$this->_datatopicStruct,$this->db->dbprefix('emule_article'),$this->db->dbprefix($table),$aid,$where);
     $data = array();
     $data['info'] = $this->db->query($sql)->row_array();
     $data['postion'] = $this->getsubparentCate($data['info']['cid']);
     return $data;
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
