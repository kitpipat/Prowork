<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cSupplier extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('supplier/mSupplier');
	}

	public function index(){
		$this->load->view('supplier/wSupplierMain');
	}

	//โหลดข้อมูลผู้จำหน่าย
	public function FSwCSUPLoadDatatable(){
		$nPage = $this->input->post('nPage');
		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 10,
			'tSearchAll'    => $this->input->post('tSearchAll')
		);

		$aUserList = $this->mSupplier->FSaMSUPGetData($aCondition);
		$aPackData = array(
			'aUserList'	=> $aUserList,
			'nPage'		=> $nPage
		);
		$this->load->view('supplier/wSupplierDatatable',$aPackData);
	}

	//โหลดหน้าจอผู้จำหน่าย + แก้ไขผู้จำหน่าย
	public function FSwCSUPCallPageInsertorEdit(){
		$tTypePage = $this->input->post('tTypepage');
		if($tTypePage == 'insert'){
			$aResult	= '';
		}else if($tTypePage == 'edit'){
			$tCode 		= $this->input->post('tCode');
			$aResult 	= $this->mSupplier->FSaMSUPGetDataUserBYID($tCode);
		}

		$aPackData = array(
			'tTypePage' 		=> $tTypePage,
			'aResult'			=> $aResult
		);
		$this->load->view('supplier/wSupplierAdd',$aPackData);
	}

	//อีเว้นท์เพิ่มข้อมูล
	public function FSwCSUPEventInsert(){

		$aLastUserCode 	= $this->mSupplier->FSaMSUPGetLastUsercode();
		if($aLastUserCode['rtCode'] == 800){
			$nUserCode = 1;
		}else{
			$nUserCode = $aLastUserCode['raItems'][0]['FTUsrCode'];
			$nUserCode = $nUserCode + 1;
		}

		$aInsertUser = array(
			// 'FTUsrCode'			=> $nUserCode,
			// 'FTBchCode'			=> ($this->input->post('oetUserBCH') == 0) ? null : $this->input->post('oetUserBCH'),
			// 'FTUsrFName'		=> $this->input->post('oetUserFirstname'),
			// 'FTUsrLName'		=> $this->input->post('oetUserLastname'),
			// 'FTUsrDep'			=> $this->input->post('oetUserDepartment'),
			// 'FTUsrEmail'		=> $this->input->post('oetUserEmail'),
			// 'FTUsrTel'			=> $this->input->post('oetUserTelphone'),
			// 'FTUsrLogin'		=> $this->input->post('oetUserLogin'),
			// 'FTUsrPwd'			=> $this->input->post('oetUserPassword'),
			// 'FTUsrImgPath'		=> $this->input->post('oetImgInsertorEditUser'),
			// 'FTUsrRmk'			=> $this->input->post('oetUserReason'),
			// 'FNRhdID'			=> $this->input->post('oetUserPermission'),
			// 'FTPriGrpID'		=> $this->input->post('oetUserPriGrp'),
			// 'FNStaUse'			=> ($this->input->post('ocmUserStaUse') == 'on') ? 1 : 0,
			// 'FNStaSysAdmin'		=> 0,
			// 'FTCreateBy'		=> $this->session->userdata('tSesUsercode'),
			// 'FDCreateOn'		=> date('Y-m-d H:i:s')
		);
		$this->mSupplier->FSxMSUPInsert($aInsertUser);
		echo 'pass_insert';
	}

	//ลบผู้ใช้
	public function FSxCSUPEventDelete(){
		$tCode = $this->input->post('ptCode');
		$this->mSupplier->FSaMSUPDelete($tCode);
	}

	//อีเว้นท์แก้ไข
	public function FSxCSUPEventEdit(){
		try{
			$aSetUpdate = array(
				// 'FTBchCode'			=> ($this->input->post('oetUserBCH') == 0) ? null : $this->input->post('oetUserBCH'),
				// 'FTUsrFName'		=> $this->input->post('oetUserFirstname'),
				// 'FTUsrLName'		=> $this->input->post('oetUserLastname'),
				// 'FTUsrDep'			=> $this->input->post('oetUserDepartment'),
				// 'FTUsrEmail'		=> $this->input->post('oetUserEmail'),
				// 'FTUsrTel'			=> $this->input->post('oetUserTelphone'),
				// 'FTUsrLogin'		=> $this->input->post('oetUserLogin'),
				// 'FTUsrPwd'			=> $this->input->post('oetUserPassword'),
				// 'FTUsrImgPath'		=> $this->input->post('oetImgInsertorEditUser'),
				// 'FTUsrRmk'			=> $this->input->post('oetUserReason'),
				// 'FNRhdID'			=> $this->input->post('oetUserPermission'),
				// 'FTPriGrpID'		=> $this->input->post('oetUserPriGrp'),
				// 'FNStaUse'			=> ($this->input->post('ocmUserStaUse') == 'on') ? 1 : 0,
				// 'FNStaSysAdmin'		=> 0,
				// 'FTUpdateBy'		=> $this->session->userdata('tSesUsercode'),
				// 'FDUpdateOn'		=> date('Y-m-d H:i:s')
			);
			$aWhereUpdate = array(
				'FTUsrCode'		 	=> $this->input->post('ohdUserCode')
			);
			$this->mSupplier->FSxMSUPUpdate($aSetUpdate,$aWhereUpdate);
			echo 'pass_update';
		}catch(Exception $Error){
            echo $Error;
        }
	}



}
