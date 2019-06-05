<?php
	
	class Materials extends CI_Controller {
		public function index() {
			$this->load->helper("url");

			$data['title']	= "- Materials";	

			// listen to login 
				$this->load->model("Loginmodel");
				$login = $this->Loginmodel->logmein();
				if ($login == true) {
					$this->load->model("Mainprocs");
					// call the book JS 
						$data['headscript']['js'][]	= base_url()."procs/book.proc.js";					
					// end 
						
					$data['headscript']['style'][]	= base_url()."style/student.style.css";
					
					$mat_sql 					= "select * from materials as m 
													LEFT JOIN materials_details as md 
														on m.mat_id = md.mat_head_id";
					$materials  				= $this->Mainprocs->__getdata(false,$mat_sql);

					$heads  = [];
					
					foreach($materials as $ms) {
						$heads[$ms->mat_id] = ["mat_id"=>$ms->mat_id,
											   "mattxt"=>$ms->mat_headtext,
											   "matlvl"=>$ms->matlvl,
											   "matcol"=>$ms->matcol];
					}
					
					$data['heads'] 	   = $heads;
					$data['materials'] = $materials;
					
					$data['content']			   = "student/materials";
					$this->load->view("includes/main",$data);
				}
			// end

		}

		public function upload() {
			$file  	   = $_FILES["attcfile"]["name"];     // filename
			$tmp  	   = $_FILES["attcfile"]["tmp_name"]; // temporary name
			$size 	   = $_FILES['attcfile']['size']; 	 // size
			$type 	   = $_FILES['attcfile']['type']; 	 // file type
			$ext       = strtolower( explode('.',$_FILES['attcfile']['name'])[1] );

 			$error     = array();	
			$extension = array("jpeg","jpg","pdf","png");

			if (in_array($ext, $extension) === false) {
				$error[] = "<p style='color:red;'> This filetype is not allowed... jpeg, jpg, png and pdf are allowed </p>";
			}

			$target_file = "upload/".$file;
	
			/*
			if (file_exists($target_file)) {
				$error[] = "<p style='color:red;'> File already exist. Consider renaming it.</p>";
			}
			*/
			
			if (count($error) > 0) {
				echo json_encode($error);
			} else {
				move_uploaded_file($tmp,$target_file);
				echo json_encode([true,$file]);
			}
			
		}
		
		public function removeattachment() {
			$modid 		= $this->input->post("modid_");
			$filename   = $this->input->post("filename_");
			
			// Capture.PNG addmaterial.js:152:2
			// 1
	//		$modid 	  = 1;
	//		$filename = "samp - Copy (2).png";
			
			$this->load->model("Mainprocs");
			$data = $this->Mainprocs->__getdata("materials_details",['matfiles'],['mat_det_id'=>$modid]);
			
			if (count($data)==0) {
				echo json_encode("module not found");
			} else {
				$matfiles = (array) json_decode($data[0]->matfiles);				
				if (in_array($filename,$matfiles) === false) {
					echo json_encode("file not found");
				} else {
					$index = array_search($filename,$matfiles);
					
					// var_dump($matfiles);
					// var_dump($index); return;
					// remove from array 
					// array_splice($matfiles,$index);
					unset($matfiles[$index]);
					
					if (count($matfiles) == 0) {
						$matfiles  = null;
					} else {
						$matfiles = json_encode($matfiles);
					}
					
					$update   = $this->Mainprocs->__update("materials_details",["matfiles"=>$matfiles],["mat_det_id"=>$modid]);
					
					/*
					if ($update) {
						unlink("uploads/".$filename);
					}
					*/
					
					echo json_encode($update);
				}
				
			}
		
		}
	}
?>