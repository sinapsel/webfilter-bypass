<div style="border: 2px ridge blue; padding: 10px; top: 20%">
<?php 
$data = $GLOBALS['page'];
$CONNECTTYPE = $GLOBALS['CONNECTTYPE'];

if($CONNECTTYPE[0] == "text/html" or $CONNECTTYPE[0] == "text/php"){//веб-страница
			//delBlacksHTML($data);
			absAddressation($data);
if(isset($CONNECTTYPE[1])){
			header("Content-Type: text/html; charset=".$CONNECTTYPE[1]);
			$data = gzencode('<meta charset="'.$CONNECTTYPE[1].'">'.$data, 9);
			header("Content-Encoding: gzip");
			header("Vary: Accept-Encoding");
			header("Content-Length: " . strlen($data));
			
			$GLOBALS['page'] .= $data;
		}else{
			header("Content-Type: text/html; charset=UTF-8");
			
			$data = gzencode('<meta charset="utf-8">'.$data, 9);
			header("Content-Encoding: gzip");
			header("Vary: Accept-Encoding");
			header("Content-Length: " . strlen($data));
			$GLOBALS['page'] .= $data;
		}

	}else if($CONNECTTYPE[0] == "text/css"){//стиль
					header("Content-Type: text/css; charset=");

		$data = gzencode($data, 9);
		header("Content-Type: text/css");
		header("Content-Encoding: gzip");
		header("Vary: Accept-Encoding");
		header("Content-Length: " . strlen($data));
		$GLOBALS['page'] .= $data;
	}else if(strpos($CONNECTTYPE[0],"image") !== false){//изображение
		header("Content-Type: ".$CONNECTTYPE[0]);
		$GLOBALS['page'] .= $data;
	}
	else{//иной тип данных
		header("Content-Type: ".$CONNECTTYPE[0]);
		$GLOBALS['page'] .= $data;
	}

echo $GLOBALS['page'];
?>
</div>
