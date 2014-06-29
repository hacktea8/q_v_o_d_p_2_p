<?php
define('YUN_SEARCH_PATH',dirname(__FILE__).'/');
require_once(YUN_SEARCH_PATH.'CloudsearchClient.php');
require_once(YUN_SEARCH_PATH.'CloudsearchDoc.php');
require_once(YUN_SEARCH_PATH.'CloudsearchSearch.php');
require_once(YUN_SEARCH_PATH.'CloudsearchAnalysis.php');

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

class Yunsearchapi{
  public $doc;
  public $search;
  public $analysis;

  public function __construct(){
    $client = new CloudsearchClient(
     CLIENT_ID,
     CLIENT_SECRET,
     array('host' => 'http://opensearch.etao.com')
    );
    $this->doc = new CloudsearchDoc(CLIENT_INDEX, $client);
    $this->search = new CloudsearchSearch($client);
    $this->analysis = new CloudsearchAnalysis(CLIENT_INDEX, $client);
  }
  public function getTopQuery($num=8,$days=30){
    $list = $this->analysis->getTopQuery($num, $days);
    return $list;
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
    $this->search->addIndex(CLIENT_INDEX);
// 指定搜索的关键词，
    $kw = $opts['query'];
    unset($opts['query']);
    $this->search->setQueryString("default:'$kw'");
// 指定搜索返回的格式。
    $this->search->setFormat('json');
// 返回搜索结果。
    $lists = $this->search->search($opts);
    $lists = json_decode($lists,1);
    return 1;
  }
  public function addDoc($json){
// 或$doc->update($json), $doc->remove($json)
// 注意，参数1可以为一个json的string或者为一个数组，
// 结构为：
// [{fields:{fieldname1: fieldvalue1, fieldname2: fieldvalue2, ...}, cmd: ADD|DELETE|UPDATE},...]
// 参数2为您创建要push数据的表名。
// 如果需要多表的数据push，请先push附表的数据，然后在push主表的数据。
    return $this->doc->add($json, 'main');
  }
  public function setDoc($json){
    return $this->doc->update($json, 'main');
  }
}
?>
