<?php 

	class Teacher extends CI_Controller {
		public function index() {
			$data['title'] 		= "| Teacher Portal";
			$data['content']	= "tutor/tutorskeds";

			$data['headscript']['style'][] = base_url()."style/admin/materials.style.css";
			$data['headscript']['style'][] = base_url()."style/student.style.css";
			$data['headscript']['style'][] = base_url()."style/teacher/teacher.style.css";

			$data['headscript']['js'][]	   = base_url()."procs/teacher.panel.js";
			$data['headscript']['js'][]	   = base_url()."procs/schedule.proc.js";

			$this->load->model("Loginmodel");
			$login = $this->Loginmodel->logmein();
			
				if ($login == true) {
					if ($this->session->userdata("type") == 2) { // teacher
						$this->load->view("includes/main",$data);
					} else if ($this->session->userdata("type") == 3) { // admin
						redirect(base_url()."admin",'refresh');
					} else if ($this->session->userdata("type") == 1) { // student
						redirect(base_url(),'refresh');
					}
				}
			
		}

		public function startclock() {
			$timezone = $this->input->post("timezone");

			date_default_timezone_set($timezone);
			date_default_timezone_get();

			$data['time']	= date("h:i:s A");
			$data['date']	= date("F d, Y");

			$this->load->view("tutor/tutorcomponents/theclock",$data);
		}

		public function getbookings() {
			$this->load->model("Teachermodel");
			$this->load->model("Mainprocs");

			$teacherid = $this->session->userdata("userid");

			$thedate   = $this->input->post("thedate");

			if ($thedate == null) {
				$thedate = date("Y-m-d");
			}

			$sql  = "select b.*, st.name from booking as b join studenttbl as st 
						on b.studentid = st.userid 
							where b.teacherid = '{$teacherid}' 
							and cast(date_time as DATE) = '{$thedate}'
							and status <= 1";

			$data = $this->Mainprocs->__getdata(false,$sql);

			$b = array_map(function($a){
				return ["time"    => date("g:i A",strtotime($a->date_time)),
						"student" => $a->name, 
						"std_id"  => $a->studentid,
						"bl_id"   => $a->bl_id];
			},$data);

			$data['data'] = $b;

			// attendance status 
			$data['attendance'] = null;
				//$att_stat = $this->Mainprocs->__getdata("t_anvailstat",["skedid"],["teacherid"=>$teacherid,"thedate"=>$thedate]);
				
				$sql 	  = "select thedate,skedid from t_anvailstat where teacherid = '{$teacherid}' and thedate like '%{$thedate}%'";
				$att_stat = $this->Mainprocs->__getdata(false,$sql);

				if (count($att_stat)==0) {
					$data['attendance'] = "present";
				} else {
					// $data['attendance'] = $att_stat[0]->skedid;
					$data['attendance']    = $att_stat;
				}
			// end attendance status

			$this->load->view("tutor/tutorcomponents/teachertime",$data);
		}

		public function attendance() {
			$timezone = $this->input->post("timezone");
			$date     = $this->input->post("thedate");
			$att 	  = $this->input->post("att");
			$times    = $this->input->post("times");
			
			
			$teacherid = $this->session->userdata("userid");
		//	$timezone = "asia/manila";
			date_default_timezone_set($timezone);
			date_default_timezone_get();

			if ($date == null) {
				$date = date("Y-m-d");
			}

			$date 		 = date("Y-m-d",strtotime($date));

			$this->load->model("Mainprocs");
			
			$status 	 = null;
			$dateofinput = date("Y-m-d");
			$sql 		 = "";
			
			if ($att == "absent") {
				
				if (count($times)==0) {
						for ($hour = 1; $hour <= 24; $hour++) {
							for ($min = 0 ; $min <= 30; $min+=30 ) {
								if ($hour == 24 && $min == 30) {
									break;
								}
								$min = ($min == 0)?"00":$min;
								// $sql .= "insert into t_anvailstat (teacherid,thedate,dateofinput) values ('{$teacherid}','{$date} {$hour}:{$min}:00','{$dateofinput}');";
								$values = ["teacherid" 	 => $teacherid,
										   "thedate"	 => $date." ".$hour.":".$min,
										   "dateofinput" => date("Y-m-d")];

								$status = $this->Mainprocs->__store("t_anvailstat",$values);
							}
						}
				} else {
					$times = (array) $times;
					
					foreach($times as $t) {
						$timehere = date("H:i:s",strtotime($t));
						$ndate 	  = $date." ".$timehere;
						// $sql 	 .= "insert into t_anvailstat (teacherid,thedate,dateofinput) values ('{$teacherid}','{$ndate}','{$dateofinput}');";
						$values = ["teacherid" 	 => $teacherid,
								   "thedate"	 => $ndate,
								   "dateofinput" => date("Y-m-d")];

						$status = $this->Mainprocs->__store("t_anvailstat",$values);
					}
				}
				// $status = $this->Mainprocs->__store(false,$sql);
			} else if ($att == "present") {
				if (count($times)==0){
					$sql 	= "delete from t_anvailstat where teacherid = '{$teacherid}' and thedate like '%{$date}%'";
					$status = $this->Mainprocs->__run_q($sql);
				} else {
					$times = (array) $times;
					foreach($times as $t) {
						$timehere = date("H:i:s",strtotime($t));
						$ndate 	  = $date." ".$timehere;
						
						$sql 	= "delete from t_anvailstat where teacherid = '{$teacherid}' and thedate = '{$ndate}'";
						$status = $this->Mainprocs->__run_q($sql);
					}
				}
			}

			echo json_encode($status);
			
		}
		
		public function stddets() {
			$stdid = $this->input->post("stdid_");
			
			$this->load->model("Mainprocs");
			
			$sql   = "select 
						st.name,
						fb.feedback,
						cn.couns_note
						from studenttbl as st 
						RIGHT JOIN feedbacktable as fb 
							on st.studentid = fb.studentid 
						RIGHT JOIN counselornote as cn 
							on fb.studentid = cn.studentid 
						where 
							fb.fbid = (select max(fbid) from feedbacktable where studentid = '{$stdid}')
								and 
							cn.cnid = (select max(cnid) from counselornote where studentid = '{$stdid}')
								and
							st.studentid = '{$stdid}'";
			
			// add joining the teachers comments here 
			
			$data_ = $this->Mainprocs->__getdata(false,$sql);
			$data['data'] = $data_;
			$this->load->view("tutor/tutorcomponents/stddetails",$data);
		}
		
		public function declinethis() {
			$bl_id = $this->input->post("blid");
			
			$this->load->model("Mainprocs");
			$this->load->model("Emailtemplates");
			
			/*
			$update = ["status" => 2];
			$where  = ["bl_id" => $bl_id];
			
			$update = $this->Mainprocs->__update("booking",$update,$where);
			
			echo json_encode($update);
			*/
			
			$sql    = "select 
							st.name as tename,
							bk.date_time,
							u.username
						from studenttbl as st
						JOIN booking as bk on
							st.studentid = bk.studentid
						JOIN users as u on 
							st.studentid = u.uniqueid
						where bk.bl_id = '{$bl_id}'";
			$data   = $this->Mainprocs->__getdata(false,$sql);
			
			if (count($data)>=0) {
				$delete = $this->Mainprocs->__run_q("delete from booking where bl_id = '{$bl_id}'");
				
				$this->Emailtemplates->data['name']		= $data[0]->tename;
				$this->Emailtemplates->data['cdate']	= date("F d, Y h:i A", strtotime($data[0]->date_time));
				$this->Emailtemplates->data['stats']	= "Declined";
				$this->Emailtemplates->data['hex']		= "#4e4e4e";
				$template  								= $this->Emailtemplates->tostudent();

				$senddetails['from_msg'] = $data[0]->tename;
				$senddetails['to'] 		 = $data[0]->username;
				$senddetails['subject']  = "Your booking is Declined";
				$senddetails['msg'] 	 = $template;

				$email = $this->Mainprocs->sendemail($senddetails);
				
				echo json_encode($delete);
			}
		}
		
		public function register() {
			$data['title']					= "Teacher Register";
			$data['headscript']['style'][] 	= base_url()."style/teacher/register.style.css";
			$data['content']			    = "tutor/register";
			
			if (isset($_POST['regmenow'])) {
				
				$default_data = ["name"  => $_POST['fullname'],
								 "email" => $_POST['email'],
								 "skype" => $_POST['skype'],
								 "password" => $_POST['password'],
								 "yearsofexp" => $_POST['yearsofexp'],
								 "q1"    => $_POST['q1'],
								 "q2"    => $_POST['q2']
								];
				$data['def'] = $default_data;
				$this->load->model("Teachermodel");
				$ret = $this->Teachermodel->regteacher();
 
				if (!is_array($ret)) {
					echo "<p class='successtch'> You have successfully Applied for the teacher's position. Please wait for the admin to schedule you for an interview. </p> ";
				} else {
					echo "<div class='errordiv'>";
						echo $ret[1];
					echo "</div>";
				}
				
			}

			$this->load->view("includes/main",$data);
		}
		
		public function reports() {
			$data['title']	  = "Teacher Report";
			$data['headscript']['style'][]	= base_url()."style/report.style.css";
			$data['headscript']['style'][]	= base_url()."style/student.style.css";

			$data['headscript']['js'][]		= base_url()."procs/troublereport.procs.js";

			$data['content']				= "student/report";

			$this->load->view("includes/main", $data);	
		}

		public function payslip() {
			$data['title']	= "Teacher Payslip";
		//	$data['headscript']['style'][]	= base_url()."style/admin/payslip.style.css";
			$data['headscript']['style'][]	= base_url()."style/teacher/payslip.style.css";
			$data['headscript']['js'][]		= base_url()."procs/payslip.procs.js";

			$tid = $this->session->userdata("compid");

			$this->load->model("Mainprocs");

			$psql = "select * from payroll as p 
						join payrollperiod as pp
							on p.ppid = pp.ppid
						where p.tid = '{$tid}'";

			$pdata = $this->Mainprocs->__getdata(false,$psql);
// var_dump($pdata);
			$data['data'] = $pdata;

			$data['content'] = "tutor/payslip";
			$this->load->view("includes/main",$data);
		}

		public function materials() {
			$data['title']	 	= "|tutor materials";

			$data['headscript']['style'][]	= base_url()."style/student.style.css";
			
			$this->load->model("Mainprocs");			
			$mat_sql 					= "select * from materials as m 
													LEFT JOIN materials_details as md 
														on m.mat_id = md.mat_head_id";
			$materials  				= $this->Mainprocs->__getdata(false,$mat_sql);

			$heads  = [];
					
			foreach($materials as $ms) {
				$heads[$ms->mat_id] = ["mat_id"=>$ms->mat_id,
									   "mattxt"=>$ms->mat_headtext,
									   "matlvl"=>$ms->matlvl,
									   "matcol"=>$ms->matcol];
			}
					
			$data['heads'] 	   = $heads;
			$data['materials'] = $materials;

			$data['content']	= "student/materials";
		//	$data['content'] = "tutor/materials";
			$this->load->view("includes/main",$data);
		}

		public function students() {
			// $data['headscript']['style'][]	= base_url()."style/teacher/payslip.style.css";
			$data['headscript']['style'][]  = base_url()."style/teacher/mystudent.style.css";

			$data['title']	 = "| My Students";
			$data['content'] = "tutor/students";

			$this->load->model("Mainprocs");

			$tid 		= $this->session->userdata("compid");

			$datetoday 	= date("Y-m-d H:i:s");
			$sql 		= "select b.*, stb.name, cr.* from booking as b 
							JOIN studenttbl as stb 
								on b.studentid = stb.studentid 
							JOIN classroom as cr 
								on b.bl_id = cr.bookingid
							where b.teacherid = '{$tid}' 
								and date_time >= '{$datetoday}'";

			$data['lessons']    = $this->Mainprocs->__getdata(false,$sql);
			
			$this->load->view("includes/main",$data);
		}
		
	}

?>