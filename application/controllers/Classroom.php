<?php 
	
	class Classroom extends CI_Controller {

		public function __construct() {
			parent::__construct();
		}

		public function waiting($croomid = '') {

			$this->load->model("Classroommodel");
			$data['title']	 = "Classroom";
			
 
			$data['headscript']['style'][] = base_url()."style/classroom.style.css";
			$data['headscript']['js'][]	   = base_url()."procs/classroom.procs.js";

			$this->Classroommodel->theid  = $this->session->userdata("userid");
			$this->Classroommodel->type   = $this->session->userdata("type");
			
			if (strlen($croomid) == 0) {
				$data['content'] = "classroom/classlist";

				$ret 		 				  = $this->Classroommodel->getclassroom();
				
				$data['class'] 				  = $ret;
				$this->load->view("includes/main",$data);
			} else {
				
				$data['content'] 			= "classroom/waiting";
				$this->Classroommodel->cid  = $croomid;

				$update 					= $this->Classroommodel->updateclassroomstatus();
				$ret 						= $this->Classroommodel->getstatus();
					
				// get the student data 
				$stddata = "select 
								b.studentid
								from classroom as cr 
								JOIN booking as b on cr.bookingid = b.bl_id
								where cr.classroomid = '{$croomid}'";

				$std 	   = $this->Mainprocs->__getdata(false,$stddata);
				$studentid = $std[0]->studentid;
				// end 

				// get the feedback data
					$sql	 = "select 
									fb.*, 
									m.mat_headtext,
									t.name
								from feedbacktable as fb 
									JOIN materials as m on fb.matid = m.mat_id 
									JOIN teachertbl as t on fb.teacherid = t.teacherid 
								where fb.studentid = '{$studentid}'";
					$fbs      = $this->Mainprocs->__getdata(false,$sql);
				$data['fbs']  = $fbs;
				// end
				$data['info'] = $ret;
				$this->load->view("includes/main",$data);	
			}

		}

		public function start($classroomid = '') {
			if ($classroomid == ''){ die("Classroom id not defined"); return; }

			$data['title']		= "Class";
			$data['content']	= "classroom/classroom";

			// $this->load->model("Classroommodel");
			//$this->Classroommodel->cid = $classroomid;
			//$ret = $this->Classroommodel->getclassroom();

			//$data['info'] = $ret;

			$this->load->model("Mainprocs");
			// get the data from the database
			$data['mats'] = $this->Mainprocs->__getdata("materials","all");

			// get the latest performance ledger
				/*
					$stdsql 		= "select bl.studentid, bl.bl_id 
										from classroom as cr 
											JOIN booking as bl 
												ON cr.bookingid = bl.bl_id
										where cr.classroomid = '{$}'";
					$stdid 			= $this->Mainprocs->__getdata("")
				*/

				$sql 			= "select * from performanceledger as pl
									where pl_id = (select max(pl.pl_id) from performanceledger as pl
													JOIN studenttbl as stb on 
														stb.studentid = pl.groupid
													JOIN booking as bl on
														bl.studentid = stb.studentid
													JOIN classroom as cr 
														on bl.bl_id = cr.bookingid 
													where cr.classroomid = '{$classroomid}')";
				
				$data['plvals']	= $this->Mainprocs->__getdata(false,$sql);
			// end performance

			$data['usertype'] 	= $this->session->userdata("type");
			$data['cid']  		= $classroomid;
			$this->load->view($data['content'],$data);
		}

		public function checktoken() {
			$classroomid = $this->input->post("cid");

			$this->load->model("Classroommodel");

			$this->Classroommodel->cid = $classroomid;
			$ret 					   = $this->Classroommodel->getcrinfo();

			echo json_encode($ret);
		}

		public function updatetoken() {
			$classroomid = $this->input->post("cid");
			$token       = $this->input->post("token");
			$sid 	 	 = $this->input->post("sid");

			/*
			$classroomid = "1467acfd15ab1";
			$token       = "T1==cGFydG5lcl9pZD00NjIxMTcwMiZzaWc9Nzk0MTQ0ODQ5YmUyOWY5NzQ0NWVkYWY3NTdkZDZjNzlhMjJjNTJmMjpzZXNzaW9uX2lkPTFfTVg0ME5qSXhNVGN3TW41LU1UVTBNRGt3TXpRNE5UQXlPWDVVVkM5bFZEYzNXa3RtTVRsSmJsbFdTbTE1ZDBGUWJXbC1mZyZjcmVhdGVfdGltZT0xNTQwOTA0NTcwJnJvbGU9cHVibGlzaGVyJm5vbmNlPTE1NDA5MDQ1NzAuNTU3NjEyMzc5MzM1NDc=";
			$sid 	 	 = "1_MX40NjIxMTcwMn5-MTU0MDkwMzQ4NTAyOX5UVC9lVDc3WktmMTlJbllWSm15d0FQbWl-fg";
			*/	

			$this->load->model("Classroommodel");
			$this->Classroommodel->cid = $classroomid;
			$ret 					   = $this->Classroommodel->updateclassroom($token,$sid);

			echo json_encode($ret);		
		}

		public function savefeedback() {
			$this->load->model("Mainprocs");
			
			$vals    = $this->input->post("croomdata");
			$croomid = $vals['cid'];
			$thefb   = $vals['thefb'];
			$lesid   = $vals["lesid"];

			// performance ledger 
				$englvl 	= $vals['englvl'];
				$conlvl 	= $vals['conlvl'];
				$grammar 	= $vals['grammar'];
				$speaking 	= $vals['speaking'];
				$reading 	= $vals['reading'];
				$writing 	= $vals['writing'];
				$listening  = $vals['listening'];
			// end performance ledger
			$sql = "select 
							b.studentid
						from feedbacktable as fb JOIN 
						classroom as cr on fb.classroomid = cr.classroomid JOIN
						booking as b on cr.bookingid = b.bl_id";

			$d   	   = $this->Mainprocs->__getdata(false,$sql);
			$teacherid = $this->session->userdata("compid");

			$values = ["classroomid" => $croomid,
					   "matid"       => $lesid,
					   "feedback"    => $thefb,
					   "dateoffb"    => date("Y-m-d"),
					   "status"      => 0,
					   "studentid"   => $d[0]->studentid,
					   "teacherid"   => $teacherid];

			$pl_values = ["englvl" 		=> $englvl,
						  "conlvl"		=> $conlvl,
						  "grammar"		=> $grammar,
						  "speaking"	=> $speaking,
						  "reading"		=> $reading,
						  "writing"		=> $writing,
						  "listening"	=> $listening,
						  "groupid"		=> $d[0]->studentid
						 ];

			if ( strlen(trim($thefb)) > 0 ) {
				$status = $this->Mainprocs->__store("feedbacktable",$values);	
			} else {
				// bypass saving the feedback
				$status = true;
			}
			
			if ($status){
				$status = $this->Mainprocs->__store("performanceledger",$pl_values);
			}

			echo json_encode( $status );

		}

		public function counselor($classroomid = '') {
			$this->load->model("Mainprocs");

			$d = $this->Mainprocs->__getdata("classroom",
												["sessionid","token"],
												["classroomid"=>$classroomid]);

			$data['c_data'] = $d;
			
			echo "<script>";
				echo "var sesid = '".$d[0]->sessionid."';";
				echo "var tok = '".$d[0]->token."';";
			echo "</script>";

			$data['headscript']['js'][] = base_url()."procs/counselling.procs.js";

			
			$this->load->view("counselor/counselling",$data);
		}
	}

?>