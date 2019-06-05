<?php 
	
	class Emailtemplates extends CI_Model {
		public $data = null;
		public function confirmbooking() {

			$confurl  	= $this->data['confurl'];
			$declurl 	= $this->data['declurl'];
			$stname 	= $this->data['name'];
			$cdate 	    = date("F d, Y @ h:i A",strtotime($this->data['cdate']));
			$bldate 	= date("F d, Y",strtotime($this->data['bldate']));
		
		/*
			<tr>
				<td style=""> 
					<a href="'.$confurl.'"> <p style="float:left; padding: 16px 50px;margin: 20px 7px 20px 0px !important; padding: 16px 50px;margin: 20px 0px;background: #f7dbd8;border: 1px solid #efa49d;font-size: 16px;color: #b45349;border-radius: 3px;cursor: pointer;"> CONFIRM </p> </a> 
					<a href="'.$declurl.'"> <p style="float:left; padding: 16px 50px;margin: 20px 0px;background: #d5d5d5;border: 1px solid #b1b1b1;font-size: 16px;color: #b45349;border-radius: 3px;cursor: pointer;"> DECLINE </p> </a>
				</td>
			</tr>
		*/
			$conf = '<html><head></head><body style="font-family: arial;">
						<table style="width: 100%;">
							<tbody><tr>
								<td>
									<table style="width: 100%;">
										<tbody><tr>
											<td style="font-size: 16px;"> A new world English Academy </td>
										</tr>
										<tr>
											<td style="font-size: 32px;color: #e78378;padding: 11px 0px;"> I booked you to teach me. </td>
										</tr>
										<tr>
											<td style="font-size: 14px;"> Please log in to anw website to view the options. </td>
										</tr>
										
										<tr>
											<td> <hr style="border: 0px;border-bottom: 1px solid #ccc;"> </td>
										</tr>
										<tr>
											<td> 
												<table>
													<tbody><tr>
														<td> Student Information </td>
													</tr>
													<tr> 
														<td style="padding: 8px;text-align: right;font-size: 14px;color: #838383;"> Student Name: </td>
														<td style="font-size: 16px;"> '.$stname.' </td>
													</tr>
													<tr> 
														<td style="padding: 8px;text-align: right;font-size: 14px;color: #838383;"> Class Date: </td>
														<td style="font-size: 16px;"> '.$cdate.' </td>
													</tr>
													<tr> 
														<td style="padding: 8px;text-align: right;font-size: 14px;color: #838383;"> Date of Booking: </td>
														<td style="font-size: 16px;"> '.$bldate.' </td>
													</tr>
												</tbody></table>
											</td>
										</tr>
									</tbody></table>
								</td>
							</tr>
						</tbody></table>

					</body></html>';
				return $conf;
		}

		public function tostudent() {

			$stname 	= $this->data['name'];
			$cdate 	    = date("F d, Y @ h:i A", strtotime($this->data['cdate']));
			$bldate 	= date("F d, Y");
			$status 	= $this->data['stats'];
			$hex 		= $this->data['hex'];

			$temp = '<html><head></head><body style="font-family: arial;">
						<table style="width: 100%;">
							<tbody><tr>
								<td>
									<table style="width: 100%;">
										<tbody><tr>
											<td style="font-size: 16px;"> A new world English Academy </td>
										</tr>
										<tr>
											<td style="font-size: 32px;color: '.$hex.';padding: 11px 0px;"> Booking '.$status.' </td>
										</tr>
										<tr>
											<td> <hr style="border: 0px;border-bottom: 1px solid #ccc;"> </td>
										</tr>
										<tr>
											<td> 
												<table>
													<tbody><tr>
														<td> Teacher\'s Information </td>
													</tr>
													<tr> 
														<td style="padding: 8px;text-align: right;font-size: 14px;color: #838383;"> Teacher\'s Name: </td>
														<td style="font-size: 16px;"> '.$stname.' </td>
													</tr>
													<tr> 
														<td style="padding: 8px;text-align: right;font-size: 14px;color: #838383;"> Class Date: </td>
														<td style="font-size: 16px;"> '.$cdate.' </td>
													</tr>
													<tr> 
														<td style="padding: 8px;text-align: right;font-size: 14px;color: #838383;"> Date of action: </td>
														<td style="font-size: 16px;"> '.$bldate.' </td>
													</tr>
												</tbody></table>
											</td>
										</tr>
									</tbody></table>
								</td>
							</tr>
						</tbody></table>

					</body></html>';
			return $temp;
		}
		
		public function cancelbooking() {
			$stname = $this->data['name'];
			$cdate  = date("F d, Y @ h:i A", strtotime($this->data['cdate']));
			$bldate = date("F l, Y", strtotime($this->data['bldate']));
			
			$temp = '<html><head></head><body style="font-family: arial;">
						<table style="width: 100%;">
							<tbody><tr>
								<td>
									<table style="width: 100%;">
										<tbody><tr>
											<td style="font-size: 16px;"> A new world English Academy </td>
										</tr>
										<tr>
											<td style="font-size: 32px;color: #e78378;padding: 11px 0px;"> A booking is cancelled </td>
										</tr>
										<tr>
											<td style="font-size: 14px;"> A student has cancelled his/her booking with you. </td>
										</tr>
										<tr>
											<td> <hr style="border: 0px;border-bottom: 1px solid #ccc;"> </td>
										</tr>
										<tr>
											<td> 
												<table>
													<tbody><tr>
														<td> Student Information </td>
													</tr>
													<tr> 
														<td style="padding: 8px;text-align: right;font-size: 14px;color: #838383;"> Student Name: </td>
														<td style="font-size: 16px;"> '.$stname.' </td>
													</tr>
													<tr> 
														<td style="padding: 8px;text-align: right;font-size: 14px;color: #838383;"> Class Date: </td>
														<td style="font-size: 16px;"> '.$cdate.' </td>
													</tr>
													<tr> 
														<td style="padding: 8px;text-align: right;font-size: 14px;color: #838383;"> Date of Booking: </td>
														<td style="font-size: 16px;"> '.$bldate.' </td>
													</tr>
												</tbody></table>
											</td>
										</tr>
									</tbody></table>
								</td>
							</tr>
						</tbody></table>

					</body></html>';
				return $temp;
		}
		
		public function notifyadmin() {
			$stname    = $this->data['name'];
			$subtype   = $this->data['subtype'];
			$bcode     = $this->data['bcode'];
			$numofmos  = $this->data['numofmos'];
			$amnt      = $this->data['amnt'];
			
			$temp = '<html><head></head><body style="font-family: arial;">
						<table style="width: 100%;">
							<tbody><tr>
								<td>
									<table style="width: 100%;">
										<tbody><tr>
											<td style="font-size: 16px;"> A new world English Academy </td>
										</tr>
										<tr>
											<td style="font-size: 32px;color: #e78378;padding: 11px 0px;"> Payment has been received through bank-to-bank </td>
										</tr>
										<tr>
											<td style="font-size: 14px;"> Please log in to ANW website to update the students subscription. </td>
										</tr>
										<tr>
											<td> <hr style="border: 0px;border-bottom: 1px solid #ccc;"> </td>
										</tr>
										<tr>
											<td> 
												<table>
													<tbody><tr>
														<td> Student Information </td>
													</tr>
													<tr> 
														<td style="padding: 8px;text-align: right;font-size: 14px;color: #838383;"> Student Name: </td>
														<td style="font-size: 16px;"> '.$stname.' </td>
													</tr>
													<tr> 
														<td style="padding: 8px;text-align: right;font-size: 14px;color: #838383;"> Subscription Plan: </td>
														<td style="font-size: 16px;"> '.$subtype.' </td>
													</tr>
													<tr> 
														<td style="padding: 8px;text-align: right;font-size: 14px;color: #838383;"> Bank Transaction Code: </td>
														<td style="font-size: 16px;"> '.$bcode.' </td>
													</tr>
													<tr> 
														<td style="padding: 8px;text-align: right;font-size: 14px;color: #838383;"> Number of Months: </td>
														<td style="font-size: 16px;"> '.$numofmos.' </td>
													</tr>
													<tr> 
														<td style="padding: 8px;text-align: right;font-size: 14px;color: #838383;"> Amount: </td>
														<td style="font-size: 16px;"> '.$amnt.' </td>
													</tr>
												</tbody></table>
											</td>
										</tr>
									</tbody></table>
								</td>
							</tr>
						</tbody></table>

					</body></html>';
			return $temp; 
		}
		
		public function thankyou() {
			$stname  = $this->data['name'];
			$subtype = $this->data['subtype'];
			$bcode   = $this->data['bcode'];
			$nummos  = $this->data['nummos'];
			$amnt    = $this->data['amnt'];
			 
			$temp = '<html><head></head><body style="font-family: arial;">
						<table style="width: 100%;">
							<tbody><tr>
								<td>
									<table style="width: 100%;">
										<tbody><tr>
											<td style="font-size: 16px;"> A new world English Academy </td>
										</tr>
										<tr>
											<td style="font-size: 32px;color: #e78378;padding: 11px 0px;"> Thank you. </td>
										</tr>
										<tr>
											<td style="font-size: 14px;"> Your account has been replenished. You may book a class with your favorite teacher now.</td>
										</tr>
										<tr>
											<td> <hr style="border: 0px;border-bottom: 1px solid #ccc;"> </td>
										</tr>
										<tr>
											<td> 
												<table>
													<tbody><tr>
														<td> Transaction Details </td>
													</tr>
													<tr> 
														<td style="padding: 8px;text-align: right;font-size: 14px;color: #838383;"> Student Name: </td>
														<td style="font-size: 16px;"> '.$stname.' </td>
													</tr>
													<tr> 
														<td style="padding: 8px;text-align: right;font-size: 14px;color: #838383;"> Subscription Plan: </td>
														<td style="font-size: 16px;"> '.$subtype.' </td>
													</tr>
													<tr> 
														<td style="padding: 8px;text-align: right;font-size: 14px;color: #838383;"> Bank Transaction Code: </td>
														<td style="font-size: 16px;"> '.$bcode.' </td>
													</tr>
													<tr> 
														<td style="padding: 8px;text-align: right;font-size: 14px;color: #838383;"> Number of Months: </td>
														<td style="font-size: 16px;"> '.$nummos.' </td>
													</tr>
													<tr> 
														<td style="padding: 8px;text-align: right;font-size: 14px;color: #838383;"> Amount: </td>
														<td style="font-size: 16px;"> '.$amnt.' </td>
													</tr>
												</tbody></table>
											</td>
										</tr>
									</tbody></table>
								</td>
							</tr>
						</tbody></table>

					</body></html>';
			return $temp;
		}
		
		public function applicant() {
			$app_name = $this->data['name'];
			$email    = $this->data['email'];
			$skype    = $this->data['skype'];
			$exp 	  = $this->data['exp'];

			$temp = '<html><head></head><body style="font-family: arial;">
						<table style="width: 100%;">
							<tbody><tr>
								<td>
									<table style="width: 100%;">
										<tbody><tr>
											<td style="font-size: 16px;"> A new world English Academy </td>
										</tr>
										<tr>
											<td style="font-size: 32px;color: #e78378;padding: 11px 0px;"> Im applying as a Teacher</td>
										</tr>
										<tr>
											<td style="font-size: 14px;"> Below is the pre-evaluation test made by the applicant. </td>
										</tr>
										<tr>
											<td> <hr style="border: 0px;border-bottom: 1px solid #ccc;"> </td>
										</tr>
										<tr>
											<td> 
												<table>
													<tbody>
														<tr>
															<td> Pre - evaluation exam </td>
														</tr>
														<tr> 
															<td style="padding: 8px;text-align: right;font-size: 14px;color: #838383;"> Name: </td>
															<td style="font-size: 16px;"> '.$app_name.' </td>
														</tr>
														<tr> 
															<td style="padding: 8px;text-align: right;font-size: 14px;color: #838383;"> Email Address: </td>
															<td style="font-size: 16px;"> '.$email.' </td>
														</tr>
														<tr> 
															<td style="padding: 8px;text-align: right;font-size: 14px;color: #838383;"> Skype ID: </td>
															<td style="font-size: 16px;"> '.$skype.' </td>
														</tr>
														<tr> 
															<td style="padding: 8px;text-align: right;font-size: 14px;color: #838383;"> Years of experience: </td>
															<td style="font-size: 16px;"> '.$exp.' </td>
														</tr>
														<tr>
															<td colspan="2" style="padding: 15px 0px;"> Pre-evaluation exam </td>
														</tr>';

									$count = 1;
									foreach($this->data['questions'] as $qs) {
										$temp .= '<tr> 
													<td style="text-align: right;font-size: 14px;color: #838383; vertical-align: top;"> Question '.$count.': </td>
													<td style="font-size: 16px;"> 
														<p style = "margin: 0px; font-size: 15px; color: #757575;"> '.$qs['q'].' </p>
														<p style = "margin: 5px 0px 0px 0px;"> - '.$qs['ans'].' </p>
													</td>
												  </tr>';
										$count++;
									}

			$temp .= '
													</tbody>
												</table>
											</td>
										</tr>
									</tbody></table>
								</td>
							</tr>
						</tbody></table>

					</body></html>';

			return $temp;
		}
		
				public function payslip() {

			$temp = '<html><head></head><body style="font-family: arial;">
						<table style="width: 100%;">
							<tbody><tr>
								<td>
									<table style="width: 100%;">
										<tbody><tr>
											<td style="font-size: 16px;"> A new world English Academy </td>
										</tr>
										<tr>
											<td style="font-size: 32px;color: #e78378;padding: 11px 0px;"> It\'s Payday </td>
										</tr>
										<tr>
											<td style="font-size: 14px;"> Have a nice day. Please continue teaching well. </td>
										</tr>
										<tr>
											<td> <hr style="border: 0px;border-bottom: 1px solid #ccc;"> </td>
										</tr>
										<tr>
											<td> 
												<table>
													<tbody>
													<tr>
														<td> Payment Information </td>
													</tr>
													<tr> 
														<td style="padding: 8px;text-align: right;font-size: 14px;color: #838383;"> Date Coverage: </td>
														<td style="font-size: 16px;"> '.date("F d, Y", strtotime($this->data['datestart'])).' - '.date("F d, Y", strtotime($this->data['dateend'])).' </td>
													</tr>
													<tr> 
														<td style="padding: 8px;text-align: right;font-size: 14px;color: #838383;"> Date of Payment: </td>
														<td style="font-size: 16px;"> '.date("F d, Y h:i:s A", strtotime($this->data['dateupdated'])).' </td>
													</tr>
													<tr>
														<td> Payroll Breakdown </td>
													</tr>
													<tr> 
														<td style="font-size: 16px; padding: 8px;" colspan=2>';
															
														$temp .= json_decode( $this->data['html'] );

			$temp .=									'</td>
													</tr>
												</tbody></table>
											</td>
										</tr>
									</tbody></table>
								</td>
							</tr>
						</tbody></table>

					</body></html>';
			return $temp;
		}
	}
?>