<?php

	require_once "route.php";
	require_once "db.php";
	//$CONNECTTYPE = array();
	function connectsite(&$url){
		if(strpos($url,"http")===False) $url = "http://".$url;
		//return file_get_contents($url); ###USE IT IF CURL IS FORBIDDEN
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Intel Mac OS X; rv:54.0) Gecko/204123 Netscape/102.0");
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch);
		$GLOBALS['CONNECTTYPE'] = explode(';',curl_getinfo($ch, CURLINFO_CONTENT_TYPE));
		var_dump($GLOBALS['CONNECTTYPE']);
		if(isset($GLOBALS['CONNECTTYPE'][1]))
			$GLOBALS['CONNECTTYPE'][1] = substr($GLOBALS['CONNECTTYPE'][1],strpos($GLOBALS['CONNECTTYPE'][1],'=')+1);
		curl_close($ch);
		return $data;
	}
	function absAddressation(&$data){
		$urlA = $GLOBALS['url'];
		$regExpPattern = array('~href\s*=\s*\"s*http:\/\/~','~src\s*=\s*\"s*http:\/\/~',
							'~href\s*=\s*\"\s*(?!http:\/\/|https:\/\/|\/)~'
							,'~src\s*=\s*\"\s*(?!http:\/\/|https:\/\/|\/)~',
							'~href\s*=\s*\"\/~', '~src\s*=\s*\"\/~'
							);
							
		$murl = implode("/",array_slice(explode("/",$urlA),2,1));
							
		if(strpos($data, '<base href="')){
			$base = substr($data, strpos($data, '<base href=')+strlen('<base href=')+1,
			 strpos($data, '"', strpos($data, '<base href='))-strpos($data, '<base href=')+strlen('<base href="')-2
					);
			$comprRepl = array('href="http://'.$_SERVER['HTTP_HOST'].'/?u='.$base,'src="http://'.$_SERVER['HTTP_HOST'].'/?u='.$base,
						'href="http://'.$_SERVER['HTTP_HOST'].'/?u='.$murl.'/','src="http://'.$_SERVER['HTTP_HOST'].'/?u='.$murl.'/',
						'href="http://'.$_SERVER['HTTP_HOST'].'/?u=','src="http://'.$_SERVER['HTTP_HOST'].'/?u=');
		}else
			$comprRepl = array('href="http://'.$_SERVER['HTTP_HOST'].'/?u=','src="http://'.$_SERVER['HTTP_HOST'].'/?u=',
						'href="http://'.$_SERVER['HTTP_HOST'].'/?u='.$urlA,'src="http://'.$_SERVER['HTTP_HOST'].'/?u='.$urlA,
						'href="http://'.$_SERVER['HTTP_HOST'].'/?u='.$murl.'/','src="http://'.$_SERVER['HTTP_HOST'].'/?u='.$murl.'/'
						);
		$data = preg_replace($regExpPattern, $comprRepl, $data);
	}
	function remainder(){
		if(isset($_SESSION['id'])){
			$DB = new db(array(
			"DB_SERVER"	=>	"localhost",
			"DB_USER"	=>	"root",
			"DB_PASS"	=>	"",
			"DB_NAME"	=>	"wfbp"
			));
			$DB->mysqlconnect();
			$authData = $DB->makeQuery("SELECT used, datalimit FROM users WHERE
				id=".$_SESSION['id']."", "ASSOC");
			return ''.$authData['used'].'/'.$authData['datalimit'];
		}
	}
	
	session_start();
	header('Content-Type: text/html; charset=utf-8');
	if(!isset($_SESSION['id'])){
		Route::NeedLogin();
		exit();
	}
	$CONNECTTYPE = array();
	$page = '';
	$r = new Route($_SERVER['REQUEST_URI'], 'app/', '.php');
	//echo $r->getUri();
	$r->appendToLoadArray("head");
	$r->appendToLoadArray("search_pan");
	if($_SERVER['REQUEST_URI'] == "/profile")
		$r->appendToLoadArray("profile");
	else
		$r->appendToLoadArray("browser");
	$r->appendToLoadArray("foot");
	$r->compose_webpage();
	
	

?>
