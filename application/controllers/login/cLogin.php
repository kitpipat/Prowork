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
			$this->session->set_userdata("tSesUsercode",$aReturn['raItems'][0]['FTUsrCode']);
			$this->session->set_userdata("tSesFirstname",$aReturn['raItems'][0]['FTUsrFName']);
			$this->session->set_userdata("tSesLastname",$aReturn['raItems'][0]['FTUsrLName']);
			$this->session->set_userdata("tSesDepartment",$aReturn['raItems'][0]['FTUsrDep']);
		}else{
			$this->session->sess_destroy();
		}

		echo json_encode($aReturn);
	}

	public function Logout(){
		$this->session->sess_destroy();
		redirect('Login');
	}
}
