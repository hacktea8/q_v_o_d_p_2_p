<?php
class tietusdk{
	private $accesskey;
	private $secretkey;
	private $base64param;
	function __construct($ak,$sk){
		if($ak == ''||$sk =='')
			return false;
		$this->accesskey = $ak;
		$this->secretkey = $sk;
	}
	public function Dealparam($param){
		$this->base64param = $this->Base64(json_encode($param));
		return $this;
	}
	public function Token(){
		$sign = $this->Sign($this->base64param,$this->secretkey);
		$token = $this->accesskey.':'.$sign.':'.$this->base64param;
		return $token;
	}
	public function Sign($str, $key){
		$hmac_sha1_str = "";
		if (function_exists('hash_hmac')){
			$hmac_sha1_str = $this->Base64(hash_hmac("sha1", $str, $key, true));
		} else {
			$blocksize = 64;
			$hashfunc  = 'sha1';
			if (strlen($key) > $blocksize){
				$key = pack('H*', $hashfunc($key));
			}
			$key       		= str_pad($key, $blocksize, chr(0x00));
			$ipad      		= str_repeat(chr(0x36), $blocksize);
			$opad      		= str_repeat(chr(0x5c), $blocksize);
			$hmac      		= pack('H*', $hashfunc(($key ^ $opad) . pack('H*', $hashfunc(($key ^ $ipad) . $str))));
			$hmac_sha1_str	= $this->Base64($hmac);
		}
		return $hmac_sha1_str;
	}
	//对url安全的base64编码 URLSafeBase64Encode
	public function Base64($str){
		$find = array('+', '/');
		$replace = array('-', '_');
		return str_replace($find, $replace, base64_encode($str));
	}
}