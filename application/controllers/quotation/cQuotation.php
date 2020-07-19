<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cQuotation extends CI_Controller
{

	public function __construct(){
		parent::__construct();
		$this->load->model('quotation/mQuotation');

	}

	//หน้า list สินค้า
	public function index($pnMode){
		$tWorkerID = $this->session->userdata('tSesLogID');
		if ($pnMode == 1) {
			$this->mQuotation->FSxMQUOClearTempByWorkID($tWorkerID);

			//สร้างข้อมูล tmp HD + HD customer ทิ้งไว้
			$this->mQuotation->FSxMQUPrepareHD($tWorkerID);
		}

		// $oFilterList  = $this->mQuotation->FSaMQUOGetFilterList();
		$this->mQuotation->FSxMQUOClearTemp();
		$this->load->model('product/product/mProduct');

		$aData = array(
			'aFilterList' 			=> '',
			'aFilter_Brand'         => $this->mProduct->FSaMPDTGetData_Filter('TCNMPdtBrand'),
			'aFilter_Color'         => $this->mProduct->FSaMPDTGetData_Filter('TCNMPdtColor'),
			'aFilter_Group'         => $this->mProduct->FSaMPDTGetData_Filter('TCNMPdtGrp'),
			'aFilter_Modal'         => $this->mProduct->FSaMPDTGetData_Filter('TCNMPdtModal'),
			'aFilter_Size'         	=> $this->mProduct->FSaMPDTGetData_Filter('TCNMPdtSize'),
			'aFilter_Type'         	=> $this->mProduct->FSaMPDTGetData_Filter('TCNMPdtType'),
			'aFilter_Unit'         	=> $this->mProduct->FSaMPDTGetData_Filter('TCNMPdtUnit'),
			'aFilter_Spl'         	=> $this->mProduct->FSaMPDTGetData_Filter('TCNMSpl')
		);
		$this->load->view('quotation/wQuotation', $aData);
	}

	/*
	Create On : 05/04/2020
	Create By : Kitpipat Kaewkieo
	Update On : -
	Update By : -

	เกี่ยวกับฟังก์ชั่น
	----------------------------------------------
	ข้อมูลสินค้าและราคาขาย
	เงื่อนไข
	1.คำนวนส่วนลดต้นทุนแล้ว
	2.คำนวนราคาขายแล้ว
	3.ราคานี้เป็นราคาตามกลุ่มราคาที่ผูกกับผู้ใช้ที่กำลังทำรายการ
	*/
	public function FCaCQUOGetProductList()
	{
		$nPage			= $this->input->GET('pnPage');
		$tSearchAll 	= $this->input->GET('tSearchAll');
		$tPdtViewType 	= $this->input->GET('tPdtViewType');
		$tPdtViewType 	= $this->input->GET('tPdtViewType');
		$aFilterAdv		= $this->input->GET('aFilterAdv');
		$tPriceGrp 		= $this->session->userdata('tSesPriceGroup');

		//การแสดงผลแบบรูปภาพ
		if(	$tPdtViewType == 1){
			$nRow = 16;
		}else{ //การแสดงข้อมูลแบบรายการ
			$nRow = 20;
		}

		$aFilter = array(
			'nPage'         => $nPage,
			'nRow'          => $nRow,
			"tSearchAll" 	=> $tSearchAll,
			"tPriceGrp"  	=> $tPriceGrp,
			'aFilterAdv'	=> $aFilterAdv
		);

		//get product list
		$aPdtList  		= $this->mQuotation->FSaMQUPdtList($aFilter);

		//data return to view
		$aData = array(
			'aPdtList' 		=> $aPdtList,
			'tPdtViewType' 	=> $tPdtViewType,
			'nPage'			=> $nPage
		);
		$this->load->view('quotation/wQuotationPdtList', $aData);
	}

	//เอาข้อมูลของเอกสารออกมาโชว์
	public function FCwCQUOCallDocHeader(){
		$this->load->model('user/user/mUser');
		$tWorkerID 		= $this->session->userdata('tSesLogID');
		$tWorkerName 	= $this->session->userdata('tSesFirstname');
		$tQuoDocNo 		= $this->input->get("tQuoDocNo");
		$aConditions 	= array("tDocNo" => $tQuoDocNo, "tWorkerID" => $tWorkerID);
		$aDocHD 		= $this->mQuotation->FCaMQUOGetDocHD($aConditions);
		$aData = array(
			"aDocHD" 		=> $aDocHD,
			"tWorkerID" 	=> $tWorkerID,
			"tWorkerName" 	=> $tWorkerName,
			'aBCHList'		=> $this->mUser->FSaMUSRGetBranch()
		);

		return $this->load->view('quotation/wQuotationHeader', $aData);
	}

	public function FCaCQUOCallItemsList()
	{

		$tWorkerID = $this->session->userdata('tSesLogID');
		$aConditions = array(
			"nMode" => 1,
			"tDocNo" => '',
			"tWorkerID" => $tWorkerID
		);

		$aQuoItemsList  = $this->mQuotation->FCaMQUOGetItemsList($aConditions);

		$aData = array('aQuoItemsList' => $aQuoItemsList);
		return $this->load->view('quotation/wQuotationItems', $aData);
	}

	public function FCaCQUOAddItem()
	{

		$tQuoDocNo = $this->input->post("tQuoDocNo");

		$tWorkerID = $this->session->userdata('tSesLogID');

		$oItem = $this->input->post("Item");

		$aItem = json_decode($oItem, true);

		// $nQTY = $this->mQuotation->FCnMQUExitingItem(array(
		// 	'tQuoDocNo' => $tQuoDocNo,
		// 	'tWorkerID' => $tWorkerID,
		// 	'tPdtCode'  => $aItem['tPdtCode']
		// ));

		$nQTY = 1;

		$nXqdSeq = $this->mQuotation->FCaMQUOGetItemLastSeq(array(
			"tDocNo" => $tQuoDocNo,
			"tWorkerID" => $tWorkerID
		));

		$aItemData = array(
			"FTXqhDocNo" => $tQuoDocNo,
			"FNXqdSeq" => $nXqdSeq,
			"FTPdtCode" => $aItem['tPdtCode'],
			"FTPdtName" => $aItem['tPdtName'],
			"FTPunCode" => $aItem['tPunCode'],
			"FTPunName" => $aItem['tPunName'],
			"FTSplCode" => $aItem['tSplCode'],
			"FTXqdCost" => $aItem['nPdtCost'],
			"FCXqdUnitPrice" => $nQTY * $aItem['nPdtUnitPri'],
			"FCXqdQty" => $nQTY,
			"FCXqdDis" => 0,
			"FCXqdFootAvg" => 0,
			"FTWorkerID" => $tWorkerID
		);

		if ($nQTY == 1) {
			$this->mQuotation->FCaMQUOAddItem2Temp($aItemData);
		} else {
			$this->mQuotation->FCxMQUOUpdateItem($aItemData);
		}
	}

	public function FCxCQUODelItem()
	{

		$tQuoDocNo = $this->input->post("tQuoDocNo");
		$tWorkerID = $this->session->userdata('tSesLogID');
		$nItemSeq = $this->input->post("nItemSeq");
		$aItemData = array(
			"tQuoDocNo" => $tQuoDocNo,
			"tWorkerID" => $tWorkerID,
			"nItemSeq"  => $nItemSeq
		);

		$this->mQuotation->FCxMQUODeleteItem($aItemData);
	}

	public function FCxCQUOEditItemQty()
	{

		$tQuoDocNo = $this->input->post("tQuoDocNo");
		$tWorkerID = $this->session->userdata('tSesLogID');
		$nItemSeq = $this->input->post("nItemSeq");
		$nItemQTY = $this->input->post("nItemQTY");
		$nUnitPrice = $this->input->post("nUnitPrice");
		$nPriB4Dis = $nItemQTY * $nUnitPrice;

		$aItemData = array(
			"tQuoDocNo" => $tQuoDocNo,
			"tWorkerID" => $tWorkerID,
			"nItemSeq"  => $nItemSeq,
			"nItemQTY"  => $nItemQTY,
			"nPriB4Dis" => $nPriB4Dis
		);

		$this->mQuotation->FCxMQUOEditItemQty($aItemData);
	}

	//โหลดข้อมูลเอกสาร
	public function FCwCQUOCallDocPage(){

		//update bch
		$tDocNo = $this->input->get("tQuoDocNo");
		$tBCH   = $this->input->get("tBCH");
		$aPackData = array(
			"tDocNo" => $tDocNo,
			"tBCH" 	 => $tBCH
		);
		$this->mQuotation->FCxMQUOUpdateBCHInQuotation($aPackData);


		$tDocNo = $this->input->get("tQuoDocNo");
		$aData = array(
			"tDocNo" 		=> $tDocNo,
			"tRouteFrom" 	=> 'Create'
		);
		$this->load->view("quotation/wQuotationDocForm", $aData);
	}
}
