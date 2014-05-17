<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aboutus extends CI_Controller {
  public $guid = 'http://www.hacktea8.com/thread-9650-1-1.html';
	/**
	 * Index Page for this controller.
	 *
	 */
  public function __construct(){
    parent::__construct();
    //$this->load->model('apimodel');
  }
  public function index(){
    header('Location: '.$this->guid);
  }
  public function serverlist(){
    header('Location: '.$this->guid);
  }
  public function connectsrv(){
    header('Location: '.$this->guid);
  }
  public function connectkad(){
    header('Location: '.$this->guid);
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
