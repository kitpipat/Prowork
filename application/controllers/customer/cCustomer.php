<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cCustomer extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('customer/mCustomer');
	}

	public function index(){
		$this->load->view('customer/wCustomerMain');
	}

	//โหลดข้อมูล ลูกค้า
	public function FSwCCUSLoadDatatable(){
		$nPage = $this->input->post('nPage');
		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 10,
			'tSearchAll'    => $this->input->post('tSearchAll')
		);

		$aCustomerList = $this->mCustomer->FSaMCUSGetData($aCondition);
		$aPackData = array(
			'aCustomerList'		=> $aCustomerList,
			'nPage'				=> $nPage
		);
		$this->load->view('customer/wCustomerDatatable',$aPackData);
	}

	//โหลดหน้าจอเพิ่ม + แก้ไข
	public function FSwCCUSCallPageInsertorEdit(){
		$tTypePage = $this->input->post('tTypepage');
		if($tTypePage == 'insert'){
			$aResult	= '';
		}else if($tTypePage == 'edit'){
			$tCode 		= $this->input->post('tCode');
			$aResult 	= $this->mCustomer->FSaMCUSGetDataCustomerBYID($tCode);
		}

		$aPackData = array(
			'tTypePage' 		=> $tTypePage,
			'aResult'			=> $aResult
		);
		$this->load->view('customer/wCustomerAdd',$aPackData);
	}

	//อีเว้นท์เพิ่มข้อมูล
	public function FSwCCUSEventInsert(){
		$aLastCode 	= $this->mCustomer->FSaMCUSGetLastCustomercode();
		if($aLastCode['rtCode'] == 800){
			$tFormatCode = 'C000001';
		}else{
			$nLastCode 		= $aLastCode['raItems'][0]['FTCstCode'];
			$aCode			= explode('C',$nLastCode);
			$nNumber		= $aCode[1] + 1;
			$nCountNumber	= count($nNumber);
			if($nCountNumber == 1){
				$tFormat 		= '00000';
			}else if($nCountNumber == 2){
				$tFormat 		= '0000';
			}else if($nCountNumber == 3){
				$tFormat 		= '000';
			}else if($nCountNumber == 1){
				$tFormat 		= '00';
			}else{
				$tFormat 		= '0';
			}

			$tFormatCode = 'C' . str_pad($nNumber,strlen($tFormat)+1,$tFormat,STR_PAD_LEFT);
		}

		$aInsert = array(
			'FTCstCode'			=> $tFormatCode,
			'FTCstName'			=> $this->input->post('oetCUSName'),
			'FTCstContactName'	=> $this->input->post('oetCUSContactname'),
			'FTCstCardID'		=> $this->input->post('oetCUSCardID'),
			'FTCstTaxNo'		=> $this->input->post('oetCUSTaxNo'),
			'FTCstSex'			=> $this->input->post('ordRadioOptions'),
			'FDCstDob'			=> $this->input->post('oetCUSDob'),
			'FTCstAddress'		=> $this->input->post('oetCUSAddress'),
			'FTCstTel'			=> $this->input->post('oetCUSTelphone'),
			'FTCstFax'			=> $this->input->post('oetCUSTelnumber'),
			'FTCstEmail'		=> $this->input->post('oetCUSEmail'),
			'FNCstPostCode'		=> $this->input->post('oetCUSPostCode'),
			'FTCstWebSite'		=> $this->input->post('oetCUSWebsite'),
			'FTCstReason'		=> $this->input->post('oetCUSReason'),
			'FTCstPathImg'		=> $this->input->post('oetImgInsertorEditCustomer'),
			'FTCstStaActive'	=> ($this->input->post('ocmCUSStaUse') == 'on') ? 1 : 0,
			'FDCreateOn'		=> date('Y-m-d H:i:s'),
			'FTCreateBy'		=> $this->session->userdata('tSesUsercode')
		);

		$this->mCustomer->FSxMCUSInsert($aInsert);
		echo 'pass_insert';
	}

	//ลบ
	public function FSxCCUSEventDelete(){
		$tCode = $this->input->post('ptCode');
		$this->mCustomer->FSaMCUSDelete($tCode);
	}

	//อีเว้นท์แก้ไข
	public function FSxCCUSEventEdit(){
		try{
			$aSetUpdate = array(
				'FTCstName'			=> $this->input->post('oetCUSName'),
				'FTCstContactName'	=> $this->input->post('oetCUSContactname'),
				'FTCstCardID'		=> $this->input->post('oetCUSCardID'),
				'FTCstTaxNo'		=> $this->input->post('oetCUSTaxNo'),
				'FTCstSex'			=> $this->input->post('ordRadioOptions'),
				'FDCstDob'			=> $this->input->post('oetCUSDob'),
				'FTCstAddress'		=> $this->input->post('oetCUSAddress'),
				'FTCstTel'			=> $this->input->post('oetCUSTelphone'),
				'FTCstFax'			=> $this->input->post('oetCUSTelnumber'),
				'FTCstEmail'		=> $this->input->post('oetCUSEmail'),
				'FNCstPostCode'		=> $this->input->post('oetCUSPostCode'),
				'FTCstWebSite'		=> $this->input->post('oetCUSWebsite'),
				'FTCstReason'		=> $this->input->post('oetCUSReason'),
				'FTCstPathImg'		=> $this->input->post('oetImgInsertorEditCustomer'),
				'FTCstStaActive'	=> ($this->input->post('ocmCUSStaUse') == 'on') ? 1 : 0,
				'FTUpdateBy'		=> $this->session->userdata('tSesUsercode'),
				'FDUpdateOn'		=> date('Y-m-d H:i:s')
			);
			$aWhereUpdate = array(
				'FTCstCode'		=> $this->input->post('ohdCustomerCode')
			);
			$this->mCustomer->FSxMCUSUpdate($aSetUpdate,$aWhereUpdate);
			echo 'pass_update';
		}catch(Exception $Error){
            echo $Error;
        }
	}


}
