<?php
	/**
	 ** Generic REST Class - API agnostic
	 **/
	Class Caller{
		public static function call($url, $mode, $data = array()) {
			$cUrl = curl_init();
			if($mode == 'GET'){
				
			}elseif($mode == 'POST'){
				curl_setopt($cUrl, CURLOPT_POSTFIELDS, json_encode($data));
				curl_setopt($cUrl, CURLOPT_POST, TRUE);
			}elseif($mode != 'PUT' && $mode != 'DELETE'){
				curl_setopt($cUrl, CURLOPT_POSTFIELDS, json_encode($data));
				curl_setopt($cUrl, CURLOPT_CUSTOMREQUEST, strtoupper($mode));        
			}
			curl_setopt($cUrl, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($cUrl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json')); 
			curl_setopt($cUrl, CURLOPT_HEADER, TRUE);
			curl_setopt($cUrl, CURLOPT_SSL_VERIFYPEER, TRUE);
			curl_setopt($cUrl, CURLOPT_URL, $url);
			$result = curl_exec($cUrl);
			$cInfo = curl_getinfo($cUrl);
			curl_close($cUrl);
			return array('status' => $cInfo['http_code'], 'header' => trim(substr($result, 0, $cInfo['header_size'])), 'data' => json_decode(substr($result, $cInfo['header_size'])));
		}

		public static function get($url) {
			return Caller::call($url,"GET");
		}
		public static function post($url, $data = array()) {
			return Caller::call($url,"POST",$data);
		}
		public static function put($url, $data = array()) {
			return Caller::call($url,"PUT",$data);
		}
		public static function delete($url, $data = array()) {
			return Caller::call($url,"DELETE",$data);
		}
	}
?>