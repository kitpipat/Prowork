<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cUserprice extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('user/userprice/mUserPrice');
	}

	public function index(){
		$this->load->view('user/userprice/wUserpriceMain');
	}

	//โหลดข้อมูลกลุ่มราคา
	public function FSwUPILoadDatatable(){
		$nPage = $this->input->post('nPage');
		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 10,
			'tSearchAll'    => $this->input->post('tSearchAll')
		);

		$aPriceGroupList = $this->mUserPrice->FSaMUPIGetData($aCondition);
		$aPackData = array(
			'aPriceGroupList'	=> $aPriceGroupList,
			'nPage'				=> $nPage
		);
		$this->load->view('user/userprice/wUserpriceDatatable',$aPackData);
	}

	//โหลดหน้าจอเพื่มกลุ่มราคา + แก้ไขกลุ่มราคา
	public function FSwUPICallPageInsertorEdit(){
		$tTypePage = $this->input->post('tTypepage');
		if($tTypePage == 'insert'){
			$aResult	= '';
		}else if($tTypePage == 'edit'){
			$tCode 		= $this->input->post('tCode');
			$aResult 	= $this->mUserPrice->FSaMUPIGetDataPriceGroupBYID($tCode);
		}

		$aPackData = array(
			'tTypePage' 		=> $tTypePage,
			'aResult'			=> $aResult
		);
		$this->load->view('user/userprice/wUserpriceAdd',$aPackData);
	}

	//อีเว้นท์เพิ่มข้อมูล
	public function FSwUPIEventInsert(){
		$aLastCode 	= $this->mUserPrice->FSaMUPIGetLastGroupPricecode();
		if($aLastCode['rtCode'] == 800){
			$nUserCode = '00001';
		}else{
			$nUserCode 		= $aLastCode['raItems'][0]['FTPriGrpID'];
			$nNumber		= $nUserCode + 1;
			$nCountNumber	= count($nNumber);
			if($nCountNumber == 1){
				$tFormat 		= '0000';
			}else if($nCountNumber == 2){
				$tFormat 		= '000';
			}else if($nCountNumber == 3){
				$tFormat 		= '00';
			}else{
				$tFormat 		= '0';
			}

			$tFormatCode = str_pad($nNumber,strlen($tFormat)+1,$tFormat,STR_PAD_LEFT);
		}

		$aInsertUser = array(
			'FTPriGrpID'		=> $tFormatCode,
			'FTPriGrpName'		=> $this->input->post('oetUPIName'),
			'FTPriGrpReason'	=> $this->input->post('oetUPIReason'),
			'FTCreateBy'		=> $this->session->userdata('tSesUsercode'),
			'FDCreateOn'		=> date('Y-m-d H:i:s')
		);
		$this->mUserPrice->FSxMUPIInsert($aInsertUser);
		echo 'pass_insert';
	}

	//ลบกลุ่มราคา
	public function FSxUPIEventDelete(){
		$tCode = $this->input->post('ptCode');
		$this->mUserPrice->FSaMUPIDelete($tCode);
	}

	//อีเว้นท์แก้ไข
	public function FSxUPIEventEdit(){
		try{
			$aSetUpdate = array(
				'FTPriGrpName'		=> $this->input->post('oetUPIName'),
				'FTPriGrpReason'	=> $this->input->post('oetUPIReason'),
				'FTUpdateBy'		=> $this->session->userdata('tSesUsercode'),
				'FDUpdateOn'		=> date('Y-m-d H:i:s')
			);
			$aWhereUpdate = array(
				'FTPriGrpID'		=> $this->input->post('ohdPriceGroupCode')
			);
			$this->mUserPrice->FSxMUPIUpdate($aSetUpdate,$aWhereUpdate);
			echo 'pass_update';
		}catch(Exception $Error){
            echo $Error;
        }
	}


}
