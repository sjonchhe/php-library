<?php
	include_once( 'class.database.php' );

	class ManageUsers{
		public $linker;

		function __construct()
		{
			$db_connection = new dbConnection();
			$this->linker = $db_connection->connect();
			return $this->linker;
		}

		// Get book From Main Page
		function getBook($bid){
				$query = $this->linker->query("SELECT * FROM books WHERE bid = '$bid'");
				$counts = $query->rowCount();
				if($counts == 1){
					$result = $query->fetchAll();
				}else{
					$result = $counts;
				}
				return $result;
		}

		function registerUsers($username,$email,$password,$ip_address,$date,$time)
		{
			$query = $this->linker->prepare("INSERT INTO users (username,email,password,ip_address,reg_date,reg_time) 
				VALUES (?,?,?,?,?,?)");
			$values = array($username,$email,$password,$ip_address,$date,$time);
			$query->execute($values);
			$counts = $query->rowCount();
			return $counts;
		}

	function LoginUsers($username,$password){
		$query = $this->linker->query("SELECT * FROM users WHERE username = '$username' AND password='$password'");
		$rowcount = $query->rowCount();
		return $rowcount;
	}

	function GetUserInfo($username){
		$query = $this->linker->query("SELECT * FROM users WHERE username = '$username'");
		$rowcount = $query->rowCount();
		// Check if username exits i.e if 1 exits else not
		if($rowcount == 1)
		{
			$result = $query->fetchAll();
			return $result;
		}
		else
		{
			return $rowcount;
		}
	}
	function getNewBooks(){
		$query = $this->linker->query("SELECT * FROM books ORDER BY bid DESC LIMIT 0,4");
		return $query->fetchAll();
	}
	function addIssue($issuedate,$submission,$b_id,$s_id){
		$query = $this->linker->prepare("INSERT INTO issues (issuedate,submission,b_id,s_id) VALUES (?,?,?,?)");
		$values = array($issuedate,$submission,$b_id,$s_id);
		$query->execute($values);
		$counts = $query->rowCount();
		return $counts;
		}
	function insertFeeds($feedby,$feed_type,$feeds){
		$query = $this->linker->prepare("INSERT INTO feedbacks (feedby,feed_type,feeds) VALUES (?,?,?)");
		$values = array($feedby,$feed_type,$feeds);
		$query->execute($values);
		$counts = $query->rowCount();
		return $counts;
	}
}

?>
