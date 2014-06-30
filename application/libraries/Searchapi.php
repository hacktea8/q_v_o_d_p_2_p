<?php
define('YUN_SEARCH_PATH',dirname(__FILE__).'/');
require_once(YUN_SEARCH_PATH.'CloudsearchAPIClient.php');

//126 ml92ML 
define('CLIENT_ID', '6100619159803307'); // $cleint_id替换成您自己的client id.
define('CLIENT_SECRET', '237862e841a1529222471eec3e17032a'); // $cleint_secret替换成您自己的密码.
define('CLIENT_INDEX', 'www_qvdhd');

/*
$client = new CloudsearchClient(
    CLIENT_ID, 
    CLIENT_SECRET, 
    array('host' => 'http://opensearch.etao.com')
);
*/

class Searchapi{
  public $search;

  public function __construct(){
    $url = 'http://opensearch.etao.com';
    
    $this->search = new CloudSearchClient(CLIENT_ID,CLIENT_SECRET, $url) ;
  }
/*
query => ''
fetch_fetches: 设定返回的字段列表
start：指定搜索结果集的偏移量。
hits：指定返回结果集的数量。
sort：指定排序规则
*/
  public function search(&$lists,$opts = array()){
    // 添加指定搜索的应用：
    $kw = $opts['query'];
    $kw = preg_quote($kw);
    unset($opts['query']);
    $this->search->format = "json";
    $this->search->debug = "json";
    $query = sprintf('query=default:\'%s\'&&config=start:%d,hit:%d',$kw,$opts['start'],$opts['hits']);
    $result = $this->search->search(CLIENT_INDEX, array('query'=>$query));
    $lists = json_decode($result,1);
  }
}
?>
