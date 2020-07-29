<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cSizeproduct extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('product/sizeproduct/mSizeproduct');
		$this->load->model('product/product/mProduct');
	}

	public function index(){
		$this->load->view('product/sizeproduct/wSizeproductMain');
	}

	//โหลดข้อมูลไซด์
	public function FSwCSIZLoadDatatable(){
		$nPage = $this->input->post('nPage');
		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 10,
			'tSearchAll'    => $this->input->post('tSearchAll')
		);

		$aSizeProductList = $this->mSizeproduct->FSaMSIZGetData($aCondition);
		$aPackData = array(
			'aSizeProductList'		=> $aSizeProductList,
			'nPage'					=> $nPage
		);
		$this->load->view('product/sizeproduct/wSizeproductDatatable',$aPackData);
	}

	//โหลดหน้าจอเพื่มไซด์ + แก้ไขไซด์
	public function FSwCSIZCallPageInsertorEdit(){
		$tTypePage = $this->input->post('tTypepage');
		if($tTypePage == 'insert'){
			$aResult	= '';
		}else if($tTypePage == 'edit'){
			$tCode 		= $this->input->post('tCode');
			$aResult 	= $this->mSizeproduct->FSaMSIZGetDataSizeProductBYID($tCode);
		}

		$aPackData = array(
			'tTypePage' 		=> $tTypePage,
			'aResult'			=> $aResult
		);
		$this->load->view('product/sizeproduct/wSizeproductAdd',$aPackData);
	}

	//อีเว้นท์เพิ่มข้อมูล
	public function FSwCSIZEventInsert(){
		/*$aLastCode 	= $this->mSizeproduct->FSaMSIZGetLastSizePDTcode();
		if($aLastCode['rtCode'] == 800){
			$tFormatCode = '00001';
		}else{
			$nLastCode 		= $aLastCode['raItems'][0]['FTPzeCode'];
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

		$tFormatCode 		= $this->input->post('oetCodeSIZName');
		$aStatusCheckCode 	= $this->mProduct->FSaMPDTCheckCode('FTPzeCode','TCNMPdtSize',$tFormatCode);
		if($aStatusCheckCode['rtCode'] == 800){
			$aInsertSizePDT = array(
				'FTPzeCode'			=> $tFormatCode,
				'FTPzeName'			=> $this->input->post('oetSIZName'),
				'FDCreateOn'		=> date('Y-m-d H:i:s'),
				'FTCreateBy'		=> $this->session->userdata('tSesUsercode')
			);
			$this->mSizeproduct->FSxMSIZInsert($aInsertSizePDT);
			echo 'pass_insert';
		}else{
			echo 'duplicate';
		}
	}

	//ลบ
	public function FSxCSIZEventDelete(){
		$tCode = $this->input->post('ptCode');
		$this->mSizeproduct->FSaMSIZDelete($tCode);
	}

	//อีเว้นท์แก้ไข
	public function FSxCSIZEventEdit(){
		try{
			$aSetUpdate = array(
				'FTPzeName'			=> $this->input->post('oetSIZName'),
				'FTUpdateBy'		=> $this->session->userdata('tSesUsercode'),
				'FDUpdateOn'		=> date('Y-m-d H:i:s')
			);
			$aWhereUpdate = array(
				'FTPzeCode'			=> $this->input->post('ohdSizeProductCode')
			);
			$this->mSizeproduct->FSxMSIZUpdate($aSetUpdate,$aWhereUpdate);
			echo 'pass_update';
		}catch(Exception $Error){
            echo $Error;
        }
	}


}
