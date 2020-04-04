<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cQuotation extends CI_Controller {

	public function __construct() {
		parent::__construct();
		//$this->load->model('user/user/mUser');
	}

	public function index(){
		$this->load->view('quotation/wQuotation');
	}

	//
	public function FSwUSRLoadDatatable(){
	
	}

}
