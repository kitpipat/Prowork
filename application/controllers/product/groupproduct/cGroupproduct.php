<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cGroupproduct extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('product/groupproduct/mGroupproduct');
	}

	public function index(){
		$this->load->view('product/groupproduct/wGroupproductMain');
	}

	//โหลดข้อมูลกลุ่มสินค้า
	public function FSwCGRPLoadDatatable(){
		$nPage = $this->input->post('nPage');
		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 10,
			'tSearchAll'    => $this->input->post('tSearchAll')
		);

		$aGroupList = $this->mGroupproduct->FSaMGRPGetData($aCondition);
		$aPackData = array(
			'aGroupList'		=> $aGroupList,
			'nPage'				=> $nPage
		);
		$this->load->view('product/groupproduct/wGroupproductDatatable',$aPackData);
	}

	//โหลดหน้าจอเพื่มกลุ่มสินค้า + แก้ไขกลุ่มสินค้า
	public function FSwCGRPCallPageInsertorEdit(){
		$tTypePage = $this->input->post('tTypepage');
		if($tTypePage == 'insert'){
			$aResult	= '';
		}else if($tTypePage == 'edit'){
			$tCode 		= $this->input->post('tCode');
			$aResult 	= $this->mGroupproduct->FSaMGRPGetDataGroupProductBYID($tCode);
		}

		$aPackData = array(
			'tTypePage' 		=> $tTypePage,
			'aResult'			=> $aResult
		);
		$this->load->view('product/groupproduct/wGroupproductAdd',$aPackData);
	}

	//อีเว้นท์เพิ่มข้อมูล
	public function FSwCGRPEventInsert(){
		$aLastCode 	= $this->mGroupproduct->FSaMGRPGetLastGroupPDTcode();
		if($aLastCode['rtCode'] == 800){
			$nLastCode = '00001';
		}else{
			$nLastCode 		= $aLastCode['raItems'][0]['FTPgpCode'];
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
		}

		$aInsertGroupPDT = array(
			'FTPgpCode'			=> $tFormatCode,
			'FTPgpName'			=> $this->input->post('oetGRPName'),
			'FDCreateOn'		=> date('Y-m-d H:i:s'),
			'FTCreateBy'		=> $this->session->userdata('tSesUsercode')
		);
		$this->mGroupproduct->FSxMGRPInsert($aInsertGroupPDT);
		echo 'pass_insert';
	}

	//ลบกลุ่มสินค้า
	public function FSxCGRPEventDelete(){
		$tCode = $this->input->post('ptCode');
		$this->mGroupproduct->FSaMGRPDelete($tCode);
	}

	//อีเว้นท์แก้ไข
	public function FSxCGRPEventEdit(){
		try{
			$aSetUpdate = array(
				'FTPgpName'			=> $this->input->post('oetGRPName'),
				'FTUpdateBy'		=> $this->session->userdata('tSesUsercode'),
				'FDUpdateOn'		=> date('Y-m-d H:i:s')
			);
			$aWhereUpdate = array(
				'FTPgpCode'			=> $this->input->post('ohdGroupProductCode')
			);
			$this->mGroupproduct->FSxMGRPUpdate($aSetUpdate,$aWhereUpdate);
			echo 'pass_update';
		}catch(Exception $Error){
            echo $Error;
        }
	}


}
