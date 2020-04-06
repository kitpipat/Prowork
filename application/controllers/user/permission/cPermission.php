<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cPermission extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user/permission/mPermission');
	}

	public function index(){
		$this->load->view('user/permission/wPermissionMain');
	}

	//โหลดข้อมูลกลุ่มสิทธิ์
	public function FSwPERLoadDatatable(){
		$nPage = $this->input->post('nPage');
		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 10,
			'tSearchAll'    => $this->input->post('tSearchAll')
		);

		$aPermissionList = $this->mPermission->FSaMPERGetData($aCondition);
		$aPackData = array(
			'aPermissionList'	=> $aPermissionList,
			'nPage'				=> $nPage
		);
		$this->load->view('user/permission/wPermissionDatatable',$aPackData);
	}

	//โหลดหน้าจอเพื่มผู้ใช้ + แก้ไขผู้ใช้
	public function FSwPERCallPageInsertorEdit(){
		$tTypePage = $this->input->post('tTypepage');
		if($tTypePage == 'insert'){
			$aResult	= '';
		}else if($tTypePage == 'edit'){
			$tCode 		= $this->input->post('tCode');
			$aResult 	= '';
		}

		$aPackData = array(
			'tTypePage' 		=> $tTypePage,
			'aResult'			=> $aResult,
			'aMenuAll'			=> $this->mPermission->FSaMPERGetMenuAll(),
		);
		$this->load->view('user/permission/wPermissionAdd',$aPackData);
	}

}
