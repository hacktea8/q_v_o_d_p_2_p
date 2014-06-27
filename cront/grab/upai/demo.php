<?php

require_once 'upai.php';

$upai = new Upai();

$fname = '';
$fn = basename($fname);
$targetName = '/www_emubt/'.$fn;


$html = $upai->uploadFile2Upai($fname,$targetName);
var_dump($html);

