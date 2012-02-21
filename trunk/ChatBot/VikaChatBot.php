<?php
/**
 * Settings
 */

include_once 'AbstractChat.php';
class VikaChatBot extends AbstractChat {
    /**
     * @var Memcache
     */
    private $cache;
    /**
     * @var VikaChatBot
     */
    private static $instance = null;

    private function VikaChatBot(){
        $this->cache = new Memcache();
        $this->cache->connect("127.0.0.1", "11211");
    }

    /**
     * @return VikaChatBot
     */
    public static function getInstance(){
        if(self::$instance == null)
                self::$instance = new VikaChatBot();
        return self::$instance;
    }

    /**
     * @return Boolean
     */
    public function isEnabled(){
        if($this->cache == null)
        return false;
        if($this->cache->get("isChatBot") === null){
        	$this->cache->set("isChatBot", false);
        }
        if($this->cache->get("isChatBot") === true){
        	return TRUE;
        }
        
        return FALSE;
    }
 
    public function setupUI(){
        $this->cache->set("isChatBot", true);
    }
    
    public function offUI(){
        $this->cache->set("isChatBot", false);
    }
    
    public function say($sentence){
    	$sentence = parent::say($sentence);
    	$mapper = new AnswerMapper($this->cache);
    	$sentence = $mapper->say($sentence)
    					   ->VariantLoad()
    					   ->SituationLoad()
    	                   ->SearchLoadTab()
    					   ->SearchResLoad()
    					   ->EmptyQuestionLoad()    	                   
    					   ->Load();
    	return mb_convert_encoding($sentence, "Windows-1251");
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

