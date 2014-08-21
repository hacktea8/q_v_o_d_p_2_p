<?php
require_once $root.'/../db.class.php';
class Model{
  protected $db = '';

  public function __construct(){
     $this->db = new DB_MYSQL(); 
  }
  function getCate(){
    $sql = sprintf('SELECT * FROM %s WHERE `flag`=1',$this->db->getTable('emule_cate'));
    $list = $this->db->result_array($sql);
    $return = array();
    foreach($list as &$v){
      $return[$v['id']] = $v;
    }
    return $return;
  }
  function get_content_table($id){
    return sprintf('emule_article_content%d',$id%10);
  }
  public function getNoneSearchLimit($limit = 30){
     $sql = sprintf('SELECT * FROM %s WHERE nonesearch = 0 LIMIT %d',$this->db->getTable('emule_article'), $limit);
     $list = $this->db->result_array($sql);
     $list = empty($list)?array():$list;
     foreach($list as $k => $val){
       $table = $this->get_content_table($val['id']);
       $sql = sprintf('SELECT intro FROM %s WHERE id = %d LIMIT 1',$this->db->getTable($table),$val['id']);
       $row = $this->db->row_array($sql);
       $list[$k]['intro'] = $row['intro'];
     }
     return $list;
  }
  public function setIsSearch($ids = ''){
     if(!$ids){
        return false;
     }
     $limit = count($ids);
     $ids = implode(',',$ids);
     $sql = sprintf('UPDATE %s SET `nonesearch` = 1  WHERE `id` IN (%s) LIMIT %d',$this->db->getTable('emule_article'),$ids,$limit);
     $this->db->query($sql);
  }
}
