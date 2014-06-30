<?php
/*/
require_once 'Searchapi.php';

$search = new Searchapi();
/*/
require_once 'Yunsearchapi.php';
$search = new Yunsearchapi();
/**/
$list = array();
$page = 1-1;
$pageSize = 12;
$q = "default:'诅咒'";
$q = "诅咒";
$opt = array('query'=>$q,'start'=>$page,'hits'=>$pageSize);
$search->search($list,$opt);

var_dump($list);
