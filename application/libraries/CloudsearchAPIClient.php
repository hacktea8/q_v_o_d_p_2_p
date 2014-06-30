<?php
/**
 * 云搜索客户端API
 * 
 * 不同于原版本，本版本力求用最简单的方式实现api功能，
 * 同时用户也可以根据线上文档添加新的api方法。
 * @link http://opensearch.aliyun.com/wiki/index.php/API%E6%96%87%E6%A1%A3
 * @version 
 * @copyright aliyun 
 * @usage
 * 
        $client_id = "xxxxxxx";
        $client_secret = "xxxxxxxxxxxxxxxxx";
        $url = "http://opensearch.aliyun.com";
        $index_name = "xxx";

        $client = new CloudSearchClient($client_id, $client_secret, $url) ;
        $client->format = "json";
        $result = $client->search($index_name, array('q'=>'云搜索'));
        $result = json_decode($result);
 */
class CloudSearchClient
{
    const METHOD_GET = "GET";
    const METHOD_POST = "POST";
    const SOCKET_READ_SIZE = 1024; 
    const FORMAT_XML       = "xml";
    const FORMAT_JSON      = "json";
    const DEFAULT_PAGE_SIZE = 10;
    const SIGN_MODE = 1;//defalut not set 
    const DEFAULT_INDEX_TABLE_NAME = "main";

    private $sign;
    private $nonce;
    public $clientId;
    public $clientSecret;
    public $httpCode;
    public $httpInfo;
    public $timeout = 30;
    public $connectTimeout = 30;
    public $debug = false;
    public $isCurl = true;
    public $format = self::FORMAT_JSON;
    public $method = self::METHOD_GET;
    public $version = "v2";
    public $apiURL = "http://opensearch.etao.com";

    // api url 用户可以自行添加
    private static $uri = array(
            "create_index" => "/index",        
            "update_index" => "/index",        
            "delete_index" => "/index",        
            "list_indexes" => "/index",
            "index_status" => "/index",
            "index_error"  => "/index/error",
            "push_doc"     => "/index/doc",        
            "search"       => "/search",        
            "get_doc"      => "/index/doc",        
            "top_query"    => "/top/query",        
            );

    public function __construct($client_id, $client_secret, $api_url = NULL, $version = NULL)
    {
        $this->clientId     = $client_id;//注意32位需要用string类型处理
        $this->clientSecret = $client_secret;
        $this->initURL($api_url, $version);
    }

    /**
     * API:创建索引
     * 
     * @param string $index_name  索引名称
     * @param string $template  模版名称
     * @return string
     */
    public function createIndex($index_name, $template)
    {
        $url = $this->serverURL.self::$uri["create_index"]."/".$index_name;
        $params = array(
                'action'    => "create",
                'template'  => $template,
                );
        $result = $this->apiCall($url, $params);
        return $result;
    }
    
    /**
     * API:删除索引
     * 
     * @param string $index_name 索引名称
     * @return string
     */
    public  function deleteIndex($index_name)
    {
        $url = $this->serverURL.self::$uri["delete_index"]."/".$index_name;
        $params = array(
                "action"     => "delete"
                );
        $result = $this->apiCall($url, $params);
        return $result;
    }

    /**
     * API:更新索引
     * 
     * @param string $index_name 被更新索引名称
     * @param string $new_index_name 更新后索引名称
     * @param string $des 更新索引描述 可选
     * @return string
     */
    public  function updateIndex($index_name, $new_index_name, $des = NULL)
    {
        $url = $this->serverURL.self::$uri["update_index"]."/".$index_name;
        $params = array(
                "new_index_name" => $new_index_name,
                "action"     => "update",
                "description" => $des, 
                );
        $result = $this->apiCall($url, $params);
        return $result;
    }
    
    /**
     * API:获取索引状态
     * 
     * @param string $index_name 索引名称
     * @return string
     */
    public function getIndexStatus($index_name)
    {
        $url = $this->serverURL.self::$uri["index_status"]."/".$index_name;
        $params = array(
                "action" => "status"
                );
        $result = $this->apiCall($url, $params);
        return $result;
    }
    
    /**
     * API:列出所有索引
     * 
     * @param int $page 列表页码
     * @param int $page_size 每页条数
     * @return string
     */
    public  function listIndexes($page = 1, $page_size = self::DEFAULT_PAGE_SIZE)
    {
        $url = $this->serverURL.self::$uri["list_indexes"];
        $params = array(
                'page' => $page,
                'page_size'  => $page_size,
                );
        $result = $this->apiCall($url, $params);
        return $result;
    }
    
    /**
     * API:上传文档
     * 
     * @param string $index_name  索引名称
     * @param  string $docs  文档内容，需要json_encode 
     * @return string
     */
    public  function pushDoc($index_name, $docs, $table_name = self::DEFAULT_INDEX_TABLE_NAME)
    {
        $url = $this->serverURL.self::$uri["push_doc"]."/".$index_name;
        $params = array(
                "items"  => $docs,
                "action" => "push",
                "sign_mode"=>self::SIGN_MODE,
                "table_name" => $table_name,
                );
        $result = $this->apiCall($url, $params);
        return $result;
    }
    
    /**
     * API:根据id获得文档内容
     * 
     * @param string $index_name  索引名称
     * @param string $doc_id 文档id
     * @return string
     */
    public function getDocById($index_name, $doc_id)
    {
        $url = $this->serverURL.self::$uri["get_doc"]."/".$index_name;
        $params = array(
                "id"  => $doc_id,
                );
        $result = $this->apiCall($url, $params);
        return $result;
    }
    
    /**
     * API:获取错误信息
     * 
     * @param string $index_name  索引名称
     * @param int $page 错误页码
     * @param int $page_size 错误信息每页条数
     * @param string $sort_mode 错误信息 排序方式DESC,ACS
     * @return string
     */
    public  function getErrorMessage($index_name, $page = 1, $page_size = self::DEFAULT_PAGE_SIZE, $sort_mode = NULL)
    {
        $url = $this->serverURL.self::$uri["index_error"]."/".$index_name;
        $params = array(
                'page'=>$page,
                'page_size'=>$page_size,
                'sort_mode'=>$sort_mode,
                );
        $result = $this->apiCall($url, $params);
        return $result;
    }
    /**
     * API:搜索文档
     * 
     * @param string $index_name  索引名称
     * @param array $query_params
     * @return string 
     */
    public function search($index_name, $query_params = array())
    {
        $url = $this->serverURL.self::$uri["search"];
        $query_params['index_name'] = $index_name;  
        $result = $this->apiCall($url, $query_params);
        return $result;
    }
    public function query($index_name, $query_params = array()){
     $url = $this->serverURL.self::$uri["search"]."/";
     $query_params['index_name'] = $index_name;
     
    } 
    /**
     * API:获得搜索频繁词
     * 
     * @param string $index_name  索引名称
     * @param int $num 返回总条数 （有总数限制，不能过大）
     * @param int $days 返回统计
     */
     public  function getTopQuery($index_name, $num = self::DEFAULT_PAGE_SIZE, $days = 7)
     {
        $url = $this->serverURL.self::$uri["top_query"]."/".$index_name;
        $query_params = array(
            'num' => $num,
            'days'=> $days,
        );
        $result = $this->apiCall($url,$query_params);
        return $result;
    }

    /**
     * 请求服务器api
     * 
     * @param string $url 请求的api地址
     * @param array $params 参数数组 
     * @param array $http_options 可选参数
     * @return string 
     */
    public function apiCall($url, $params = array(), $http_options = array()) 
    {
        #$params['format'] = $this->format;
        $params['client_id'] = $this->clientId;
        #$params["version"] = $this->version;
        $params['nonce']  = $this->_makeNonce();
        $params['sign']    = $this->_makeSign($params);

        if ($this->isCurl)
        {
            $data = $this->requestByCurl($this->method, $url, $params, $http_options);
        }
        else
        {
            $data = $this->requestBySocket($this->method, $url, $params, $http_options); 
        }

        return $data;
    }

    private function initURL($api_url, $version)
    {
        if ($api_url)
        {
            $this->apiURL = $api_url;
        }

        if ($version)
        {
            $this->version = $version;
        }

        $this->serverURL    = rtrim($this->apiURL, "/").'/'.$this->version.'/api';
    }

    /**
     * 根据参数创建签名信息。
     * 
     * @param array 参数数组。
     * @return string 签名字符串。
     * @access private
     */
    private function _makeSign($params) 
    {
        $q = "";
        if (NULL != $params) {
            ksort($params);
            if(isset($params['sign_mode'])&&1==$params['sign_mode']&&isset($params['items'])){
                unset($params['items']);
            }
            $q = http_build_query($params);
        }
        return md5($q.$this->clientSecret);
    }

    /**
     * 创建Nonce信息。
     *
     * @return string 返回Nonce信息。
     * @access private
     */
    private function _makeNonce() 
    {
        $time = time();
        $nonce = md5($this->clientId . $this->clientSecret . $time) . "." . $time;
        return $nonce;
    }

    /**
     * 将参数数组转换成http query字符串
     * 
     * @param array $params 参数数组
     * @return string query 字符串
     */
    public function buildParams($params) 
    {
        $args = http_build_query($params);
        // remove the php special encoding of parameters
        // see http://www.php.net/manual/en/function.http-build-query.php#78603
        return preg_replace('/%5B(?:[0-9]|[1-9][0-9]+)%5D=/', '=', $args);
    }
    

    /**
     * curl方式
     * 
     * @param string $method  POST 或者 GET
     * @param string $url 
     * @param array $params
     * @param array $http_options
     * @return string 
     */
    private function requestByCurl($method, $url, $params = array(), $http_options = array()) 
    {
        $args = $this->buildParams($params);
        $method = strtoupper($method);

        if ($method == self::METHOD_GET) {
            $url .= preg_match('/\?/i', $url) ? '&'.$args : '?'.$args;
            $args = '';
        }
        else
        {
            $method = self::METHOD_POST;
        }

        $options = array(

                CURLOPT_CONNECTTIMEOUT => $this->connectTimeout,

                CURLOPT_TIMEOUT => $this->timeout,
                // Specify HTTP method
                CURLOPT_CUSTOMREQUEST => $method,
                // The body of the POST
                CURLOPT_POSTFIELDS => $args,
                // Not to return headers
                CURLOPT_HEADER => false,
                // Return the response
                CURLOPT_RETURNTRANSFER => true,
                //Fixes the HTTP/1.1 417 Expectation Failed
                CURLOPT_HTTPHEADER => array('Expect:')
                );

        if(!empty($http_options)){
            $options = $options + $http_options;
        }
        $ci = curl_init($url);
        curl_setopt_array($ci, $options);
        $response =  curl_exec($ci);
        $this->httpInfo = curl_getinfo($ci);
        $this->httpCode = curl_getinfo($ci, CURLINFO_HTTP_CODE);
        curl_close($ci);

        $this->showDebugMessage($params,$response);
        return $response;
    }
    
    

    /**
     * socket 方式调用api
     * 
     * @param string $method POST GET方法
     * @param string $url api 请求地址
     * @param array $params 参数
     * @return string
     * @throws Exception 
     */
    public function requestBySocket($method, $url, $params = array()) 
    {
        $u = parse_url($url);
        $remote_server = $u["host"];
        $remote_path = $u["path"];
        $method = strtoupper($method);
        //$remote_server, $remote_path, $post_string, $port = 80, $timeout = 30
        $parse = self::parseHost($url);
        $data  = http_build_query($params);
        $content = self::buildRequestContent($parse, $method, $data);
        $socket = fsockopen($remote_server, $parse["port"], $errno, $errstr, $this->timeout);
        if (!$socket) {
            throw new Exception("connect socket fail");
        }

        fwrite($socket, $content);


        $response_text = '';

        //read from socket
        while ($data = fread($socket, self::SOCKET_READ_SIZE)) 
        {
            $response_text .= $data;
        }

        //close socket
        fclose($socket);
        $ret = self::parseResponse($response_text);  
        $this->httpCode = (int)$ret["info"]["http_code"];
        $this->httpInfo = $ret["info"];
        $this->showDebugMessage($params, $ret);
        return  $ret["result"];
    }

    /**
     * debug 信息
     */
    private function showDebugMessage($params, $response)
    {
        if(!$this->debug)
        {
            return;
        }

        if ($this->isCurl)
        {
            echo "===== CURL  ".$this->method." data ======"."\r\n";
            print_r( $params );
            echo "===== CURL ".$this->method." info ====="."\r\n";
            print_r($this->httpInfo);
            echo '===== CURL '.$this->method.' response ====='."\r\n";
            print_r( $response );
            echo '===end CURL '. $this->method .' debug ====='."\r\n";
        }
        else
        {
            echo "===== SOCKET  ".$this->method." data ======\r\n";
            print_r( $params );
            echo '=====SOCKET '. $this->method .' response ====='."\r\n";
            print_r( $response);
            echo '===end SOCKET '. $this->method .' debug ====='."\r\n";
        }
    }

    private static function parseHost($host) 
    {
        //parse host url
        $parse = parse_url($host);

        if (!$parse) {
            throw new Exception("host is empty");
        }

        if (!isset($parse['port']) || !$parse['port']) {
            $parse['port'] = '80';
        }

        $parse['host'] = str_replace(array('http://', 'https://'), array('', 'ssl://'), $parse['scheme'] . "://") . $parse['host'];
        $parse["path"] = isset($parse["path"]) ? $parse["path"] : '/';
        $query = isset($parse['query']) ? $parse['query'] : '';

        $path = str_replace(array('\\', '//'), '/', $parse['path']);
        $parse['path'] = $query ? $path . "?" . $query : $path;

        return $parse;
    }

    private static function buildRequestContent(&$parse, $method, $data) 
    {
        $content_length_str = '';
        $post_content = '';

        if ($method == self::METHOD_GET) {
            substr($data, 0, 1) == '&' && $data = substr($data, 1);
            $query = isset($parse['query']) ? $parse['query'] : '';
            $parse['path'] .= ($query ? '&' : '?') . $data; 
        } else{
            $method = self::METHOD_POST;
            $content_length_str = "infoContent-length: " . strlen($data) . "\r\n";
            $post_content = $data;
        }

        $write = $method . " " . $parse['path'] . " HTTP/1.0\r\n";
        $write .= "Host: " . $parse['host'] . "\r\n";
        //$write .= "Content-Type:text/html;charset=UTF8'";
        $write .= "Content-type: application/x-www-form-urlencoded\r\n";
        $write .= $content_length_str;
        //$write .= "Connection: Keep-Alive\r\n";
        $write .= "Connection: close\r\n\r\n";
        $write .= $post_content;

        return $write;
    }



    private static function parseResponse($response_text)
    {
        $http_header_str  = substr($response_text, 0, strpos($response_text, "\r\n\r\n"));
        $http_headers = self::parseHttpSocketHeader($http_header_str);
        $response_text = trim(stristr($response_text, "\r\n\r\n"), "\r\n");

        $ret = array();
        $ret["result"] = $response_text;
        $ret["info"]["http_code"]   = isset($http_headers["http_code"]) ? $http_headers["http_code"] : 0;
        $ret["info"]["headers"]  = $http_headers;

        return $ret;
    }

    private static function parseHttpSocketHeader($str)
    {
        $slice = explode("\r\n", $str);
        $headers = array();

        foreach ($slice as $v)
        {
            if (false !== strpos($v, "HTTP"))
            {
                $headers["http_code"] = self::parseHttpCodeFromSocketHeader($v);
                $headers["status"] = $v;
            }
            else
            {
                $header_slice = explode(":", $v);
                $headers[$header_slice[0]] = isset($header_slice[1]) ? $header_slice[1] : '';
            }
        }

        return $headers;
    }

    private static function parseHttpCodeFromSocketHeader($str)
    {
        $slice = explode(" ", $str);
        return $slice[1];
    }

    public function __destruct()
    {
    }

}//end class

?>
