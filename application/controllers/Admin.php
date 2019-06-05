<?php 
	
	class Admin extends CI_Controller {
		private $type;

		public function index() {
			$this->load->model("Mainprocs");
			$this->Mainprocs->secure();

			$data['title']   = "| Admin Dashboard";
			$data['content'] = "admin/dashboard";
			$data['headscript']['style'][] = base_url()."style/dashboard.student.style.css";

			$this->load->view("includes/main",$data);	
		}

		public function students($type = '') {
			$this->load->model("Mainprocs");
			$this->Mainprocs->secure();

			$data['title']	  			    = " Admin | Student ";
			$data['content']  			    = "admin/student";

			$data['headscript']['js'][]	    = base_url()."procs/student.procs.js";
			$data['headscript']['style'][]	= base_url()."style/admin/materials.style.css";
			$data['headscript']['style'][]  = base_url()."style/admin/student.style.css";

			/*
			$sql_ = "select 
							st.name, 
							st.studentid, 
							l.lep_lvl, 
							pt.subscriptionType 
						from studenttbl as st 
						JOIN (select distinct(studentid), subscriptionType as studentid from paymenttbl) as pt on st.studentid = pt.studentid
						JOIN leplvl as l on st.lep_lvl = l.lep_id 
						JOIN cpchoice as c on st.cp_choice = c.cpchoice_id 
						JOIN stttptbl as s on st.stttp_choice = s.stttp_id";
			*/

			$sql_ = "select 
							st.name, 
							st.studentid, 
							l.lep_lvl 
						from studenttbl as st 
						JOIN (select distinct(studentid) from paymenttbl where status = '0') as pt on st.studentid = pt.studentid
						JOIN leplvl as l on st.lep_lvl = l.lep_id 
						JOIN cpchoice as c on st.cp_choice = c.cpchoice_id 
						JOIN stttptbl as s on st.stttp_choice = s.stttp_id";

			if ($type == 'expired') {
				// 2019-07-14
				$datetoday = date("Y-m-d");
				$sql_ = "select 
							st.name, 
							st.studentid, 
							l.lep_lvl 
						from studenttbl as st 
						JOIN (select max(p_inc_id), studentid from paymenttbl where periodEnd < '{$datetoday}') as pt on st.studentid = pt.studentid
						JOIN leplvl as l on st.lep_lvl = l.lep_id 
						JOIN cpchoice as c on st.cp_choice = c.cpchoice_id 
						JOIN stttptbl as s on st.stttp_choice = s.stttp_id";
			} else if ($type != ''){
				die("whoooaa.. we don't know what you are looking for");
			}

			$data['student'] = $this->Mainprocs->__getdata(false, $sql_);
			
			$this->load->view("includes/main",$data);			
		}

		public function teachers() {
			$this->load->model("Mainprocs");
			$this->Mainprocs->secure();

			$data['title']	  			   = " Admin | Teachers ";
			$data['content']  			   = "admin/teachers";
			$data['headscript']['style'][] = base_url()."style/admin/materials.style.css";
			$data['headscript']['style'][] = base_url()."style/admin/student.style.css";
			$data['headscript']['style'][] = base_url()."style/admin/teacher.style.css";
			
			$data['headscript']['js'][]	   = base_url()."procs/teachers.js";

			$sql_ = "select 
							*
						from teachertbl as ts";

			$data['teachers'] = $this->Mainprocs->__getdata(false, $sql_);
			
			$this->load->view("includes/main",$data);
		}
		
		public function showteacherwindow() {
			$teacherid = $this->input->post("teacherid_");

			$this->load->model("Mainprocs");

			$sql = "select * from teachertbl as tb 
					JOIN users as u on 
					tb.teacherid = u.uniqueid 
					where tb.teacherid = '{$teacherid}'";

			$data = $this->Mainprocs->__getdata(false,$sql);
			$data['data'] = $data;
		
			$this->load->view("admin/addteacher/teacherwindow",$data);
		}
		
		public function setactive() {
			$teacherid  = $this->input->post("teacherid_");
			$status     = $this->input->post("setto");

			switch ($status) {
				case 'active':
					$status = 1;
					break;
				
				case 'inactive':
					$status = 0;
					break;
			}

			$this->load->model("Mainprocs");
			$update = $this->Mainprocs->__update("users",["status"=>$status],["uniqueid"=>$teacherid,"connector"=>"and","type"=>2]);

			echo json_encode($update);
		}

		public function addteacher() {
			$tid 		= $this->input->post("tid");
			$tname 		= $this->input->post("tname");
			$ttypeid 	= $this->input->post("ttypeid");
			$t_age 		= $this->input->post("t_age");
			$tyexp 		= $this->input->post("tyexp");
			$trate 		= $this->input->post("trate");
			$tper 		= $this->input->post("tper");
			$tskypeid 	= $this->input->post("tskypeid");
			$tdept 		= $this->input->post("tdept");
			$temail 	= $this->input->post("temail");
			$tpword 	= $this->input->post("tpword");

			// get userid from js
			$userid 	= $this->input->post("userid");

			$this->load->model("Mainprocs");
			$this->Mainprocs->secure();

			// check email duplicate 
				//$email = $this->Mainprocs->__getdata("users",['uniqueid'],['username'=>$temail]);

				//if (count($email)==0) {
					// $userid = $this->Mainprocs->createuniquenumber(md5($temail),9);
					$valuesttbl = ["name" 			=> $tname,
								   "availability"	=> 1,
								   "age"			=> $t_age,
								   "exp"			=> $tyexp,
								   "dept"			=> $tdept,
								   "skypename"		=> $tskypeid,
								   "teachertype"	=> $ttypeid,
								   "startdate"		=> date('Y-m-d'),
								   "rate"			=> $trate,
								   "per"			=> $tper];

					// save to teacher table
					// $save = $this->Mainprocs->__store("teachertbl",$values);

					   $wheretbl = ["teacherid"=>$userid];
					   $update   = $this->Mainprocs->__update("teachertbl",$valuesttbl,$wheretbl);

					if ($update) {
						// save to users table
						$values = ["username" 	=> $temail,
								   "type"	  	=> 2,
								   "isloggedin"	=> 1,
								   "status"		=> 0];

						// "uniqueid"	=> $userid
						if ($tpword != null || strlen($tpword) != 0) {
							$values["password"] = md5($tpword);
						}

						$where = ["uniqueid"=>$userid];
						// $save = $this->Mainprocs->__store("users",$values);
						$update  = $this->Mainprocs->__update("users",$values,$where);
					}

					echo json_encode($update);
				/*
				} else {
					echo json_encode("dup_mail");
				}
				*/
			//end email duplicate 
		}
		
		public function reports($from = null) {
			if ($from == null){ 
				echo "<p> Please select from either student or teacher </p>";
				return;
			}
			
			$this->load->model("Mainprocs");
			$this->Mainprocs->secure();
			
			$data['title']	  			   = " Admin | Reports ";
			$data['content']  			   = "admin/reports";
			$data['headscript']['style'][] = base_url()."style/admin/student.style.css";
			$data['headscript']['style'][] = base_url()."style/admin/adminreport.style.css";
			$data['headscript']['js'][]	   = base_url()."procs/admin.reports.procs.js";
			
			if ($from == "student") {
				$rep_sql 		  = "select 
										t.*,
										s.name as name,
										s.lep_lvl,
										case 
											when t.status = 0 then 'open'
											when t.status = 1 then 'closed'
											else 'something wrong'
										end as t_status
										 from troublereports as t 
									 JOIN studenttbl as s on t.reporterid = s.studentid 
									 JOIN booking as b on t.trbclassid = b.bl_id";
				
			} else if ($from == "teacher") {
				$rep_sql 		  = "select 
										t.*,
										tt.name as name,
										case 
											when t.status = 0 then 'open'
											when t.status = 1 then 'closed'
											else 'something wrong'
										end as t_status
										 from troublereports as t 
									 JOIN teachertbl as tt on t.reporterid = tt.teacherid 
									 JOIN booking as b on t.trbclassid = b.bl_id";
			}
			
			$data['reports']  = $this->Mainprocs->__getdata(false,$rep_sql);
			$data['from']	  = $from;		
			$this->load->view("includes/main",$data);
		}

		public function materials($dowhat = '', $matid = '' ) {
			$this->load->model("Mainprocs");
			$this->Mainprocs->secure();

			$data['title']	  			    = " Admin | Reports ";
			$data['headscript']['style'][]	= base_url()."style/student.style.css";
			$data['headscript']['style'][]	= base_url()."style/admin/materials.style.css";
			// $data['headscript']['style'][] = base_url()."style/admin/student.style.css";

			if ($dowhat == '') {
				$mat_sql 						= "select * from materials as m 
													LEFT JOIN materials_details as md 
														on m.mat_id = md.mat_head_id";
				$materials  					= $this->Mainprocs->__getdata(false,$mat_sql);

				$heads  = [];
				
				foreach($materials as $ms) {
					$heads[$ms->mat_id] = ["mat_id"=>$ms->mat_id,
										   "mattxt"=>$ms->mat_headtext,
										   "matlvl"=>$ms->matlvl,
										   "matcol"=>$ms->matcol];
				}
				
				$data['heads'] 	   = $heads;
				$data['materials'] = $materials;
				/*
				$sorted = array_map(function($a){
				$b = [];	
						if (count($b)==0) {
							array_push($b,$a->mat_id);
						} else {
							
						}
					return $b;
				},$materials,$b);

				var_dump($sorted);
				*/
				// $data['materials']			= $this->Mainprocs->__getdata(false,$mat_sql);
				$data['content']  			    = "admin/materials";
			} else if ($dowhat == 'add') {
				$data['headscript']['js'][]		= base_url()."procs/addmaterial.js";
				
				$data['content']  			    = "admin/materialadd";
			}

			$this->load->view("includes/main",$data);
		}

		public function loadaddmat() {
			$this->load->model("Mainprocs");

			$matid  		  = $this->input->post("matid");
			$allow 			  = $this->input->post("allow");

			$data  			  = null;

			$data['allow']    = $allow;
			$data['matcount'] = $this->Mainprocs->__getdata(false,"select count(mat_id) as cnt from materials")[0]->cnt;

			if ($matid != null) {
				$data['mats']     = $this->Mainprocs->__getdata("materials","all",["mat_id"=>$matid]);
			}

			$this->load->view("admin/addmaterialcomponents/addmaterialhead",$data);
		}

		public function listofmats() {
			$this->load->model("Mainprocs");

			$data['mats']    = $this->Mainprocs->__getdata("materials","all");

			$this->load->view("admin/addmaterialcomponents/listofmats",$data);	
		}

		public function modules() {
			$this->load->model("Mainprocs");

			$matid = $this->input->post("matid");
			
			if ($matid == null) return;

			$data  = null;

			$sql   = "select * from materials as m 
					  join materials_details as md 
					  	on m.mat_id = md.mat_head_id
					  where m.mat_id = '{$matid}'";

			$data['mods']  = $this->Mainprocs->__getdata(false,$sql);
			$this->load->view("admin/addmaterialcomponents/modules",$data);	
		}

		public function add_module_pop() {
			$this->load->model("Mainprocs");

			$modid = $this->input->post("modid");

			$data  = null;
			$data['mod_count'] = $this->Mainprocs->__getdata(false,"select count(mat_det_id) as cnt from materials_details")[0]->cnt;
			if ($modid != null) {
				$data['modules']  = $this->Mainprocs->__getdata("materials_details","all",["mat_det_id"=>$modid]);
			}

			$this->load->view("admin/addmaterialcomponents/module_pop",$data);	
		}

		public function delete() {
			$what  = $this->input->post("deletewhat");
			$matid = $this->input->post("ids_")['mat'];
			$modid = $this->input->post("ids_")['mod'];

			$this->load->database();

			$res = null;
			if ($what == "material") {
				// delete material and module
				$sql_dels = ["delete from materials where mat_id = '{$matid}'",
							 "delete from materials_details where mat_head_id = '{$matid}'"];
				foreach($sql_dels as $d) {
					$res = $this->db->query($d);
				}
				$this->db->close();
			} else if ($what == "module") {
				// delete module
				$sql = "delete from materials_details where mat_det_id = '{$modid}'";
				$res = $this->db->query($sql);
				$this->db->close();
			}
			echo json_encode($res);
		}

		public function addthismodule() {
			$title   = $this->input->post("module")['_title'];
			$order   = $this->input->post("module")['order'];
			$content = $this->input->post("module")['_content'];
			$matid   = $this->input->post("matid");
	
			$files   = json_encode( $this->input->post("module")["file"] );
			
			$mod_id  = $this->input->post("module")['modid'];

			$this->load->model("Mainprocs");
			$res   = null;
			$table = "materials_details";
			if ($mod_id == null) {
				// insert 
				$values = ["mat_mod_title" => $title,
						   "mat_det"       => $content,
						   "matmodorder"   => $order,
						   "mat_head_id"   => $matid,
						   "matfiles"	   => $files];
				$res 	= $this->Mainprocs->__store($table,$values);
			} else {
				// update
				$values = ["mat_mod_title" => $title,
						   "mat_det"       => $content,
						   "matmodorder"   => $order,
						   "matfiles"	   => $files];
				$res    = $this->Mainprocs->__update($table,$values,['mat_det_id'=>$mod_id]);
			}
			echo json_encode($res);
		}

		public function addthismaterial() {
			$this->load->model("Mainprocs");
			$this->Mainprocs->secure();

			$mathead = $this->input->post("mats")['mathead'];
			$matlvl  = $this->input->post("mats")['matlvl'];
			$matcap  = $this->input->post("mats")['matcap'];
			$matcol  = $this->input->post("mats")['matcol'];
			$order   = $this->input->post("mats")['order']; 
			$matid   = $this->input->post("mats")['matid'];

			$table  = "materials";

			$rets   = null;
			if ($matid == null) {
				// insert	
				$values = ["mat_headtext"=> $mathead,
						   "matlvl"		 => $matlvl,
						   "matcapt"	 => $matcap,
						   "matcol"		 => $matcol,
						   "matorder"	 => $order];

				$rets = $this->Mainprocs->__store($table,$values);
			} else {
				$up_vals = ["mat_headtext"=> $mathead,
						   "matlvl"		 => $matlvl,
						   "matcapt"	 => $matcap,
						   "matcol"		 => $matcol,
						   "matorder"	 => $order];
				$rets = $this->Mainprocs->__update($table,$up_vals,["mat_id"=>$matid]);
			}
			
			echo json_encode($rets);
		}

		public function payslips() {
			$this->load->model("Mainprocs");
			$this->Mainprocs->secure();

			$data['title']	  			   = " Admin | Payslisp ";
			$data['content']  			   = "admin/payslips";

			$data['headscript']['style'][] = base_url()."style/admin/student.style.css";
			$data['headscript']['style'][] = base_url()."style/admin/payslip.style.css";
			
			$data['headscript']['js'][]	   = base_url()."procs/payroll.js";			
			$sql_ = "select 
							*
						from teachertbl as ts";

			$data['teachers'] = $this->Mainprocs->__getdata(false, $sql_);

			$this->load->view("includes/main",$data);
		}

		public function replenish_window() {
			$studentid = $this->input->post("stdid");
			$timezone  = $this->input->post("timezone");

			date_default_timezone_set($timezone);
			date_default_timezone_get();

			$periodtoday = date("Y-m-d");

			$this->load->model("Paymentmodel");
			$data['info'] 	  = $this->Paymentmodel->getpaymentdetails($periodtoday,$studentid);

			$valid 			  = $data['isvalid'] = $this->Paymentmodel->checkvalidity($periodtoday,$studentid);
			$data['validity'] = ($valid == "valid")?"<div class='coloritblue'><p class=''> SUBSCRIPTION VALID </p></div>":"<div class='coloritgrey'><p class=''> EXPIRED </p></div>";


			$this->load->view("admin/addstudent/replenish",$data);
		}

		public function replenish() {
			$studentid   = $this->input->post("studentid");
			$dateofext_  = $this->input->post('dateofext_');
			$pre_val 	 = $this->input->post("pre_val");
			$payid   	 = $this->input->post("payid");
			$transnum    = $this->input->post("transnum");
			$numofmos_js = $this->input->post("numofmos");
			
			$modifiedBy = $this->session->userdata("userid");

			$this->load->model("Mainprocs");

			date_default_timezone_set("asia/manila");
			date_default_timezone_get();

			$stats = null;
			
			$name    = null;
			$subtype = null;
			$bcode   = null;
			$nummos  = null;
			$amnt    = null;
			$email   = null;
			
			if ($payid == null) {
				// save 
				$paymenttransid  = $this->Mainprocs->createuniquenumber(date("mdYHis").$transnum);
				$val = ["paymentTransId"	=> $paymenttransid,
						"studentId"			=> $studentid,
						"amount"			=> "0000",
						"paymentMode"		=> "b2b",
						"paymentDetails"	=> $transnum,
						"subscriptionType"	=> "special",
						"periodStart"		=> $pre_val,
						"periodEnd"			=> date("Y-m-d", strtotime($dateofext_)),
						"status"			=> 1,
						"modifiedBy"		=> $modifiedBy,
						"inputDate"			=> date("Y-m-d h:i:s A"),
						"numofmos"			=> $numofmos_js
						];
				$stats = $this->Mainprocs->__store("paymenttbl",$val);
				
				//$stsql = "select ";
				
				/*
				$name    = $stdata[0]->name;
				$subtype = $stdata[0]->subscriptionType;
				$bcode   = $transnum;
				$nummos  = $stdata[0]->numofmos;
				$amnt    = $stdata[0]->amount;
				$email   = $stdata[0]->username;
				*/
			} else {
				// update
				$val   = ["status"   => 1];
				$where = ["p_inc_id" => $payid];
				$stats = $this->Mainprocs->__update("paymenttbl",$val,$where);
				
				$stsql  = "select 
							st.name,
							p.subscriptionType,
							p.paymentDetails,
							p.numofmos,
							p.amount,
							u.username
						from studenttbl as st 
							RIGHT JOIN paymenttbl as p on st.studentid = p.studentid 
							JOIN users as u on st.studentid = u.uniqueid
						where p.p_inc_id = {$payid}";
						
				$stdata = $this->Mainprocs->__getdata(false,$stsql);
				
				if (count($stdata)==0) { return false; }
			
				$name    = $stdata[0]->name;
				$subtype = $stdata[0]->subscriptionType;
				$bcode   = $stdata[0]->paymentDetails;
				$nummos  = $stdata[0]->numofmos;
				$amnt    = $stdata[0]->amount;
				$email   = $stdata[0]->username;
				
			}
			 
			$this->load->model("Emailtemplates");
			$this->Emailtemplates->data['name'] 	= $name;
			$this->Emailtemplates->data['subtype']  = $subtype;
			$this->Emailtemplates->data['bcode']    = $bcode;
			$this->Emailtemplates->data['nummos']   = $nummos;
			$this->Emailtemplates->data['amnt']     = $amnt;
			$temp 									= $this->Emailtemplates->thankyou();
			 
			$details['from_msg'] = "A New World - Admin";
			$details['to'] 		 = $email;
			$details['subject']  = "Thank you for your patronage - {$bcode}";
			$details['msg'] 	 = $temp;
			
			$mail = $this->Mainprocs->sendemail($details);
			
			echo json_encode($stats);
		}
		
		public function changemos() {
			$month = $this->input->post("numofmos");
			$payid = $this->input->post("payid");
			
			$this->load->model("Mainprocs");
			// __update($table, $values, $where = false)
			$update = $this->Mainprocs->__update("paymenttbl",
												 ['numofmos'=>$month],
												 ['p_inc_id'=>$payid]);
			echo json_encode($update);
		}
	}
?>