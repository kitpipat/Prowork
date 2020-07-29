<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cModalProduct extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('product/modalproduct/mModalproduct');
		$this->load->model('product/product/mProduct');
	}

	public function index(){
		$this->load->view('product/modalproduct/wModalproductMain');
	}

	//โหลดข้อมูลรุ่นสินค้า
	public function FSwCMOPLoadDatatable(){
		$nPage = $this->input->post('nPage');
		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 10,
			'tSearchAll'    => $this->input->post('tSearchAll')
		);

		$aModalProductList = $this->mModalproduct->FSaMMOPGetData($aCondition);
		$aPackData = array(
			'aModalProductList'		=> $aModalProductList,
			'nPage'					=> $nPage
		);
		$this->load->view('product/modalproduct/wModalproductDatatable',$aPackData);
	}

	//โหลดหน้าจอเพื่มรุ่นสินค้า + แก้ไขรุ่นสินค้า
	public function FSwCMOPCallPageInsertorEdit(){
		$tTypePage = $this->input->post('tTypepage');
		if($tTypePage == 'insert'){
			$aResult	= '';
		}else if($tTypePage == 'edit'){
			$tCode 		= $this->input->post('tCode');
			$aResult 	= $this->mModalproduct->FSaMMOPGetDataModalProductBYID($tCode);
		}

		$aPackData = array(
			'tTypePage' 		=> $tTypePage,
			'aResult'			=> $aResult
		);
		$this->load->view('product/modalproduct/wModalproductAdd',$aPackData);
	}

	//อีเว้นท์เพิ่มข้อมูล
	public function FSwCMOPEventInsert(){
		/*$aLastCode 	= $this->mModalproduct->FSaMMOPGetLastModalPDTcode();
		if($aLastCode['rtCode'] == 800){
			$tFormatCode = '00001';
		}else{
			$nLastCode 		= $aLastCode['raItems'][0]['FTMolCode'];
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

		$tFormatCode 		= $this->input->post('oetCodeMOLName');
		$aStatusCheckCode 	= $this->mProduct->FSaMPDTCheckCode('FTMolCode','TCNMPdtModal',$tFormatCode);
		if($aStatusCheckCode['rtCode'] == 800){
			$aInsertGroupPDT = array(
				'FTMolCode'			=> $tFormatCode,
				'FTMolName'			=> $this->input->post('oetMOLName'),
				'FDCreateOn'		=> date('Y-m-d H:i:s'),
				'FTCreateBy'		=> $this->session->userdata('tSesUsercode')
			);
			$this->mModalproduct->FSxMMOPInsert($aInsertGroupPDT);
			echo 'pass_insert';
		}else{
			echo 'duplicate';
		}
	}

	//ลบ
	public function FSxCMOPEventDelete(){
		$tCode = $this->input->post('ptCode');
		$this->mModalproduct->FSaMMOPDelete($tCode);
	}

	//อีเว้นท์แก้ไข
	public function FSxCMOPEventEdit(){
		try{
			$aSetUpdate = array(
				'FTMolName'			=> $this->input->post('oetMOLName'),
				'FTUpdateBy'		=> $this->session->userdata('tSesUsercode'),
				'FDUpdateOn'		=> date('Y-m-d H:i:s')
			);
			$aWhereUpdate = array(
				'FTMolCode'			=> $this->input->post('ohdModalProductCode')
			);
			$this->mModalproduct->FSxMMOPUpdate($aSetUpdate,$aWhereUpdate);
			echo 'pass_update';
		}catch(Exception $Error){
            echo $Error;
        }
	}


}
