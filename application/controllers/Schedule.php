<?php 
	
	class Schedule extends CI_Controller {
		public function index() {
			$this->load->helper("url");

			$data['title']					= "- Schedule";

			// listen to login 
				$this->load->model("Loginmodel");
				$login = $this->Loginmodel->logmein();
				if ($login == true) {
					// call the book JS 
						$data['headscript']['js'][]	= base_url()."procs/book.proc.js";					
					// end 

					// script invoking the function inside book.proc.js
						$data['headscript']['js'][]		= base_url()."procs/schedule.proc.js"; 	
					// :::::::::::::::::

					$data['headscript']['style'][]	= base_url()."style/student.style.css";
					$data['content'] 				= "student/schedule";

					// var_dump($period);
					
					$this->load->view("includes/main",$data);
				}
			// end
			
		}

		public function sked_dates() {
			// get the current timezone of the user base from its local computer's set timezone.
			$timezone = $this->input->post("timezone");

			date_default_timezone_set($timezone);
			date_default_timezone_get();

			$datetoday  = date("Y-m-d");
			$period 	= new DatePeriod(
							new DateTime( date('Y-m-d', strtotime($datetoday ." - 2 days")) ),
							new DateInterval("P1D"),
							new DateTime( date('Y-m-d', strtotime($datetoday ." + 3 days")) )
						);

			$data['period']	= $period;
			$this->load->view("student/scheduledate",$data);
		}

		public function daydivs() {
			$this->load->library('session');
			$this->load->model("Mainprocs");

			$thedate   = $this->input->post("thedate");
			$timezone  = $this->input->post("timezone_");

			date_default_timezone_set($timezone);
			date_default_timezone_get();

			$studentid = $this->session->userdata('userid');

			$sql     = "select * from booking where date_time like '%{$thedate}%' and studentid = '{$studentid}'";

			$data    = $this->Mainprocs->__getdata(false,$sql);

			$time = [];

			foreach($data as $d) {
				$time[] = date("h:i A", strtotime($d->date_time));
			}

			$data['timezone'] = $timezone;
			$data['today']    = date("Y-m-d H:i:s");

			$data['thedate']  = $thedate;
			$data['time'] 	  = $time;
			$this->load->view("student/daydivision",$data);
		}

		public function movedate() {
			$olddate = $this->input->post("olddate");
			$newdate = $this->input->post("newdate");

		#	$olddate = "2018-08-20";
		#	$newdate = "2018-08-21";	

			$direction = null;
			$move  	   = null;

			// old date
			$olddate = date("Y-m-d", strtotime($olddate));
			list($old_yy,$old_mm,$old_dd) = explode("-", $olddate );

			// new date 
			$newdate = date("Y-m-d", strtotime($newdate));
			list($new_yy, $new_mm, $new_dd) = explode("-", $newdate );

			$start = null; // start should be lesser the the end
			$end   = null; // end should be greater the the start

			if ($old_dd < $new_dd) {
				// pointing forward
				if ($old_mm < $new_mm) {
					// pointing forward
					if ($old_yy < $new_yy) {
						// pointing forward
						$direction = "right";
					} else if ($old_yy > $new_yy) {
						// pointing backward
						$direction = "left";
					} else if ($old_yy == $new_yy) {
						// pointing forward
						$direction = "right";
					}
				} else if ($old_mm > $new_mm) {
					if ($old_yy > $new_yy) {
						$direction = "left";
					} else if ($old_yy < $new_yy) {
						$direction = "right";
					} else if ($old_yy == $new_yy) {
						$direction = "left";
					}
				} else if ($old_mm == $new_mm) {
					// pointing forward 
					$direction = "right";
				}
			} else if ($old_dd > $new_dd) { 
				// backward
				if ($old_mm > $new_mm) {
					// backward 
					if ($old_yy	> $new_yy) {
						// backward
						$direction = "left";
					} else if ($old_yy < $new_yy) {
						// forward
						$direction = "right";
					} else if ($old_yy == $new_yy) {
						// pointing 
						$direction = "left";
					}
				} else if ( $old_mm < $new_mm ){
					// forward
					if ($old_yy	< $new_yy) {
						$direction = "right";	
					} else if ($old_yy > $new_yy) {
						$direction = "left";
					} else if ($old_yy == $new_yy) {
						$direction = "right";
					}
				} else if ($old_mm == $new_mm) {
					$direction = "left";
				}
			} else if ($old_dd == $new_dd) {
				$direction = null;
			}

			
			$start = strtotime($olddate);
			$end   = strtotime($newdate);

			$secs  = $start - $end;
			$move  = $secs/86400;

			$clickmove = round($move,0);
			$datemove  = 2; // advance 

			$unit      = null;

				if ( substr($clickmove,0,1) == '-' ) {
					$unit = "+";
					$clickmove = substr($clickmove, 1, strlen($clickmove));
				} else {
					$unit = "-";
				}

			$thedateis = date("Y-m-d", strtotime($newdate."{$unit} {$datemove} days"));

			$startdate = null;
			$enddate   = null;


			if ($direction == "right") {
				$startdate = $newdate;
				$enddate   = $thedateis;
			} else if ($direction == "left") {
				$startdate = $thedateis;
				$enddate   = $newdate;
			} else if ($direction == null) {
				// exit
			}

			/*
			echo "old date:".$olddate;
				echo "<br/>";
			echo "new date:".$newdate;
				echo "<br/>";
			echo "start:".$startdate;
				echo "<br/>";
			echo "end:".$enddate;
				echo "<br/>";
			*/

			$begin = new DateTime($startdate);
			$end = clone $begin;
			$end->modify($enddate); // 2016-07-08
			$end->setTime(0,0,1);     // new line
			$interval = new DateInterval('P1D');
			$daterange = new DatePeriod($begin, $interval, $end);

			$thedates = [];
			foreach($daterange as $date) {
			    $thedates[] = $date->format('Y-m-d');
			}

			#echo json_encode([$datestart,$move,$dir,$dateend]);
			echo json_encode([$thedates,$clickmove,$direction]);
		}

		public function substract() {
			$begin = new DateTime('monday this week'); //2016-07-04

			$end = clone $begin;

			// this will default to a time of 00:00:00    
			$end->modify('next friday'); // 2016-07-08

			$end->setTime(0,0,1);     // new line

			$interval = new DateInterval('P1D');
			$daterange = new DatePeriod($begin, $interval, $end);

			foreach($daterange as $date) {
			    echo $date->format('Y-m-d')."<br />";
			}
			$num = -1;
			echo intVal(floatVal($num));
		}
		
		public function displayoption() {
			$datetime = $this->input->post("date_");
			
			$this->load->library('session');
			$this->load->model("Mainprocs");
			
			$datetime = date("Y-m-d H:i:00", strtotime($datetime));
			$userid = $this->session->userdata("userid");
			$get    = ["date_time" => $datetime, "studentid" => $userid];
			
			$dat['data'] = $this->Mainprocs->__getdata("booking","all",$get);
			
			$this->load->view("student/skedview",$dat);
		}

		public function cancelbooking() {
			$bkid = $this->input->post("bkid_");
			
			$this->load->model("Mainprocs");
			$this->load->model("Emailtemplates");
				
			$gsql = "select 
						b.date_time, 
						b.dateofbooking,
						st.name as studentname,
						tb.username as email 
					 from booking as b 
						JOIN studenttbl as st on b.studentid = st.studentid 
						JOIN users as tb on b.teacherid = tb.uniqueid 
					   where b.bl_id = {$bkid}";
					
			$data = $this->Mainprocs->__getdata(false,$gsql);
			
			$sql = "delete from booking where bl_id = '{$bkid}'";
			
			$ret = $this->Mainprocs->__run_q($sql);
			
			if ($ret) {
				$this->Emailtemplates->data['name']   = $data[0]->studentname;
				$this->Emailtemplates->data['cdate']  = $data[0]->date_time;
				$this->Emailtemplates->data['bldate'] = $data[0]->dateofbooking;
				
				$template = $this->Emailtemplates->cancelbooking();
				
				$cdate_   = date("F d, Y h:i A", strtotime($data[0]->date_time));
				$details["from_msg"] = $data[0]->studentname;
				$details["to"] 		 = $data[0]->email;
				$details["subject"]  = "Booking on {$cdate_} is Cancelled by {$data[0]->studentname}";
				$details["msg"] 	 = $template;
				$ret 				 = $this->Mainprocs->sendemail($details);
			}
			
			echo json_encode($ret);
		
		}
	}

?>