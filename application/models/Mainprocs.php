<?php 
	class Mainprocs extends CI_Model {
		public function __getdata($table = false, $query, $where = false) {
			$this->load->database();

			$sql = null;

			if ($table != false) {
				// not yet tested in the workfield
					$sql = "SELECT ";
					if ( is_array($query) ) {
						$count = 0;
						foreach($query as $q) {
							$sql .= $q;
							$sql .= ($count == count($query)-1)?"":",";
							$count++;
						}
					} else if ($query == "all") {
						$sql .= "* ";
					}

					$sql .= " from {$table}";

					if ($where != false && is_array($where)) {
						$sql .= " WHERE ";
						$count = 0;
						foreach($where as $key => $value) {
							$sql .= $key ."='".$value."'";
							$sql .= ($count==count($where)-1)?"":" AND ";
							$count++;
						}
					}
				// end
			} else {
				$sql = $query;
			}
	
			$query = $this->db->query($sql);
			$ret   = $query->result();
			$this->db->close();
			return $ret;
		}

		public function __update($table, $values, $where = false) {
			$this->load->database();

			$sql = null;

			if ( is_array($values) ) {
				$count = 0;
				$sql = "update {$table} set ";

				foreach($values as $field => $vals) {
					$sql .= $field ."='".$vals."'";
					$sql .= ($count == count($values)-1)?"":",";
					$count++;
				}

				if ($where != "false" || $where != false) {
					if (!is_array($where)) {
						return false;
					} else {
						$count = 0;
						$sql .= " WHERE ";
						foreach($where as $field => $val) {
							if ($field != "connector") {
								$sql .= $field ."='".$val."' ";
								//$sql .= ($count == count($where)-1)?"":"";
							} else {
								$sql .= $val." ";
							}
						}
					}
				}
			}

			$ret = $this->db->query($sql);
			$this->db->close();
			return $ret;
		}

		public function __store($table, $values) {
			$this->load->database();
			
			$sql  = null;

			if (is_array($values)) {
				$count = 0;
				$sql = "insert into {$table} (";
				
				foreach(array_keys($values) as $a) {
					$sql .= $a;
					$sql .= ($count == count($values)-1)?"":",";
					$count++;
				}

				$sql .= ") VALUES (";
				$count = 0;
				
				foreach($values as $vals) {
					$sql .= "'".$vals."'";
					$sql .= ($count == count($values)-1)?"":",";
					$count++;
				}	
				$sql .= ")";
				
			} else {
				$sql = $values;
			}

			$ret = $this->db->query($sql);
			$this->db->close();
			return $ret;
		}

		public function __run_q($sql) {
			$this->load->database();

			$ret = $this->db->query($sql);
			$this->db->close();
			return $ret;
		}

		public function checkforbooking($datetime, $teacher) {
			$datetime = date("Y-m-d H:i:00",strtotime($datetime));
			$sql 	  = "select * from booking where date_time = '{$datetime}' and teacherid = '{$teacher}'";
			$checked  = $this->__getdata(false,$sql);
			
			return $checked;
		}

		public function __datetoday() {
			// __datetoday is base from local time of server 
			return date("Y-m-d");
		}

		public function createuniquenumber($word,$length = false) {
			if ($length > strlen(md5($word)) || $length == false) {
				$length = 11;
			}
			return substr(md5(substr(md5($word),0,$length).substr(md5($this->__datetoday().date("His")),0,$length)),0,$length);
		}

		public function sendemail($details) {
			$this->load->library('email');
 
			$config = array();
			$config['protocol']  = 'smtp';
			$config['smtp_host'] = 'ssl://smtp.googlemail.com';
			$config['smtp_user'] = 'anwenglish.noreply@gmail.com';
			$config['smtp_pass'] = 'ghty56ruei';
			$config['smtp_port'] = 465;
			$config['mailtype']  = 'html';
    		$config['charset']   = 'iso-8859-1';
			$this->email->initialize($config);
			 
			$this->email->set_newline("\r\n");

			$this->email->from("anwenglish@noreply", $details['from_msg']);
	        $this->email->to($details['to']);
	        $this->email->subject($details['subject']);
	        $this->email->message($details['msg']);

	        if($this->email->send()) {
	        	return true;
	        } else {
            	return false;
	        }
		}

		public function addpayment($post,$itemname,$amount,$userid,$paypalUrl) {
			$this->load->helper("url");
			// $enableSandbox = true;
			// $paypalUrl     = $enableSandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
			
			$paypalConfig = [
				'email'      => 'testmerchantsandbox.a@gmail.com',
				'return_url' => base_url()."payment/return",
				'cancel_url' => base_url()."payment/cancel",
				'notify_url' => base_url()."payment/notify"
			];

			$data = [];
			foreach ($post as $key => $value) {
				$data[$key] = stripslashes($value);
			}

			$data['business'] = $paypalConfig['email'];

			
			$data['return'] 	   = stripslashes($paypalConfig['return_url']);
			$data['cancel_return'] = stripslashes($paypalConfig['cancel_url']);
			$data['notify_url']    = stripslashes($paypalConfig['notify_url']);

			
			$data['item_name'] 	   = $itemname;
			$data['amount'] 	   = $amount;
			$data['currency_code'] = 'JPY';

			$data['custom'] 	   = $userid;

			$queryString = http_build_query($data);

			header('location:' . $paypalUrl . '?' . $queryString);
		}

		public function verifytransaction($data) {
				// global $paypalUrl;
				$paypalUrl = "https://www.sandbox.paypal.com/cgi-bin/webscr";
			//	$paypalUrl = "https://ipnpb.sandbox.paypal.com/cgi-bin/webscr"; // sandbox
			//	$paypalurl = "https://ipnpb.paypal.com/cgi-bin/webscr"; // live 

				$req = 'cmd=_notify-validate';
				foreach ($data as $key => $value) {
					$value = urlencode(stripslashes($value));
					$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i', '${1}%0D%0A${3}', $value); // IPN fix
					$req .= "&$key=$value";
				}

				$ch = curl_init($paypalUrl);
				curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
				curl_setopt($ch, CURLOPT_SSLVERSION, 6);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
				curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
				$res = curl_exec($ch);

				if (!$res) {
					$errno = curl_errno($ch);
					$errstr = curl_error($ch);
					curl_close($ch);
					throw new Exception("cURL error: [$errno] $errstr");
				}

				$info = curl_getinfo($ch);

				// Check the http response
				$httpCode = $info['http_code'];
				if ($httpCode != 200) {
					throw new Exception("PayPal responded with http code $httpCode");
				}

				curl_close($ch);

				return $res === 'VERIFIED';
		}

		public function secure() {
			$type = $this->session->userdata("type");
			if ($type != 3) {
				redirect(base_url(),"refresh");
			}
		}
	}	
?>