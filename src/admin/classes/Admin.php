<?php
class Admin
{
	private $con;

	function __construct()
	{
		include_once("Database.php");
		$db = new Database();
		$this->con = $db->connect();
	}

	public function getAdminList(){
		$query = $this->con->prepare("SELECT `id`, `name`, `email` FROM `admin` WHERE 1");
		$query->execute();
		$result = $query->get_result();
		$ar = [];
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$ar[] = $row;
			}
			return ['status'=> 202, 'message'=> $ar];
		}
		return ['status'=> 303, 'message'=> 'No Admin'];
	}
}
if (isset($_POST['GET_ADMIN'])) {
	$a = new Admin();
	echo json_encode($a->getAdminList());
	exit();
}

?>