<?php
class grabapiModel extends CI_Model{
  public $db;
  
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
    $sql = sprintf("SELECT * FROM %s WHERE `name`='%s' LIMIT 1",$table,$data['name']);
    $row = $this->db->query($sql)->row_array();
    if($row){
      return $row['id'];
    }
    $sql = $this->db->insert_string($table,$data);
    $id = $this->db->query($sql)->insert_id();
    return $id;
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
    $head = $this->copy_array($data['head'],array('name','cid'));
    $contents = $this->copy_array($data['content'],array('intro','keyword'));
    $vols = $data['vols'];
    $sql=$this->db->insert_string($this->db->dbprefix('emule_article'),$head);
    $this->db->query($sql);
    $id = $this->db->insert_id();
    if(!$id){
       return false;
    }
    $contents['id'] = $id;
    $table = $this->get_content_table($id);
    $sql=$this->db->insert_string($this->db->dbprefix($table),$contents);
    $this->db->query($sql);
    return $id;
  }
  public function addArticleVols($data){
    if( !$data){
      return 0;
    }
    foreach($data as $vol){
      $this->addVols($vol);
    }
    return 1;
  }
  public function addVols($data){
    if( !$data['link']){
      return 0;
    }
    $table = $this->db->dbprefix('emule_article_vols'.$data['vid']%10);
    $sql = sprintf("SELECT `id` FROM %s WHERE `sid`=%d AND `vid`=%d LIMIT 1",$table,$data['sid'],$data['vid']);
    $row = $this->db->query($sql)->row_array();
    if($row){
      return $row['id'];
    }
    $sql=$this->db->insert_string($table,$data);
    $id = $this->db->query($sql)->insert_id();
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
