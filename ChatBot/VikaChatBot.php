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



