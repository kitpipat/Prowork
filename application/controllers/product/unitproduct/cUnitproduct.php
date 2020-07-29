<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cUnitproduct extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('product/unitproduct/munitproduct');
		$this->load->model('product/product/mProduct');
	}

	public function index(){
		$this->load->view('product/unitproduct/wUnitproductMain');
	}

	//โหลดข้อมูลยี่ห้อสินค้า
	public function FSwCUNILoadDatatable(){
		$nPage = $this->input->post('nPage');
		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 10,
			'tSearchAll'    => $this->input->post('tSearchAll')
		);

		$aList 		= $this->munitproduct->FSaMUNIGetData($aCondition);
		$aPackData 	= array(
			'aList'				=> $aList,
			'nPage'				=> $nPage
		);
		$this->load->view('product/unitproduct/wUnitproductDatatable',$aPackData);
	}

	//โหลดหน้าจอเพื่มยี่ห้อสินค้า + แก้ไขยี่ห้อสินค้า
	public function FSwCUNICallPageInsertorEdit(){
		$tTypePage = $this->input->post('tTypepage');
		if($tTypePage == 'insert'){
			$aResult	= '';
		}else if($tTypePage == 'edit'){
			$tCode 		= $this->input->post('tCode');
			$aResult 	= $this->munitproduct->FSaMUNIGetDataunitproductBYID($tCode);
		}

		$aPackData = array(
			'tTypePage' 		=> $tTypePage,
			'aResult'			=> $aResult
		);
		$this->load->view('product/unitproduct/wUnitproductAdd',$aPackData);
	}

	//อีเว้นท์เพิ่มข้อมูล
	public function FSwCUNIEventInsert(){
		/*$aLastCode 	= $this->munitproduct->FSaMUNIGetLastBrandPDTcode();
		if($aLastCode['rtCode'] == 800){
			$tFormatCode = '00001';
		}else{
			$nLastCode 		= $aLastCode['raItems'][0]['FTPbnCode'];
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

		$tFormatCode 		= $this->input->post('oetCodeUNIName');
		$aStatusCheckCode 	= $this->mProduct->FSaMPDTCheckCode('FTPunCode','TCNMPdtUnit',$tFormatCode);
		if($aStatusCheckCode['rtCode'] == 800){
			$aInsertBrandPDT = array(
				'FTPunCode'			=> $tFormatCode,
				'FTPunName'			=> $this->input->post('oetUNIName'),
				'FDCreateOn'		=> date('Y-m-d H:i:s'),
				'FTCreateBy'		=> $this->session->userdata('tSesUsercode')
			);
			$this->munitproduct->FSxMUNIInsert($aInsertBrandPDT);
			echo 'pass_insert';
		}else{
			echo 'duplicate';
		}
	}

	//ลบ
	public function FSxCUNIEventDelete(){
		$tCode = $this->input->post('ptCode');
		$this->munitproduct->FSaMUNIDelete($tCode);
	}

	//อีเว้นท์แก้ไข
	public function FSxCUNIEventEdit(){
		try{
			$aSetUpdate = array(
				'FTPunName'			=> $this->input->post('oetUNIName'),
				'FTUpdateBy'		=> $this->session->userdata('tSesUsercode'),
				'FDUpdateOn'		=> date('Y-m-d H:i:s')
			);
			$aWhereUpdate = array(
				'FTPunCode'			=> $this->input->post('ohdunitProductCode')
			);
			$this->munitproduct->FSxMUNIUpdate($aSetUpdate,$aWhereUpdate);
			echo 'pass_update';
		}catch(Exception $Error){
            echo $Error;
        }
	}


}
