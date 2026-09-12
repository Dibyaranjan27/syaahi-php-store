<?php 
session_start();

class Credentials
{
	private $con;

	function __construct()
	{
		include_once("Database.php");
		$db = new Database();
		$this->con = $db->connect();
	}


	public function createAdminAccount($name, $email, $password){
		$q_stmt = $this->con->prepare("SELECT email FROM admin WHERE email = ?");
		$q_stmt->bind_param("s", $email);
		$q_stmt->execute();
		$q = $q_stmt->get_result();
		if ($q->num_rows > 0) {
			return ['status'=> 303, 'message'=> 'Email already exists'];
		}else{
			$password = password_hash($password, PASSWORD_BCRYPT, ["COST"=> 8]);
			$q_stmt = $this->con->prepare("INSERT INTO `admin`(`name`, `email`, `password`) VALUES (?, ?, ?)");
			$q_stmt->bind_param("sss", $name, $email, $password);
			$q = $q_stmt->execute();
			if ($q) {
				return ['status'=> 202, 'message'=> 'Admin Created Successfully'];
			}

		}
	}

	public function loginAdmin($email, $password){
		$q_stmt = $this->con->prepare("SELECT * FROM admin WHERE email = ? LIMIT 1");
		$q_stmt->bind_param("s", $email);
		$q_stmt->execute();
		$q = $q_stmt->get_result();
		if ($q->num_rows > 0) {
			$row = $q->fetch_assoc();
			if (password_verify($password, $row['password'])) {
				$_SESSION['admin_name'] = $row['name'];
				$_SESSION['admin_id'] = $row['id'];
				return ['status'=> 202, 'message'=> 'Login Successful'];
			}else{
				return ['status'=> 303, 'message'=> 'Login Fail'];
			}
		}else{
			return ['status'=> 303, 'message'=> 'Account not created yet with this email'];
		}
	}

}

if (isset($_POST['admin_register'])) {
	extract($_POST);
	if (!empty($name) && !empty($email) && !empty($password) && !empty($cpassword)) {
		if ($password == $cpassword) {
			$c = new Credentials();
			$result = $c->createAdminAccount($name, $email, $password);
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

if (isset($_POST['admin_login'])) {
	extract($_POST);
	if (!empty($email) && !empty($password)) {
		$c = new Credentials();
		$result = $c->loginAdmin($email, $password);
		echo json_encode($result);
		exit();
	}else{
		echo json_encode(['status'=> 303, 'message'=> 'Empty fields']);
		exit();
	}
}
?>