<?php 
	
	class Payslips extends CI_Controller {

		function index() {
			$this->load->view("includes/main",$data);
		}

		function panel() {
			$this->load->view("admin/payroll/payroll_panel");
		}

		function header() {
			$teacherid = $this->input->post("teacherid");

			$this->load->model("Mainprocs");

			$data['data'] = $this->Mainprocs->__getdata("teachertbl",['name'],['teacherid'=>$teacherid]);
			$this->load->view("admin/payroll/payrollheader",$data);
		}

		function information() {
			// rate 
			$this->load->model("Mainprocs");
			$teacherid 	  = $this->input->post("teacherid");

			$data['data'] = $this->Mainprocs->__getdata("teachertbl",['rate','per'],['teacherid'=>$teacherid]);
			$this->load->view("admin/payroll/payrollinformation",$data);
		}

		function period() {
			$this->load->model("Mainprocs");
			$period    = $this->input->post("period");
			$teacherid = $this->input->post("teacherid");

			$get = "select * from payroll as p 
						right join payrollperiod as pp 
							on p.ppid = pp.ppid 
						where pp.ppid = (select max(ppid) from payrollperiod)";

			if ($period != null) {
				list($start,$end) = explode("_",$period);
				$start 	  = date("Y-m-d",strtotime($start));
				$end  	  = date("Y-m-d",strtotime($end));

				$get 	  = "select * from payrollperiod as pp
								LEFT join payroll as p on pp.ppid = p.pid
							where pp.ppdatestart = '{$start}' and pp.ppdateend = '{$end}' ";
			}
			
			// echo $get;
			$data['period'] = $this->Mainprocs->__getdata("payrollperiod","all");
			$data['data']   = $this->Mainprocs->__getdata(false,$get);

			$this->load->view("admin/payroll/payrollperiod",$data);
		}

		function hoursrendered() {
			$this->load->model("Mainprocs");

			$period 	= $this->input->post("period");
			$teacherid  = $this->input->post("teacherid");
			
			if ($period == null) return;

			list($start,$end) = explode("_", $period);

			$start = date("Y-m-d",strtotime($start));
			$end   = date("Y-m-d",strtotime($end));
			$sql   = "select * from booking as b where teacherid = '{$teacherid}' 
					  and status = 1 
					  and date_time between '{$start}' 
					  and '{$end}' order by date_time ASC";

			$data  = $this->Mainprocs->__getdata(false,$sql);

			$date_ = [];

			foreach($data as $d) {
				$datekey = date("m/d/Y",strtotime($d->date_time));
				
				$date_[$datekey][] = [date("h:i A", strtotime($d->date_time)),$d->bl_id];

			}

			$data['date_']	= $date_;

			$this->load->view("admin/payroll/hoursrendered",$data);
		}

		function earnings() {
			$this->load->model("Mainprocs");

			$teacherid   = $this->input->post("teacherid");
			$period 	 = $this->input->post("period");

			$status      = $this->input->post("status");
/*
$teacherid = "3ba4bc347";
$period    = "2018-11-01_2018-12-01";
$status    = 1;
*/
//		 	if ($period == null) return;

			list($start,$end) = explode("_", $period);
			$start = date("Y-m-d",strtotime($start));
			$end   = date("Y-m-d",strtotime($end));
			$sql   = "select * from booking as b 
						LEFT JOIN 
						teachertbl as t on b.teacherid = t.teacherid 
						where b.teacherid = '{$teacherid}' and b.status = 1 and b.date_time between '{$start}' and '{$end}' order by b.date_time ASC";

			$data  = $this->Mainprocs->__getdata(false,$sql);
		
			$date_ = [];

			foreach($data as $d) {
				$datekey = date("m/d/Y",strtotime($d->date_time));
				
				$date_[$datekey][] = [date("h:i", strtotime($d->date_time)),$d->bl_id];
			}
			
			$time      = strtotime("00:00");
			$thetime   = 0;
			$count     = 0;

			foreach($date_ as $d) {
				foreach($d as $sd[0]) {
					// $thetime = date("h:i",strtotime('+30 minutes',strtotime($time)));
					$count += 1;
				}
			}


// echo $thetime;

// var_dump($date_);
		// 	if ($thetime == 0) $thetime = "00:00";

			// 	list($hrs, $mins)   = explode(":",$thetime);
		
			$thetime = (30*$count); // should be in minutes 

				$data_['per']       = $data[0]->per;

				$data_['count']     = $count;
				$data_['hrend']     = $hrs = $count/2; // date("h:i", strtotime($thetime));
				$data_['rate']      = $data[0]->rate;
				
				$data_['status']    = $status;
				$themins_amount     = 0;
				/*
				if ($mins == 30) {
					$themins_amount = $data[0]->rate/2;
				}
				*/
				$data_['numberoflessons']	= $count;
				// $data_['total'] = ($data_['rate']*$hrs)+$themins_amount;
				$data_['total'] = ($data_['rate']*($count/2));

			$this->load->view("admin/payroll/thearnings",$data_);
		}

		function saverate() {
			$teacherid = $this->input->post("teacherid");
			$rate 	   = $this->input->post("rate");
			$per 	   = $this->input->post("per");

			$values = ["rate"=>$rate,"per"=>$per];

			$this->load->model("Mainprocs");

			$__update = $this->Mainprocs->__update("teachertbl",$values,["teacherid"=>$teacherid]);

			echo json_encode($__update);
		}

		function deletebooking() {
			$blid = $this->input->post("bookingid");

			$this->load->model("Mainprocs");

			$update = ['status'=>0];
			$where  = ['bl_id'=>$blid];
			$del = $this->Mainprocs->__update("booking",$update,$where);

			echo json_encode($del);

		}

		function createpayroll() {
			$date_     = $this->input->post("period");
			$teacherid = $this->input->post("teacherid");

			$this->load->model("Mainprocs");

			// admin ID 
			$uname 	   = $this->session->userdata("username");

			list($start, $end) = explode("_",$date_);

			$start 	   = date("Y-m-d",strtotime($start));
			$end 	   = date("Y-m-d",strtotime($end));

			$bookingsql = "select * from booking where 
							teacherid = '{$teacherid}' and 
							status = 1 and date_time between '{$start}' and '{$end}'";

			$bk 		= $this->Mainprocs->__getdata(false,$bookingsql);
			
			if (count($bk) == 0) {
				echo json_encode(["notime"]);
			} else {
				// $sqldate   = "select ppid from payrollperiod where ppdatestart = '{$start}' and ppdateend='{$end}'"; 
				$sqldate 	  = "select pp.ppid 
									from payroll as p
									join payrollperiod as pp 
								where
									p.tid = '{$teacherid}' and 
									pp.ppdatestart = '{$start}' and pp.ppdateend='{$end}'"; 
				
				$checkdate = $this->Mainprocs->__getdata(false,$sqldate);

				// create payroll period 
					// :: determine if the payroll period is created
					$ppdateid  = null;

					$ispaid    = null;

					if (count($checkdate) > 0) {
						$ppdateid   	 = $checkdate[0]->ppid;
					} else {
						// create the payroll period 
						$ppdateid  = $this->Mainprocs->createuniquenumber($start.$end.date("mdyHiS").$uname);
						$insert    = ["ppid"  		=> $ppdateid,
									  "ppdatestart" => $start,
									  "ppdateend"   => $end];

						$inserted  = $this->Mainprocs->__store("payrollperiod",$insert);
					}
				// end =================================


				// determine whether the teacher is paid or not 
					$paymentdets  = $this->Mainprocs->__getdata("payroll",["ppid","status"],['ppid' => $ppdateid]);

					if (count($paymentdets) == 0) { // fresh :: insert date to payroll table and use the ppdateid value given above
						$inserpayroll   = ["ppid"	  => $ppdateid,
									 	   "tid" 	  => $teacherid,
									 	   "status"   => 0, 		// determines if the teacher is paid or not on this date period 
									 	   "datepaid" => date("mdyHiS")]; 
						$insertopayroll = $this->Mainprocs->__store("payroll",$inserpayroll);

						$ispaid = false; // means that the teacher is not yet paid
					} else {
						if ($paymentdets[0]->status == 0) {
							$ispaid = false; // means that the teacher is not yet paid
						} else if ($paymentdets[0]->status == 1) {
							$ispaid = true; // means that the teacher is already paid
						}
					}
				// end ==================================
				
				// return the value 
					echo json_encode([$ispaid,$ppdateid]);
				// end return of value as of Alvin

			}
			
		}

		function sendpayslip() {
			$datepayid = $this->input->post("payrollid");
			$html_     = $this->input->post("html_");

			$this->load->model("Mainprocs");
			$this->load->model("Emailtemplates");

// $datepayid = "99dfa1f8ff2";
 
			$toemail = "select 
							u.username,
							pp.ppdatestart,
							pp.ppdateend
							from payroll as p 
							JOIN users as u on 
								p.tid = u.uniqueid
							JOIN payrollperiod as pp on 
								p.ppid = pp.ppid
						where p.ppid = '{$datepayid}'";

			$data    = $this->Mainprocs->__getdata(false, $toemail);
			
			if (count($data) > 0) {
				$this->Emailtemplates->data['html']		   = $html_;
				$this->Emailtemplates->data['datestart']   = $data[0]->ppdatestart;
				$this->Emailtemplates->data['dateend']	   = $data[0]->ppdateend;
				$this->Emailtemplates->data['dateupdated'] = $dateupdate = date("Y-m-d H:i:s");
				
				$details['to'] 		 = $data[0]->username;
				$details['from_msg'] = "ANW Accounting";
				$details['msg'] 	 = $this->Emailtemplates->payslip();
				$details['subject']  = "Payslip - ANW English Learning";
				$a 					 = $this->Mainprocs->sendemail($details);
				
				$update 			 = $this->Mainprocs->__update("payroll",
																  ['status'=>1,"datepaid"=>$dateupdate],
																  ['ppid' => $datepayid]);
				
				echo json_encode($a);
			} else {
				echo json_encode("No data found");
			}		
			
		}
	}

?>