<?php

include_once 'AnswerMapper.php';
class AbstractChat{
	public function say($s){
		return $this->normalaze($s);
	}
	
	private function normalaze($string){
		$string = preg_replace("/\s+/", " ", $string);
		$string = trim($string);
		$string = mb_strtolower($string, "UTF-8", "Windows-1251");
		return $string;
	}
}