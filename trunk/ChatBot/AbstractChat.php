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

/*
*    Copyright 2012 Andrey Khomchenko

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.

*
*/