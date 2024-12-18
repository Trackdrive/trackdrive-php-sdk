<?php
	require_once 'caller.php';
	/**
	 ** API Class
	 **/
	Class TrackDrive_API Extends Caller{
		private $user  = '';
		private $token = '';
		private $errors = array();
		private $types = array('billings','buyers','buyer_groups','calls','contacts','offers','phone_numbers','traffic_sources','teams','page_views');
		private $base_url   = 'https://_username_.trackdrive.com/api/v1/';

		public function __construct($u = NULL,$t = NULL){
			if(!$u || !$t){
				throw new Exception('Missing user/token to establish connection.');
			}else{
				$this->user = $u;
				$this->token = $t;
				$this->base_url = str_ireplace("_username_",$this->user,$this->base_url);
			}
		}

		public function view($type,$id = NULL,$params = array()){
			$this->errors = array();
			if($this->checkType($type)){
				$url = $this->base_url.$type.( $id != NULL ? '/'.$id :'')."?auth_token=".$this->token;
				if(sizeof($params)){
					foreach($params as $p=>$a){
						foreach($a as $h=>$v){
							$url .= "&".$h."=".$v;
						}
					}
				}
				return parent::get($url);
			}else{
				$this->errors[] = array("status"=>422,"errors"=>array("invalid_resource"=>"Unable to find resource named '".$type."'. Available resources : 'billings','buyers','buyer_groups','calls','contacts','offers','phone_numbers','traffic_sources','teams','page_views'."));				
				return $this->errors;
			}
		}

		public function add($type,$data = array()){
			$this->errors = array();
			if($this->checkType($type)){
				$url = $this->base_url.$type."?auth_token=".$this->token;
				return parent::post($url,$data);
			}else{
				$this->errors[] = array("status"=>422,"errors"=>array("invalid_resource"=>"Unable to add '".$type."'"));
				return $this->errors;
			}
		}

		public function edit($type,$id,$data = array()){
			$this->errors = array();
			if($this->checkType($type) && isset($id)){
				$url = $this->base_url.$type.'/'.$id.'?auth_token='.$this->token;
				return parent::put($url,$data);
			}else{
				$this->errors[] = array("status"=>422,"errors"=>array("invalid_resource"=>"Unable to edit '".$type."' with ID# ".$id));
				return $this->errors;
			}
		}

		public function remove($type,$id = NULL){
			$this->errors = array();
			if($this->checkType($type) && isset($id)){
				$url = $this->base_url.$type.'/'.$id.'?auth_token='.$this->token;
				return parent::delete($url);
			}else{
				$this->errors[] = array("status"=>422,"errors"=>array("invalid_resource"=>"Unable to delete '".$type."' with ID# ".$id));
				return $this->errors;
			}
		}

		public function checkType($t){
			return (is_string($t) && strlen($t) > 0 && array_search($t, $this->types) >= 0 ? true : false);
		}

		public function getError(){
			return $this->errors;
		}	

	}
?>