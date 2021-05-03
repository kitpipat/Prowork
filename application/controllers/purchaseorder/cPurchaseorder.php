<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cPurchaseorder extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('purchaseorder/mPurchaseorder');
		date_default_timezone_set('Asia/Bangkok');
	}

	public function index(){
		$this->load->view('purchaseorder/wPurchaseorderMain');
	}

	//โหลดข้อมูลเอกสารใบสั้งซื้อ
	public function FSwCPOLoadDatatable(){
		$nPage = $this->input->post('nPage');
		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 10,
			'tSearchAll'    => $this->input->post('tSearchAll')
		);

		$aList = $this->mPurchaseorder->FSaMPOGetData($aCondition);
		$aPackData = array(
			'aList'				=> $aList,
			'nPage'				=> $nPage
		);
		$this->load->view('purchaseorder/wPurchaseorderDatatable',$aPackData);
	}

	//โหลดหน้าจอเพื่มข้อมูล + แก้ไขข้อมูล
	public function FSwCPOCallPageInsertorEdit(){
		$tTypePage = $this->input->post('tTypepage');

		//ลบข้อมูลใน Tmp ก่อน
		$this->mPurchaseorder->FSxMAJCDeleteTmpAfterInsDT('');

		if($tTypePage == 'insert'){
			$aResult	= '';
		}else if($tTypePage == 'edit'){
			$tCode 		= $this->input->post('tCode');
			$aResult 	= $this->mPurchaseorder->FSaMAJCGetDataBYID($tCode);

			//Move DT To Tmp
			$this->mPurchaseorder->FSaMAJCMoveDTToTmp($tCode);
		}

		//โหลดข้อมูล spl
		$this->load->model('product/product/mProduct');
		$aPackData = array(
			'tTypePage' 		=> $tTypePage,
			'aResult'			=> $aResult,
			'aFilter_Spl'       => $this->mProduct->FSaMPDTGetData_Filter('TCNMSpl')

		);
		$this->load->view('adjcost/wAdjcostAdd',$aPackData);
	}

	//ลบเอกสาร
	public function FSxCPOEventDelete(){
		$tCode = $this->input->post('ptCode');
		$this->mPurchaseorder->FSaMPODelete($tCode);
	}

}
