<?php 
class DbRepository
{
	protected $con;
	
	public function __construct($con) {
		$this->con = $con;
	}
	
	public function setConnection($con)
	{
		$this->con = $con;
	}
	
	public function execute($sql,$param = array())
	{
		$stmt = $this->con->prepare($sql);
		$stmt->execute($param);
		
		return $stmt;
	}
	
	public function fetch($sql,$param=array())
	{
		return $this->execute($sql,$param)->fetch(PDO::FETCH_ASSOC);
	}
	
	public function fetchAll($sql,$param=array())
	{
		return $this->execute($sql,$param)->fetchAll(PDO::FETCH_ASSOC);
	}
}

?>