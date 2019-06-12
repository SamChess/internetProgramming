<?php 
	include "crud.php";
	include "authenticator.php";
	include_once 'DBConnector.php';


	class User implements Crud, Authenticator{
		private $user_id;
		private $first_name;
		private $last_name;
		private $city_name;

		private $username;
		private $password;
		private $timestamp;
		private $offset;

		function __construct ($first_name, $last_name, $city_name,$username,$password,$timestamp,$offset)
		{
			$this->first_name = $first_name;
			$this->last_name = $last_name;
			$this->city_name = $city_name;
			$this->username = $username;
			$this->password = $password;
			$this->timestamp = $timestamp;
			$this->offset = $offset;
		}

		public static function create(){
			//$instance = new self();
			//return $instance;
			$reflection = new ReflectionClass(__CLASS__);
			$instance = $reflection->newInstanceWithoutConstructor();

			return $instance;
		}
		public function setTimeStamp($timestamp){
			$this->timestamp=$timestamp;
			
		}
		public function getTimeStamp(){
			return $timestamp;
		}
		public function setOffset($offset){
			$this->offset=$offset;
			
		}
		public function getOffset(){
			return $offset;
		}


		public function setUsername($username){
			$this->username = $username;
		}

		public function getUsername(){
			return $this->username;
		}

		public function setPassword($password){
			$this->password = $password;
		}

		public function getPassword(){
			return $this->password;
		}

		public function setUserId($user_id){
			$this->user_id = $user_id;
		}

		public function getUserId(){
			return $this->user_id;
		}

		public function save(){
			$fn = $this->first_name;
			$ln = $this->last_name;
			$city = $this->city_name;
			$uname = $this->username;
			$this->hashPassword();
			$pass = $this->password;
			$timestamp = $this->timestamp;
			$offset = $this->offset;

			if ($this->isUserExist($uname)==true){
				return false;
			}
			$this->conn = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME) or die("Error:".mysqli_error());

			 $res=mysqli_query($this->conn, "INSERT INTO user(first_name,last_name,user_city,username,password,timestamping,offset) VALUES('$fn','$ln','$city','$uname','$pass','$timestamp','$offset')") or die("Error".mysqli_connect_error($conn));
		     return $res;
		}

		public function readAll(){

			$this->conn = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME) or die("Error:".mysqli_connect_error());

			$sql = "SELECT * FROM user";
			$result = mysqli_query($this->conn,$sql);
			return $result;
		}

		public function readUnique(){
			return null;
		}

		public function search(){
			return null;
		}

		public function update(){
			return null;
		}

		public function removeOne(){
			return null;
		}

		public function removeAll(){
			return null;
		}

		public function validateForm(){
			$fn = $this->first_name;
			$ln = $this->last_name;
			$city = $this->city_name;

			if ($fn == "" || $ln == "" || $city == ""){
				return false;
			}
			return true;
		}

		public function createFormErrorSessions($warning){
			session_start();
			$_SESSION['form_errors'] = $warning;
		}

		public function hashPassword(){
			$this->password = password_hash($this->password, PASSWORD_DEFAULT);
		}

		public function isPasswordCorrect(){
			
			$this->conn = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME) or die("Error:".mysqli_error());

			$found = false;
			$res = mysqli_query($this->conn,"SELECT * FROM user") or die("Error".mysqli_error());

			while ($row=mysqli_fetch_array($res)){
				if (password_verify($this->getPassword(), $row['password']) && $this->getUsername()==$row['username']){
					$this->setUserId($row['id']);
					$found = true;
				}
			}
			return $found;
		}

		public function login(){
			if ($this->isPasswordCorrect()){
				header("Location:private_page.php");
			}
		}

		public function createUserSession(){
			session_start();
			$_SESSION['username'] = $this->getUsername();
			$_SESSION['id'] = $this->getUserId();
		}
		
		public function logout(){
			session_start();
			unset($_SESSION['username']);
			session_destroy();
			header("Location:lab.php");
		}


		public function isUserExist($username){

			$this->conn = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME) or die("Error:".mysqli_error());

			$sql = "SELECT * FROM user where username = '$username' ";
			$result = mysqli_query($this->conn,$sql);
			$matchFound = mysqli_num_rows($result) > 0 ? 'yes' : 'no';
            if($matchFound=='yes'){
            	return true;
            }
            return false;
	
			}
			public function readUserApiKey($user){
			$this->DBConnect();

			$res = mysqli_query($this->con->conn, "SELECT api_key FROM api_keys WHERE user_id = $user") or die("Error " . mysqli_error($this->con->conn));

			$this->DBClose();

			if (mysqli_num_rows($res)) {
				return mysqli_fetch_array($res)['api_key'];
			}
			
			return false;
		}
		public function DBConnect() {
			$this->con = new DBConnector;
		}
		public function DBClose() {
			$this->con->closeDatabase();
		}

			
		}

 ?>