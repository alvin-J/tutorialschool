<?php 
	
	class Loginmodel extends CI_Model {
		

		public function logmein() {
			$this->load->library('session');

			// capture login button
				if(isset($_POST['loginbtn'])) {
					$this->load->model("mainprocs");
					$username = $_POST['username'];
					$password = md5($_POST['password']);
					$log_creds = $this->mainprocs->__getdata(false,"select * from users where username='{$username}' and password = '{$password}' and status = 1");

					if (count($log_creds) == 1 ) {
						// $this->makeasession(['username'=>$username,'userid'=>$log_creds[0]->uniqueid]);
						// $user_d      = ( $log_creds[0]->type == 1 ) ? "studenttbl":"teachertbl";
						// $user_his_id = ( $log_creds[0]->type == 1 ) ? "studentid":"teacherid";

						$user_d 		= null;
						$user_his_id 	= null;

						if ($log_creds[0]->type == 1) {	// student
							$user_d 		= "studenttbl";
							$user_his_id 	= "studentid";
						} else if ($log_creds[0]->type == 2) { // teacher
							$user_d 		= "teachertbl";
							$user_his_id 	= "teacherid";
						} else if ($log_creds[0]->type == 4) { // Counselor
							$user_d 		= "counselortbl";
							$user_his_id 	= "counselorid";
						}

						if ($log_creds[0]->type == 1 
								|| $log_creds[0]->type == 2 
									|| $log_creds[0]->type == 4 ) {
							$user_d_t    = $this->mainprocs->__getdata($user_d,["name",$user_his_id],['userid'=>$log_creds[0]->uniqueid]);
							
							$logindata = array(
								        'username'  => $username,
								        'fullname'	=> $user_d_t[0]->name,
								        'userid'	=> $log_creds[0]->uniqueid,
										'compid'	=> $user_d_t[0]->$user_his_id,
								        'type'		=> $log_creds[0]->type,
								        'logged_in' => TRUE
								);

							$this->session->set_userdata($logindata);
							
							unset($_POST);
						} else {
							$logindata = array(
								        'username'  => $username,
								        'fullname'	=> $username,
								        'userid'	=> $log_creds[0]->uniqueid,
								        'compid'	=> $log_creds[0]->uniqueid,
								        'type'		=> $log_creds[0]->type,
								        'logged_in' => TRUE
								);

							$this->session->set_userdata($logindata);
						}
						// return true;
					} else if (count($log_creds)== 0){
						echo "<p style='margin: 0px;
										text-align: center;
										text-transform: uppercase;
										background: #ff8484;
										position: fixed;
										width: 100%;
										bottom: 0px;
										padding: 15px;
										color: #fff;
										font-size: 19px;
										box-shadow: 0px -3px 3px #c58383;
										border-top: 1px solid #b06a6a;'> user not recognized </p>";
					}
				}
			// end capture login button

			$data = [];
			if ( NULL === $this->session->userdata("logged_in"))  {
				$data['content']	= "login";
				// call the book JS 
						$data['headscript']['js'][]	= base_url()."procs/book.proc.js";				
				// end 

				$data['headscript']['style'][]	= base_url()."style/login.style.css";
				$data['headscript']['style'][]	= base_url()."style/student.style.css";

				$data['headscript']['js'][]		= base_url()."procs/proc.login.js";

				// data for the dropdown button in the login page
					$data['drops'] = $this->getdropdown_dets();

				$this->load->view("includes/header",$data);
				$this->load->view("login",$data); 
				$this->load->view("includes/footer",$data);
				return;
			} else {
				// logged in 
				return true;
			}

			return $data;
		}

		public function makeasession($data) {
			$this->load->library('session');

			$logindata = array('username'  => $data['username'],
							   'userid'	   => $data['uniqueid'],
							   'logged_in' => TRUE
							);

			$this->session->set_userdata($logindata);
						
			// unset($_POST);

			// header("Location: ".$_SERVER['PHP_SELF']);
			echo "<script>";
				echo "window.location.reload();";
			echo "</script>";
		}

		public function getdropdown_dets() {
			$this->load->model("mainprocs");

			$lep 		= $this->mainprocs->__getdata("leplvl","all");
			$cpchoice   = $this->mainprocs->__getdata("cpchoice","all");
			$stttp 		= $this->mainprocs->__getdata("stttptbl","all");

			return [$lep,$cpchoice,$stttp];
		}
	}

?>