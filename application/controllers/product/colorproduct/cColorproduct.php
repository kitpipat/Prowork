<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cColorproduct extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('product/colorproduct/mColorproduct');
		$this->load->model('product/product/mProduct');
	}

	public function index(){
		$this->load->view('product/colorproduct/wColorproductMain');
	}

	//โหลดข้อมูลสี
	public function FSwCCOPLoadDatatable(){
		$nPage = $this->input->post('nPage');
		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 10,
			'tSearchAll'    => $this->input->post('tSearchAll')
		);

		$aColorList = $this->mColorproduct->FSaMCOPGetData($aCondition);
		$aPackData = array(
			'aColorList'		=> $aColorList,
			'nPage'				=> $nPage
		);
		$this->load->view('product/colorproduct/wColorproductDatatable',$aPackData);
	}

	//โหลดหน้าจอเพื่มสี + แก้ไขสี
	public function FSwCCOPCallPageInsertorEdit(){
		$tTypePage = $this->input->post('tTypepage');
		if($tTypePage == 'insert'){
			$aResult	= '';
		}else if($tTypePage == 'edit'){
			$tCode 		= $this->input->post('tCode');
			$aResult 	= $this->mColorproduct->FSaMCOPGetDataColorProductBYID($tCode);
		}

		$aPackData = array(
			'tTypePage' 		=> $tTypePage,
			'aResult'			=> $aResult
		);
		$this->load->view('product/colorproduct/wColorproductAdd',$aPackData);
	}

	//อีเว้นท์เพิ่มข้อมูล
	public function FSwCCOPEventInsert(){
		/*$aLastCode 	= $this->mColorproduct->FSaMCOPGetLastColorPDTcode();
		if($aLastCode['rtCode'] == 800){
			$tFormatCode = '00001';
		}else{
			$nLastCode 		= $aLastCode['raItems'][0]['FTPClrCode'];
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
		$tFormatCode 		= $this->input->post('oetCodeCOPName');
		$aStatusCheckCode 	= $this->mProduct->FSaMPDTCheckCode('FTPClrCode','TCNMPdtColor',$tFormatCode);
		if($aStatusCheckCode['rtCode'] == 800){
			$aInsertColorPDT = array(
				'FTPClrCode'	=> $tFormatCode,
				'FTPClrName'	=> $this->input->post('oetCOPName'),
				'FDCreateOn'	=> date('Y-m-d H:i:s'),
				'FTCreateBy'	=> $this->session->userdata('tSesUsercode')
			);
			$this->mColorproduct->FSxMCOPInsert($aInsertColorPDT);
			echo 'pass_insert';
		}else{
			echo 'duplicate';
		}
	}

	//ลบ
	public function FSxCCOPEventDelete(){
		$tCode = $this->input->post('ptCode');
		$this->mColorproduct->FSaMCOPDelete($tCode);
	}

	//อีเว้นท์แก้ไข
	public function FSxCCOPEventEdit(){
		try{
			$aSetUpdate = array(
				'FTPClrName'		=> $this->input->post('oetCOPName'),
				'FTUpdateBy'		=> $this->session->userdata('tSesUsercode'),
				'FDUpdateOn'		=> date('Y-m-d H:i:s')
			);
			$aWhereUpdate = array(
				'FTPClrCode'		=> $this->input->post('ohdColorProductCode')
			);
			$this->mColorproduct->FSxMCOPUpdate($aSetUpdate,$aWhereUpdate);
			echo 'pass_update';
		}catch(Exception $Error){
            echo $Error;
        }
	}


}
