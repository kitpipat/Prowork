<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cInformation extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('information/mInformation');
	}

	public function index(){
		$aPackData = array(
			'aGetInfomation' => $this->mInformation->FSaMINFGetData()
		);
		$this->load->view('information/wInformation',$aPackData);
	}

}
