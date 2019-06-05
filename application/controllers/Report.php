<?php 
	
class Report extends CI_Controller {

		public function index() {
			$this->load->helper("url");

			$data['title']	= "- Trouble Report";	

			// listen to login 
				$this->load->model("Loginmodel");
				$login = $this->Loginmodel->logmein();
				if ($login == true) {
					$data['headscript']['style'][]	= base_url()."style/report.style.css";
					$data['headscript']['style'][]	= base_url()."style/student.style.css";

					$data['headscript']['js'][]	= base_url()."procs/troublereport.procs.js";

					$data['content']			= "student/report";

					$this->load->view("includes/main", $data);	
				}

		}

		public function getdata(){
			$this->load->model("Mainprocs");	


			$timezone = $this->input->post("timezone");

			date_default_timezone_set($timezone);
			date_default_timezone_get();
			
						
						$sql = "select * from reportquestions as tr 
								JOIN optionstbl as ot 
								on tr.optionsgprid = ot.optiongrpid";
						$reports = $this->Mainprocs->__getdata(false,$sql);

						$questions = [];

						foreach($reports as $r) {
							if ($r->position == 1) {
								$questions['header'][$r->optiongrpid][$r->trbid]['topquestion'] = $r->trbid." ".$r->question;	
								$questions['header'][$r->optiongrpid][$r->trbid]['optioname'][] = $r->optionsid." ".$r->optionname;
							} else if ($r->position == 2) {
								$questions['other'][$r->optiongrpid][$r->trbid]['topquestion']  = $r->trbid." ".$r->question;	
								$questions['other'][$r->optiongrpid][$r->trbid]['optioname'][]  = $r->optionsid." ".$r->optionname;
							}
						}	

						$data['questions'] = $questions;
			
			// get whether the logged in user is a teacher or student 
				$usertype  = $this->session->userdata("type");
				$userid    = $this->session->userdata("compid");
				
				$script    = "";
				if ($usertype == 1) { // student
					$script = "b.studentid = '{$userid}' and ";
				} else if ($usertype == 2) {  // teacher
					$script = "b.teacherid = '{$userid}' and ";
				}
			// end 
			
					// get bookings 
						$thedate = date("Y-m-d H:i:s");
						$getbkng = "select * from booking as b 
									left join teachertbl as tt
									on b.teacherid = tt.teacherid 
									where b.date_time < '{$thedate}' and {$script}
									b.bl_id not in (select trbclassid from troublereports) order by bl_id DESC";
// echo $getbkng;
						$bookings = $this->Mainprocs->__getdata(false,$getbkng);

						$data['bookings'] = $bookings;

					// end getting of bookings

						$this->load->view("student/reportdata",$data);
		}

		public function addreport() {
			$reportval   = $this->input->post("reportid");
			$reportfirst = $this->input->post("reportfirst");
			// format 


			// first : reportquestions ID
			// second: optionstbl ID 
			// third : booking ID
				// format = 2_5_43

			$this->load->library("session");
			$this->load->model("Mainprocs");

			// $studentid = $this->session->userdata("userid");
			$reporterid 				   = $this->session->userdata("compid");
			$reportertype 				   = $this->session->userdata("type");
			list($rep_q_id,$ops_id,$bk_id) = explode("_",$reportval);

			$details = [
					"trbclassid"   => $bk_id,
					"trbdetails"   => $reportval." | ".$reportfirst,
					"reporterid"   => $reporterid,
					"status"       => 0,
					"reportdate"   => date("Y-m-d"),
					"reportertype" => $reportertype
				];
			$store_ = $this->Mainprocs->__store("troublereports",$details);

			echo json_encode($store_);
		}
	
	// used in the admin reports procedure javascript
		public function viewreport() {
			$trblid = $this->input->post("trblid");
			
			$this->load->model("Mainprocs");

			$trbdetails 	= $this->Mainprocs->__getdata("troublereports","all",['troubleid'=>$trblid]);
			
			$reporterid 	= $trbdetails[0]->reporterid;
			$reportertype	= $trbdetails[0]->reportertype;
			$thedetails     = $trbdetails[0]->trbdetails;

			// booking id 
			$bookingid 		= $trbdetails[0]->trbclassid;

			// trouble report details 
				list($second_q,$first_q) = explode("|",$thedetails);

				// exploading the first question's answer
				list($q_f_num,$q_f_ans) = explode("_",$first_q);

				// exploading the second question's answer
				list($q_s_num,$q_s_num) = explode("_",$second_q);

				// get the questions
				$qs = $this->Mainprocs->__getdata("reportquestions","all",false);				

				$thequestions = [];
				$count = 1;
				foreach($qs as $q) {
					$answer 		   = ($count==1)?$q_f_ans:$q_s_num;
					$ans 			   = $this->Mainprocs->__getdata("optionstbl","all",["optionsid"=>$answer]);
					$loc_q['question'] = $q->question;
					$loc_q['answer']   = $ans[0]->optionname;

					array_push($thequestions,$loc_q);
					$count++;
				}

				$data['thequestions'] = $thequestions;
			// end 

			$sql 		= "";
			$table 		= "";
			$bfield 	= "";
			$tbfield 	= "";

			$reportertbl = "";

			$data['thetype']   = "";
			switch($reportertype) {
				case 1:
					$table   = "teachertbl";
					$bfield  = "b.teacherid";
					$tbfield = "tb.teacherid";

					$reportertbl 	   = "teacherid";
					$data['thetype']   = "STUDENT";
					break;
				case 2:
					$table   = "studenttbl";
					$bfield  = "b.studentid";
					$tbfield = "tb.studentid";
					
					$reportertbl 	   = "studentid";
					$data['thetype']   = "TEACHER";
					break;
			}

			$data['reportername'] = $this->Mainprocs->__getdata($table,["name"],[$reportertbl => $reporterid]);
		
			$sql = "select * from booking as b 
						JOIN {$table} as tb on {$bfield} = {$tbfield}
						where bl_id = '{$bookingid}'";

			$data['details']  = $this->Mainprocs->__getdata(false,$sql);
			$data['status']   = ($trbdetails[0]->status==0)?"OPEN":"CLOSE";

			$this->load->view("admin/reportview",$data);
		}
	// end usage

		public function setstatus() {
			$status = $this->input->post("status");
			$trbcid = $this->input->post("trbid");

			$this->load->model("Mainprocs");
			echo json_encode( $this->Mainprocs->__update("troublereports",["status"=>$status],["troubleid"=>$trbcid]) );
			// echo json_encode([$status,$trbcid]);
		}

		public function test() {
			$date  = strtotime("2018-08-20 21:30:00");
			$date1 = strtotime( date("Y-m-d H:i:00") );
			echo $date;
				echo "<br/>";
			echo $date1;
				echo "<br/>";

			if ($date > $date1){
				echo "old date is greater";
			} else if ($date < $date1) {
				echo "new date is greater";
			}

		}
	}
	
?>