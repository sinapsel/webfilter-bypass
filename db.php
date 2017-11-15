<?
class db{
		
		private $dbConnectionData;
		private $sql;

		public function __construct($dbdata){
			foreach($dbdata as $dbrecord => $dbvalue){
				define($dbrecord, $dbvalue);
				//$this->dbConnectionData[$dbrecord] = $dbvalue;
			}
		}
		public function mysqlconnect(){
			$this->sql = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
			$this->sql->connect_errno ? die("err"): 1==1;
			$this->sql->query("SET character_set_results = 'utf8',
								character_set_client = 'utf8',
								character_set_connection = 'utf8',
								character_set_database = 'utf8',
								character_set_server = 'utf8'");
		}
		public function makeQuery($query, $TYPE="ASSOC", $N=1){
			$a = array();
			$res = $this->sql->query($query);
			if($res && !is_bool($res) && $N==1){
				switch ($TYPE){
					case "JSON":
						while($row = $res->fetch_assoc()) $a = $row;
						$a = json_encode($a);
						break;
					case "OBJECT":
						while($row = $res->fetch_object())$a = $row;
						break;
					default://ASSOC
						while($row = $res->fetch_assoc()) $a = $row;
						break;
				}
			} else{
				 return $this->sql->error;
			 }
			return $a;
		}
	}
?>
