<?php

$root = dirname(__FILE__).'/';

require_once $root.'../model.php';
require_once $root.'../db.class.php';

$model = new Model();

for($page = 800; $page<1600;$page++){
  $list = $model->getArticleList($page, $limit = 500);
  if(empty($list)){
    break;
  }

 foreach($list as $val){
    $data = $model->getArticleByid($val['id']);
//var_dump($data);exit;
    $model->add_article_contents($data );
//    exit;
  }
}
echo "\n++++page: 1 - $page is OK!++++\n";

