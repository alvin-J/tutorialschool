<?php

	$this->load->view("includes/header");

	if ($this->session->userdata("type") == 1 ){
		$this->load->view("includes/nav");
	} else if ($this->session->userdata("type") == 3 ){
		$this->load->view("includes/adminnav");
	} else if ($this->session->userdata("type") == 2 ){
		$this->load->view("includes/teachernav");
	} else if ($this->session->userdata("type") == 4 ){
		$this->load->view("includes/counselornav");
	} 

	$this->load->view($content);
	$this->load->view("includes/footer");
?>