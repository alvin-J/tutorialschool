<?php
	
	class Maincontroller extends CI_Controller {
		public function index() {
			$this->load->helper("url");
			

			$data['title']		= "- Student";
			
			// listen to login 
				$this->load->model("Loginmodel");
				$login = $this->Loginmodel->logmein();
				if ($login == true) {
					if ($this->session->userdata("type") == 1) { // student
						// call the book JS 
							$data['headscript']['js'][]	= base_url()."procs/book.proc.js";				
						// end 

						// dashboard 
							$data['headscript']['js'][]	= base_url()."procs/dashboard.procs.js";					
						// end dashboard

						$data['headscript']['style'][] = base_url()."style/dashboard.student.style.css";
						
						$this->load->model("Mainprocs");
						// booked classes 
							$blsql 			= "select bl.*,te.name as name from booking as bl
												JOIN teachertbl as te 
													on bl.teacherid = te.teacherid 
												where bl.studentid = '{$this->session->userdata("userid")}' limit 4";
							$data['bclass'] = $this->Mainprocs->__getdata(false,$blsql);

						// boomarked teachers
							$sql 		 = "select * from bookmark as bm 
												JOIN teachertbl as te 
											on bm.teacherid = te.teacherid 
												where studentid = '{$this->session->userdata('userid')}'";
							$data['bl']  = $this->Mainprocs->__getdata(false,$sql);

						$stdid = $this->session->userdata("compid");
						$plsql = "select * from performanceledger 
									where pl_id = (select max(pl_id) from performanceledger 
													where groupid = '{$stdid}')";
						$data['pl_vals'] = $this->Mainprocs->__getdata(false,$plsql);

						// feedback
							$fb_sql = "select fbt.*,ttbl.name from feedbacktable as fbt 
										JOIN teachertbl as ttbl on 
											fbt.teacherid = ttbl.teacherid 
										where studentid = '{$stdid}'";
							$data['feedbacks'] = $this->Mainprocs->__getdata(false,$fb_sql);
						// end feedback

						$data['content'] = "student/dashboard";
						$this->load->view("includes/main",$data);
					} else if ($this->session->userdata("type") == 3) { // admin
						redirect(base_url()."admin",'refresh');
					} else if ($this->session->userdata("type") == 2) {
						redirect(base_url()."teacher",'refresh');
					} else if ($this->session->userdata("type") == 4) {
						redirect(base_url()."counselor/teacher",'refresh');
					}
					
				}
			// end

		}
	}
?>