<?php 
session_start();

class profile
{
	private $con;

	function __construct()
	{
		include_once("Database.php");
		$db = new Database();
		$this->con = $db->connect();
	}

	public function getprofile(){
		$name=$_SESSION['admin_name'];
		$stmt = $this->con->prepare("SELECT id, name, email FROM admin WHERE 1 AND admin.name=?");
		$stmt->bind_param("s", $name);
		$stmt->execute();
		$query = $stmt->get_result();
		$ar = [];
		if (@$query->num_rows > 0) {
			while ($row = $query->fetch_assoc()) {
				$ar[] = $row;
			}
			return ['status'=> 202, 'message'=> $ar];
		}
		return ['status'=> 303, 'message'=> 'no admin data'];
	}	
	
	public function deleteprofile($id){
		if ($id != null) {
			$q_stmt = $this->con->prepare("DELETE FROM admin WHERE id=?");
			$q_stmt->bind_param("s", $id);
			$q = $q_stmt->execute();
			if ($q) {
				return ['status'=> 202, 'message'=> 'Profile removed'];
			}else{
				return ['status'=> 202, 'message'=> 'Failed'];
			}
			
		}else{
			return ['status'=> 303, 'message'=>'Invalid Admin id'];
		}

	}	


}
if (isset($_POST["GET_PROFILE"])) {
		$c = new profile();
		echo json_encode($c->getprofile());
		exit();
}

if (isset($_POST['DELETE_PROFILE'])) {
	if (!empty($_POST['id'])) {
		$p = new profile();
		echo json_encode($p->deleteprofile($_POST['id']));
		exit();
	}else{
		echo json_encode(['status'=> 303, 'message'=> 'Invalid details']);
		exit();
	}
}



?>