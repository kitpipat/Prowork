<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cPurchaseorder extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('purchaseorder/mPurchaseorder');
		$this->load->model('user/user/mUser');
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

			//สร้าง HD Default ไว้หนึ่งใบ
			$this->mPurchaseorder->FSaMPOInsert_HDDefault();
		}else if($tTypePage == 'edit'){
			$tCode 		= $this->input->post('tCode');
			$aResult 	= $this->mPurchaseorder->FSaMPOGetDataBYID_HD($tCode);

			//Move DT To Tmp
			$this->mPurchaseorder->FSaMPOMoveDTToTmp($tCode);
		}

		$aPackData = array(
			'aBCHList'			=> $this->mUser->FSaMUSRGetBranch(),
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

	//แก้ไขราคาสินค้าในเอกสาร
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
		for($d=0; $d<$nDisLen; $d++){
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

	//แก้ไขจำนวนสินค้าในเอกสาร
	public function FSxCPOEventEditQty(){
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

		for($d=0; $d<$nDisLen; $d++){
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

	//แก้ไขส่วนลดรายการ
	public function FSxCPOEventItemDis(){
		$tDocNo 		= $this->input->post('tDocNo');
		$nItemSeq 		= $this->input->post('nItemSeq');
		$nItemDiscount 	= $this->input->post('nItemDiscount');
		$tPdtCode 		= $this->input->post('tPdtCode');
		$nItemNet 		= str_replace(",", "", $this->input->post('nItemNet'));
		$aDiscount 		= explode(",",$nItemDiscount);
		$nDiscountCal 	= 0;
		$nDisLen 		= count($aDiscount);
    	$nTotalDisCount = 0;
		$nItemNetLast 	= $nItemNet;

		for($d=0; $d<$nDisLen; $d++){
			$tDisType = substr(trim($aDiscount[$d]), strlen(trim($aDiscount[$d])) - 1);//ประเภทส่วนลด
			if($tDisType == '%'){
				$nDiscountCal 	= substr(trim($aDiscount[$d]), 0, strlen(trim($aDiscount[$d])) - 1);
				$nTotalDisCount = $nTotalDisCount + ($nItemNetLast * trim($nDiscountCal)) / 100;
				$nItemNetLast 	= $nItemNetLast - ($nItemNetLast * trim($nDiscountCal)) / 100;
			}else{
				$nDiscountCal 	= trim($aDiscount[$d]);
				if(is_numeric($nTotalDisCount) && is_numeric($nDiscountCal)){
					$nTotalDisCount = $nTotalDisCount+$nDiscountCal;
				}else{
					$nTotalDisCount = $nTotalDisCount+0;
				}
				$nItemNetLast 	= $nItemNetLast - $nTotalDisCount;
			}
		}

		$aItemDisData = array(
			"tDocNo" 		=> $tDocNo,
			"nItemSeq" 		=> $nItemSeq,
			"tPdtCode" 		=> $tPdtCode,
			"nDiscount" 	=> $nTotalDisCount,
			"tDisText" 		=> $nItemDiscount
		);
		$this->mPurchaseorder->FCxMPOEditItemDisCount($aItemDisData);
	}

	//ส่วนลดท้ายบิล
	public function FSxCPOEventFootDis(){
		$tDocNo 	  	= $this->input->post('tDocNo');
		$nDiscount 		= $this->input->post('nDiscount');
		$nNetB4HD 		= str_replace(",", "", $this->input->post('nNetB4HD'));
		$tWorkerID		= $this->session->userdata('tSesLogID');
		$aDiscount 		= explode(",",$nDiscount);
		$nDiscountCal 	= 0;
		$nDisLen 		= count($aDiscount);
    	$nTotalDisCount = 0;
		$nB4DisLast 	= $nNetB4HD;

		for($d=0; $d<$nDisLen; $d++){
			$tDisType = substr($aDiscount[$d], strlen($aDiscount[$d]) - 1);//ประเภทส่วนลด
			if($tDisType == '%'){
				$nDiscountCal 	= substr($aDiscount[$d], 0, strlen($aDiscount[$d]) - 1);
				$nTotalDisCount = $nTotalDisCount + ($nB4DisLast * $nDiscountCal) / 100;
				$nB4DisLast 	= $nB4DisLast - ($nB4DisLast * $nDiscountCal) / 100;
			}else{
				$nDiscountCal 	= $aDiscount[$d];
				$nTotalDisCount = $nTotalDisCount+$nDiscountCal;
				$nB4DisLast 	= $nB4DisLast - $nTotalDisCount;
			}
		}

		$aDisInfo = array(
			"tDocNo" 	=> $tDocNo,
			"nDiscount" => $nTotalDisCount,
			"tDisTxt" 	=> $nDiscount,
			"tWorkerID" => $tWorkerID
		);

		$this->mPurchaseorder->FCxMPOEditDocDisCount($aDisInfo);
		echo $nTotalDisCount;
	}

	//บันทึกเอกสารใหญ่
	public function FSxCPOEventInsert(){
		$tDocNo 		= $this->input->post('tDocNo');
		$nSplCode 		= $this->input->post('tSplCode');
		$tBchCode 		= $this->input->post('oetBCHPO');
		$tPOEftTo 		= $this->input->post('odpPOXpoEftTo');
		$tCashorCard 	= $this->input->post('osmPOCashorCard');
		$nCredit		= $this->input->post('oetPOXpoCredit');
		$nVatType 		= $this->input->post('ocmPOVatType');
		$tRemark 		= $this->input->post('tRemark');
		$tNewDocNo		= $this->mPurchaseorder->FCtMPOGetDocNo($tBchCode);

		//ข้อมูล HD
		$aDocUpdateHD 	= array(
			'FTXpoDocNoOld'		=> $tDocNo,
			'FTXpoDocNo'		=> $tNewDocNo,
			'FTBchCode'			=> $tBchCode,
			'FDXpoDocDate'		=> date('Y-m-d H:i:s'),
			'FTXpoCshOrCrd'		=> ($tCashorCard == '') ? '1' : $tCashorCard,
			'FNXpoCredit'		=> ($nCredit == '') ? '30' : $nCredit,
			'FTXpoVATInOrEx'	=> $nVatType,	
			'FDDeliveryDate'	=> $tPOEftTo,
			'FTXpoStaExpress'	=> 0,
			'FTXpoStaDoc'		=> 1,
			'FTXpoStaActive'	=> 1,
			'FTXpoStaDeli'		=> 1,
			'FTXpoRmk'			=> $tRemark,
			'FTXpoStaApv'		=> 0,	
			'FTXpoStaRefInt'	=> 0,
			'FTApprovedBy'		=> '',
			'FDApproveDate'		=> '',
			'FTCreateBy'		=> $this->session->userdata('tSesUsercode'),
			'FDCreateOn'		=> date('Y-m-d H:i:s'),
			'FTUpdateBy'		=> $this->session->userdata('tSesUsercode'),
			'FDUpdateOn'		=> date('Y-m-d H:i:s'),
		);
		$this->mPurchaseorder->FCxMPOUpdate_HDTmp($aDocUpdateHD);

		//ข้อมูล HD SPL
		$aDetailSPL			= $this->mPurchaseorder->FCxMPOGetSupplierByID($nSplCode);
		$aDocInsertHDSpl 	= array(
			'FTXpoDocNo'		=> $tNewDocNo,
			'FTXpoSplCode'		=> $nSplCode,
			'FTXpoSplName'		=> $aDetailSPL[0]['FTSplName'],
			'FTXpoAddress'		=> $aDetailSPL[0]['FTSplAddress'],
			'FTXpoTaxNo'		=> '-',
			'FTXpoContact'		=> $aDetailSPL[0]['FTSplContact'],
			'FTXpoEmail'		=> $aDetailSPL[0]['FTSplEmail'],
			'FTXpoTel'			=> $aDetailSPL[0]['FTSplTel'],
			'FTXpoFax'			=> $aDetailSPL[0]['FTSplFax'],
			'FTCreateBy'		=> $this->session->userdata('tSesUsercode'),
			'FDCreateOn'		=> date('Y-m-d H:i:s'),
			'FTUpdateBy'		=> $this->session->userdata('tSesUsercode'),
			'FDUpdateOn'		=> date('Y-m-d H:i:s')
		);
		$this->mPurchaseorder->FCxMPOInsert_SPLHD($aDocInsertHDSpl);

		//Move จาก DTTemp -> DT
		$this->mPurchaseorder->FCxMPOUpdate_DT($aDocUpdateHD);
		$this->mPurchaseorder->FCxMPOMoveTemp2DT($tNewDocNo);

		//Move จาก HDTemp -> HD
		$this->mPurchaseorder->FCxMPOMoveTemp2HD($tNewDocNo);

		//Prorate
		// $this->mQuotation->FCxMQUProrate($tXqhDocNo, $nB4Dis, $nDis);

		$aReturn = array(
			'tStatus' 			=> 'pass_insert',
			'tDocuementnumber'	=> $tNewDocNo
		);
		echo json_encode($aReturn);
	}


}
