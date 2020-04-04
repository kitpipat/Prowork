<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cMain extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library("session");
		if(@$_SESSION['tSesUsercode'] == true) { //มี session
			$this->load->model('common/mCommon');
		}else{//ไม่มี session
			redirect('Login', '');
			exit();
		}
	}

	public function index(){
		$aReturnMenu = array(
			'aMenuList' => $this->mCommon->FSaMGetListMenu($this->session->userdata('tSesUsercode'))
		);
		$this->load->view('common/wHeader',$aReturnMenu);
		$this->load->view('common/wContent');
		$this->load->view('common/wFooter');
	}
}
