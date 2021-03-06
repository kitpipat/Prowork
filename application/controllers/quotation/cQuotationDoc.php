<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cQuotationDoc extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Pdf');
		$this->load->model('quotation/mQuotation');
	}

	//แปลงตัวเลขเป็น TEXT
	public function FCNtReadNumber($number)
	{
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
		if (
			$number[1] == '0' or $number[1] == '00' or
			$number[1] == ''
		) {
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

	public function FCNtReadNumberToCurrency(){
		      $nNumber = $this->input->get('nNumber');
		      echo $this->FCNtReadNumber($nNumber);
	}

	//Get ข้อมูลส่วนหัว
	public function FSaCQUODocHeader()
	{
		$tWorkerID 		= $this->session->userdata('tSesLogID');
		$tDocNo 		= $this->input->get('tDocNo');
		$aConditions 	= array("tDocNo" => $tDocNo, "tWorkerID" => $tWorkerID);
		$aDocHeader 	= $this->mQuotation->FCaMQUOGetDocHD($aConditions);
		echo json_encode($aDocHeader);
	}

	//Get ข้อมูลส่วนลูกค้า
	public function FSaCQUODocCst()
	{
		$tWorkerID 		= $this->session->userdata('tSesLogID');
		$tDocNo 		= $this->input->get('tDocNo');
		$aConditions 	= array("tDocNo" => $tDocNo, "tWorkerID" => $tWorkerID);
		$aDocCst 		= $this->mQuotation->FCaMQUOGetDocCst($aConditions);
		echo json_encode($aDocCst);
	}

	//Get ข้อมูลส่วนรายการสินค้า
	public function FSvCQUODocItems()
	{
		$tSesUserGroup 	= $this->session->userdata('tSesUserGroup');
		$tWorkerID 		= $this->session->userdata('tSesLogID');
		$tDocNo 		= $this->input->get('tDocNo');
		$aFilter 		= array("tDocNo" => $tDocNo, "tWorkerID" => $tWorkerID, "nMode" => 1);
		$aDocItems 		= $this->mQuotation->FCaMQUOGetItemsList($aFilter);
		$aData 			= array("aDocItems" => $aDocItems, "tSesUserGroup" => $tSesUserGroup);
		$this->load->view("quotation/wQuotationDocItems", $aData);
	}


	//บันทึกข้อมูลเอกสาร
	public function FSxCQUODocSave()
	{

		$oDocHeaderInfo 	= $this->input->post("oDocHeaderInfo");
		$tBCH 				= $this->input->post('tBchCode');
		$oDocCstInfo 		= $this->input->post("oDocCstInfo");
		$tWorkerID 			= $this->session->userdata('tSesLogID');
		$tDocNo 			= $this->input->post('tDocNo');
		$nStaExpress 		= $this->input->post('nStaExpress');
		$nStaDocActive 		= $this->input->post('nStaDocActive');
		$nStaDeli 			= $this->input->post('nStaDeli');
		$nB4Dis 			= $this->input->post('nB4Dis');
		$nDis 				= $this->input->post('nDis');
		$tDisText 			= $this->input->post('tDisText');
		$nAfDis 			= $this->input->post('nAfDis');
		$nVatRate 			= $this->input->post('nVatRate');
		$nAmtVat 			= $this->input->post('nAmtVat');
		$nGrandTotal 		= $this->input->post('nGrandTotal');
		$tDocRemark 		= $this->input->post('tDocRemark');
		$tGndText 			= $this->FCNtReadNumber(str_replace(",", "", $nGrandTotal));

		if ($oDocHeaderInfo[5]["value"] == 1) {
			$nVatable = $nAfDis;
		} else {
			$nVatable = str_replace(",", "", $nAfDis) - str_replace(",", "", $nAmtVat);
		}

		$aDocHD = array(
			'FTBchCode'			=> $tBCH,
			"FNXqhSmpDay" 		=> $oDocHeaderInfo[0]["value"],
			"FDXqhEftTo" 		=> date('Y-m-d', strtotime(str_replace('/', '-', $oDocHeaderInfo[1]["value"]))) . ' ' . date('H:i:s'),
			"FTXqhCshOrCrd" 	=> $oDocHeaderInfo[2]["value"],
			"FNXqhCredit" 		=> str_replace(",", "", $oDocHeaderInfo[3]["value"]),
			"FDDeliveryDate" 	=> date('Y-m-d', strtotime(str_replace('/', '-', $oDocHeaderInfo[4]["value"]))) . ' ' . date('H:i:s'),
			"FTXqhVATInOrEx" 	=> $oDocHeaderInfo[5]["value"],
			"FTXqhStaExpress" 	=> $nStaExpress,
			"FTXqhStaActive" 	=> $nStaDocActive,
			"FTXqhStaDeli" 		=> $nStaDeli,
			"FTXqhPrjName" 		=> $oDocCstInfo[8]["value"],
			"FTXqhPrjCodeRef" 	=> $oDocCstInfo[9]["value"],
			"FCXqhB4Dis" 		=> str_replace(",", "", $nB4Dis),
			"FCXqhDis" 			=> str_replace(",", "", $nDis),
			"FTXqhDisTxt" 		=> $tDisText,
			"FCXqhAFDis" 		=> str_replace(",", "", $nAfDis),
			"FCXqhVatRate" 		=> str_replace(",", "", $nVatRate),
			"FCXqhAmtVat" 		=> str_replace(",", "", $nAmtVat),
			"FCXqhVatable" 		=> str_replace(",", "", $nVatable),
			"FCXqhGrand" 		=> str_replace(",", "", $nGrandTotal),
			"FTXqhGndText" 		=> $tGndText,
			"FTXqhRmk" 			=> $tDocRemark,
			"tWorkerID" 		=> $tWorkerID,
			"tDocNo" 			=> $tDocNo
		);

		//ถ้า session ยังไม่หมดอายุ
		if ($tWorkerID != '') {

			$this->mQuotation->FCxMQUODocUpdHeader($aDocHD);
			$aDocCst = array(
				"FTXqcCstCode" 		=> $oDocCstInfo[0]["value"],
				"FTXqcCstName" 		=> $oDocCstInfo[1]["value"],
				"FTXqcAddress" 		=> $oDocCstInfo[2]["value"],
				"FTXqhTaxNo" 		=> $oDocCstInfo[3]["value"],
				"FTXqhContact" 		=> $oDocCstInfo[4]["value"],
				"FTXqhEmail" 		=> $oDocCstInfo[5]["value"],
				"FTXqhTel" 			=> $oDocCstInfo[6]["value"],
				"FTXqhFax" 			=> $oDocCstInfo[7]["value"],
				"tWorkerID" 		=> $tWorkerID,
				"tDocNo" 			=> $tDocNo
			);

			//Update Header Information
			$this->mQuotation->FCxMQUODocUpdCst($aDocCst);
			$oDocInfo = $this->mQuotation->FCxMQUCheckDocNoExiting($tWorkerID);
			if ($oDocInfo['rtCode'] == 1) {
				$tXqhDocNo = $oDocInfo['raItems'][0]['FTXqhDocNo'];
				if ($tXqhDocNo == '') {
					$tBchCode 	= $tBCH;
					$tXqhDocNo 	= $this->mQuotation->FCtMQUGetDocNo($tBchCode);
					$dDocDate 	= date("Y-m-d H:i:s");
					$this->mQuotation->FCtMQUUpdateDocNo($tXqhDocNo, $dDocDate, $tBchCode, $tWorkerID);
					$aDocData 	= array("tXqhDocNo" => $tXqhDocNo, "dDocDate" => $dDocDate, "nStaRender" => 1);
					$this->mQuotation->FCxMQUMoveTemp2HD($tXqhDocNo, $tWorkerID);
					$this->mQuotation->FCxMQUMoveTempHDCst($tXqhDocNo, $tWorkerID);
					$this->mQuotation->FCxMQUMoveTemp2DT($tXqhDocNo, $tWorkerID);
					$this->mQuotation->FCxMQUProrate($tXqhDocNo, $nB4Dis, $nDis);
					echo json_encode($aDocData);
				} else {
					$aDocData =  array("tXqhDocNo" => '', "dDocDate" => '', "nStaRender" => 0);
					$this->mQuotation->FCxMQUMoveTemp2HD($tDocNo, $tWorkerID);
					$this->mQuotation->FCxMQUMoveTempHDCst($tDocNo, $tWorkerID);
					$this->mQuotation->FCxMQUMoveTemp2DT($tDocNo, $tWorkerID);
					$this->mQuotation->FCxMQUProrate($tDocNo, $nB4Dis, $nDis);
					echo json_encode($aDocData);
				}
			}
		} else {
			echo 'expired';
		}
	}

	// แก้ไขจำนวนสินค้าในเอกสาร
	public function FSxCQUOEventEditQty()
	{
		$nItemSeq = $this->input->post('nItemSeq');
		$tQuoDocNo = $this->input->post('tQuoDocNo');
		$nItemQTY = str_replace(",", "", $this->input->post('nItemQTY'));
		$tPdtCode = $this->input->post('tPdtCode');
		$nPdtUnitPrice = str_replace(",", "", $this->input->post('nPdtUnitPrice'));
		$nItemDiscount = $this->input->post('nItemDiscount');

		$nItemCost = $this->input->post('nItemCost');

		$nItemNet = number_format($nItemQTY, 0) * $nPdtUnitPrice;

		$aDiscount = explode(",",$nItemDiscount);
		//print_r($aDiscount);
		$nDiscountCal = 0;
		$nDisLen = count($aDiscount);
    	$nTotalDisCount = 0;
		$nItemNetLast = $nItemNet;

		for($d = 0;$d<$nDisLen;$d++){

					$tDisType = substr($aDiscount[$d], strlen($aDiscount[$d]) - 1);//ประเภทส่วนลด
			    if($tDisType == '%'){
						$nDiscountCal = substr($aDiscount[$d], 0, strlen($aDiscount[$d]) - 1);
					  $nTotalDisCount = $nTotalDisCount + ($nItemNetLast * $nDiscountCal) / 100;
						$nItemNetLast = $nItemNetLast - ($nItemNetLast * $nDiscountCal) / 100;
					}else{
						$nDiscountCal = $aDiscount[$d];
						if(is_numeric($nTotalDisCount) && is_numeric($nDiscountCal)){
							 $nTotalDisCount = $nTotalDisCount+$nDiscountCal;
						}else{
							 $nTotalDisCount = $nTotalDisCount+0;
						}

						$nItemNetLast = $nItemNetLast - $nTotalDisCount;
					}
		}


		// $nStrCountDisTxt = strlen($nItemDiscount) - 1;
		//
		// $tDisType = substr($nItemDiscount, $nStrCountDisTxt);
		// $nDiscountCal = 0;
		// $nDiscount = 0;
		// //echo $nItemDiscount;
		// if ($tDisType == '%') {
		// 	$nDiscountCal = substr($nItemDiscount, 0, $nStrCountDisTxt);
		// 	$nDiscount = ($nItemNet * $nDiscountCal) / 100;
		// } else {
		//
		// 	$nDiscount = $nItemDiscount;
		// }

		//get After discount
		$nItemNetAfDisLine = $nItemNet - $nTotalDisCount;

		$aDataUpdate = array(
			"tQuoDocNo" => $tQuoDocNo,
			"nItemSeq" => $nItemSeq,
			"nItemQTY" => $nItemQTY,
			"tPdtCode" => $tPdtCode,
			"nDiscount" => $nTotalDisCount,
			'tDisText'  => $nItemDiscount
		);


		$this->mQuotation->FCxMQUEditItemInTemp($aDataUpdate);

		echo "NetAfDis :".$nItemNetAfDisLine." Cost : ".$nItemCost;
	}

	// แก้ไขราคาสินค้าในเอกสาร
	public function FSxCQUOEventItemPri()
	{

		$nItemSeq = $this->input->post('nItemSeq');
		$tQuoDocNo = $this->input->post('tQuoDocNo');
		$nItemQTY = str_replace(",", "", $this->input->post('nItemQTY'));
		$tPdtCode = $this->input->post('tPdtCode');
		$nPdtUnitPrice = str_replace(",", "", $this->input->post('nPdtUnitPrice'));
		$nItemDiscount = $this->input->post('nItemDiscount');

		$nItemNet = number_format($nItemQTY, 0) * $nPdtUnitPrice;

		$aDiscount = explode(",",$nItemDiscount);
		//print_r($aDiscount);
		$nDiscountCal = 0;
		$nDisLen = count($aDiscount);
    	$nTotalDisCount = 0;
		$nItemNetLast = $nItemNet;
		for($d = 0;$d<$nDisLen;$d++){

					$tDisType = substr($aDiscount[$d], strlen($aDiscount[$d]) - 1);//ประเภทส่วนลด
			    if($tDisType == '%'){
						$nDiscountCal = substr($aDiscount[$d], 0, strlen($aDiscount[$d]) - 1);
					  $nTotalDisCount = $nTotalDisCount + ($nItemNetLast * $nDiscountCal) / 100;
						$nItemNetLast = $nItemNetLast - ($nItemNetLast * $nDiscountCal) / 100;

					}else{
						$nDiscountCal = $aDiscount[$d];
						$nTotalDisCount = $nTotalDisCount+$nDiscountCal;
            $nItemNetLast = $nItemNetLast - $nTotalDisCount;
					}
		}

		// $nStrCountDisTxt = strlen($nItemDiscount) - 1;
		//
		// $tDisType = substr($nItemDiscount, $nStrCountDisTxt);
		// $nDiscountCal = 0;
		// $nDiscount = 0;
		// //echo $nItemDiscount;
		// if ($tDisType == '%') {
		// 	$nDiscountCal = substr($nItemDiscount, 0, $nStrCountDisTxt);
		// 	$nDiscount = ($nItemNet * $nDiscountCal) / 100;
		// } else {
		//
		// 	$nDiscount = $nItemDiscount;
		// }

		$aDataUpdate = array(
			"tQuoDocNo" => $tQuoDocNo,
			"nItemSeq" => $nItemSeq,
			"nPdtUnitPrice" => $nPdtUnitPrice,
			"tPdtCode" => $tPdtCode,
			"nDiscount" => $nTotalDisCount
		);

		$this->mQuotation->FCxMQUEditUnitPriInTemp($aDataUpdate);
	}

	// แก้ไขส่วนลดรายการ
	public function FSxCQUOEventItemDis()
	{

		$tQuoDocNo = $this->input->post('tQuoDocNo');
		$nItemSeq = $this->input->post('nItemSeq');
		$nItemDiscount = $this->input->post('nItemDiscount');
		$tPdtCode = $this->input->post('tPdtCode');
		$nItemNet = str_replace(",", "", $this->input->post('nItemNet'));

		$aDiscount = explode(",",$nItemDiscount);
		//print_r($aDiscount);
		$nDiscountCal = 0;
		$nDisLen = count($aDiscount);
    	$nTotalDisCount = 0;
		$nItemNetLast = $nItemNet;
		for($d = 0;$d<$nDisLen;$d++){

					$tDisType = substr(trim($aDiscount[$d]), strlen(trim($aDiscount[$d])) - 1);//ประเภทส่วนลด
			    if($tDisType == '%'){
						$nDiscountCal = substr(trim($aDiscount[$d]), 0, strlen(trim($aDiscount[$d])) - 1);
					  $nTotalDisCount = $nTotalDisCount + ($nItemNetLast * trim($nDiscountCal)) / 100;
						$nItemNetLast = $nItemNetLast - ($nItemNetLast * trim($nDiscountCal)) / 100;
					}else{
						$nDiscountCal = trim($aDiscount[$d]);
						if(is_numeric($nTotalDisCount) && is_numeric($nDiscountCal)){
							 $nTotalDisCount = $nTotalDisCount+$nDiscountCal;
						}else{
							 $nTotalDisCount = $nTotalDisCount+0;
						}
						$nItemNetLast = $nItemNetLast - $nDiscountCal;
					}
		}

		//cal total after discount

		$nItemNetB4DisLine = $this->input->post('nItemNetB4DisLine');
 	  	$nItemCost = $this->input->post('nItemCost');

		$nTotalAfDis = $nItemNetB4DisLine - $nTotalDisCount;

		// $nStrCountDisTxt = strlen($nItemDiscount) - 1;
		// $tDisType = substr($nItemDiscount, $nStrCountDisTxt);
		// $nDiscountCal = 0;
		// $nItemNetAFDis = 0;
		// $nDiscount = 0;
		// //echo $nItemDiscount;
		// if ($tDisType == '%') {
		// 	$nDiscountCal = substr($nItemDiscount, 0, $nStrCountDisTxt);
		// 	$nDiscount = ($nItemNet * $nDiscountCal) / 100;
		// } else {
		//
		// 	$nDiscount = $nItemDiscount;
		// }

		$aItemDisData = array(
			"tQuoDocNo" => $tQuoDocNo,
			"nItemSeq" => $nItemSeq,
			"tPdtCode" => $tPdtCode,
			"nDiscount" => $nTotalDisCount,
			"tDisText" => $nItemDiscount
		);
		if($nTotalAfDis >= $nItemCost){
		 	 $this->mQuotation->FCxMQUEditItemIDisCount($aItemDisData);
			 echo 'success';
		}else{
			 echo 'error';
		}

		//echo "AFDis: ".$nTotalAfDis."Cost:".$nItemCost;


	}

	//ลบข้อมูลใน Temp - รายการ
	public function FSxCQUOEventDeleteItem()
	{
		$tDocument 	= $this->input->post('ptDocument');
		$nSeq 		= $this->input->post('pnSeq');
		$nPDTCode 	= $this->input->post('pnPDTCode');

		$aItem = array(
			'FTXqhDocNo'	=> $tDocument,
			'FNXqdSeq'		=> $nSeq,
			'FTPdtCode'		=> $nPDTCode
		);
		$this->mQuotation->FCxMQUDeleteItemInTemp($aItem);
	}

	//ส่วนลดท้ายบิล
	public function FSxCQUOEventFootDis()
	{

		$tQuoDocNo 	  = $this->input->post('tQuoDocNo');
		$nDiscount 		= $this->input->post('nDiscount');
		$nNetB4HD 	= str_replace(",", "", $this->input->post('nNetB4HD'));

		// discount to array modifi 23/07/2020 p'run
		$aDiscount = explode(",",$nDiscount);
		//print_r($aDiscount);
		$nDiscountCal = 0;
		$nDisLen = count($aDiscount);
    	$nTotalDisCount = 0;
		$nB4DisLast = $nNetB4HD;
		for($d = 0;$d<$nDisLen;$d++){
			$tDisType = substr($aDiscount[$d], strlen($aDiscount[$d]) - 1);//ประเภทส่วนลด
			if($tDisType == '%'){
				$nDiscountCal = substr($aDiscount[$d], 0, strlen($aDiscount[$d]) - 1);
				$nTotalDisCount = $nTotalDisCount + ($nB4DisLast * $nDiscountCal) / 100;
				$nB4DisLast = $nB4DisLast - ($nB4DisLast * $nDiscountCal) / 100;
				//echo $nB4DisLast.'-';
			}else{
				$nDiscountCal = $aDiscount[$d];
				$nTotalDisCount = $nTotalDisCount+$nDiscountCal;
				$nB4DisLast = $nB4DisLast - $nDiscountCal;
				//echo $nB4DisLast.'-';
			}
		}

		//
		// exit();
		//
		// $nDiscountTxt  = str_replace(",", "", $nDiscount);
		// $nNetB4HD 	= str_replace(",", "", $this->input->post('nNetB4HD'));
		//
		// $nStrCountDisTxt = strlen($nDiscount) - 1;
		// $tDisType = substr($nDiscount, $nStrCountDisTxt);
		// $nDiscountCal = 0;
		// $nItemNetAFDis = 0;
		// //echo $nItemDiscount;
		// if ($tDisType == '%') {
		// 	$nDiscountCal = substr($nDiscount, 0, $nStrCountDisTxt);
		// 	$nDiscount = ($nNetB4HD * $nDiscountCal) / 100;
		// } else {
		//
		// 	$nDiscount = $nDiscount;
		// }
		$tWorkerID	= $this->session->userdata('tSesLogID');

		$aDisInfo = array(
			"tQuoDocNo" => $tQuoDocNo,
			"nDiscount" => $nTotalDisCount,
			"tDisTxt" 	=> $nDiscount,
			"tWorkerID" => $tWorkerID
		);

		if ($tWorkerID != "") {
			$this->mQuotation->FCxMQUEditDocDisCount($aDisInfo);
			echo $nTotalDisCount;
		} else {
			echo 'expired';
		}
	}

	//ยกเลิกเอกสาร
	public function FSxCQUOEventCancleDocument()
	{
		$tDocumentNumber = $this->input->post('tDocNo');
		$aItem = array(
			'FTXqhDocNo'	=> $tDocumentNumber
		);
		$this->mQuotation->FCxMQUCancleDocument($aItem);
	}

	//อนุมัติเอกสาร
	public function FSxCQUOEventApproveDocument()
	{
		$tDocumentNumber = $this->input->post('tDocNo');
		$aItem = array(
			'FTXqhDocNo'	=> $tDocumentNumber
		);
		$this->mQuotation->FCxMQUApproveDocument($aItem);
	}

	//เลือกลูกค้าในหน้าเอกสาร (Master)
	public function FSxCQUOSelectCustomer(){
		$nPage	= $this->input->post('nPage');

		$aCondition = array(
			'nPage'         	=> $nPage,
			'nRow'          	=> 10,
			'tSearchCustomer'   => $this->input->post('tSearchCustomer')
		);

		$aListCustomer 	= $this->mQuotation->FCxMQUGetCustomerAll($aCondition);
		$aPackData 	= array(
			'aListCustomer'		=> $aListCustomer,
			'nPage'				=> $nPage
		);
		$this->load->view('quotation/wSelectCustomer',$aPackData);
	}

  	//พิมพ์ใบเสนอราคา
	public function FSaCQUODocPrintForm($ptDocNo,$ptContact)
	{
		// สร้าง object สำหรับใช้สร้าง pdf
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// กำหนดรายละเอียดของ pdf
		$pdf->SetTitle('ใบเสนอราคา : ' . $ptDocNo);

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

		$aDocHeader 	= $this->mQuotation->FCaMQUODocPrintHD($ptDocNo);
		$aDocCustomer 	= $this->mQuotation->FCaMQUODocPrintHDCst($ptDocNo);
		$aDocDT	= $this->mQuotation->FCaMQUODocPrintDT($ptDocNo);

		$aSQData = array(	"aDocHeader"	=>$aDocHeader,
							"aDocCustomer"	=>$aDocCustomer,
							"aDocDT" 		=>$aDocDT,
							"aContact"		=>$ptContact
						);

		$html = $this->load->view('quotation/wQuotationForm',$aSQData,true);

		// สร้างข้อเนื้อหา pdf ด้วยคำสั่ง writeHTMLCell()
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		// จบการทำงานและแสดงไฟล์ pdf
		// การกำหนดในส่วนนี้ สามารถปรับรูปแบบต่างๆ ได้ เช่นให้บันทึกเป้นไฟล์ หรือให้แสดง pdf เลย ดูวิธีใช้งานที่คู่มือของ tcpdf เพิ่มเติม
		$pdf->Output('example_001.pdf', 'I');
	}

	//เเก้ไขชื่อในรายการ
	public function FSxCQUOChangenameinDT(){
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
		$this->mQuotation->FCxMQUChangenameinDT($aPackData);
	}
}
