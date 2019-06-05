<?php
	
	class Payment extends CI_Controller {

		public function index() {
			$this->load->helper("url");

			$data['title']		= "- Payment";

			// listen to login 
				$this->load->model("Loginmodel");
				$this->load->model("Mainprocs");

				$login = $this->Loginmodel->logmein();
				if ($login == true) {
					// call the book JS 
						$data['headscript']['js'][]	= base_url()."procs/book.proc.js";				
					// end 
					
					// process script
						$data['headscript']['js'][]	= base_url()."procs/payment.procs.js";				
					// end 

					$data['headscript']['style'][]	= base_url()."style/admin/materials.style.css";
					$data['headscript']['style'][]	= base_url()."style/payment.style.css";
					
					// $this->load->model("Paymentmodel");
					// $data['substype']	= $this->Paymentmodel->returnsubs(,$this->session->userdata("userid"));
					$data['content']	= "student/payment";
					
					$thename 		 = explode(" ",$this->session->userdata("fullname"));
					$data['first']   = $thename[0]; unset($thename[0]);					
					$data['last'] 	 = implode(" ",$thename);

					$enableSandbox = true;
					$paypalurl     = $enableSandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
					
					// get settings :: payment
						$userid 		  = $this->session->userdata("userid");
						$payment_settings = $this->Mainprocs->__getdata("usersettings",["paymentmethod"],["userid"=>$userid]);

						if (count($payment_settings) > 0) {
							$data['paymentmethod'] = $payment_settings[0]->paymentmethod;
						}
					// end payment
						if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])) {
							if (isset($_POST['subscribe'])) {
								

								$stntid    	   = $this->session->userdata("compid");
								$itemprice 	   = null;

								switch($_POST['item_number']) {
									case "_1d":
										$itemprice = "5000";
										break;
									case "_8m":
										$itemprice = "4000";
										break;
									case "_1dp":
										$itemprice = "5500";
										break;
								}
								$this->Mainprocs->addpayment($_POST,$_POST['item_number'],$itemprice,$stntid,$paypalurl);
							}
						} else {
							// process the paypal returns here
						}

					$this->load->view("includes/main",$data);
				}
			// end
		}

		public function notify() {
			$this->load->helper("url");
			$this->load->library("session");

			$verified = true;

			$data['verified'] = null;

			if ($verified) {
				$data['headscript']['js'][] = base_url()."procs/creditpayment.procs.js";
				$data['headscript']['style'][]	= base_url()."style/payment.style.css";
				$data['verified'] = true;
			} else {
				$data['verified'] = false;
				echo "error";
			}

			$data['title']	 = "- Payment Confirmation";
			$data['content'] = "student/notify_payment";

			$this->load->view("includes/main",$data);
			// if verified 
				// call the creditpayment javascript

			// if not 
				// display error
		}

		public function creditpayment() {
		//	$timezone = $this->input->post("timezone");

			$timezone = "Asia/Taipei";
			date_default_timezone_set($timezone);
			date_default_timezone_get();

			$this->load->library("session");

			$studentid   = $this->session->userdata("compid");
			$periodtoday = date("Y-m-d");

			$this->load->model("Paymentmodel");
			$this->Paymentmodel->setperiod($periodtoday);
			$this->Paymentmodel->setstudentid($studentid);

			$return = $this->Paymentmodel->checkvalidity($periodtoday,$studentid);

		//	var_dump($return); return;
			if ($return == "valid") {
				$up_ped = $this->Paymentmodel->addup();
				echo json_encode($up_ped);	
			} else if ($return == "invalid") {
				$this->Paymentmodel->setamount("5500");
				$this->Paymentmodel->setpmode("cc");
				$this->Paymentmodel->setpdets("9230j092f");
				$this->Paymentmodel->setsubtype("1D");

				$inserted = $this->Paymentmodel->addnew();

				echo json_encode($inserted);
			}

		}

		public function cancel() {
			
			$date__ = strtotime("2018-08-22");
			$date   = date("Y-m-d",strtotime("+1 months",$date__));

			echo $date__; 
				echo "<br/>";
			echo $date;
		}

		public function checkvalidity() {
		//	$timezone 	 = $this->input->post("_timezone");

		//	date_default_timezone_set($timezone);
		//	date_default_timezone_get();

			$this->load->library("session");

			$studentid   = $this->session->userdata("compid");
			$periodtoday = date("Y-m-d");

			$this->load->model("Paymentmodel");
			
			$return = $this->Paymentmodel->checkvalidity($periodtoday,$studentid);

			echo json_encode($return);
		}

		public function savepmethod() {
			$this->load->library("session");

			$userid     = $this->session->userdata("userid");
			$field		= $this->input->post("field");
			$fieldvalue = $this->input->post("fvalue");
			
			$this->load->model("Mainprocs");

			// check setting exist 
				$setting = $this->Mainprocs->__getdata("usersettings",["settingid"],["userid"=>$userid]);

				$status = null;
				if (count($setting) == 0) {
					// add new 
					$insert = [$field => $fieldvalue, "userid"=>$userid];
					$status = $this->Mainprocs->__store("usersettings",$insert);
				} else {
					// update existing
					$update = [$field   => $fieldvalue];
					$where  = ["userid" => $userid];
					$status = $this->Mainprocs->__update("usersettings",$update,$where);
				}
				echo json_encode($status);
		}

		public function loadbtb() {
			$stdid   = $this->input->post("stdid");
			$substyp = $this->input->post("substype");

			$this->load->model("Mainprocs");

			$data['info']	 = $this->Mainprocs->__getdata("studenttbl",["name"],['studentid'=>$stdid]);

			$data['subtype'] = null;
			$data['amount']  = null;
			switch ($substyp) {
				case '_1d':
					$data['subtype'] = "1D STUDENT PLAN";
					$data['amount']  = "5,000 YEN / MONTH";
					break;
				case '_8m':
					$data['subtype'] = "8M STUDENT PLAN";
					$data['amount']  = "4,000 YEN / MONTH";
					break;
				case '_1dp':
					$data['subtype'] = "1D STUDENT PLAN + COUNSELING";
					$data['amount']  = "5,500 YEN / MONTH";
					break;
			}

			$this->load->view("student/paymentcomponents/addbtb",$data);
		}

		public function savebtn() {
			$stdid   	  = $this->input->post("stdid");
			$substyp 	  = $this->input->post("subtyp");
			$bnktranscode = $this->input->post("bnkcod"); 
			$numofmonths  = $this->input->post("nummos"); 
			$amount 	  = $this->input->post("amount"); 

			$this->load->model("Mainprocs");

			// check if there are unused top ups
				$ql = "select p_inc_id from paymenttbl where studentid = '{$stdid}' and status = 0";
				$check = $this->Mainprocs->__getdata(false,$ql);


			// end 

			if (count($check) == 0) {
				// get the last inputted payment 
					$sql	   = "select * from paymenttbl 
									where p_inc_id = (select max(p_inc_id) from paymenttbl 
														where studentId = '{$stdid}' and
														status = 1)";

					$lastinput = $this->Mainprocs->__getdata(false,$sql);
				// end 

				$dbsubtype 	   = null;
				$dbsubtext     = null;
				switch ($substyp) {
					case '_1d':
						$dbsubtype = "1D";
						$dbsubtext = "1D Student Plan";
						break;
					case '_8m':
						$dbsubtype = "8M";
						$dbsubtext = "8M Student Plan";
						break;
					case '_1dp':
						$dbsubtype = "1DP";
						$dbsubtext = "1D Student Plan + Counseling";
						break;
				}	

				$ret = null;
				$paymenttransid = $this->Mainprocs->createuniquenumber(date("mdYHis").$stdid);
				if (count($lastinput) == 1) {
					// get the end period and compute the next end period according to the number of months 
					$endperiod 		= $lastinput[0]->periodEnd;
					$new_endperiod  = date("Y-m-d",strtotime("+{$numofmonths} months",strtotime("+1 days",strtotime($endperiod))));

					$values = ["paymentTransId"		=> $paymenttransid,
							   "studentId"			=> $stdid,
							   "amount"				=> $amount,
							   "paymentMode"		=> "b2b",
							   "paymentDetails"		=> $bnktranscode,
							   "subscriptionType"	=> $dbsubtype,
							   "periodStart"		=> date("Y-m-d",strtotime("+1 days",strtotime($endperiod))),
							   "periodEnd"			=> $new_endperiod,
							   "status"				=> 0,
							   "modifiedBy"			=> $stdid,
							   "inputDate"			=> date("Y-m-d H:i:s"),
							   "numofmos" 			=> $numofmonths];
					$ret = $this->Mainprocs->__store("paymenttbl",$values);
				} else if (count($lastinput)==0) {
					// get today and compute for the end period accorind to the number of months 
					$startperiod = date("Y-m-d");
					$endperiod   = date("Y-m-d",strtotime("+{$numofmonths} months"));

					$values = ["paymentTransId"		=> $paymenttransid,
							   "studentId"			=> $stdid,
							   "amount"				=> $amount,
							   "paymentMode"		=> "b2b",
							   "paymentDetails"		=> $bnktranscode,
							   "subscriptionType"	=> $dbsubtype,
							   "periodStart"		=> $startperiod,
							   "periodEnd"			=> $endperiod,
							   "status"				=> 0,
							   "modifiedBy"			=> $stdid,
							   "inputDate"			=> date("Y-m-d H:i:s"),
							   "numofmos" 			=> $numofmonths];
					$ret = $this->Mainprocs->__store("paymenttbl",$values);
				}
				
				$this->load->model("Emailtemplates");
				
				$stdata = $this->Mainprocs->__getdata("studenttbl",['name'],['studentid' => $stdid]);
				$admine = $this->Mainprocs->__getdata("users",["username"],["type"=>3]);
				
				$this->Emailtemplates->data['name'] 	= $stdata[0]->name; 
				$this->Emailtemplates->data['subtype']  = $dbsubtext;
				$this->Emailtemplates->data['bcode'] 	= $bnktranscode;
				$this->Emailtemplates->data['numofmos'] = $numofmonths;
				$this->Emailtemplates->data['amnt'] 	= $amount;
				$temp 									= $this->Emailtemplates->notifyadmin();
				
				$emailsadmin = "";
					
					$count = 0;
					foreach($admine as $e) {
						$emailsadmin .= $e->username;
						if ($count < count($admine)) {
							$emailsadmin .= "";
						} else {
							$emailsadmin .= ",";
						}
						$count++;
					}
					
				$details['from_msg'] = $stdata[0]->name;
				$details['to'] 		 = $emailsadmin;
				$details['subject']  = "Payment received from {$stdata[0]->name} - {$bnktranscode}";
				$details['msg'] 	 = $temp;
				$ret 				 = $this->Mainprocs->sendemail($details);
				
				echo json_encode($ret);
			} else {
				echo json_encode("There is an unused top up for your account yet. We cannot add another. Please tell the admin to approve it first.");
			}
		}
		
		public function screener() {
			$stdid = $this->session->userdata("userid");
			
			$this->load->model("Mainprocs");
			
			$get = $this->Mainprocs->__getdata("usersettings","all",["userid"=>$stdid]);
			
			$showwhat = null;
			if (count($get)==0){
				$showwhat = "setuppmethod";
			} else {
				if ($get[0]->paymentmethod == "b2b") {
					$showwhat = "confirmb2b";
				} else if ($get[0]->paymentmethod == "ctc") {
					$showwhat = "confirmpaypal";
				}
			}
			
			$this->load->view("student/paymentcomponents/{$showwhat}");
		}
		
		public function checksubs() {
			$timezone = $this->input->post("timezone");
			
			date_default_timezone_set($timezone);
			date_default_timezone_get();
			
			$today = date("Y-m-d");
			$this->load->model("Paymentmodel");
			$substype	= $this->Paymentmodel->returnsubs($today,$this->session->userdata("userid"));
			
			echo json_encode($substype['substype']);
		}
		
		public function planlist() {
			$timezone = $this->input->post("timezone");
			
			date_default_timezone_set($timezone);
			date_default_timezone_get();
			
			$this->load->model("Paymentmodel");
			
			$today 		= date("Y-m-d");
			$substype	= $this->Paymentmodel->returnsubs($today,$this->session->userdata("userid"));
			
			if ($substype != false) {
				$substype = $substype['substype'];
			}
			
			$data['substype'] = $substype;
			$this->load->view("student/paymentcomponents/plans",$data);
		}
 
	}
?>