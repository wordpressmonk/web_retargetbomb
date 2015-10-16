<?php 
//class for groups
class targetClass {
	
	static public function addIpCount($params){
		
		$connectionurl = "host=".servername." port=".alport." dbname=".database." user=".username." password=".password."";
		$dbconn3 = pg_pconnect($connectionurl);
		if (!$dbconn3) {
		die("Error in connection: " . pg_last_error());
		}
		$userId = $params['userId'];
		$skey = $params['skey'];
		$sval = $params['sval'];
		$sqlCheck = "SELECT * FROM retarget_settings WHERE userId = '$userId' AND skey = '$skey'";	
		$resultCheck = pg_query($dbconn3,$sqlCheck);
		$arr = pg_fetch_all($resultCheck);		
		if(empty($arr[0]['id'])){
			//insert
			$sqlInsert = "INSERT INTO retarget_settings (userId,skey,sval) VALUES ('$userId','$skey','$sval');";			
			pg_query($dbconn3,$sqlInsert);
			$sqlupdate = "UPDATE retarget_settings SET sval = '$sval' WHERE userId = '$userId' AND skey = 'ip'";			
			pg_query($dbconn3,$sqlupdate);			
		} else {
			//update
			//echo $sqlupdate = "UPDATE retarget_settings SET sval = '$sval' WHERE userId = '$userId' AND skey = '$skey'";			
			//pg_query($dbconn3,$sqlupdate);
		}
		
	}
	static public function checkIpUniqueCount($params){
		$database = new Database();	
		$sqlCheck = "SELECT * FROM retarget_settings WHERE  skey = :skey AND userId = :userId";
		$database->query($sqlCheck);
		$database->bind(':skey', $params['skey']);
		$database->bind(':userId', $params['userId']);		
		$count = $database->resultCount();
		$rows = $database->single();	
		return 	$rows;
	}	
	static public function addHitCount($params){				
		$database = new Database();	
		$sqlCheck = "SELECT * FROM retarget_settings WHERE userId = :userId AND skey=:skey";
		$database->query($sqlCheck);
		$database->bind(':userId', $params['userId']);	
		$database->bind(':skey', 'hits');			
		$count = $database->resultCount();
		$rows = $database->single();	
		if(empty($rows)){ 
			$sqlInsert = "INSERT INTO retarget_settings (userId,skey,sval) VALUES (:userId,:skey,:sval);";
			$database->query($sqlInsert);
			$database->bind(':userId', $params['userId']);
			$database->bind(':skey', 'hits');					
			$database->bind(':sval', $params['sval']);																
			$database->execute();			
		} else {			
			$sqlCheck = "UPDATE retarget_settings SET sval = :sval WHERE userId =:userId";
			$database->query($sqlCheck);
			$database->bind(':userId', $params['userId']);	
			$database->bind(':sval', $params['sval']);	
			$database->execute();			
		}				
	}
	
}
?>
