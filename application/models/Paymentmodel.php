<?php 
	
	class Paymentmodel extends CI_Model {
		private $period    			= null;
		private $studentid 			= null;

		private $amount				= null;
		private $paymentMode   		= null;
		private $paymentDetails 	= null;
		private $subscriptionType	= null;

		public function setperiod($period) {
			$this->period = $period;
		}

		public function setstudentid($studentid) {
			$this->studentid = $studentid;
		}

		public function setamount($amount) {
			$this->amount = $amount;
		}

		public function setpmode($pmode) {
			$this->paymentMode = $pmode;
		}

		public function setpdets($pdets) {
			$this->paymentDetails = $pdets;
		}

		public function setsubtype($subtype) {
			$this->subscriptionType = $subtype;
		}

		public function checkvalidity($periodtoday,$studentid, $rw = false) {
			if ($studentid != null) {				
				$sql = "select * from paymenttbl as p 
							where '{$periodtoday}' between p.periodStart and p.periodEnd 
								and p.studentId = '{$studentid}' 
								and p.status = 1";
			 	
				$this->load->model("Mainprocs");

				$validity = $this->Mainprocs->__getdata(false,$sql);
				
				if ($rw != false) {
					return $validity;
				}
				
				if (count($validity) > 0) {
					return ("valid");
				} else {
					return ("invalid");
				}
			}
		}
		
		public function returnsubs($periodtoday,$studentid)  {
			if ($studentid != null) {				
				$sql = "select * from paymenttbl as p 
							where '{$periodtoday}' between p.periodStart and p.periodEnd 
								and p.studentId = '{$studentid}' 
								and p.status = 1";
			 	
				$this->load->model("Mainprocs");

				$validity = $this->Mainprocs->__getdata(false,$sql);

				if (count($validity) > 0) {
					return ["substype"=>$validity[0]->subscriptionType];
				}
				return false;
			}
		}

		public function getpaymentdetails($periodtoday,$stdid) {
			if($stdid != null) {

				$sql = "select * from paymenttbl as p 
							JOIN studenttbl as stbl 
								where p.p_inc_id = (select max(p_inc_id) from paymenttbl 
							where studentId = '{$stdid}') and stbl.studentid = '{$stdid}'";
				
				// '{$periodtoday}' between p.periodStart and p.periodEnd and
				$this->load->model("Mainprocs");
				
				$details = $this->Mainprocs->__getdata(false,$sql);
				
				
				if(count($details)>0){
					return $details;
				} else if(count($details)==0) {
					return false;
				}
			}
		}

		public function addup() {
			if ($this->period == null || $this->studentid == null) { return; }

			$this->load->model("Mainprocs");
			$sql = "select max(p_inc_id) as p_inc_id,periodend from paymenttbl where studentId = '{$this->studentid}'";
			$data = $this->Mainprocs->__getdata(false, $sql);

			$periodend = null;
			if (count($data)==0 || count($data) > 1) {
				return;
			} else if (count($data)==1){
				$pmentid   = $data[0]->p_inc_id;
				$periodend = strtotime($data[0]->periodend);
				$newperiod = date("Y-m-d",strtotime("+1 months",$periodend));

				$up_vals = ["periodEnd"	=> $newperiod];
				$where   = ["p_inc_id"  => $pmentid];
				$table   = "paymenttbl";

				$update_ = $this->Mainprocs->__update($table,$up_vals,$where);

				if ($update_) {
					return true;
				} 
				return false;
			}
		}

		public function addnew() {
		//	$this->studentId;
		//	$this->amount;
		//	$this->paymentMode;
		//	$this->paymentDetails;
		//	$this->subscriptionType;
			$paymentTransId = null;
			$periodStart    = date("Y-m-d");
			$periodEnd 	    = date("Y-m-d",strtotime("+1 months", strtotime($periodStart)));
			$status 	    = 1;
			$modifiedBy     = 1;
			$inputDate 	    = date("Y-m-d h:i:s A");

			$insert = [
				"paymentTransId"	 => $paymentTransId,
				"studentId"			 => $this->studentid,
				"amount"			 => $this->amount,
				"paymentMode"		 => $this->paymentMode,
				"paymentDetails"	 => $this->paymentDetails,
				"subscriptionType"	 => $this->subscriptionType,
				"periodStart"		 => $periodStart,
				"periodEnd"	 		 => $periodEnd,
				"status"			 => $status,
				"modifiedBy"		 => $modifiedBy,		
				"inputDate"			 => $inputDate
			];

			$stored = $this->Mainprocs->__store("paymenttbl", $insert);

			if ($stored) {
				return true;
			} 
			return false;
		}
	}

?>