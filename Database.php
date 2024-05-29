<?php 

class Database
{
	private $host = "localhost";
	private $user = "root";
	private $pass = "123456";
	private $db = "exam";
	public $link;
	public function __construct()
	{
		try
		{
			$this->link = new PDO("mysql:host=".$this->host.";dbname=".$this->db."",$this->user, $this->pass);
			$this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $this->link;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}

	}
}
