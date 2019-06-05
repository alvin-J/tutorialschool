<?php 

class Classroommodel extends CI_Model {

	public $theid 	  = null;
	public $cid 	  = null;
	public $type 	  = null;

	public function __construct() {
		parent::__construct();
		$this->load->model("Mainprocs");

	}

	function getclassroom() {
		if($this->theid == null) { echo "error on student id"; return; }

		if ($this->type != null) {
			if ($this->type == 1) { // student
				$sql = "select bl.date_time, bl.teacherid, bl.timezone, bl.status as blstat,
							   cr.*, 
							   st.name
							from booking as bl 
						JOIN classroom as cr on bl.bl_id = cr.bookingid ";
				$sql .= "JOIN studenttbl as st on bl.studentid = st.userid ";
				$sql .= "WHERE bl.studentid = '{$this->theid}'";
			//	$sql .= " and bl.status = 1";
			} else if ($this->type == 2) { // teacher 
				$sql = "select bl.date_time, bl.teacherid, bl.timezone, bl.status as blstat, cr.*, te.name 
							from booking as bl 
						JOIN classroom as cr on bl.bl_id = cr.bookingid ";
				$sql .= "JOIN teachertbl as te on bl.teacherid = te.userid ";
				$sql .= "WHERE bl.teacherid = '{$this->theid}'";
			//	$sql .= " and bl.status = 1";
			} else if ($this->type == 3) { // admin 
				// $sql .= "WHERE bl.studentid = '{$this->theid}'";
				$sql .= " ";
			}
			
			$sql .= " ORDER BY bl.bl_id DESC";
		}

		$ret = $this->Mainprocs->__getdata(false,$sql);
		
		if (count($ret)==0) {
			return false;
		}

		return $ret;
	}

	function getstatus() {
		if ($this->cid == null) { echo "error on classroom"; return; }

		$sql = "select 
					st.name as stname, 
				    te.name as tename, 
				    cr.*
				  from classroom as cr 
				  	LEFT JOIN booking as bl on cr.bookingid = bl.bl_id 
				    LEFT JOIN studenttbl as st on bl.studentid = st.userid 
				    LEFT JOIN teachertbl as te on bl.teacherid = te.teacherid
				  where cr.classroomid = '{$this->cid}'";
				
		$ret = $this->Mainprocs->__getdata(false,$sql);

		if (count($ret)==0) {
			return false;
		}

		return $ret;
	}

	function updateclassroomstatus() {

		$update = null;
		if ($this->type == 1) { // student 
			$update = ["isstudentpres" => 1];
		} else if ($this->type == 2) { // teacher
			$update = ["isteacherpres" => 1];
		}

		return $this->Mainprocs->__update("classroom",$update,["classroomid"=>$this->cid]);
	}

	function getcrinfo() {
		if ($this->cid == null) { echo "Classroom is empty"; return; }

		$sql = "select cr.*,bl.studentid,bl.teacherid 
					from classroom as cr 
				join booking as bl 
					on cr.bookingid = bl.bl_id
				where cr.classroomid = '{$this->cid}'";

		$ret = $this->Mainprocs->__getdata(false,$sql);

		if (count($ret)==0) {
			return false;
		}

		return $ret;
	}

	function updateclassroom($token,$sid) {
		if ($this->cid == null) { echo "Classroom is empty"; return; }

		return $this->Mainprocs->__update("classroom",["sessionid"=>$sid,"token"=>$token],["classroomid"=>$this->cid]);


	}

}

?>