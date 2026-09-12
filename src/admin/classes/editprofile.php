<?php 
session_start();

class editprofile
{
	private $con;

	function __construct()
	{
		include_once("Database.php");
		$db = new Database();
		$this->con = $db->connect();
	}


	public function editAdminAccount($name, $email, $password){
		    $id=$_SESSION['admin_id'];
			$password = password_hash($password, PASSWORD_BCRYPT, ["COST"=> 8]);
			$q_stmt = $this->con->prepare("UPDATE admin SET name = ?, email = ?, password = ? WHERE id = ?");
			$q_stmt->bind_param("ssss", $name, $email, $password, $id);
			$q = $q_stmt->execute();
			if ($q) {
				return ['status'=> 202, 'message'=> 'Admin Updated Successfully'];
			}
	}

}

if (isset($_POST['admin_editprofile'])) {
	extract($_POST);
	if (!empty($name) && !empty($email) && !empty($password) && !empty($cpassword)) {
		if ($password == $cpassword) {
			$c = new editprofile();
			$result = $c->editAdminAccount($name, $email, $password);
			echo json_encode($result);
			exit();
		}else{
			echo json_encode(['status'=> 303, 'message'=> 'Password mismatch']);
			exit();
		}
	}else{
		echo json_encode(['status'=> 303, 'message'=> 'Empty fields']);
		exit();
	}
}

?>