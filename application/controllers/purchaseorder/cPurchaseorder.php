<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cPurchaseorder extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('Pdf');
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

	//แปลงตัวเลขเป็น TEXT
	public function FCNtReadNumber($number){
		$txtnum1 = array('ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า', 'สิบ');
		$txtnum2 = array('', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');
		$number = str_replace(",", "", $number);
		$number = str_replace(" ", "", $number);
		$number = str_replace("บาท", "", $number);
		$number = explode(".", $number);
		if (sizeof($number) > 2) {
			return 'ทศนิยมหลายตัวนะจ๊ะ';
			exit;
		}
		$strlen = strlen($number[0]);
		$convert = '';
		for ($i = 0; $i < $strlen; $i++) {
			$n = substr($number[0], $i, 1);
			if ($n != 0) {
				if ($i == ($strlen - 1) and $n == 1) {
					$convert .= 'เอ็ด';
				} elseif ($i == ($strlen - 2) and $n == 2) {
					$convert .= 'ยี่';
				} elseif ($i == ($strlen - 2) and $n == 1) {
					$convert .= '';
				} else {
					$convert .= $txtnum1[$n];
				}
				$convert .= $txtnum2[$strlen - $i - 1];
			}
		}

		$convert .= 'บาท';
		if ($number[1] == '0' or $number[1] == '00' or $number[1] == '') {
			$convert .= 'ถ้วน';
		} else {
			$strlen = strlen($number[1]);
			for ($i = 0; $i < $strlen; $i++) {
				$n = substr($number[1], $i, 1);
				if ($n != 0) {
					if ($i == ($strlen - 1) and $n == 1) {
						$convert
							.= 'เอ็ด';
					} elseif (
						$i == ($strlen - 2) and
						$n == 2
					) {
						$convert .= 'ยี่';
					} elseif (
						$i == ($strlen - 2) and
						$n == 1
					) {
						$convert .= '';
					} else {
						$convert .= $txtnum1[$n];
					}
					$convert .= $txtnum2[$strlen - $i - 1];
				}
			}
			$convert .= 'สตางค์';
		}
		
		return $convert;
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

			//Move HD To Tmp
			$this->mPurchaseorder->FSaMPOMoveHDToTmp($tCode);
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
				$nItemNetLast 	= $nItemNetLast - $nDiscountCal;
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
				$nB4DisLast 	= $nB4DisLast - $nDiscountCal;
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

	//เเก้ไขชื่อในรายการ
	public function FSxCPOChangenameinDT(){
		$nSeq 				= $this->input->post('pnSeq');
		$nPDTCode 			= $this->input->post('pnPDTCode');
		$tPDTName 			= $this->input->post('ptPDTName');
		$tDocumentNumber	= $this->input->post('ptDocumentNumber');
		$tWorkerID 			= $this->session->userdata('tSesLogID');

		$aPackData 		= array(
			'nSeq'					=> $nSeq,
			'nPDTCode'				=> $nPDTCode,
			'tPDTName'				=> $tPDTName,
			'tWorkerID'				=> $tWorkerID,
			'tDocumentNumber'		=> $tDocumentNumber
		);
		$this->mPurchaseorder->FCxMPOChangenameinDT($aPackData);
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
		$nB4Dis 		= $this->input->post('nB4Dis');
		$nDis 			= $this->input->post('nDis');
		$tDisText 		= $this->input->post('tDisText');
		$nAfDis			= $this->input->post('nAfDis');
		$nVatRate		= $this->input->post('nVatRate');
		$nAmtVat		= $this->input->post('nAmtVat');
		$nVatable		= $this->input->post('nVatable');
		$nGrandTotal	= $this->input->post('nGrandTotal');

		//ข้อมูลผู้จำหน่าย
		$tSPLPOAddress	= $this->input->post('tSPLPOAddress');
		$tSPLPOContact	= $this->input->post('tSPLPOContact');
		$tSPLPOEmail	= $this->input->post('tSPLPOEmail');
		$tSPLPOTel		= $this->input->post('tSPLPOTel');
		$tSPLPOFax		= $this->input->post('tSPLPOFax');

		$tGndText 		= $this->FCNtReadNumber(str_replace(",", "", $nGrandTotal));
		$tNewDocNo		= $this->mPurchaseorder->FCtMPOGetDocNo($tBchCode);
		
		if ($nVatType  == 1) { //แยกนอก
			$nVatable = $nAfDis;
		} else { //รวมใน
			$nVatable = str_replace(",", "", $nAfDis) - str_replace(",", "", $nAmtVat);
		}

		//ข้อมูล HD
		$this->db->trans_begin();
		$aDocUpdateHD 	= array(
			'FTXpoDocNoOld'		=> $tDocNo,
			'FTXpoDocNo'		=> $tNewDocNo,
			'FTBchCode'			=> $tBchCode,
			'FDXpoDocDate'		=> date('Y-m-d H:i:s'),
			'FTXpoCshOrCrd'		=> ($tCashorCard == '') ? '1' : $tCashorCard,
			'FNXpoCredit'		=> ($nCredit == '') ? '30' : $nCredit,
			'FTXpoVATInOrEx'	=> $nVatType,	
			'FDDeliveryDate'	=> date('Y-m-d',strtotime(str_replace('/', '-', $tPOEftTo))) . ' ' . date('H:i:s'),
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
			"FCXpoB4Dis" 		=> str_replace(",", "", $nB4Dis),
			"FCXpoDis" 			=> str_replace(",", "", $nDis),
			"FTXpoDisTxt" 		=> $tDisText,
			"FCXpoAFDis" 		=> str_replace(",", "", $nAfDis),
			"FCXpoVatRate" 		=> str_replace(",", "", $nVatRate),
			"FCXpoAmtVat" 		=> str_replace(",", "", $nAmtVat),
			"FCXpoVatable" 		=> str_replace(",", "", $nVatable),
			"FCXpoGrand" 		=> str_replace(",", "", $nGrandTotal),
			"FTXpoGndText" 		=> $tGndText
		);
		$this->mPurchaseorder->FCxMPOUpdate_HDTmp($aDocUpdateHD);

		//ข้อมูล HD SPL
		$aDetailSPL			= $this->mPurchaseorder->FCxMPOGetSupplierByID($nSplCode);
		$aDocInsertHDSpl 	= array(
			'FTXpoDocNo'		=> $tNewDocNo,
			'FTXpoSplCode'		=> $nSplCode,
			'FTXpoSplName'		=> $aDetailSPL[0]['FTSplName'],
			'FTXpoAddress'		=> $tSPLPOAddress,
			'FTXpoTaxNo'		=> '-',
			'FTXpoContact'		=> $tSPLPOContact,
			'FTXpoEmail'		=> $tSPLPOEmail,
			'FTXpoTel'			=> $tSPLPOTel,
			'FTXpoFax'			=> $tSPLPOFax,
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
		$this->mPurchaseorder->FCxMPOProrate($tNewDocNo, $nB4Dis, $nDis);

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		}else{
			$this->db->trans_commit();
		}

		$aReturn = array(
			'tStatus' 			=> 'pass_insert',
			'tDocuementnumber'	=> $tNewDocNo
		);
		echo json_encode($aReturn);
	}

	//แก้ไขบันทึกเอกสารใหญ่
	public function FSxCPOEventEdit(){
		$tDocNo 		= $this->input->post('tDocNo');
		$nSplCode 		= $this->input->post('tSplCode');
		$tBchCode 		= $this->input->post('oetBCHPO');
		$tPOEftTo 		= $this->input->post('odpPOXpoEftTo');
		$tCashorCard 	= $this->input->post('osmPOCashorCard');
		$nCredit		= $this->input->post('oetPOXpoCredit');
		$nVatType 		= $this->input->post('ocmPOVatType');
		$tRemark 		= $this->input->post('tRemark');
		$nB4Dis 		= $this->input->post('nB4Dis');
		$nDis 			= $this->input->post('nDis');
		$tDisText 		= $this->input->post('tDisText');
		$nAfDis			= $this->input->post('nAfDis');
		$nVatRate		= $this->input->post('nVatRate');
		$nAmtVat		= $this->input->post('nAmtVat');
		$nVatable		= $this->input->post('nVatable');
		$nGrandTotal	= $this->input->post('nGrandTotal');
		$tGndText 		= $this->FCNtReadNumber(str_replace(",", "", $nGrandTotal));

		//ข้อมูลผู้จำหน่าย
		$tSPLPOAddress	= $this->input->post('tSPLPOAddress');
		$tSPLPOContact	= $this->input->post('tSPLPOContact');
		$tSPLPOEmail	= $this->input->post('tSPLPOEmail');
		$tSPLPOTel		= $this->input->post('tSPLPOTel');
		$tSPLPOFax		= $this->input->post('tSPLPOFax');
		
		if ($nVatType  == 1) { //แยกนอก
			$nVatable = $nAfDis;
		} else { //รวมใน
			$nVatable = str_replace(",", "", $nAfDis) - str_replace(",", "", $nAmtVat);
		}

		//ข้อมูล HD
		$this->db->trans_begin();
		$aDocUpdateHD 	= array(
			'FTXpoDocNoOld'		=> $tDocNo,
			'FTXpoDocNo'		=> $tDocNo,
			'FTBchCode'			=> $tBchCode,
			'FDXpoDocDate'		=> date('Y-m-d H:i:s'),
			'FTXpoCshOrCrd'		=> ($tCashorCard == '') ? '1' : $tCashorCard,
			'FNXpoCredit'		=> ($nCredit == '') ? '30' : $nCredit,
			'FTXpoVATInOrEx'	=> $nVatType,	
			'FDDeliveryDate'	=> date('Y-m-d',strtotime(str_replace('/', '-', $tPOEftTo))) . ' ' . date('H:i:s'),
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
			"FCXpoB4Dis" 		=> str_replace(",", "", $nB4Dis),
			"FCXpoDis" 			=> str_replace(",", "", $nDis),
			"FTXpoDisTxt" 		=> $tDisText,
			"FCXpoAFDis" 		=> str_replace(",", "", $nAfDis),
			"FCXpoVatRate" 		=> str_replace(",", "", $nVatRate),
			"FCXpoAmtVat" 		=> str_replace(",", "", $nAmtVat),
			"FCXpoVatable" 		=> str_replace(",", "", $nVatable),
			"FCXpoGrand" 		=> str_replace(",", "", $nGrandTotal),
			"FTXpoGndText" 		=> $tGndText
		);
		$this->mPurchaseorder->FCxMPOUpdate_HDTmp($aDocUpdateHD);

		//ข้อมูล HD SPL
		$aDetailSPL			= $this->mPurchaseorder->FCxMPOGetSupplierByID($nSplCode);
		$aDocInsertHDSpl 	= array(
			'FTXpoDocNo'		=> $tDocNo,
			'FTXpoSplCode'		=> $nSplCode,
			'FTXpoSplName'		=> $aDetailSPL[0]['FTSplName'],
			'FTXpoAddress'		=> $tSPLPOAddress,
			'FTXpoTaxNo'		=> '-',
			'FTXpoContact'		=> $tSPLPOContact,
			'FTXpoEmail'		=> $tSPLPOEmail,
			'FTXpoTel'			=> $tSPLPOTel,
			'FTXpoFax'			=> $tSPLPOFax,
			'FTCreateBy'		=> $this->session->userdata('tSesUsercode'),
			'FDCreateOn'		=> date('Y-m-d H:i:s'),
			'FTUpdateBy'		=> $this->session->userdata('tSesUsercode'),
			'FDUpdateOn'		=> date('Y-m-d H:i:s')
		);
		$this->mPurchaseorder->FCxMPOUpdate_SPLHD($aDocInsertHDSpl);

		//Move จาก DTTemp -> DT
		$this->mPurchaseorder->FCxMPOMoveTemp2DT($tDocNo);

		//Move จาก HDTemp -> HD
		$this->mPurchaseorder->FCxMPOMoveTemp2HD($tDocNo);

		//Prorate
		$this->mPurchaseorder->FCxMPOProrate($tDocNo, $nB4Dis, $nDis);

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		}else{
			$this->db->trans_commit();
		}

		$aReturn = array(
			'tStatus' 			=> 'pass_update',
			'tDocuementnumber'	=> $tDocNo
		);
		echo json_encode($aReturn);
	}

	//ยกเลิกเอกสาร
	public function FSxCPOCancelDocument(){
		$tCode = $this->input->post('tCode');
		$this->mPurchaseorder->FSaMPOCancelDocument($tCode);
	}

	//อนุมัติเอกสาร
	public function FSxCPOAproveDocument(){
		$tCode = $this->input->post('tCode');
		$this->mPurchaseorder->FSaMPOAproveDocument($tCode);
	}

	//พิมพ์
	public function FSaCPODocPrintForm($ptDocNo,$aParametertwo){
		// สร้าง object สำหรับใช้สร้าง pdf
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// กำหนดรายละเอียดของ pdf
		$pdf->SetTitle('ใบสั่งซื้อ : ' . $ptDocNo);

		// กำหนดข้อมูลที่จะแสดงในส่วนของ header และ footer
		$pdf->setPrintHeader(false);
		$pdf->setFooterData(array(0,64,0), array(0,64,128));
		$pdf->setPrintFooter(true);

		// กำหนดรูปแบบของฟอนท์และขนาดฟอนท์ที่ใช้ใน header และ footer
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// กำหนดค่าเริ่มต้นของฟอนท์แบบ monospaced
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// กำหนด margins
		//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetMargins(5, 5, 5);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->setCellHeightRatio(1.2);

		// กำหนดการแบ่งหน้าอัตโนมัติ
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// กำหนดรูปแบบการปรับขนาดของรูปภาพ
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set default font subsetting mode
		$pdf->setFontSubsetting(true);

		// กำหนดฟอนท์
		// ฟอนท์ freeserif รองรับภาษาไทย
		$pdf->SetFont('THSarabunNew', '', 13, '', true);

		// เพิ่มหน้า pdf
		// การกำหนดในส่วนนี้ สามารถปรับรูปแบบต่างๆ ได้ ดูวิธีใช้งานที่คู่มือของ tcpdf เพิ่มเติม
		$pdf->AddPage();

		// กำหนดเงาของข้อความ
		//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

		$aDocHeader 	= $this->mPurchaseorder->FCaMPODocPrintHD($ptDocNo);
		$aDocSPL 		= $this->mPurchaseorder->FCaMPODocPrintSPL($ptDocNo);
		$aDocDT			= $this->mPurchaseorder->FCaMPODocPrintDT($ptDocNo);
		$aLicense		= $this->mPurchaseorder->FCaMPOGetLicense($this->session->userdata('tSesUsercode')); //เอาคนที่ login เข้ามา

		$aSQData = array(	"aDocHeader"	=> $aDocHeader,
							"aDocSPL"		=> $aDocSPL,
							"aDocDT" 		=> $aDocDT,
							"aLicense" 		=> $aLicense
						);

		$html = $this->load->view('purchaseorder/wPurchaseorderPrint',$aSQData,true);

		// สร้างข้อเนื้อหา pdf ด้วยคำสั่ง writeHTMLCell()
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		// จบการทำงานและแสดงไฟล์ pdf
		// การกำหนดในส่วนนี้ สามารถปรับรูปแบบต่างๆ ได้ เช่นให้บันทึกเป้นไฟล์ หรือให้แสดง pdf เลย ดูวิธีใช้งานที่คู่มือของ tcpdf เพิ่มเติม
		$pdf->Output('example_001.pdf', 'I');
	}

	
	//////////////////////////////////////////////////////////////////////// CREATE PO //////////////////////////////////////

	//Gen เอกสาร PO
	public function FCwCQUOGenDocumentPO(){
		$tDocumentNumber = $this->input->post('tDocumentNumber');
		$aPackData = array(
			"tDocumentNumber" => $tDocumentNumber
		);
		$aItem = $this->mPurchaseorder->FCxMQUOGetPDTBySPL($aPackData);

		$aData = array(
			"tDocumentNumber"   => $tDocumentNumber,
			"aItem" 			=> $aItem
		);
		$this->load->view("quotation/wQuotationDetailPDTBySPL", $aData);
	}

	//Gen PO
	public function FCwCQUOItemGenPO(){
		$tDocumentNumber = $this->input->post('tDocumentNumber');
		$aItem 			 = $this->input->post('aItem');

		$this->db->trans_begin();
			
			$aSPL 			= [];
			$aResultToView 	= [];
			//Insert DT
			for($j=0; $j<count($aItem); $j++){
				if(!in_array($aItem[$j]['tSPLCode'],$aSPL)){
					array_push($aSPL,$aItem[$j]['tSPLCode']);
				}

				$oItem 			= $this->mPurchaseorder->FCaMPOGetDetailItemAndPrice($aItem[$j]['tPDTCode']);
				$aDetailItem 	= $oItem['raItems'][0];
				$nQTY  			= str_replace(",","",$aItem[$j]['nQty']);
				$aDocInsertDT  = array(
					"FTXpoDocNo" 		=> 'DEMO',
					"FNXpoSeq" 			=> $j + 1,
					"FTPdtCode" 		=> $aItem[$j]['tPDTCode'],
					"FTPdtName" 		=> $aItem[$j]['tPDTName'],
					"FTPunCode" 		=> $aDetailItem['FTPunCode'],
					"FTPunName" 		=> $aDetailItem['FTPunName'],
					"FTSplCode" 		=> $aItem[$j]['tSPLCode'],
					"FTXpoCost" 		=> $aItem[$j]['nPrice'],
					"FCXpoUnitPrice" 	=> $aItem[$j]['nPrice'],
					"FCXpoB4Dis"		=> $aItem[$j]['nPrice'],
					"FTXpoDisTxt"		=> '',
					"FCXpoAfDT"			=> $aItem[$j]['nPrice'],
					"FCXpoNetAfHD"		=> $aItem[$j]['nPrice'],
					"FCXpoQty" 			=> $nQTY,
					"FTXpoRefPo"		=> $tDocumentNumber,
					"FCXpoDis" 			=> 0,
					"FCXpoFootAvg" 		=> 0,
					"FTPdtStaEditName"	=> $aDetailItem['FTPdtStaEditName'],
					"FTXpoRefBuyer"		=> '',
					"FTPdtStaCancel"	=> 0,
					"FTCreateBy"		=> $this->session->userdata('tSesUsercode'),
					"FDCreateOn"		=> date('Y-m-d'),	
					"FTUpdateBy"		=> $this->session->userdata('tSesUsercode'),
					"FDUpdateOn"		=> date('Y-m-d'),	
				);
				$this->mPurchaseorder->FCxMPOInsert_DT($aDocInsertDT);

				//Update สินค้าใน ใบเสนอราคาว่าใช้เเล้ว
				$aDocUpdateDT  = array(
					"FTDocRefPO" 		=> 'DEMO',
					"FTPdtCode" 		=> $aItem[$j]['tPDTCode'],
				);
				$this->mPurchaseorder->FCxMPOUpdatePDTInQuotationUseRef($aDocUpdateDT,$tDocumentNumber);
			}

			//Insert HD + Insert SPL
			$tReturnDocument = '';
			for($n=0;$n<count($aSPL);$n++){
				$tSPLCode			= $aSPL[$n];
				$tBchCode		    = ($this->session->userdata('tSesBCHCode') == '') ? '00001' : $this->session->userdata('tSesBCHCode');
				$tNewDocNo		    = $this->mPurchaseorder->FCtMPOGetDocNo($tBchCode);
				$tReturnDocument 	.= $tNewDocNo . ',';

				//Update เลขที่เอกสารใน DT ตาม SPL + เรียง Seq ใหม่
				$this->mPurchaseorder->FCxMPOUpdateDocNoInDT($tNewDocNo,$tSPLCode,$tDocumentNumber);

				$aGetItemINDT 		= $this->mPurchaseorder->FSaMPOGetPDTInDT($tNewDocNo);
				$aDetailSPL			= $this->mPurchaseorder->FCxMPOGetSupplierByID($tSPLCode);
				$nPrince 			= $aGetItemINDT['raItems'][0]['nTotal'];
				$nVatRate			= $aDetailSPL[0]['FNSplVat'];

				if($aDetailSPL[0]['FTSplVatType'] == 1){ //แยกนอก 
					$FCXpoAmtVat 		= (($nPrince * (100 + $nVatRate)) / 100) - $nPrince;
					$FCXpoVatable 		= $nPrince;
					$FCXpoGrand 		= $nPrince + $FCXpoAmtVat;
					$FTXpoGndText 		= ($FCXpoGrand == '') ? 'บาทถ้วน' : $this->FCNtReadNumber(str_replace(",", "", number_format($FCXpoGrand,2)));
				}else{ //รวมใน
					$FCXpoAmtVat 		= $nPrince - (($nPrince * 100) / (100 + $nVatRate));
					$FCXpoVatable 		= $nPrince - $FCXpoAmtVat;
					$FCXpoGrand 		= $nPrince;
					$FTXpoGndText 		= ($FCXpoGrand == '') ? 'บาทถ้วน' : $this->FCNtReadNumber(str_replace(",", "", number_format($FCXpoGrand,2)));
				}

				array_push($aResultToView,array('SPLNAME' => $aDetailSPL[0]['FTSplName'] , 'DOCNO' => $tNewDocNo));

				//Insert SPL
				$aDocInsertHDSpl 	= array(
					'FTXpoDocNo'		=> $tNewDocNo,
					'FTXpoSplCode'		=> $tSPLCode,
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

				//Insert HD
				$aDocInsertHD 	= array(
					'FTXpoDocNo'		=> $tNewDocNo,
					'FTBchCode'			=> $tBchCode,
					'FDXpoDocDate'		=> date('Y-m-d H:i:s'),
					'FTXpoCshOrCrd'		=> 1,
					'FNXpoCredit'		=> 30,
					'FTXpoVATInOrEx'	=> $aDetailSPL[0]['FTSplVatType'],	
					'FDDeliveryDate'	=> date('Y-m-d H:i:s'),
					'FTXpoStaExpress'	=> 0,
					'FTXpoStaDoc'		=> 1,
					'FTXpoStaActive'	=> 1,
					'FTXpoStaDeli'		=> 1,
					'FTXpoRmk'			=> '',
					'FTXpoStaApv'		=> 0,	
					'FTXpoStaRefInt'	=> 0,
					'FTApprovedBy'		=> '',
					'FDApproveDate'		=> '',
					'FTCreateBy'		=> $this->session->userdata('tSesUsercode'),
					'FDCreateOn'		=> date('Y-m-d H:i:s'),
					'FTUpdateBy'		=> $this->session->userdata('tSesUsercode'),
					'FDUpdateOn'		=> date('Y-m-d H:i:s'),
					"FCXpoB4Dis" 		=> $nPrince,
					"FCXpoDis" 			=> 0,
					"FTXpoDisTxt" 		=> '',
					"FCXpoAFDis" 		=> $nPrince,
					"FCXpoVatRate" 		=> $aDetailSPL[0]['FNSplVat'],
					"FCXpoAmtVat" 		=> $FCXpoAmtVat,
					"FCXpoVatable" 		=> $FCXpoVatable,
					"FCXpoGrand" 		=> $FCXpoGrand,
					"FTXpoGndText" 		=> $FTXpoGndText
				);
				$this->mPurchaseorder->FCxMPOInsert_HD($aDocInsertHD);
			}

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		}else{
			$this->db->trans_commit();
		}

		//ส่งค่ากลับ
		$aReturn = array(
			'nCountSPL'			=> count($aSPL),
			'aResultToView'		=> $aResultToView
		);
		echo json_encode($aReturn);
	}


}
