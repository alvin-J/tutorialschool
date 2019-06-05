<?php 

	class Actiononbooking extends CI_Controller {

		public function action($actionbtn = '' , $bl_id = '' , $keycode = '') {
			if (strlen($bl_id)==0) {
				$bl_id = $this->input->post("bl_id");
			}

			if (strlen($actionbtn)==0) {
				$actionbtn = $this->input->post("actionbtn");
			}

			if (strlen($keycode)==0) {
				$keycode = $this->input->post("keycode");
			}

			if(strlen($actionbtn)==0 || strlen($bl_id)==0 || strlen($keycode)==0) {
				die("Something is missing from this link."); return;
			}

			$this->load->model("Mainprocs");

			$sql = "select te.name as tename, 
						   st.name as stname, 
						   u.username,
						   bl.date_time
						   from booking as bl
						JOIN studenttbl as st on bl.studentid = st.userid 
						JOIN teachertbl as te on bl.teacherid = te.userid
						JOIN users as u on bl.studentid = u.uniqueid
					where bl.bl_id = '{$bl_id}' and bl.keycode = '{$keycode}'";

			$data = $this->Mainprocs->__getdata(false,$sql);
			
			if (count($data)==0) {
				die("NO DATA FOUND"); return;
			} else {
				/*
					0 = for confirmation 
					1 = confirmed
					2 = declined
					3 = cancelled
				*/
				$update 	  = null;
				$actionstatus = null;
				$acttext 	  = null;
				$hex 		  = null;
				if ($actionbtn == "confirm") {
					$actionstatus = 1;
					$acttext	  = "CONFIRMED";
					$hex 		  = "#51a751";
				} else if ($actionbtn == "decline") {
					$actionstatus = 2;
					$acttext	  = "DECLINED";
					$hex 		  = "#4e4e4e";
				} else if ($actionbtn == "cancel") {
					$actionstatus = 3;
					$acttext	  = "CANCELLED";
					$hex 		  = "#d67575";
				}

				$update = $this->Mainprocs->__update("booking",['status'=>$actionstatus],['bl_id'=>$bl_id]);

				if ($update) {
					// #4e4e4e declined
					// #51a751  confirmed

						// mail the student here 
							$this->load->model("Emailtemplates");
							$this->Emailtemplates->data['name']		= $data[0]->tename;
							$this->Emailtemplates->data['cdate']	= date("F d, Y h:i A", strtotime($data[0]->date_time));
							$this->Emailtemplates->data['stats']	= strtolower($acttext);
							$this->Emailtemplates->data['hex']		= $hex;
							$template  								= $this->Emailtemplates->tostudent();

							$senddetails['from_msg'] = $data[0]->tename;
							$senddetails['to'] 		 = $data[0]->username;
							$senddetails['subject']  = "Your booking is {$acttext}";
							$senddetails['msg'] 	 = $template;

							$email = $this->Mainprocs->sendemail($senddetails);
						// end mailing 
					if ($email) {
						echo "<style>";
							echo "body {
									text-align: center;
									margin: 34px;
									background: {$hex};
									color: #fff;
									font-size: 26px;
									font-family: arial;
								}";
						echo "</style>";
						echo "Booking has been {$acttext}";
					}

				}
			}
		}
	}

?>