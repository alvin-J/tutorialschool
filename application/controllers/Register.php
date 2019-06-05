<?php 
	
	class Register extends CI_Controller {
		public function index() {

			$fullname = $this->input->post("fullname");
			$eadd     = $this->input->post("email");
			$skypnme  = $this->input->post("skype");
			$pword    = $this->input->post("pword");
			$type	  = $this->input->post("u_type");
			$timezone = $this->input->post("timezone");
			
			date_default_timezone_set($timezone);
			date_default_timezone_get();
			
		#	$fullname = "dupplicateoin";
		#	$eadd     = "merto.alvinjay@gmail.com";
		#	$skypnme  = "merto.alvinsldkfjslkfj";
		#	$pword    = "skldjflsjdflskdjflskdjflksjdfl";
			
		#	$lep 	  = "sdfsfd";
		#	$cp 	  = "sdfsfd";
		#	$stttp    = "sdfsfd";

			$type	  = 1;
	
			$this->load->model("Mainprocs");

			$checkemail = $this->Mainprocs->__getdata("users","all",['username'=>$eadd]);

			$proceed = true;
			$msg     = null;

			if (count($checkemail) >= 1) {
				$msg = "Someone has already used that email address.";
				$proceed = false;
				// exit;
			}

			$checkskype = null;
			if ($type == 1) {
				$checkskype = $this->Mainprocs->__getdata("studenttbl","all",['skypename'=>$skypnme]);
			} else if ($type == 2) {
				$checkskype = $this->Mainprocs->__getdata("teachertbl","all",['skypename'=>$skypnme]);
			}
	
			if (count($checkskype) >= 1) {
				$msg = "Someone has that skype ID";
				$proceed = true;
				// exit;
			}

			if ($proceed == true) {
				$uniqueid = $this->Mainprocs->createuniquenumber($eadd,9); // not in use
				$personid = $this->Mainprocs->createuniquenumber($eadd.date("Ymd HiS"),9);

				$users   = [
						"username"	 => $eadd,
						"password"   => md5($pword),
						"type"		 => $type,
						"isloggedin" => 0,
						"status"	 => 0,
						"uniqueid"   => $personid
					];

				$into_user = $this->Mainprocs->__store("users",$users);

				$intopersontbl = false;
				if ($into_user) {
					$tablename = null;
					$details   = null;
					if ($type == 1) { // student
						$lep 	  = $this->input->post("lep");
						$cp 	  = $this->input->post("cp");
						$stttp    = $this->input->post("stttp");

						$tablename = "studenttbl";
						$details = [
								"studentid"		=> $personid,
								"name"   		=> $fullname,
								"userid" 		=> $personid,
								"skypename"		=> $skypnme,
								"lep_lvl"		=> $lep,
								"cp_choice"		=> $cp,
								"stttp_choice"  => $stttp
							];

					} else if ($type== 2) { // teacher
						$tablename = "teachertbl";
						$details = [
								"teacherid"		=> $personid,
								"name"			=> $fullname,
								"userid"		=> $personid,
								"picture"		=> null,
								"availability"	=> null,
								"age"			=> null,
								"exp"			=> null,
								"dept"			=> null,
								"skypename"		=> null,
								"teachertype"	=> null
							];
					}

					$intopersontbl = $this->Mainprocs->__store($tablename,$details);

					if ($intopersontbl && $type == 1) {
						#$this->load->model("loginmodel");
						#$this->loginmodel->makeasession(['username'=>$eadd,'userid'=>$uniqueid]);
						
						// add free trial period 
							/*
								paymentTransId
								studentId
								amount
								paymentMode
								paymentDetails
								subscriptionType
								periodStart
								periodEnd
								status
								modifiedBy
								inputDate
							*/
						$datestart = date("Y-m-d");
						$dateend   = date("Y-m-d",strtotime("+30 days",strtotime($datestart)));
							$freetrial = [
									"paymentTransId"	  => "free trial",
									"studentId"			  => $personid,
									"amount"			  => "free",
									"paymentMode"		  => "sign up",
									"paymentDetails"	  => "free trial",
									"subscriptionType"	  => "1D",
									"periodStart"		  => $datestart,
									"periodEnd"			  => $dateend,
									"status"			  => 1,
									"modifiedBy"		  => $personid,
									"inputDate"			  => $datestart
								];
							$trial = $this->Mainprocs->__store("paymenttbl",$freetrial);
						// add free trial period 
						
						if ($trial) {
							$this->load->library("session");
							$logindata = array(
								   'username'  => $eadd,
								   'fullname'  => $fullname,
								   'userid'	   => $personid,
								   'compid'	   => $personid,
								   'type'	   => $type,
								   'logged_in' => TRUE
							);

							$this->session->set_userdata($logindata);
						}
					}
				}

				echo json_encode($intopersontbl);
			} else {
				echo json_encode($msg);
			}
		}

		public function forgotpassword() {
			$this->load->model("Mainprocs");
			$this->load->helper("url");

			$emailadd = $this->input->post("loginemail");

			$select   = $this->Mainprocs->__getdata("users","all",['username'=>$emailadd]);

			$msg = null;
			if (count($select) == 0) {
				$msg = "No such email address found in the database.";
			} else {
				$newpass 				= $this->Mainprocs->createuniquenumber($emailadd,6);

				$update 				= $this->Mainprocs->__update("users", ["password" => md5($newpass)], ["username"=>$emailadd]);
				
				$details['from_msg']	= "New Password";
				$details['to']			= $emailadd;
				$details['subject']		= "This is your new password";
				$details['msg']			= "<div style='width: 100%; font-family: calibri;'>
												<div style='width: 60%;
															margin: auto;
															background: #e0e0e0;
															padding: 20px;'>
																<table style='width: 100%;
																			  text-align: center;
																			  padding-bottom: 110px;'>
																	<tr>
																		<td style='padding: 15px 0px;'> <img src='".base_url()."images/logoanw.png'/> </td>
																	</tr>
																	<tr>
																		<td style='padding: 15px 0px;'>
																			<p style='font-size: 28px;
																					  color: #0d4a42;
																					  line-height: 43px;'> 
																					  Your new password: </p> 
																			<p style='font-size: 23px;'> {$newpass} </p>
																		</td>
																	</tr>
																	<tr>
																		<td style='padding: 15px 0px;'> <hr style='width: 45%;
																						border: 0px;
																						border-bottom: 1px solid #a9a9a9;'/> 
																		</td>
																	</tr>
																	<tr>
																		<td style='padding: 15px 0px;'> <p style='color: #868283;'> Please login to your account. </p> </td>
																	</tr>
																	<tr>
																		<td style='padding: 30px 0px;'> <span style='background: #fea0be;
																							padding: 21px 36px;
																							font-size: 24px;
																							color: #fff;
																							border-radius: 3px;'> LOGIN </span> </td>
																	</tr>
																</table>
															</div>
														</div>";

				$email = $this->Mainprocs->sendemail($details);

				if ($email) {
					$msg = "Please check your email. We sent you your new password.";
				} 
			}
			echo json_encode($msg);
		}
	}

?>