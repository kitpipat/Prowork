<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cUser extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user/user/mUser');
	}

	public function index(){
		$this->load->view('user/user/wUserMain');
	}

	//โหลดข้อมูลผู้ใช้
	public function FSwUSRLoadDatatable(){
		$aUserList = $this->mUser->FSaMUSRGetData();
		$this->load->view('user/user/wUserDatatable',$aUserList);
	}

}
