<?php 
session_start();

class comment
{
	private $con;

	function __construct()
	{
		include_once("Database.php");
		$db = new Database();
		$this->con = $db->connect();
	}

	public function getcomment(){
		$stmt = $this->con->prepare("SELECT comments.UserID,comments.ProductId,comments.Details,comments.commentID,users.UserName AS un,products.Title AS an FROM products,comments,users WHERE 1 AND comments.UserID=users.UserID AND comments.ProductId=products.ProductId");
		$stmt->execute();
		$query = $stmt->get_result();
		$ar = [];
		if (@$query->num_rows > 0) {
			while ($row = $query->fetch_assoc()) {
				$ar[] = $row;
			}
			return ['status'=> 202, 'message'=> $ar];
		}
		return ['status'=> 303, 'message'=> 'no comment data'];
	}

	public function deletecomment($commentID){
		if ($commentID != null) {
			$q_stmt = $this->con->prepare("DELETE FROM comments WHERE comments.commentID = ?");
			$q_stmt->bind_param("s", $commentID);
			$q = $q_stmt->execute();
			if ($q) {
				return ['status'=> 202, 'message'=> 'Comment removed'];
			}else{
				return ['status'=> 202, 'message'=> 'Failed'];
			}
			
		}else{
			return ['status'=> 303, 'message'=>'Invalid comment id'];
		}

	}		
		
}
if (isset($_POST["GET_COMMENT"])) {
		$c = new comment();
		echo json_encode($c->getcomment());
		exit();
}

if (isset($_POST['DELETE_COMMENT'])) {
	if (!empty($_POST['commentID'])) {
		$p = new comment();
		echo json_encode($p->deletecomment($_POST['commentID']));
		exit();
	}else{
		echo json_encode(['status'=> 303, 'message'=> 'Invalid details']);
		exit();
	}
}


?>