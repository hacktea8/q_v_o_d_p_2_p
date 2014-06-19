<?php

define('ROOTPATH',dirname(__FILE__).'/');

require_once ROOTPATH.'../phpCurl.php';
require_once ROOTPATH.'picLink.php';

//var_dump($picConfig);exit;
$picM = new Piclink($picConfig);

$param = array();
/*
$param['action'] = 'get';
/*
 *rainy@tuku> php test.php
 string(37) "{"code":"900","info":"album is null"}"
 rainy@tuku> php test.php
 string(48) "{"code":"200","info":"create ok","albumid":4868}"
 rainy@tuku> php test.php
 string(90) "[{"albumid":"4868","albumname":"\u9759\u601d\u4e50BT\u5f71\u89c6","num":"0","code":"200"}]"
 *
$param['action'] = 'create';
$param['albumname'] = '静思乐BT影视';
//
$return = $picM->album($param);
var_dump($return);
exit;
*/

$param = array('from'=>'web','album'=>4868,'return'=>'ubb');

$token = $picM->upFileToken($param);
$param['token'] = $token;
$param['file'] = 'http://hiphotos.baidu.com/isno/pic/item/67fc5ab50f6323d737d3ca0e.jpg';
$return = $picM->upFile($param);
var_dump($return);

?>
