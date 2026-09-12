<?php 
session_start();

class Categories
{
	private $con;

	function __construct()
	{
		include_once("Database.php");
		$db = new Database();
		$this->con = $db->connect();
	}
	
	public function addCategory($name){
		$q = $this->con->prepare("SELECT * FROM categories WHERE CategoryName = ? LIMIT 1");
		$q->bind_param("s", $name);
		$q->execute();
		$result = $q->get_result();
		if ($result->num_rows > 0) {
			return ['status'=> 303, 'message'=> 'Category already exists'];
		}else{
			$q = $this->con->prepare("INSERT INTO categories (CategoryName) VALUES (?)");
			$q->bind_param("s", $name);
			if ($q->execute()) {
				return ['status'=> 202, 'message'=> 'New Category added Successfully'];
			}else{
				return ['status'=> 303, 'message'=> 'Failed'];
			}
		}
	}	

	public function getCategories(){
		$stmt = $this->con->prepare("SELECT categories.CategoryID , categories.CategoryName , (SELECT COUNT(AdsID) FROM advertisments WHERE categories.CategoryID=advertisments.CategoryID) AS c FROM categories WHERE 1");
		$stmt->execute();
		$query = $stmt->get_result();
		$ar = [];
		if (@$query->num_rows > 0) {
			while ($row = $query->fetch_assoc()) {
				$ar[] = $row;
			}
			return ['status'=> 202, 'message'=> $ar];
		}
		return ['status'=> 303, 'message'=> 'no category data'];
	}	
	
	
	public function deleteCategory($CategoryID){
		if ($CategoryID != null) {
			$q = $this->con->prepare("DELETE FROM categories WHERE CategoryID=?");
			$q->bind_param("s", $CategoryID);
			if ($q->execute()) {
				return ['status'=> 202, 'message'=> 'Category removed'];
			}else{
				return ['status'=> 202, 'message'=> 'You must delete the advertisments related to this category before'];
			}
			
		}else{
			return ['status'=> 303, 'message'=>'Invalid category id'];
		}

	}		

	public function updateCategory($post = null){
		extract($post);
		if (!empty($CategoryID) && !empty($CategoryName)) {
			$q = $this->con->prepare("UPDATE categories SET CategoryName = ? WHERE CategoryID = ?");
			$q->bind_param("ss", $CategoryName, $CategoryID);
			if ($q->execute()) {
				return ['status'=> 202, 'message'=> 'Category updated'];
			}else{
				return ['status'=> 202, 'message'=> 'Failed'];
			}
			
		}else{
			return ['status'=> 303, 'message'=>'Invalid category id'];
		}

	}

}

if (isset($_POST['add_category'])) {
	if (isset($_SESSION['admin_id'])) {
		$CategoryName = $_POST['CategoryName'];
		if (!empty($CategoryName)) {
			$p = new Categories();
			echo json_encode($p->addCategory($CategoryName));
		}else{
			echo json_encode(['status'=> 303, 'message'=> 'Empty fields']);
		}
	}else{
		echo json_encode(['status'=> 303, 'message'=> 'Session Error']);
	}
}

if (isset($_POST["GET_CATEGORIES"])) {
		$c = new Categories();
		echo json_encode($c->getCategories());
		exit();
}



if (isset($_POST['DELETE_CATEGORY'])) {
	if (!empty($_POST['CategoryID'])) {
		$p = new Categories();
		echo json_encode($p->deleteCategory($_POST['CategoryID']));
		exit();
	}else{
		echo json_encode(['status'=> 303, 'message'=> 'Invalid details']);
		exit();
	}
}

if (isset($_POST['edit_category'])) {
	if (!empty($_POST['CategoryID'])) {
		$p = new Categories();
		echo json_encode($p->updateCategory($_POST));
		exit();
	}else{
		echo json_encode(['status'=> 303, 'message'=> 'Invalid details']);
		exit();
	}
}

?>