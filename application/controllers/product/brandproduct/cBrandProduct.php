<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cBrandProduct extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('product/brandproduct/mBrandproduct');
		$this->load->model('product/product/mProduct');

	}

	public function index(){
		$this->load->view('product/brandproduct/wBrandproductMain');
	}

	//โหลดข้อมูลยี่ห้อสินค้า
	public function FSwCBAPLoadDatatable(){
		$nPage = $this->input->post('nPage');
		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 10,
			'tSearchAll'    => $this->input->post('tSearchAll')
		);

		$aList 		= $this->mBrandproduct->FSaMBAPGetData($aCondition);
		$aPackData 	= array(
			'aList'				=> $aList,
			'nPage'				=> $nPage
		);
		$this->load->view('product/brandproduct/wBrandproductDatatable',$aPackData);
	}

	//โหลดหน้าจอเพื่มยี่ห้อสินค้า + แก้ไขยี่ห้อสินค้า
	public function FSwCBAPCallPageInsertorEdit(){
		$tTypePage = $this->input->post('tTypepage');
		if($tTypePage == 'insert'){
			$aResult	= '';
		}else if($tTypePage == 'edit'){
			$tCode 		= $this->input->post('tCode');
			$aResult 	= $this->mBrandproduct->FSaMBAPGetDataBrandProductBYID($tCode);
		}

		$aPackData = array(
			'tTypePage' 		=> $tTypePage,
			'aResult'			=> $aResult
		);
		$this->load->view('product/brandproduct/wBrandproductAdd',$aPackData);
	}

	//อีเว้นท์เพิ่มข้อมูล
	public function FSwCBAPEventInsert(){
		/*$aLastCode 	= $this->mBrandproduct->FSaMBAPGetLastBrandPDTcode();
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

		$tFormatCode 		= $this->input->post('oetCodeBANName');
		$aStatusCheckCode 	= $this->mProduct->FSaMPDTCheckCode('FTPbnCode','TCNMPdtBrand',$tFormatCode);
		if($aStatusCheckCode['rtCode'] == 800){
			$aInsertBrandPDT = array(
				'FTPbnCode'			=> $tFormatCode,
				'FTPbnName'			=> $this->input->post('oetBANName'),
				'FDCreateOn'		=> date('Y-m-d H:i:s'),
				'FTCreateBy'		=> $this->session->userdata('tSesUsercode')
			);
			$this->mBrandproduct->FSxMBAPInsert($aInsertBrandPDT);
			echo 'pass_insert';
		}else{
			echo 'duplicate';
		}
	}

	//ลบ
	public function FSxCBAPEventDelete(){
		$tCode = $this->input->post('ptCode');
		$this->mBrandproduct->FSaMBAPDelete($tCode);
	}

	//อีเว้นท์แก้ไข
	public function FSxCBAPEventEdit(){
		try{
			$aSetUpdate = array(
				'FTPbnName'			=> $this->input->post('oetBANName'),
				'FTUpdateBy'		=> $this->session->userdata('tSesUsercode'),
				'FDUpdateOn'		=> date('Y-m-d H:i:s')
			);
			$aWhereUpdate = array(
				'FTPbnCode'			=> $this->input->post('ohdBrandProductCode')
			);
			$this->mBrandproduct->FSxMBAPUpdate($aSetUpdate,$aWhereUpdate);
			echo 'pass_update';
		}catch(Exception $Error){
            echo $Error;
        }
	}


}
