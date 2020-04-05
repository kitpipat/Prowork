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
		$aPackData = array(
			'aUserList'	=> $aUserList
		);
		$this->load->view('user/user/wUserDatatable',$aPackData);
	}

	//โหลดหน้าจอเพื่มผู้ใช้ + แก้ไขผู้ใช้
	public function FSwUSRCallPageInsertorEdit(){
		$tTypePage = $this->input->post('ptTypepage');
		if($tTypePage == 'insert'){

		}else{

		}

		$aPackData = array(
			'tTypePage' 		=> $tTypePage,
			'aBCHList'			=> $this->mUser->FSaMUSRGetBranch(),
			'aPermissionList'	=> $this->mUser->FSaMUSRGetPermission(),
			'aPriGrp'			=> $this->mUser->FSaMUSRGetPriceGroup(),
			'aResult'			=> ''
		);
		$this->load->view('user/user/wUserAdd',$aPackData);
	}

}
