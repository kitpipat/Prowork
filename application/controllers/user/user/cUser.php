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
		$nPage = $this->input->post('nPage');
		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 10,
			'tSearchAll'    => $this->input->post('tSearchAll')
		);

		$aUserList = $this->mUser->FSaMUSRGetData($aCondition);
		$aPackData = array(
			'aUserList'	=> $aUserList,
			'nPage'		=> $nPage
		);
		$this->load->view('user/user/wUserDatatable',$aPackData);
	}

	//โหลดหน้าจอเพื่มผู้ใช้ + แก้ไขผู้ใช้
	public function FSwUSRCallPageInsertorEdit(){
		$tTypePage = $this->input->post('tTypepage');
		if($tTypePage == 'insert'){
			$aResult	= '';
		}else if($tTypePage == 'edit'){
			$tCode 		= $this->input->post('tCode');
			$aResult 	= $this->mUser->FSaMUSRGetDataUserBYID($tCode);
		}

		$aPackData = array(
			'tTypePage' 		=> $tTypePage,
			'aBCHList'			=> $this->mUser->FSaMUSRGetBranch(),
			'aPermissionList'	=> $this->mUser->FSaMUSRGetPermission(),
			'aPriGrp'			=> $this->mUser->FSaMUSRGetPriceGroup(),
			'aResult'			=> $aResult
		);
		$this->load->view('user/user/wUserAdd',$aPackData);
	}

	//เพิ่มข้อมูล
	public function FSwUSREventInsert(){
		$aLastUserCode 	= $this->mUser->FSaMUSRGetLastUsercode();
		if($aLastUserCode['rtCode'] == 800){
			$nUserCode = 1;
		}else{
			$nUserCode = $aLastUserCode['raItems'][0]['FTUsrCode'];
			$nUserCode = $nUserCode + 1;
		}

		$aInsertUser = array(
			'FTUsrCode'			=> $nUserCode,
			'FTBchCode'			=> ($this->input->post('oetUserBCH') == 0) ? null : $this->input->post('oetUserBCH'),
			'FTUsrFName'		=> $this->input->post('oetUserFirstname'),
			'FTUsrLName'		=> $this->input->post('oetUserLastname'),
			'FTUsrDep'			=> $this->input->post('oetUserDepartment'),
			'FTUsrEmail'		=> $this->input->post('oetUserEmail'),
			'FTUsrTel'			=> $this->input->post('oetUserTelphone'),
			'FTUsrLogin'		=> $this->input->post('oetUserLogin'),
			'FTUsrPwd'			=> $this->input->post('oetUserPassword'),
			'FTUsrImgPath'		=> $this->input->post('oetImgInsertorEditUser'),
			'FTUsrRmk'			=> $this->input->post('oetUserReason'),
			'FNRhdID'			=> $this->input->post('oetUserPermission'),
			'FTPriGrpID'		=> $this->input->post('oetUserPriGrp'),
			'FNStaUse'			=> ($this->input->post('ocmUserStaUse') == 'on') ? 1 : 0,
			'FNStaSysAdmin'		=> 0,
			'FTCreateBy'		=> $this->session->userdata('tSesUsercode'),
			'FDCreateOn'		=> date('Y-m-d H:i:s')
		);
		$this->mUser->FSxMUSRInsert($aInsertUser);
	}

	//ลบผู้ใช้
	public function FSxUSREventDelete(){
		$tCode = $this->input->post('ptCode');
		$this->mUser->FSaMUSRDelete($tCode);
	}

	//อีเว้นท์บันทึก
	public function FSxUSREventEdit(){
		try{
			$aSetUpdate = array(
				'FTBchCode'			=> ($this->input->post('oetUserBCH') == 0) ? null : $this->input->post('oetUserBCH'),
				'FTUsrFName'		=> $this->input->post('oetUserFirstname'),
				'FTUsrLName'		=> $this->input->post('oetUserLastname'),
				'FTUsrDep'			=> $this->input->post('oetUserDepartment'),
				'FTUsrEmail'		=> $this->input->post('oetUserEmail'),
				'FTUsrTel'			=> $this->input->post('oetUserTelphone'),
				'FTUsrLogin'		=> $this->input->post('oetUserLogin'),
				'FTUsrPwd'			=> $this->input->post('oetUserPassword'),
				'FTUsrImgPath'		=> $this->input->post('oetImgInsertorEditUser'),
				'FTUsrRmk'			=> $this->input->post('oetUserReason'),
				'FNRhdID'			=> $this->input->post('oetUserPermission'),
				'FTPriGrpID'		=> $this->input->post('oetUserPriGrp'),
				'FNStaUse'			=> ($this->input->post('ocmUserStaUse') == 'on') ? 1 : 0,
				'FNStaSysAdmin'		=> 0,
				'FTUpdateBy'		=> $this->session->userdata('tSesUsercode'),
				'FDUpdateOn'		=> date('Y-m-d H:i:s')
			);

			$aWhereUpdate = array(
				'FTUsrCode'		 	=> $this->input->post('ohdUserCode')
			);

			$this->mUser->FSxMUSUpdate($aSetUpdate,$aWhereUpdate);
		}catch(Exception $Error){
            echo $Error;
        }
	}



}
