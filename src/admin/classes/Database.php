<?php
require_once(__DIR__ . '/../../includes/config.php');

class Database
{
	private $con;
	public function connect(){
		$this->con = new Mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ($this->con->connect_error) {
			die('Admin DB connection failed: ' . $this->con->connect_error);
		}
		$this->con->set_charset('utf8mb4');
		return $this->con;
	}
}
?>