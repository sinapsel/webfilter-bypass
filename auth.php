<?php
    require_once "db.php";
    require_once "route.php";
    

    session_start();
    if (isset($_POST['submit'])){
        $err = array();
        if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login'])){
            $err[] = "Incorrect login letters";
        }
        if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30){
            $err[] = "Incorrect login length";
        }
        foreach($err as $k => $i){
            echo $i.'</br>';
        }
        if(!isset($err)) exit();
        
        $login = htmlspecialchars($_POST['login']);
        $password = htmlspecialchars($_POST['password']);
        $DB = new db(array(
			"DB_SERVER"	=>	"localhost",
			"DB_USER"	=>	"root",
			"DB_PASS"	=>	"",
			"DB_NAME"	=>	"wfbp"
			));
        $DB->mysqlconnect();
        $authData = $DB->makeQuery("SELECT * FROM users WHERE
				login='$login' AND password='$password'", "ASSOC");
        if(!isset($authData['id'])){
            echo 'Inncorrect login';
            Route::Forbidden();
            die();
        }else{
            $_SESSION['id'] = $authData['id'];
            header("Location: /");
        }
            
    }
    if(isset($_POST['logout'])){
        unset($_SESSION);
        session_destroy();
        header("Location: /");
    }

?>
