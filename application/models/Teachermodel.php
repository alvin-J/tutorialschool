<?php 

	class Teachermodel extends CI_Model {
		public function regteacher() {
			$name  = $_POST['fullname'];
			$email = $_POST['email'];
			$skype = $_POST['skype'];
			$pwd   = $_POST['password'];
			$exp   = $_POST['yearsofexp'];

			$q1    = $_POST['q1'];
			$q2    = $_POST['q2'];

			$this->load->model("Mainprocs");

			$proceed   = true;
			$returnmsg = "";

			// admin start 	
				$admin = $this->Mainprocs->__getdata("users",["username"],['type'=>3]);
			// end admin  

			// check email 
				$isemail  = $this->Mainprocs->__getdata("users",['username'],['username'=>$email]);

				if (count($isemail) >= 1){
					$proceed = false;
					$returnmsg = "<p> Duplicate email. </p>";
					return [$proceed,$returnmsg];
				}
			// end 

			// check skype 
				$isskype = $this->Mainprocs->__getdata("teachertbl",['teacherid'],['skypename'=>$skype]);

				if (count($isskype) >= 1) {
					$proceed = false;
					$returnmsg .= "<p> Duplicate Skype ID </p>";
					return [$proceed,$returnmsg];
				}
			// end skype 

			if ($proceed) {
				// save to username 
				$uniqueid = $this->Mainprocs->createuniquenumber($email,9);

				$users = [
						"username"   => $email, 
						"password" 	 => $pwd,
						"type" 		 => 2,
						"isloggedin" => 0,
						"status" 	 => 0,
						"uniqueid" 	 => $uniqueid
					];
				$users_ = $this->Mainprocs->__store("users",$users);
 
				if (!$users_) {
					$proceed = false;
					$returnmsg .= "<p> error saving to users </p>";
					return [$proceed,$returnmsg];
				}
			}

			if ($proceed) {
				// save to teachers 
				$teachers = [
						"teacherid"		=> $uniqueid,
						"name"			=> $name,
						"userid"		=> $uniqueid,
						"exp"			=> $exp,
						"skypename"		=> $skype
				];

				$teachers_ = $this->Mainprocs->__store("teachertbl",$teachers);

				if (!$teachers) {
					$proceed   = false;
					$returnmsg .= "<p> Error saving to teachers table </p>";
					return [$proceed,$returnmsg];
				}
			}

			if ($proceed) {
				// send email 
				$this->load->model("Emailtemplates");

				$this->Emailtemplates->data['name']  = $name;
				$this->Emailtemplates->data['email'] = $email;
				$this->Emailtemplates->data['skype'] = $skype;
				$this->Emailtemplates->data['exp']   = $exp;

				$qs = [
						['q'   => "Lorem Ipsum Dolor set amit consectitur",
						 'ans' => $q1],
						['q'   => "Lorem Ipsum Dolor set amit consectitur",
						 'ans' => $q2]
					];

				$this->Emailtemplates->data['questions']   = $qs;

				$temp = $this->Emailtemplates->applicant();

				$adminemail = "";

				$count = 0;
				foreach($admin as $a) {
					$adminemail .= $a->username;
					if ($count != count($admin)-1) {
						$adminemail .= ",";
					}
					$count++;
				}

				$details   = ["to" 	     => $adminemail,
							  "from_msg" => $name,
							  "subject"  => "Im applying as teacher",
							  "msg"	     => $temp ];

				$sendemail = $this->Mainprocs->sendemail($details);
				// end send email.
			}

			if ($proceed) {
				return true;
			}
		}
	}
?>