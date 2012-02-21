<?php
include_once 'ChatBot.php';

error_reporting(E_ALL);
ini_set('display_errors','On');

ChatBot::getInstance()->setupUI();
if(ChatBot::getInstance()->isEnabled()){
	echo 'listen:' . ChatBot::getInstance()->say("listen");
	echo 'угу 	:'.ChatBot::getInstance()->say("угу 	");
	echo 'Ты кто?:' . ChatBot::getInstance()->say("Ты кто?");
	echo 'Ты кто? 	:'.ChatBot::getInstance()->say("Ты кто? 	");
	echo 'я работаю в майкрософт 	:'.ChatBot::getInstance()->say("я работаю в майкрософт 	");
	echo 'повтори:'.ChatBot::getInstance()->say("повтори");
	echo 'бредор:'.ChatBot::getInstance()->say("бредор");
	echo '100 %???:'.ChatBot::getInstance()->say("100 %???");
	echo ')):'.ChatBot::getInstance()->say("))");
	echo '123:'.ChatBot::getInstance()->say("123");
	echo '):'.ChatBot::getInstance()->say(")");
}