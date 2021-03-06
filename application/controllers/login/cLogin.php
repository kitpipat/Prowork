<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cLogin extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('login/mLogin');
	}

	public function index(){
		$this->load->view('login/wLogin.php');
	}

	public function FSxCCheckLogin(){
		$tUserLogin = $this->input->post('oetUserLogin');
		$tPassword 	= $this->input->post('oetPassword');

		$paWhere = array(
			'tUserlogin' 	=> $tUserLogin,
			'tPassword' 	=> $tPassword
		);
		$aReturn = $this->mLogin->FSaMCheckLogin($paWhere);
		if($aReturn['rtCode'] == 1){

			if($aReturn['raItems'][0]['FNStaUse'] == 0){ //0 คือไม่มีสิทธิใช้ระบบ
				$aReturn = array(
					'rtCode' => '400',
					'rtDesc' => 'Status dont use',
				);
				echo json_encode($aReturn);
				exit;
			}else{

				$tPermitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz@$';
				$tSessID = substr(str_shuffle($tPermitted_chars), 0, 15);
      
        		$this->session->set_userdata("tSesLogID",$tSessID);		//session id
				$this->session->set_userdata("tSesUsercode",$aReturn['raItems'][0]['FTUsrCode']);		//รหัสผู้ใช้
				$this->session->set_userdata("tSesFirstname",$aReturn['raItems'][0]['FTUsrFName']);		//ชื่อ
				$this->session->set_userdata("tSesLastname",$aReturn['raItems'][0]['FTUsrLName']);		//นามสกุล
				$this->session->set_userdata("tSesDepartment",$aReturn['raItems'][0]['FTUsrDep']);		//แผนก
				$this->session->set_userdata("tSesRoleUser",$aReturn['raItems'][0]['FNRhdID']);			//รหัสกลุ่มสิทธิ
				$this->session->set_userdata("tSesPriceGroup",$aReturn['raItems'][0]['FTPriGrpID']);	//รหัสกลุ่มราคา
				$this->session->set_userdata("tSesUserGroup",$aReturn['raItems'][0]['FNUsrGrp']);		//รหัสกลุ่มของผู้ใช้ (มีผลต่อการมองเห็น)
				$this->session->set_userdata("tSesUsrImg",$aReturn['raItems'][0]['FTUsrImgPath']);		//รูปภาพของผู้ใช้


				if($aReturn['raItems'][0]['FTBchName'] == '' || $aReturn['raItems'][0]['FTBchName'] == null){
					//USER : HQ ต้องวิ่งไปเอาบริษัท default
					$aReturn 	= $this->mLogin->FSaMGetCmpDefault();
					$tCmpName	= $aReturn['raItems'][0]['FTCmpName'];
					$tBchName	= '';
					$tBchCode	= '';
					$tUserLevel = 'HQ';
				}else{
					$tCmpName	= $aReturn['raItems'][0]['FTCmpName'];
					$tBchName	= $aReturn['raItems'][0]['FTBchName'];
					$tBchCode	= $aReturn['raItems'][0]['FTBchCode'];
					$tUserLevel = 'BCH';
				}

				$this->session->set_userdata("tSesUserLevel",$tUserLevel);		//เลเวล HQ , BCH
				$this->session->set_userdata("tSesCMPName",$tCmpName);			//สาขา
				$this->session->set_userdata("tSesBCHCode",$tBchCode);			//บริษัท
				$this->session->set_userdata("tSesBCHName",$tBchName);			//ชื่อบริษัท

				//ลบข้อมูลใน Temp 
				$this->mLogin->FSaMDeleteDataInTemp($paWhere);
			}
		}else{
			$this->session->sess_destroy();
		}
		echo json_encode($aReturn);
	}

	public function Logout(){
		$this->session->sess_destroy();
		redirect('Login');
	}

	//ลืมรหัสผ่าน
	public function FSxCForgetPassword(){
		$tUserLogin = $this->input->post('tUserLogin');
		$tEmail 	= $this->input->post('tEmail');
		$tNewPass 	= $this->input->post('tNewPass');
		$paWhere = array(
			'tUserlogin' 	=> $tUserLogin,
			'tEmail'		=> $tEmail
		);
		$aReturn = $this->mLogin->FSaMCheckUserForgetPassword($paWhere);
		if($aReturn['rtCode'] == 1){
			//พบข้อมูล
			$aSet = array(
				'FTUsrPwd' 		=> $tNewPass
			);

			$aWhere = array(
				'FTUsrLogin' 	=> $tUserLogin,
				'FTUsrEmail'	=> $tEmail
			);
			$this->mLogin->FSaMUpdateForgetPassword($aSet,$aWhere);
		}else{
			//ไม่พบข้อมูล
		}
		echo json_encode($aReturn);
	}
}
