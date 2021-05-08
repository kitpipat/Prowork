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

	//โหลดข้อมูลเอกสารใบสั่งซื้อ
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
		$this->mPurchaseorder->FSxMPODeleteTmpAfterInsDT('');

		if($tTypePage == 'insert'){
			$aResult	= '';
		}else if($tTypePage == 'edit'){
			$tCode 		= $this->input->post('tCode');
			$aResult 	= $this->mPurchaseorder->FSaMPOGetDataBYID_HD($tCode);

			//Move DT To Tmp
			$this->mPurchaseorder->FSaMPOMoveDTToTmp($tCode);
		}

		$aPackData = array(
			'tTypePage' 		=> $tTypePage,
			'aResult'			=> $aResult
		);
		$this->load->view('purchaseorder/wPurchaseorderAdd',$aPackData);
	}

	//ลบเอกสาร
	public function FSxCPOEventDelete(){
		$tCode = $this->input->post('ptCode');
		$this->mPurchaseorder->FSaMPODelete($tCode);
	}

	//เลือกผู้จำหน่าย
	public function FSxCPOSelectSupplier(){
		$nPage	= $this->input->post('nPage');

		$aCondition = array(
			'nPage'         	=> $nPage,
			'nRow'          	=> 10,
			'tSearchSupplier'   => $this->input->post('tSearchSupplier')
		);

		$aListSupplier 	= $this->mPurchaseorder->FCxMPOGetSupplierAll($aCondition);
		$aPackData 	= array(
			'aListSupplier'		=> $aListSupplier,
			'nPage'				=> $nPage
		);
		$this->load->view('purchaseorder/wSelectSupplier',$aPackData);
	}

	//โหลดข้อมูลสินค้าใน DT
	public function FSxCPOLoadItemDT(){
		$tCode 	= $this->input->post('tCode');
		$nPage 	= $this->input->post('nPage');

		$aListTmp 	= $this->mPurchaseorder->FSaMAJPGetDataInTmp($tCode);
		$aPackData 	= array(
			'aListTmp'				=> $aListTmp,
			'nPage'					=> $nPage
		);
		$this->load->view('purchaseorder/wPurchaseorderDTTmp',$aPackData);
	}

	//โหลดข้อมูลสินค้าใน Master
	public function FSvCPOLoadPDT(){
		$tTypepage 		= $this->input->post('tTypepage');
		$nPage			= $this->input->post('nPage');
		$tSPL			= $this->input->post('tSPL');

		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 10,
			'tSearchPDT'    => $this->input->post('tSearchPDT'),
			'tSPL'			=> $tSPL
		);

		$aListPDT 	= $this->mPurchaseorder->FSaMPOGetPDTToTmp($aCondition);
		$aPackData 	= array(
			'aListPDT'			=> $aListPDT,
			'nPage'				=> $nPage
		);
		$this->load->view('purchaseorder/wPurchaseorderDatatableBrowsePDT',$aPackData);
	}

	//เอาข้อมูลสินค้าที่เลือก ไป insert ลง temp
	public function FSvCPOInsPDTToTmp(){
		$tTypepage 		= $this->input->post('tTypepage');
		$tCode			= $this->input->post('tCode');
		$aData			= $this->input->post('aData');
		if($aData !== null){
			$aResult = explode(",",$aData);

			$nSeq = $this->mPurchaseorder->FCaMPOGetItemLastSeq(array(
				"FTXpoDocNo" 	=> $tCode,
				"tWorkerID" 	=> $this->session->userdata('tSesLogID')
			));

			for($i=0; $i<count($aResult); $i++){

				$oItem = $this->mPurchaseorder->FCaMPOGetDetailItemAndPrice($aResult[$i]);
				$aItem = $oItem['raItems'][0];
				$nQTY  = 1;
 				$aIns  = array(
					"FTXpoDocNo" 		=> $tCode,
					"FNXpoSeq" 			=> $nSeq + $i,
					"FTPdtCode" 		=> $aItem['FTPdtCode'],
					"FTPdtName" 		=> $aItem['FTPdtName'],
					"FTPunCode" 		=> $aItem['FTPunCode'],
					"FTPunName" 		=> $aItem['FTPunName'],
					"FTSplCode" 		=> $aItem['FTSplCode'],
					"FTXpoCost" 		=> $aItem['FCPdtCostAfDis'],
					"FCXpoUnitPrice" 	=> $nQTY * $aItem['FCPdtCostAfDis'],
					"FCXpoQty" 			=> $nQTY,
					"FCXpoDis" 			=> 0,
					"FCXpoFootAvg" 		=> 0,
					"FTPdtStaEditName"	=> $aItem['FTPdtStaEditName'],
					"FDCreateOn"		=> date('Y-m-d'),	
					'FTWorkerID'		=> $this->session->userdata('tSesLogID')
				);
				$this->mPurchaseorder->FSaMPOInsertPDTToTmp($aIns);
			}
		}
	}

	//ลบข้อมูลสินค้าใน temp
	public function FSvCPODeleteDTInTmp(){
		$tDocument 	= $this->input->post('ptDocument');
		$nSeq 		= $this->input->post('pnSeq');
		$nPDTCode 	= $this->input->post('pnPDTCode');

		$aItem = array(
			'FTXpoDocNo'	=> $tDocument,
			'FNXpoSeq'		=> $nSeq,
			'FTPdtCode'		=> $nPDTCode
		);
		$this->mPurchaseorder->FCxMPODeleteItemInTemp($aItem);
	}

	// แก้ไขราคาสินค้าในเอกสาร
	public function FSxCPOEventItemPri(){
		$nItemSeq 		= $this->input->post('nItemSeq');
		$tDocNo 		= $this->input->post('tDocNo');
		$nItemQTY 		= str_replace(",", "", $this->input->post('nItemQTY'));
		$tPdtCode 		= $this->input->post('tPdtCode');
		$nPdtUnitPrice 	= str_replace(",", "", $this->input->post('nPdtUnitPrice'));
		$nItemDiscount 	= $this->input->post('nItemDiscount');
		$nItemNet 		= number_format($nItemQTY, 0) * $nPdtUnitPrice;
		$aDiscount 		= explode(",",$nItemDiscount);
		$nDiscountCal 	= 0;
		$nDisLen 		= count($aDiscount);
    	$nTotalDisCount = 0;
		$nItemNetLast 	= $nItemNet;
		for($d = 0;$d<$nDisLen;$d++){
			$tDisType = substr($aDiscount[$d], strlen($aDiscount[$d]) - 1);//ประเภทส่วนลด
			if($tDisType == '%'){
				$nDiscountCal 	= substr($aDiscount[$d], 0, strlen($aDiscount[$d]) - 1);
				$nTotalDisCount = $nTotalDisCount + ($nItemNetLast * $nDiscountCal) / 100;
				$nItemNetLast 	= $nItemNetLast - ($nItemNetLast * $nDiscountCal) / 100;
			}else{
				$nDiscountCal 	= $aDiscount[$d];
				$nTotalDisCount = $nTotalDisCount+$nDiscountCal;
            	$nItemNetLast 	= $nItemNetLast - $nTotalDisCount;
			}
		}

		$aDataUpdate = array(
			"tDocNo" 		=> $tDocNo,
			"nItemSeq" 		=> $nItemSeq,
			"nPdtUnitPrice" => $nPdtUnitPrice,
			"tPdtCode" 		=> $tPdtCode,
			"nDiscount" 	=> $nTotalDisCount
		);
		$this->mPurchaseorder->FCxMPOEditUnitPriInTemp($aDataUpdate);
	}

	// แก้ไขจำนวนสินค้าในเอกสาร
	public function FSxCPOOEventEditQty(){
		$nItemSeq 		= $this->input->post('nItemSeq');
		$tDocNo 		= $this->input->post('tDocNo');
		$nItemQTY 		= str_replace(",", "", $this->input->post('nItemQTY'));
		$tPdtCode 		= $this->input->post('tPdtCode');
		$nPdtUnitPrice 	= str_replace(",", "", $this->input->post('nPdtUnitPrice'));
		$nItemDiscount 	= $this->input->post('nItemDiscount');
		$nItemNet 		= number_format($nItemQTY, 0) * $nPdtUnitPrice;
		$aDiscount 		= explode(",",$nItemDiscount);
		$nDiscountCal 	= 0;
		$nDisLen 		= count($aDiscount);
    	$nTotalDisCount = 0;
		$nItemNetLast 	= $nItemNet;

		for($d=0;$d<$nDisLen;$d++){
			$tDisType = substr($aDiscount[$d], strlen($aDiscount[$d]) - 1); //ประเภทส่วนลด
			if($tDisType == '%'){
				$nDiscountCal 	= substr($aDiscount[$d], 0, strlen($aDiscount[$d]) - 1);
				$nTotalDisCount = $nTotalDisCount + ($nItemNetLast * $nDiscountCal) / 100;
				$nItemNetLast 	= $nItemNetLast - ($nItemNetLast * $nDiscountCal) / 100;
			}else{
				$nDiscountCal = $aDiscount[$d];
				if(is_numeric($nTotalDisCount) && is_numeric($nDiscountCal)){
					$nTotalDisCount = $nTotalDisCount + $nDiscountCal;
				}else{
					$nTotalDisCount = $nTotalDisCount+0;
				}
				$nItemNetLast = $nItemNetLast - $nTotalDisCount;
			}
		}

		$aDataUpdate = array(
			"tDocNo" 	=> $tDocNo,
			"nItemSeq" 	=> $nItemSeq,
			"nItemQTY" 	=> $nItemQTY,
			"tPdtCode" 	=> $tPdtCode,
			"nDiscount" => $nTotalDisCount,
			'tDisText'  => $nItemDiscount
		);

		$this->mPurchaseorder->FCxMPOEditItemInTemp($aDataUpdate);
	}

}
