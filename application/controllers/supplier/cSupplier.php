<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cSupplier extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('supplier/mSupplier');
		$this->load->model('product/product/mProduct');
	}

	public function index(){
		$this->load->view('supplier/wSupplierMain');
	}

	//โหลดข้อมูลผู้จำหน่าย
	public function FSwCSUPLoadDatatable(){
		$nPage = $this->input->post('nPage');
		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 10,
			'tSearchAll'    => $this->input->post('tSearchAll')
		);

		$aSUPList = $this->mSupplier->FSaMSUPGetData($aCondition);
		$aPackData = array(
			'aSUPList'	=> $aSUPList,
			'nPage'		=> $nPage
		);
		$this->load->view('supplier/wSupplierDatatable',$aPackData);
	}

	//โหลดหน้าจอผู้จำหน่าย + แก้ไขผู้จำหน่าย
	public function FSwCSUPCallPageInsertorEdit(){
		$tTypePage = $this->input->post('tTypepage');
		if($tTypePage == 'insert'){
			$aResult	= '';
		}else if($tTypePage == 'edit'){
			$tCode 		= $this->input->post('tCode');
			$aResult 	= $this->mSupplier->FSaMUSRGetDataSupplierBYID($tCode);
		}
		$aPackData = array(
			'tTypePage' 		=> $tTypePage,
			'aResult'			=> $aResult
		);
		$this->load->view('supplier/wSupplierAdd',$aPackData);
	}

	//อีเว้นท์เพิ่มข้อมูล
	public function FSwCSUPEventInsert(){

		/*$aLastSUPCode 	= $this->mSupplier->FSaMSUPGetLastSuppliercode();
		if($aLastSUPCode['rtCode'] == 800){
			$nSUPCode = '00001';
		}else{
			$nSUPCode 		= $aLastSUPCode['raItems'][0]['FTSplCode'];
			$nNumber		= $nSUPCode + 1;
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

		$tFormatCode 		= $this->input->post('oetCodeSupplier');
		$aStatusCheckCode 	= $this->mProduct->FSaMPDTCheckCode('FTSplCode','TCNMSpl',$tFormatCode);
		if($aStatusCheckCode['rtCode'] == 800){
			$aInsertSupplier = array(
				'FTSplCode'				=> $tFormatCode,
				'FTSplName'				=> $this->input->post('oetSupplierName'),
				'FTSplAddress'			=> $this->input->post('oetSupplierAddress'),
				'FTSplContact'			=> $this->input->post('oetSupplierContact'),
				'FTSplTel'				=> $this->input->post('oetSupplierTel'),
				'FTSplFax'				=> $this->input->post('oetSupplierTelNumber'),
				'FTSplEmail'			=> $this->input->post('oetSupplierEmail'),
				'FTSplPathImg'			=> $this->input->post('oetImgInsertorEditsupplier'),
				'FNSplVat'				=> $this->input->post('oetSupplierVat'),
				'FTSplVatType'			=> $this->input->post('oetSupplierVatType'),
				'FTSplStaActive'		=> ($this->input->post('ocmSupplierStaUse') == 'on') ? 1 : 0,
				'FTSplReason'			=> $this->input->post('oetSupplierReason'),
				'FDCreateOn'			=> date('Y-m-d H:i:s'),
				'FTCreateBy'			=> $this->session->userdata('tSesUsercode')
			);
			$this->mSupplier->FSxMSUPInsert($aInsertSupplier);
			echo 'pass_insert';
		}else{
			echo 'duplicate';
		}
	}

	//ลบผู้ใช้
	public function FSxCSUPEventDelete(){
		$tCode = $this->input->post('ptCode');
		$this->mSupplier->FSaMSUPDelete($tCode);
	}

	//อีเว้นท์แก้ไข
	public function FSxCSUPEventEdit(){
		try{
			$aSetUpdate = array(
				'FTSplName'				=> $this->input->post('oetSupplierName'),
				'FTSplAddress'			=> $this->input->post('oetSupplierAddress'),
				'FTSplContact'			=> $this->input->post('oetSupplierContact'),
				'FTSplTel'				=> $this->input->post('oetSupplierTel'),
				'FTSplFax'				=> $this->input->post('oetSupplierTelNumber'),
				'FTSplEmail'			=> $this->input->post('oetSupplierEmail'),
				'FTSplPathImg'			=> $this->input->post('oetImgInsertorEditsupplier'),
				'FNSplVat'				=> $this->input->post('oetSupplierVat'),
				'FTSplVatType'			=> $this->input->post('oetSupplierVatType'),
				'FTSplStaActive'		=> ($this->input->post('ocmSupplierStaUse') == 'on') ? 1 : 0,
				'FTSplReason'			=> $this->input->post('oetSupplierReason'),
				'FTLastUpdBy'			=> $this->session->userdata('tSesUsercode'),
				'FDLastUpdOn'			=> date('Y-m-d H:i:s')
			);
			$aWhereUpdate = array(
				'FTSplCode'		 	=> $this->input->post('ohdSupplierCode')
			);
			$this->mSupplier->FSxMSUPUpdate($aSetUpdate,$aWhereUpdate);
			echo 'pass_update';
		}catch(Exception $Error){
            echo $Error;
        }
	}



}
