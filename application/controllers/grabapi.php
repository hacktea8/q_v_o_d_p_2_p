<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grabapi extends CI_Controller {
   
	/**
	 * Index Page for this controller.
	 *
	 */
  public function __construct(){
    parent::__construct();
    $this->load->model('grabapimodel');
  }
  public function addCateByname(){
    $post = $_POST['cate_info'];
    if(!$post){
      echo 'data 404';
      return 0;
    }
    $data = $this->grabapimodel->addCateByname($post);
    $data = json_encode($data);
    die($data);
  }
  public function feed($cid=0){
    $data = $this->apimodel->getFeedById($cid);
    $this->load->view('api_feed',array('data'=>$data));
  }
  public function opensearch(){
    $data = $this->apimodel->getFeedById($cid);
    $this->load->view('api_opensearch',array('data'=>$data));
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
