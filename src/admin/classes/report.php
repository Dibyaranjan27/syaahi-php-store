<?php 
session_start();

class report
{
	private $con;

	function __construct()
	{
		include_once("Database.php");
		$db = new Database();
		$this->con = $db->connect();
	}

	public function getreport(){
		$stmt = $this->con->prepare("SELECT report.UserID,report.AdsID,report.details,report.Date,users.UserName AS un,advertisments.Title AS an FROM advertisments,report,users WHERE 1 AND report.UserID=users.UserID AND report.AdsID=advertisments.AdsID");
		$stmt->execute();
		$query = $stmt->get_result();
		$ar = [];
		if (@$query->num_rows > 0) {
			while ($row = $query->fetch_assoc()) {
				$ar[] = $row;
			}
			return ['status'=> 202, 'message'=> $ar];
		}
		return ['status'=> 303, 'message'=> 'no report data'];
	}

	public function deletereport($UserID,$AdsID){
		if ($UserID != null && $AdsID != null) {
			$q_stmt = $this->con->prepare("DELETE FROM report WHERE report.UserID = ?");
			$q_stmt->bind_param("s", $UserID' AND report.AdsID = '$AdsID);
			$q = $q_stmt->execute();
			if ($q) {
				return ['status'=> 202, 'message'=> 'Report removed'];
			}else{
				return ['status'=> 202, 'message'=> 'Failed'];
			}
			
		}else{
			return ['status'=> 303, 'message'=>'Invalid user id or ad id'];
		}

	}	
		
}
if (isset($_POST["GET_REPORT"])) {
		$c = new report();
		echo json_encode($c->getreport());
		exit();
}

if (isset($_POST['DELETE_REPORT'])) {
	if (!empty($_POST['UserID']) && !empty($_POST['AdsID'])) {
		$p = new report();
		echo json_encode($p->deletereport($_POST['UserID'],$_POST['AdsID']));
		exit();
	}else{
		echo json_encode(['status'=> 303, 'message'=> 'Invalid details']);
		exit();
	}
}

?>