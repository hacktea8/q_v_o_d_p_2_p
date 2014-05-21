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
    $post = json_decode($post,1);
    if(!$post){
      echo '404';exit;
    }
    $data = $this->grabapimodel->addCateByname($post);
    $data = json_encode($data);
    die($data);
  }
  public function checkArticleByOname(){
    $oname = $_POST['oname'];
    if(!$oname){
      echo '404';
      return 0;
    }
    $data = $this->grabapimodel->checkArticleByOname($oname);
    $data = json_encode($data);
    die($data);
  }
  public function addArticleInfo(){
    $post = $_POST['article_data'];
    $post = json_decode($post,1);
    if(!$post){
      echo '404';
      return 0;
    }
    $data = $this->grabapimodel->addArticle($post);
    $data = json_encode($data);
    die($data);
  }
  public function addArticleVols(){
    $post = $_POST['article_data'];
    if(!$post){
      echo '404';
      return 0;
    }
    $data = $this->grabapimodel->addArticleVols($post);
    $data = json_encode($data);
    die($data);
  }
}
