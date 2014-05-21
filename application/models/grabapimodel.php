<?php
class grabapiModel extends CI_Model{
  public $db;
  public $serverMod = array('qvod'=>1,'百度影音'=>2,'xfplay'=>3);  
  public function __construct(){
     parent::__construct();
     $this->db  = $this->load->database('default', TRUE);
     
  }
  public function get_content_table($id){
    return sprintf('emule_article_content%d',$id%10);
  }

  public function addCateByname($data){
    if(empty($data['name'])){
      return 0;
    }
    $table = $this->db->dbprefix('emule_cate');
    $sql = sprintf("SELECT * FROM %s WHERE `name`='%s' LIMIT 1",$table,mysql_real_escape_string($data['name']));
    $row = $this->db->query($sql)->row_array();
    if($row){
      return $row['id'];
    }
    $sql = $this->db->insert_string($table,$data);
    $this->db->query($sql);
    $id = $this->db->insert_id();
    return array('id'=>$id);
  }
  public function checkArticleByOname($name){
     if(!$name){
       return array();
     }
     $sql = sprintf("SELECT `id` FROM `%s` WHERE  `name`='%s' LIMIT 1",$this->db->dbprefix('emule_article'),mysql_real_escape_string($name));
    $row = $this->db->query($sql)->row_array();
    return $row['id']?$row['id']:0;
  }
  public function addArticle($data){
    if(empty($data['name'])){
      return 0;
    }
    $head = $this->copy_array($data,array('name','cid','thum','ourl','ptime','utime'));
    $contents = $this->copy_array($data,array('intro','actor','keyword'));
    $sql = $this->db->insert_string($this->db->dbprefix('emule_article'),$head);
    $this->db->query($sql);
    $id = $this->db->insert_id();
    if(!$id){
       return false;
    }
    $contents['id'] = $id;
    $table = $this->get_content_table($id);
    $sql = $this->db->insert_string($this->db->dbprefix($table),$contents);
    $this->db->query($sql);
    foreach($data['vols'] as $vinfo){
      $vdata = array('vid'=>$id,'server'=>$vinfo[0],'vols'=>$vinfo[1]);
      $this->addArticleVols($vdata);
    }
    return $id;
  }
  public function addArticleVols($data){
    if( !$data){
      return 0;
    }
    $vols = array();
    $vols['sid'] = $this->serverMod[$data['server']];
    $vols['vid'] = $data['vid'];
    foreach($data['vols'] as $vol){
      $vols['vol'] = $k+1;
      $vols['link'] = $vol;
      $this->addVols($vols);
    }
    return 1;
  }
  public function addVols($data){
    if( !$data['link']){
      return 0;
    }
    $table = $this->db->dbprefix('emule_article_vols'.$data['vid']%10);
    $sql = sprintf("SELECT `id` FROM %s WHERE `vol`=%d AND `sid`=%d AND `vid`=%d LIMIT 1",$table,$data['vol'],$data['sid'],$data['vid']);
    $row = $this->db->query($sql)->row_array();
    if($row){
      return $row['id'];
    }
    $sql = $this->db->insert_string($table,$data);
    $this->db->query($sql);
    $id = $this->db->insert_id();
    return $id;
  }
  public function copy_array($data,$key){
    $return = array();
    foreach($key as $k){
      if(isset($data[$k])){
        $return[$k] = $data[$k];
      }
    }
    return $return;
  }

}
?>
