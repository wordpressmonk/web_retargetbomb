<?php 
class Database{
    private $host      = servername;
    private $user      = username;
    private $pass      = password;
    private $dbname    = database;
 
    private $dbh;
    private $error;
	
	private $stmt;	
 
    public function __construct(){
        // Set DSN
	$dsn = 'pgsql:host=' . $this->host . ';port='.alport.';dbname=' . $this->dbname;        
        // Set options
        $options = array(
            PDO::ATTR_PERSISTENT    => true,
            PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
        );
        // Create a new PDO instanace
        try{
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        }
        // Catch any errors
        catch(PDOException $e){
            $this->error = $e->getMessage();
        }
    }
	//query start	
	public function query($query){
		$this->stmt = $this->dbh->prepare($query);
	}
	//query end
	//bind start
	public function bind($param, $value, $type = null){
		if (is_null($type)) {
			switch (true) {
				case is_int($value):
					$type = PDO::PARAM_INT;
					break;
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
					break;
				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;
				default:
					$type = PDO::PARAM_STR;
			}
		}
		$this->stmt->bindValue($param, $value, $type);
	}	
	//bind start	
	//execute start 
	public function execute(){
		return $this->stmt->execute();
	}	
	//execute end
	//count
	public function resultCount(){
		$this->execute();
		return count($this->stmt->fetchAll(PDO::FETCH_ASSOC));		
	}
	//resultset start 
	public function resultset(){
		$this->execute();
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}	
	//result set end
	//single records start 
	public function single(){
		$this->execute();
		return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}	
	//single records end
	//rowCount start 
	public function rowCount(){
		return $this->stmt->rowCount();
	}	
	//rowCount end	
	//lastInsertId start 
	public function lastInsertId(){
		return $this->dbh->lastInsertId();
	}	
	//lastInsertId end
	public function beginTransaction(){
		return $this->dbh->beginTransaction();
	}
	public function endTransaction(){
		return $this->dbh->commit();
	}
	public function cancelTransaction(){
		return $this->dbh->rollBack();
	}	
	public function debugDumpParams(){
		return $this->stmt->debugDumpParams();
	}	
}
?>
