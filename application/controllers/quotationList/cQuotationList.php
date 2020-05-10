<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cQuotationList extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('quotationList/mQuotationList');
	}

	public function index(){
		$this->load->view('quotationList/wQuotationListMain');
	}

	//หน้าจอตาราง
	public function FSwCPILLoadDatatable(){
		$nPage = $this->input->post('nPage');
		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 10,
			'tSearchAll'    => $this->input->post('tSearchAll')
		);

		$aList = $this->mQuotationList->FSaMPILGetData($aCondition);
		$aPackData = array(
			'aList'		=> $aList,
			'nPage'		=> $nPage
		);
		$this->load->view('quotationList/wQuotationListDatatable',$aPackData);
	}

	//เอาข้อมูลจากตารางจริงลง Tmp ให้หมด เเล้ววิ่งไปหน้าที่พี่รันต์สร้างไว้
	public function FSwCPILCallPageEdit(){
		$tDocumentnumber 	= $this->input->post('ptCode');
		$tWorkerID 			= $this->session->userdata('tSesLogID');
		//ลบข้อมูลใน Tmp ก่อน
		$this->mQuotationList->FSaMPILDeleteTmpAll($tWorkerID);

		//Move HD -> Tmp
		$this->mQuotationList->FSaMPILMoveHDToTmp($tDocumentnumber,$tWorkerID);

		//Move DT -> Tmp
		$this->mQuotationList->FSaMPILMoveDTToTmp($tDocumentnumber,$tWorkerID);

		//Move HD Customer -> Tmp
		$this->mQuotationList->FSaMPILMoveHDCusToTmp($tDocumentnumber,$tWorkerID);

		$aData 	= array(
			"tDocNo" 		=> $tDocumentnumber ,
			"tRouteFrom" 	=> 'List'
		);
		$this->load->view("quotation/wQuotationDocForm", $aData);
	}

	//ลบเอกสาร
	public function FSwCPILEventDelete(){
		$tDocumentnumber 	= $this->input->post('ptCode');
		$tWorkerID 			= $this->session->userdata('tSesUsercode');

		//ลบข้อมูลใน Tmp ก่อน
		$this->mQuotationList->FSaMPILDeleteTmpAll($tWorkerID);

		//ลบข้อมูลในเอกสาร กับตารางที่เกี่ยวข้อง
		$this->mQuotationList->FSaMPILDeleteDocumentAll($tDocumentnumber);
	}

}
