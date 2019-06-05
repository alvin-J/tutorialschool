<?php 
	
	class Tutors extends CI_Controller {
		public function index() {
			$this->load->helper("url");

			$data['title']	= "- Tutors";	

			// listen to login 
				$this->load->model("Loginmodel");
				$login = $this->Loginmodel->logmein();
				if ($login == true) {
					$this->load->model("Mainprocs");

					// call the book JS 
						$data['headscript']['js'][]	= base_url()."procs/book.proc.js";					
					// end 

					$data['headscript']['style'][]	= base_url()."style/student.style.css";
					$data['headscript']['js'][]		= base_url()."procs/tutors.procs.js";
					$data['content']			    = "student/tutors";

					$studentid = $this->session->userdata("userid");
					$teacherid = null;

					$sql = "select * from bookmark as b 
							JOIN teachertbl as ttbl on b.teacherid = ttbl.teacherid
							where b.studentid = '{$studentid}'";
					$data['bookmarks'] = $this->Mainprocs->__getdata(false, $sql);

					$avs = "select * from teachertbl where availability != '0'";
					$data['availables'] = $this->Mainprocs->__getdata(false,$avs);

					$this->load->view("includes/main",$data);	
				}
			// end

		}

		public function bookmark() {
			$teacherid = $this->input->post("teacherid");

			$this->load->model("Mainprocs");
			$this->load->library("session");

			$studentid = $this->session->userdata("userid");

			$find   = $this->Mainprocs->__getdata("bookmark", "all",["studentid"=>$studentid,"teacherid"=>$teacherid]);

			$msg = "false";

			if (count($find)>=1) {
				// duplicate 
				$msg = "You have already bookmarked this teacher";
			} else {
				$stored = $this->Mainprocs->__store("bookmark", ["studentid"=>$studentid,"teacherid"=>$teacherid]);

				if ($stored) {
					$msg = "true";
				}
			}
			
			echo json_encode($msg);
		}

		public function bookmarked() {
			$this->load->model("Mainprocs");
			$this->load->library("session");
			$this->load->helper("url");

			$studentid = $this->session->userdata("userid");

			$sql = "select * from bookmark as b 
					JOIN teachertbl as ttbl on b.teacherid = ttbl.teacherid
					where b.studentid = '{$studentid}'";
			$data['bookmarks'] = $this->Mainprocs->__getdata(false, $sql);

			$this->load->view("student/bookmarked",$data);
		}
	}

?>