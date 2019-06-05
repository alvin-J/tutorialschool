<?php 
	
	class Book extends CI_Controller {
		public function index() {
			$this->load->helper("url");
			$this->load->model("Mainprocs");

			$values  = $this->input->post("values");

			$teacher  = $values[0];
			$datetime = $values[1];

			$timezone = $values[2];

			// date_default_timezone_set("Asia/Manila");
			date_default_timezone_set($timezone);
			date_default_timezone_get();

			$data['status'] = null;
			// check validity 
				$this->load->model("Paymentmodel");
				$this->load->library("session");
				$studentid = $this->session->userdata("compid");
				$status = $this->Paymentmodel->checkvalidity(date("Y-m-d"),$studentid);
				if ($status == "invalid") {
					$data['status'] = true;
				} 
			// end checking
	
			$isselected = null;
			if ($datetime == NULL) {
				// set default date and time and use it in getting the available teachers
				// 08-19-2018 02:57 AM

				if (date("i") >= 30) {
					$datetime = date("Y-m-d H:30:00");
				} else if (date("i") <=29){
					$datetime = date("Y-m-d H:00:00");
				}
				
				$isselected = false;
			} else {
				// set the date to the given value
				$datetime   = date("Y-m-d H:i:00", strtotime($datetime));
				$isselected = true;
			}

			if ($teacher == NULL) {
				// get the pool of teachers
			} else {
				// get the teacher ID 
				$data['teacherdets'] = $this->Mainprocs->__getdata("teachertbl","all",["teacherid"=>$teacher]);
			}

			/*
			$sql = "select * from teachertbl as t where t.teacherid not in 
						(select teacherid from booking where date_time = '{$datetime}')";
			*/

			$sql = "select * from teachertbl as t";
			$available_teachers = $this->Mainprocs->__getdata(false,$sql);

			$data['available_teachers'] = $available_teachers;

			// 23-August-2018 08:00 AM
			$data['selected_date']	= date("d-F-Y",strtotime($datetime)); // h:i A
			$data['isselected']     = $isselected;
			$data['today']	 		= date("Y-m-d H:i:s");
			
			$this->load->view("student/booking",$data);
			
		}

		public function booknow() {
			
			$this->load->model("Mainprocs");
			$this->load->library('session');

			$teacher  = $this->input->post("teacher");
			$datetime = $this->input->post("datetime");
			$timezone = $this->input->post("_timezone");

			$thetime  = $this->input->post("time"); // array

			/*
			$teacher  = "5558913d4";
			$datetime = "2018-11-02";
			$timezone = "Asia/Manila";

			$thetime  = ['23:30:00']; // array
			*/
			
			// date_default_timezone_set("Asia/Manila");
			date_default_timezone_set($timezone);
			date_default_timezone_get();

			$date_time = null;

			if ($datetime == null) {
				if (date("i") <= 29) {
					// use 00
					$date_time = date("Y-m-d H:00:00");
				} else if (date("i") >= 30) {
					// use 30
					$date_time = date("Y-m-d H:30:00");
				}
			} else {
				// $date_time = date("Y-m-d H:i:00",strtotime($datetime));
				 $datetime = date("Y-m-d",strtotime($datetime));
			}
	
			$details['studentid']     = $this->session->userdata('userid');
			$details['teacherid']     = $teacher;
			$details['dateofbooking'] = date("Y-m-d H:i:s");
			$details['status']        = 1;
			$details['timezone']      = $timezone;
			$details['keycode']       = $this->Mainprocs->createuniquenumber(date("Y-m-d H:i:s").$this->session->userdata('userid').$teacher,30);

			$ret = false;
			
			$this->load->model("Paymentmodel");
			$p_inc 		 = $this->Paymentmodel->checkvalidity($details['dateofbooking'],$details['studentid'], true);
			
			$isfreetrial = false;
			if (count($p_inc)>0) {
				if ($p_inc[0]->paymentTransId=="free trial") {
					$isfreetrial = $p_inc[0]->p_inc_id;
				}
			}
			
			for($i = 0; $i <= count($thetime)-1 ; $i++) {
				$d = $datetime." ". date("H:i:00",strtotime($thetime[$i]));

				$ca = $this->Mainprocs->checkforbooking($d,$teacher);

				if (count($ca) == 0) {
					$details['date_time']   = $d;
					$store 					= $this->Mainprocs->__store("booking", $details);
					
					if ($store){
							$sql   = "select 
											bl.bl_id, 
											st.name, 
											bl.date_time, 
											bl.dateofbooking,
											u.username
										from booking as bl 
									  join studenttbl as st on 
									  	bl.studentid = st.userid 
									  join users as u on bl.teacherid = u.uniqueid
									  where bl.keycode = '{$details['keycode']}'";
									  
							// $bl_id = $this->Mainprocs->__getdata("booking",['bl_id'],['keycode'=>$details['keycode']]);
							$bk    = $this->Mainprocs->__getdata(false,$sql);

							if (count($bk) == 0) {
								return false;
							}

							$bl_id = $bk[0]->bl_id;

							// actiononbooking/action/confirm/152/029j3r0293j09f2
							$this->load->model("Emailtemplates");

							$this->Emailtemplates->data['confurl']	= base_url()."actiononbooking/action/confirm/".$bl_id."/".$details['keycode']; 
							$this->Emailtemplates->data['declurl']	= base_url()."actiononbooking/action/decline/".$bl_id."/".$details['keycode']; 
							$this->Emailtemplates->data['name'] 	= $bk[0]->name;
							$this->Emailtemplates->data['cdate'] 	= $bk[0]->date_time;
							$this->Emailtemplates->data['bldate'] 	= $bk[0]->dateofbooking;
							
							$template 	 			 = $this->Emailtemplates->confirmbooking();
							
							$cdate_date				 = date("F d, Y h:i A", strtotime($bk[0]->date_time));
							$senddetails['from_msg'] = $bk[0]->name;
							$senddetails['to'] 		 = $bk[0]->username;
							$senddetails['subject']  = "I booked you for a class on {$cdate_date} - {$bk[0]->name}";
							$senddetails['msg'] 	 = $template;

							$ret 	   	 = $this->Mainprocs->sendemail($senddetails);
							
					}
					
					// update the payment status field to 0 for free trial subscription
						// and break or exit the function 
						if ($isfreetrial != false) {
							$update_vals  = ["status"=>0];
							$update_where = ["p_inc_id"=>$isfreetrial,"connector"=>"and","studentId"=>$details['studentid']];
							$updatenow    = $this->Mainprocs->__update("paymenttbl",$update_vals,$update_where);
							
							if ($updatenow) {
								break;	
							}
						}
					// end update
				}
			}
			
			echo json_encode($ret);
			
		}
		
		public function loadtime() {
			$timezone      		   = $this->input->post("timezone");
			$selecteddate  		   = $this->input->post("selecteddate");
			
			date_default_timezone_set($timezone);
			date_default_timezone_get();
			
			if ($selecteddate == null) {
				$selecteddate = date("Y-m-d");
			}
			
			$data['selected_date'] = date("Y-m-d",strtotime($selecteddate));
			$data['today'] 		   = date("Y-m-d H:i:s");
			
			$this->load->view("student/timetable",$data);
		}

		public function getavailabletime() {
			$teacher = $this->input->post("teacher");
			$p_date  = $this->input->post("datetime");

			date_default_timezone_set("Asia/Manila");
			date_default_timezone_get();

			if ($p_date == null) {
				$p_date = date("Y-m-d");
			}

			$date    = date("Y-m-d", strtotime($p_date));

			// $teacher = 2;
			// $date = '2018-08-19';
			$sql = "select * from booking where date_time like '%{$date}%' and teacherid = '{$teacher}'";
			
			$this->load->model("Mainprocs");
			$data  = $this->Mainprocs->__getdata(false,$sql);

			$times = [];
			foreach($data as $d) {
				$times[] = date("h:i A", strtotime($d->date_time));
			}
			
			// get the absent time 
				$absent_sql   = "select * from t_anvailstat where thedate like '%{$date}%' and teacherid = '{$teacher}'";
		//	echo json_encode($absent_sql);
				$absent_data  = $this->Mainprocs->__getdata(false,$absent_sql);
			
				if (count($absent_data)>0) {
					foreach($absent_data as $ad) {
						$times[] = date("h:i A", strtotime($ad->thedate));
					}
				}
			// end 
			
			echo json_encode([$times, date("F d, Y", strtotime($p_date)) ]);
		}

		public function checkavailability() {
			$this->load->model("Mainprocs");

			$teacherid = $this->input->post("teacher");
			$datetime  = $this->input->post("datetime");

			// $teacherid = 1;
			// $datetime  = date("Y-m-d H:i:00",strtotime("22-August-2018 08:30 AM"));

			date_default_timezone_set("Asia/Manila");
			date_default_timezone_get();

	//		$teacherid = 1;
	//		$datetime = "08-September-2018 07:00:00";

			if ($datetime == null) {
				$datetime = date("Y-m-d H:i:00");
				if (date("i",strtotime($datetime)) <= 29) {
					// use 00
					$datetime = date("Y-m-d H:00:00",strtotime($datetime));
				} else if (date("i",strtotime($datetime)) >= 30) {
					// use 30
					$datetime = date("Y-m-d H:30:00",strtotime($datetime));
				}
			} 

			// uses teacherid 
			// uses date_time

			$ca = $this->Mainprocs->checkforbooking($datetime,$teacherid);
			
			$ret = false;
			if (count($ca) >=1 ) { // found
				$ret = true; // not available
			}

			echo json_encode([$ret,$datetime,$ca]);
		}

		function test() {
			echo phpinfo();
		}
		
	}

?>