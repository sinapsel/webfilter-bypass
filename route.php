<?php
class Route{
    public function __construct($uri, $appfolder, $ext){
			$this->appdir = $appfolder;
			$this->ext = $ext;
			$this->setUri(explode("?",$uri)[0]);
			$this->setUri(explode("?",$uri)[0]);
    }	
    public $loadArray = array();
    private $uri;
    public function setLoadArray($arr){
        $loadArray = $arr;
    }
    public function appendToLoadArray($elem){
        $this->loadArray[] = $elem;
    }
    
    public function setUri($uri){
        $this->uri = $uri;
    }
    public function getUri(){
        return $this->uri;
    }
    public function compose_webpage(){
        $this->loadArray = array_unique($this->loadArray);
            foreach($this->loadArray as $a){
				require $this->appdir.$a.$this->ext;
			}
    }
    
    public static function NotFound(){//Загрузка 404 ошибки
        header('HTTP/1.0 404 Not Found');
        header('HTTP/1.1 404 Not Found');
        header('Status: 404 Not Found');
        require_once "err/404.html";
        exit();
    }
    public static function Forbidden(){//Загрузка 403 ошибки
        header('HTTP/1.0 403 Forbidden');
        header('HTTP/1.1 403 Forbidden');
        header('Status: 403 Forbidden');
        require_once "err/403.html";
        exit();
    }
    public static function NeedLogin(){//Загрузка входа
        require_once "login.html";
        exit();
    }
}

?>
