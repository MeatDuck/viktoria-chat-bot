<?php

class AnswerMapper {
	private $storage = null;
	private $phrase = null;
	private $output = "";
	private $last_phrase = "";
	
	//load data
	/**
	 * @param Memcache $storage
	 */
	public function __construct($storage){
		$this->storage = $storage;
		$c = $this->storage->get("data_cached");
		if(is_null($c) ||  $c + 60*60*6 < time()){
			$this->storage->set("data_cached", time());
			$my_folder = dirname( realpath( __FILE__ ) ) . DIRECTORY_SEPARATOR."data".DIRECTORY_SEPARATOR;
			$this->load_file($my_folder."VariantLoadTab.xml", "VariantLoadTab_");
			$this->load_file_without_keys($my_folder."EmptyQuestionLoadTab.xml", "EmptyQuestionLoadTab");
			$this->load_file_with_keys($my_folder."SearchLoadTab.xml", "SearchLoadTab_");
			$this->load_file_with_keys($my_folder."SearchResLoadTab.xml", "SearchResLoadTab_");
			$this->load_file_without_keys($my_folder."LoadTab.xml", "LoadTab");
			$this->load_file_with_keys($my_folder."SituationLoadTab.xml", "SituationLoadTab_");
		}
		
	}
	
	public function say($phrase){
		$this->phrase = $phrase;
		
		$p = $this->storage->get("bot_last_phrase");
		if(!is_null($p)){
			$this->last_phrase = $p;
		}
		return $this;
	}

	public function EmptyQuestionLoad(){
		if($this->output == ""){			
			if(preg_match("/\?$/i", $this->phrase)){
				$ret = $this->storage->get("EmptyQuestionLoadTab");
				if(!is_null($ret)){
					$size = count($ret);
					$i = rand(0, $size-1);
					$this->output = $ret[$i];
				}	
			}		
		}
		return $this;
	}

	public function VariantLoad() {
		if($this->output == ""){
			$ret = $this->storage->get("VariantLoadTab_".$this->phrase);
			if(!is_null($ret)){
				$size = count($ret);
				$i = rand(0, $size-1);
				$this->output = $ret[$i];
			}			
		}
		return $this;
	}
	
	public function SituationLoad(){
		if($this->output == ""){
			if(preg_match("|\(\(|i", $this->phrase)){
				$ret = $this->storage->get("SituationLoadTab_((");
				if(!is_null($ret)){
					$size = count($ret);
					$i = rand(0, $size-1);
					$this->output = $ret[$i];
					return $this;
				}
			}
		}
		if($this->output == ""){
			if(preg_match("|!!!|i", $this->phrase)){
				$ret = $this->storage->get("SituationLoadTab_!!!");
				if(!is_null($ret)){
					$size = count($ret);
					$i = rand(0, $size-1);
					$this->output = $ret[$i];
					return $this;
				}
			}
		}
		if($this->output == ""){
			if(preg_match("|!!|i", $this->phrase)){
				$ret = $this->storage->get("SituationLoadTab_!!");
				if(!is_null($ret)){
					$size = count($ret);
					$i = rand(0, $size-1);
					$this->output = $ret[$i];
					return $this;
				}
			}
		}
		if($this->output == ""){
			if(preg_match("|\?\?\?|i", $this->phrase)){
				$ret = $this->storage->get("SituationLoadTab_???");
				if(!is_null($ret)){
					$size = count($ret);
					$i = rand(0, $size-1);
					$this->output = $ret[$i];
					return $this;
				}
			}
		}
		if($this->output == ""){
			if(preg_match("|100.+?%|i", $this->phrase)){
				$ret = $this->storage->get("SituationLoadTab_100%");
				if(!is_null($ret)){
					$size = count($ret);
					$i = rand(0, $size-1);
					$this->output = $ret[$i];
					return $this;
				}
			}
		}
		if($this->output == ""){
			if($this->phrase == $this->last_phrase  && $this->last_phrase != ""){
				$ret = $this->storage->get("SituationLoadTab_repeat");
				if(!is_null($ret)){
					$size = count($ret);
					$i = rand(0, $size-1);
					$this->output = $ret[$i];
					return $this;
				}
			}
		}
		if($this->output == ""){
			if(preg_match("|^\.+$|", $this->phrase)){
				$ret = $this->storage->get("SituationLoadTab_.");
				if(!is_null($ret)){
					$size = count($ret);
					$i = rand(0, $size-1);
					$this->output = $ret[$i];
					return $this;
				}
			}
		}
		if($this->output == ""){
			if(preg_match("!(http|www)!i", $this->phrase)){
				$ret = $this->storage->get("SituationLoadTab_www");
				if(!is_null($ret)){
					$size = count($ret);
					$i = rand(0, $size-1);
					$this->output = $ret[$i];
					return $this;
				}
			}
		}
		if($this->output == ""){
			if(preg_match("!\)!i", $this->phrase)){
				$ret = $this->storage->get("SituationLoadTab_)");
				if(!is_null($ret)){
					$size = count($ret);
					$i = rand(0, $size-1);
					$this->output = $ret[$i];
					return $this;
				}
			}
		}
		if($this->output == ""){
			if(preg_match("!\(!i", $this->phrase)){
				$ret = $this->storage->get("SituationLoadTab_(");
				if(!is_null($ret)){
					$size = count($ret);
					$i = rand(0, $size-1);
					$this->output = $ret[$i];
					return $this;
				}
			}
		}
		if($this->output == ""){
			if(mb_strlen($this->phrase, "UTF-8") > 200){
				$ret = $this->storage->get("SituationLoadTab_long");
				if(!is_null($ret)){
					$size = count($ret);
					$i = rand(0, $size-1);
					$this->output = $ret[$i];
					return $this;
				}
			}
		}
		if($this->output == ""){
			if(mb_strlen($this->phrase, "UTF-8") < 4){
				$ret = $this->storage->get("SituationLoadTab_short");
				if(!is_null($ret)){
					$size = count($ret);
					$i = rand(0, $size-1);
					$this->output = $ret[$i];
					return $this;
				}
			}
		}
		return $this;
	}
	
	public function SearchLoadTab(){
		if($this->output == ""){
			$keys = $this->storage->get("SearchLoadTab_keys");
			foreach ($keys as $key) {
				if(strpos($this->phrase, mb_strtolower($key, "UTF-8")) !== FALSE){
					$ret = $this->storage->get("SearchLoadTab_".$key);
					if(!is_null($ret)){
						$size = count($ret);
						$i = rand(0, $size-1);
						$this->output = $ret[$i];
					}
				}
			}
		}
		return $this;
	}
	
	public function SearchResLoad(){
		if($this->last_phrase == "" || $this->output != ""){
			return $this;
		}else{
			$keys = $this->storage->get("SearchResLoadTab_keys");
			foreach ($keys as $key) {
				if(strpos($this->last_phrase, mb_strtolower($key, "UTF-8")) !== FALSE){
					$ret = $this->storage->get("SearchResLoadTab_".$key);

					if(!is_null($ret)){
						$size = count($ret);
						$i = rand(0, $size-1);
						$this->output = $ret[$i];
					}
				}
			}
		}

		return $this;
	}
	
	public function Load(){
		if($this->output == ""){
				$ret = $this->storage->get("LoadTab");
				if(!is_null($ret)){
					$size = count($ret);
					$i = rand(0, $size-1);
					$this->output = $ret[$i];
				}	
		}
		return $this;
	}
	
	public function __toString(){
		return $this->output;
	}
	
	private function load_file($file, $prefix){
		$data = file_get_contents($file);
		$obj = new SimpleXMLElement($data);
		foreach ($obj->m as $value) {
			$ms = $value->ms;
			$t = $value->t;
			foreach ($ms as $ms_value) {
				$arr = array();
				foreach ($t as $t_value) {
					$arr[] = (string)$t_value;
				}
				$this->storage->set($prefix.$ms_value, $arr);
			}
		}
	}
	
	private function load_file_without_keys($file, $prefix){
		$data = file_get_contents($file);
		$obj = new SimpleXMLElement($data);
		$arr = array();
		foreach ($obj->m as $value) {
			$t = $value->t;			
			foreach ($t as $t_value) {
				$arr[] = (string)$t_value;
			}			
		}
		$this->storage->set($prefix, $arr);
	}
	
	private function load_file_with_keys($file, $prefix){
		$data = file_get_contents($file);
		$obj = new SimpleXMLElement($data);
		$keys = array();
		foreach ($obj->m as $value) {
			$ms = $value->ms;
			$t = $value->t;
			foreach ($ms as $ms_value) {
				$arr = array();
				$ms_value = (string) $ms_value;
				foreach ($t as $t_value) {
					$arr[] = (string)$t_value;
				}
				$this->storage->set($prefix.$ms_value, $arr);
				$keys[$ms_value] = '';
			}
		}
		$this->storage->set($prefix."keys", array_keys($keys));
	}
	
	public function __destruct(){
		$this->storage->set("bot_last_phrase", $this->output);
	}
}