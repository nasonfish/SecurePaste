<?php

include_once('encryption.php');

class Handler {

    public $languages = array(
        'c'=>'C', 'shell'=>'Shell', 'java'=>'Java', 'd'=>'D',
        'coffeescript'=>'CoffeeScript', 'generic'=>'Generic',
        'scheme'=>'Scheme', 'javascript'=>'JavaScript',
        'r'=>'R', 'haskell'=>'haskell', 'python'=>'Python', 'html'=>'HTML',
        'smalltalk'=>'SmallTalk', 'csharp'=>'C#', 'go'=>'Go', 'php'=>'PHP',
        'ruby'=>'Ruby', 'lua'=>'Lua', 'css'=>'CSS', 'terminal'=>'Terminal',
        'none'=>'Text'
    );

    public $predis;

    function __construct(){
        require 'Predis/Autoloader.php';
        Predis\Autoloader::register();
        $predis = new Predis\Client(array('port'=>6383));
        $this->predis = $predis;
    }

    public function getLanguages_html(){
        $ret = '';
        foreach($this->languages as $val => $language){
            $ret .= '<option value="'.$val.'">' . $language . '</option>';
        }
        return $ret;
    }

    public function generateHash(){
        for($i = 0; $i < 20; $i++){
            $random = substr(md5(rand()), 0, 7);
            $cmd = new Predis\Command\KeyExists;
            $cmd->setRawArguments(array('paste:' . $random));
            if($this->predis->executeCommand($cmd)){
                continue;
            }
            return $random;
        }
        return time(); // this should never match itself
    }

    public function generateKey(){
        return md5(rand());
    }

    public function save($syntax, $text){
        $hash = $this->generateHash();
        $key = $this->generateKey();
        $iv = mcrypt_create_iv(8);
        $save = new Predis\Command\StringSet;
        $save->setRawArguments(array('paste:' . $hash, encrypt(base64_encode($key), $text, $iv)));
        $this->predis->executeCommand($save);
        $save->setRawArguments(array('paste:' . $hash . ':syntax', $syntax));
        $this->predis->executeCommand($save);
        return $hash .'/'.base64_encode($key.'/'.base64_encode($iv));
    }

    public function get($hash, $keys){
        $keys = base64_decode($keys);
        $keys = explode('/', $keys);
        $key = $keys[0];
        $iv = base64_decode($keys[1]);
        $ret = array(
            'text'=>htmlspecialchars($this->getText($hash, $key, $iv)),
            'syntax'=>$this->getSyntax($hash)
        );
        return $ret;
    }

    public function getText($hash, $key, $iv){
        $get = new Predis\Command\StringGet;
        $get->setRawArguments(array('paste:' . $hash));
        $text = $this->predis->executeCommand($get);
        return decrypt(base64_encode($key), $text, $iv);
    }

    public function getSyntax($hash){
        $get = new Predis\Command\StringGet;
        $get->setRawArguments(array('paste:' . $hash . ':syntax'));
        return $this->predis->executeCommand($get);
    }
}
