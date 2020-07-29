<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cTypeproduct extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('product/typeproduct/mTypeproduct');
		$this->load->model('product/product/mProduct');
	}

	public function index(){
		$this->load->view('product/typeproduct/wTypeproductMain');
	}

	//โหลดข้อมูลประเภทสินค้า
	public function FSwCTYPLoadDatatable(){
		$nPage = $this->input->post('nPage');
		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 10,
			'tSearchAll'    => $this->input->post('tSearchAll')
		);

		$aTypeProductList = $this->mTypeproduct->FSaMTYPGetData($aCondition);
		$aPackData = array(
			'aTypeProductList'		=> $aTypeProductList,
			'nPage'					=> $nPage
		);
		$this->load->view('product/typeproduct/wTypeproductDatatable',$aPackData);
	}

	//โหลดหน้าจอเพื่มประเภทสินค้า + แก้ไขประเภทสินค้า
	public function FSwCTYPCallPageInsertorEdit(){
		$tTypePage = $this->input->post('tTypepage');
		if($tTypePage == 'insert'){
			$aResult	= '';
		}else if($tTypePage == 'edit'){
			$tCode 		= $this->input->post('tCode');
			$aResult 	= $this->mTypeproduct->FSaMTYPGetDataTypeProductBYID($tCode);
		}

		$aPackData = array(
			'tTypePage' 		=> $tTypePage,
			'aResult'			=> $aResult
		);
		$this->load->view('product/typeproduct/wTypeproductAdd',$aPackData);
	}

	//อีเว้นท์เพิ่มข้อมูล
	public function FSwCTYPEventInsert(){
		/*$aLastCode 	= $this->mTypeproduct->FSaMTYPGetLastTypePDTcode();
		if($aLastCode['rtCode'] == 800){
			$tFormatCode = '00001';
		}else{
			$nLastCode 		= $aLastCode['raItems'][0]['FTPtyCode'];
			$nNumber		= $nLastCode + 1;
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
		}*/

		//เช็ครหัสซ้ำก่อน
		$tFormatCode 		= $this->input->post('oetCodeTYPName');
		$aStatusCheckCode 	= $this->mProduct->FSaMPDTCheckCode('FTPtyCode','TCNMPdtType',$tFormatCode);
		if($aStatusCheckCode['rtCode'] == 800){
			$aInsertTYPPDT = array(
				'FTPtyCode'			=> $tFormatCode,
				'FTPtyName'			=> $this->input->post('oetTYPName'),
				'FDCreateOn'		=> date('Y-m-d H:i:s'),
				'FTCreateBy'		=> $this->session->userdata('tSesUsercode')
			);
			$this->mTypeproduct->FSxMTYPInsert($aInsertTYPPDT);
			echo 'pass_insert';
		}else{
			echo 'duplicate';
		}
	}

	//ลบประเภทสินค้า
	public function FSxCTYPEventDelete(){
		$tCode = $this->input->post('ptCode');
		$this->mTypeproduct->FSaMTYPDelete($tCode);
	}

	//อีเว้นท์แก้ไข
	public function FSxCTYPEventEdit(){
		try{
			$aSetUpdate = array(
				'FTPtyName'			=> $this->input->post('oetTYPName'),
				'FTUpdateBy'		=> $this->session->userdata('tSesUsercode'),
				'FDUpdateOn'		=> date('Y-m-d H:i:s')
			);
			$aWhereUpdate = array(
				'FTPtyCode'			=> $this->input->post('ohdTypeProductCode')
			);
			$this->mTypeproduct->FSxMTYPUpdate($aSetUpdate,$aWhereUpdate);
			echo 'pass_update';
		}catch(Exception $Error){
            echo $Error;
        }
	}


}
