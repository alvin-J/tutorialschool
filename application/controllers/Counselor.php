<?php 
	
	class Counselor extends CI_Controller {

		function teacher() {
			$data['title']				   = "- Counselor";

			$data['headscript']['style'][] = base_url()."style/counselor.style.css";
			$data['headscript']['js'][]	   = base_url()."procs/thecounselor.procs.js";

			$data['content']			   = "counselor/counselorteacher";
			$this->load->view("includes/main",$data);
		}

		function enrollment() {
			$data['title']					= "- Enrollment";

			$data['headscript']['style'][]	= base_url()."style/counselor.style.css";
			$data['headscript']['js'][]	    = base_url()."procs/counselorpage.procs.js";
			$data['content']    			= "counselor/enroll/enrollment";


			$this->load->view("includes/main",$data);
		}

		function stdinformation() {

			$this->load->model("Mainprocs");

			$info  = $this->input->post("info");
			$stdid = $info['stdid'];

			$sql   = "select * from studenttbl as stb 
							JOIN leplvl as lpl on 
								stb.lep_lvl = lpl.lep_id 
							JOIN cpchoice as cpc on 
								stb.cp_choice = cpc.cpchoice_id 
							JOIN stttptbl as sttp on
								stb.stttp_choice = sttp.stttp_id
							where stb.studentid = '{$stdid}'";

			$data['inf'] = $inf = $this->Mainprocs->__getdata(false,$sql);
			
			if (count($inf) > 0) {
				$sql1 = "select * from feedbacktable as fb 
							JOIN teachertbl as tbl 
								on fb.teacherid = tbl.teacherid
							where fb.studentid = '{$stdid}'";
				$data['feedback'] = $this->Mainprocs->__getdata(false,$sql1);
			}

			$this->load->view("counselor/enroll/stdinformation",$data);
		}

		function loadstudents() {
			$this->load->model("Mainprocs");

			$data['students'] = $this->Mainprocs->__getdata("studenttbl","all");

			$this->load->view("counselor/enroll/studentslist",$data);
		}

	// ======= for the counselor 
			function loadbookings() {
				$cid = $this->session->userdata("compid");

				$this->load->model("Mainprocs");

				$sql = "select * from booking as b 
							JOIN studenttbl as stb 
								on b.studentid = stb.studentid 
							where b.status = '1' 
								and b.teacherid = '{$cid}'";

				$bookings = $this->Mainprocs->__getdata(false,$sql);
				$data['bookings'] = $bookings;
				$this->load->view("counselor/couns/bookings",$data);
			}

			function showinformation() {
				$info = $this->input->post("info");
				$blid = $info['blid'];

				$this->load->model("Mainprocs");

				$sql = "select * from booking as b 
							JOIN studenttbl as stb 
								on b.studentid = stb.studentid
							JOIN classroom as cr 
								on b.bl_id = cr.bookingid
							where b.bl_id = '{$blid}'";

				$data['personaldata'] = $thedata = $this->Mainprocs->__getdata(false,$sql);

				if (count($thedata) > 0) {
					$sql1 = "select * from feedbacktable as fb 
								JOIN teachertbl as tbl 
									on fb.teacherid = tbl.teacherid
								where fb.studentid = '{$thedata[0]->studentid}'";
					$data['feedback'] = $this->Mainprocs->__getdata(false,$sql1);
				}
				// classroom link 
					// http://anwdev.ariesvrebuldad.com/classroom/start/2687f2eb32284g4g4g4g
				$this->load->view("counselor/couns/information",$data);
			}
	// ======= end for the counselor

		function student() {
			$data['title']		= "- Counselor";

			$data['headscript']['style'][] = base_url()."style/counselor.style.css";
			$data['headscript']['js'][]    = base_url()."procs/counselor.procs.js";

			$data['content']	= "counselor/counselorstudent";

			$this->load->model("Mainprocs");
			// get the list of counselors 
				$data['counselors'] = $this->Mainprocs->__getdata("counselortbl","all");

			// end 
			$this->load->view("includes/main",$data);
		}

	// =============================================
// ajax processes
		function couns_timeskeds() {
			
			$info  = $this->input->post("info");

			date_default_timezone_set( $info['timezone'] );
			date_default_timezone_get();

			$data  = [];
//var_dump($info);
			if (isset($info['cid'])) {
				$cid   = $info["cid"];
				$date  = date("Y-m-d", strtotime($info["datetime"]));

				$this->load->model("Mainprocs");

				$sql   = "select * from booking as b 
							JOIN counselortbl as ctb 
								on b.teacherid = ctb.counselorid
							where ctb.counselorid = '{$cid}'
								and b.date_time like '%{$date}%'";

				// $data['cdata'] = $this->Mainprocs->__getdata(false,$sql);	
				$thetime = $this->Mainprocs->__getdata(false,$sql);	

				$data['time'] = [];
				if (count($thetime) > 0) {
					foreach($thetime as $time) {
						array_push( $data["time"], date("h:i A", strtotime($time->date_time)) );
					}
				}
			}

			// echo json_encode($cdata);
 	
			// $this->load->view("counselor/counsspecs/timeskeds",$data);
			$this->load->view("counselor/counsspecs/timeslot",$data);
		}

		function getclassroom() {
			$stdid = $this->session->userdata("compid");

			$this->load->model("Mainprocs");

			$sql 	  = "select * from booking as b 
							JOIN classroom as cr on 
								b.bl_id = cr.bookingid
							where 
								b.studentid = '{$stdid}' 
								and b.status = '1' 
								and b.bookingtype = '1'
								ORDER BY bl_id DESC";

			$booking  = $this->Mainprocs->__getdata(false,$sql);

			$sesid  = null;
			$token  = null;
			$apikey = null;

			if (count($booking) > 0) {
				$sesid  = $booking[0]->sessionid;
				$token  = $booking[0]->token;
				$apikey = $booking[0]->apikey;
			}

			echo json_encode( ["sessid"		 => $sesid,
							   "token"		 => $token,
							   "classroomid" => $booking[0]->classroomid,
							   "apikey"		 => $apikey] );
			// echo json_encode($booking);
		}

		function bookmecounselor() {
			$info 			= $this->input->post("info");

			$this->load->model("Mainprocs");

			$studentid 		= $this->session->userdata("compid");
			$counserlord	= $info['cid'];
			$datetime  		= date("Y-m-d H:i:s", strtotime($info['datetime']));
			$dateofbooking  = date("Y-m-d");
			$status 		= 1;
			$timezone 		= $info['timezone'];
			$keycode 	 	= $this->Mainprocs->createuniquenumber(date("Y-m-d H:i:s").$this->session->userdata('userid').$counserlord,30);

			$purpose 		= $info['purpose'];

			$token 			= json_decode($info['token']);
			$sesid 			= json_decode($info['sessionId']);
			$apiKey 		= $info['apiKey'];
/*
// apiKey: "46211702"
$counserlord = "4g4g4g4g";
$datetime    = "May 1, 2019 03:00 PM";
$purpose     = "dfgdfg";
$sesid       = "2_MX40NjIxMTcwMn5-MTU1MjE3NTgwNzY0NX50U1lrSUEranNtb1RGMWdleGdLVVpRWlh-fg";
$timezone    = "Asia/Manila";
$token       =  "T1==cGFydG5lcl9pZD00NjIxMTcwMiZzaWc9YjI1NzM3ZWRkNjBiYjBjZGUyMjk3NTEzZmM4YzYzMGZmNjJjMmUzNTpzZXNzaW9uX2lkPTJfTVg0ME5qSXhNVGN3TW41LU1UVTFNakUzTlRnd056WTBOWDUwVTFsclNVRXJhbk50YjFSR01XZGxlR2RMVlZwUldsaC1mZyZjcmVhdGVfdGltZT0xNTUyMTgyMTE5JnJvbGU9cHVibGlzaGVyJm5vbmNlPTE1NTIxODIxMTkuMTI2NTQ2OTI0MDYzMA==";
			// $this->Mainprocs->createuniquenumber(date("Y-m-d H:i:s").$this->session->userdata('userid').$teacher,30);
*/
			$values = [
				"studentid"			=> $studentid,
				"teacherid"			=> $counserlord,
				"date_time"			=> $datetime,
				"dateofbooking"		=> $dateofbooking,
				"status"			=> $status,
				"timezone"			=> $timezone,
				"keycode"			=> $keycode,
				"bookingtype"		=> "1",
				"bookingreason"		=> $purpose
			];

			
			$save = $this->Mainprocs->__store("booking",$values);

//			if ($save) {
				$blid = $this->Mainprocs->__getdata("booking",["bl_id"],["keycode"=>$keycode]);
				$blid = $blid[0]->bl_id;

				$classroomid = $blid.$studentid.$counserlord;

				$save = $this->Mainprocs->__update("classroom",
													["token"	=> $token,
													 "sessionid"=> $sesid,
													 "apikey" 	=> $apiKey],
													["classroomid"=>$classroomid]);
//			}
			echo json_encode($save);

		}
// end processes
	// =============================================

		function checkforbooking() {
			$info = $this->input->post("info");

			$stid = $this->session->userdata("compid");
			$cid  = $info['cid'];
			$dt   = $info['datetime'];

		//	$cid  = "5g5g5g5g";
		//	$dt   = "January 1, 2010 02:00 PM";

			$this->load->model("Mainprocs");

			$sql = "select * from booking 
						where teacherid = '{$cid}'
							and studentid = '{$stid}'
							and date_time = '{$dt}'";
// echo $sql;
			$item  = $this->Mainprocs->__getdata(false,$sql);

			$ret   = 0;
			if (count($item) > 0) {
				$ret = $item;
			}
			echo json_encode( $ret);
		}

		function showbookslot() {
			$this->load->view("counselor/counsspecs/bookslot");
		}

		function showcall() {
			$crid 		  =  $this->input->post("crid");
			$data['crid'] = $crid;
			$this->load->view("counselor/calling",$data);
		}

		function markcomplete() {
			$this->load->model("Mainprocs");

			$blid   = $this->input->post("blid");

			echo json_encode( $this->Mainprocs->__update("booking",["status"=>4],["bl_id"=>$blid]) );

		}

		function fillnotes($stdid = '') {
			if ($stdid == '') { return; }

			$this->load->model("Mainprocs");

			$info = $this->Mainprocs->__getdata("studenttbl",
												["name"],
												['studentid'=>$stdid]);

			if (count($info) == 0) { return; }

			$data['name']  = $info[0]->name;
			$data['stdid'] = $stdid;

			$data['mats'] = $this->Mainprocs->__getdata("materials",["*"]);
			
			$this->load->view("counselor/counsspecs/fillnotes",$data);
		}

		function savenotes() {
			$info 		  = $this->input->post("info");
			$note 		  = $info['note'];
			$rec_mat 	  = $info['recmat'];
			$stdid 		  = $info['stdid'];
			$counsid 	  = $this->session->userdata("compid");
			$status 	  = 0;
 			
 			$this->load->model("Mainprocs");
 			$cnid 		  = $this->Mainprocs->createuniquenumber(date("mdyHisA").$stdid.$counsid,11);
			
			$values = ["cnid"			=> $cnid,
					   "couns_note" 	=> $note,
					   "rec_mat"  		=> $rec_mat,
					   "studentid"		=> $stdid,
					   "counselorid"	=> $counsid,
					   "status"			=> $status];

			if (isset($info['cnid'])) {
				$update = $this->Mainprocs->__update("counselornote",$values,["cnid"=>$info['cnid']]);
			} else {
				$save   = $this->Mainprocs->__store("counselornote",$values);
			}

			echo json_encode($cnid);
		}

		// enroll functions
		function enrollwindow() {
			$info  = $this->input->post("info");
			$stdid = $info['stdid'];

			$this->load->model("Mainprocs");
			$this->load->model("Paymentmodel");

			$data['inf'] = $this->Mainprocs->__getdata("studenttbl",
														['name'],
														["studentid"=>$stdid]);

			if (count($data['inf']) == 0) { die ("No student found"); }

			$periodtoday 		   = date("Y-m-d");
			$data['paymentstatus'] = $stat = $this->Paymentmodel->checkvalidity($periodtoday,$stdid);

			$data['class'] = ($stat == "valid")?"valid_stat":"invalid_stat";
			$this->load->view("counselor/enroll/enrollwindow",$data);
		}

		function enrollnow() {
			$datestart = date("Y-m-d");
			$dateend   = date("Y-m-d",strtotime("+30 days",strtotime($datestart)));
			
			$info 	   = $this->input->post("info");
			$personid  = $info['stdid'];
			$subtype   = $info['subtype'];

			$counsid   = $this->session->userdata("compid");

			$freetrial = ["paymentTransId"	  => "free trial",
						  "studentId"		  => $personid,
						  "amount"			  => "free",
					   	  "paymentMode"		  => "Counselor Free Trial",
						  "paymentDetails"	  => "free trial",
						  "subscriptionType"  => $subtype,
						  "periodStart"		  => $datestart,
						  "periodEnd"		  => $dateend,
						  "status"			  => 1,
						  "modifiedBy"		  => $counsid,
						  "inputDate"		  => $datestart
						];

			$this->load->model("Mainprocs");
			$trial = $this->Mainprocs->__store("paymenttbl",$freetrial);
			echo json_encode($trial);
			// add free trial period 
		}

		function addstudent() {
			$this->load->view("counselor/couns/addstudent");
		}

		function addnewstudent() {
			$info   = $this->input->post("stdata");

			$fname  = $info['fname'];
			$email  = $info['email'];
			$pwd    = $info['pwd'];
			$lep    = $info['lep'];
			$cp     = $info['cp'];
			$stttp  = $info['stttp'];
/*
			$fname  = "new student input";
			$email  = "new@gmail.com";
			$pwd    = "123";
			$lep    = "2";
			$cp     = "2";
			$stttp  = "2";
*/
			$this->load->model("Mainprocs");

			$word     = date("mdyHisA").$email.$fname;
			$uniqueid = $this->Mainprocs->createuniquenumber($word,9);

			$userinfo = ["username"		=> $email,
						 "password"		=> md5($pwd),
						 "type"			=> 1,
						 "isloggedin"	=> 0,
						 "status"		=> 1,
						 "uniqueid"		=> $uniqueid];

			$save   = $this->Mainprocs->__store("users",$userinfo);

			if ($save) {
				$std_dets = ["studentid"	 => $uniqueid,
							 "name"			 => $fname,
							 "userid"		 => $uniqueid,
							 "skypename"	 => null,
							 "lep_lvl"		 => $lep,
							 "cp_choice"	 => $cp,
							 "stttp_choice"	 => $stttp];
				$save = $this->Mainprocs->__store("studenttbl",$std_dets);
			}
			echo json_encode($save);
		}
		// end 

		public function checkdup() {
			$email = $this->input->post("email_");

			$this->load->model("Mainprocs");

			$check = $this->Mainprocs->__getdata("users",["uid"],["username"=>$email]);

			$return = false;
			if (count($check) == 0) {
				$return = true;
			} 
			echo json_encode($return);
		}
	}

?>