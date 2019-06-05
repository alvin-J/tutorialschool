<?php 
	
	class Contact extends CI_Controller {
		public function index() {
			$this->load->helper("url");

			$data['title']	= "- Contact Us";	

			// listen to login 
				$this->load->model("Loginmodel");
				$login = $this->Loginmodel->logmein();
				if ($login == true) {
					// call the book JS 
						$data['headscript']['js'][]	= base_url()."procs/book.proc.js";					
					// end 

						$data['headscript']['js'][] = base_url()."procs/contact.procs.js";
						
					$data['headscript']['style'][]	= base_url()."style/student.style.css";
					$data['headscript']['style'][]	= base_url()."style/contact.style.css";
					$data['content']			   = "student/contact";

					$this->load->view("includes/main",$data);
				}
			// end

		}

		public function sendemail_no() {
			$this->load->model("Mainprocs");
			$this->load->helper("url");

			$details['from_msg']	= "Registration Confirmation";
			$details['to']			= $this->input->post("eadd");
			$details['subject']		= "Email confirmation for your registration";
			$details['msg']			= "<div style='width: 100%; font-family: calibri;'>
											<div style='width: 60%;
														margin: auto;
														background: #e0e0e0;
														padding: 20px;'>
												<table style='width: 100%;
															  text-align: center;
															  padding-bottom: 110px;''>
													<tr>
														<td style='padding: 15px 0px;'> <img src='".base_url()."images/logoanw.png'/> </td>
													</tr>
													<tr>
														<td style='padding: 15px 0px;'>
															<p style='font-size: 28px;
																	  color: #0d4a42;
																	  line-height: 43px;'> 
																	  This is to confirm your registration with <br/> A New World - Online English Tutors </p> 
														</td>
													</tr>
													<tr>
														<td style='padding: 15px 0px;'> <hr style='width: 45%;
																		border: 0px;
																		border-bottom: 1px solid #a9a9a9;'/> 
														</td>
													</tr>
													<tr>
														<td style='padding: 15px 0px;'> <p style='color: #868283;'> If you wish to book a Free trial lesson, please click the link below </p> </td>
													</tr>
													<tr>
														<td style='padding: 30px 0px;'> <span style='background: #fea0be;
																			padding: 21px 36px;
																			font-size: 24px;
																			color: #fff;
																			border-radius: 3px;'> FREE TRIAL LESSON </span> </td>
													</tr>
												</table>
											</div>
										</div>";
			// main email
			$email = $this->Mainprocs->sendemail($details);

			echo json_encode($email);
		}

		public function emailconf() {
			$this->load->helper("url");
			?>
				<div style='width: 100%; font-family: calibri;'>
					<div style='width: 60%;
								margin: auto;
								background: #e0e0e0;
								padding: 20px;'>
						<table style='width: 100%;
									  text-align: center;
									  padding-bottom: 110px;'>
							<tr>
								<td style='padding: 15px 0px;'> <img src='<?php echo base_url(); ?>images/logoanw.png'/> </td>
							</tr>
							<tr>
								<td style='padding: 15px 0px;'>
									<p style='font-size: 28px;
											  color: #0d4a42;
											  line-height: 43px;'> 
											  Your new password: </p> 
									<p> sdfljs9 </p>
								</td>
							</tr>
							<tr>
								<td style='padding: 15px 0px;'> <hr style='width: 45%;
												border: 0px;
												border-bottom: 1px solid #a9a9a9;'/> 
								</td>
							</tr>
							<tr>
								<td style='padding: 15px 0px;'> <p style='color: #868283;'> Please login to your account. </p> </td>
							</tr>
							<tr>
								<td style='padding: 30px 0px;'> <span style='background: #fea0be;
													padding: 21px 36px;
													font-size: 24px;
													color: #fff;
													border-radius: 3px;'> LOGIN </span> </td>
							</tr>
						</table>
					</div>
				</div>
			<?php
		}
	}

?>