<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'viewbase.php';
class Checkage extends Viewbase {
 public function __construct(){
  parent::__construct();
 }
 public function index(){
  $this->load->view('checkage_index',$this->viewData);
 }
}
