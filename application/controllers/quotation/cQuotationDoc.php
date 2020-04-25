<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cQuotationDoc extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('quotation/mQuotation');
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

	//Get ข้อมูลส่วนหัว
	public function FSaCQUODocHeader(){
		$tWorkerID 		= $this->session->userdata('tSesUsercode');
		$tDocNo 		= $this->input->get('tDocNo');
		$aConditions 	= array("tDocNo" => $tDocNo, "tWorkerID" => $tWorkerID);
		$aDocHeader 	= $this->mQuotation->FCaMQUOGetDocHD($aConditions);
		echo json_encode($aDocHeader);
	}

	//Get ข้อมูลส่วนลูกค้า
	public function FSaCQUODocCst(){
		$tWorkerID 		= $this->session->userdata('tSesUsercode');
		$tDocNo 		= $this->input->get('tDocNo');
		$aConditions 	= array("tDocNo" => $tDocNo, "tWorkerID" => $tWorkerID);
		$aDocCst 		= $this->mQuotation->FCaMQUOGetDocCst($aConditions);
		echo json_encode($aDocCst);
	}

	//Get ข้อมูลส่วนรายการสินค้า
	public function FSvCQUODocItems(){
		$tSesUserGroup 	= $this->session->userdata('tSesUserGroup');
		$tWorkerID 		= $this->session->userdata('tSesUsercode');
		$tDocNo 		= $this->input->get('tDocNo');
		$aFilter 		= array("tDocNo" => $tDocNo, "tWorkerID" => $tWorkerID, "nMode" => 1);
		$aDocItems 		= $this->mQuotation->FCaMQUOGetItemsList($aFilter);
		$aData 			= array("aDocItems" => $aDocItems, "tSesUserGroup" => $tSesUserGroup);
		$this->load->view("quotation/wQuotationDocItems", $aData);
	}

	//บันทึกข้อมูล
	public function FSxCQUODocSave(){
		$oDocHeaderInfo 	= $this->input->post("oDocHeaderInfo");
		$oDocCstInfo 		= $this->input->post("oDocCstInfo");
		$tWorkerID 			= $this->session->userdata('tSesUsercode');
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
			$nVatable = $nB4Dis;
		} else {
			$nVatable = str_replace(",", "", $nAfDis) - str_replace(",", "", $nAmtVat);
		}

		$aDocHD = array(
			"FNXqhSmpDay" 		=> $oDocHeaderInfo[0]["value"],
			"FDXqhEftTo" 		=> date('Y-m-d',strtotime(str_replace('/', '-', $oDocHeaderInfo[1]["value"]))) . ' ' . date('H:i:s'),
			"FTXqhCshOrCrd" 	=> $oDocHeaderInfo[2]["value"],
			"FNXqhCredit" 		=> $oDocHeaderInfo[3]["value"],
			"FDDeliveryDate" 	=> date('Y-m-d',strtotime(str_replace('/', '-', $oDocHeaderInfo[4]["value"]))) . ' ' . date('H:i:s'),
			"FTXqhVATInOrEx" 	=> $oDocHeaderInfo[5]["value"],
			"FTXqhStaExpress" 	=> ($nStaExpress == 'on') ? 1 : 0,
			"FTXqhStaActive" 	=> ($nStaDocActive == 'on') ? 1 : 0,
			"FTXqhStaDeli" 		=> ($nStaDeli == 'on') ? 1 : 0,
			"FTXqhPrjName" 		=> $oDocCstInfo[7]["value"],
			"FTXqhPrjCodeRef" 	=> $oDocCstInfo[8]["value"],
			"FCXqhB4Dis" 		=> $nB4Dis,
			"FCXqhDis" 			=> $nDis,
			"FTXqhDisTxt" 		=> $tDisText,
			"FCXqhAFDis" 		=> $nAfDis,
			"FCXqhVatRate" 		=> $nVatRate,
			"FCXqhAmtVat" 		=> $nAmtVat,
			"FCXqhVatable" 		=> $nVatable,
			"FCXqhGrand" 		=> $nGrandTotal,
			"FTXqhGndText" 		=> $tGndText,
			"FTXqhRmk" 			=> $tDocRemark,
			"tWorkerID" 		=> $tWorkerID,
			"tDocNo" 			=> $tDocNo
		);

		$this->mQuotation->FCxMQUODocUpdHeader($aDocHD);

		$aDocCst = array(
			"FTXqcCstName" 		=> $oDocCstInfo[0]["value"],
			"FTXqcAddress" 		=> $oDocCstInfo[1]["value"],
			"FTXqhTaxNo" 		=> $oDocCstInfo[2]["value"],
			"FTXqhContact" 		=> $oDocCstInfo[3]["value"],
			"FTXqhEmail" 		=> $oDocCstInfo[4]["value"],
			"FTXqhTel" 			=> $oDocCstInfo[5]["value"],
			"FTXqhFax" 			=> $oDocCstInfo[6]["value"],
			"tWorkerID" 		=> $tWorkerID,
			"tDocNo" 			=> $tDocNo
		);

		//Update Header Information
		$this->mQuotation->FCxMQUODocUpdCst($aDocCst);

		$oDocInfo = $this->mQuotation->FCxMQUCheckDocNoExiting($tWorkerID);
		if ($oDocInfo['rtCode'] == 1) {
			$tXqhDocNo = $oDocInfo['raItems'][0]['FTXqhDocNo'];
			if ($tXqhDocNo == '') {
				$tBchCode 	= $this->session->userdata('tSesBCHCode');
				$tXqhDocNo 	= $this->mQuotation->FCtMQUGetDocNo($tBchCode);
				$dDocDate 	= date("Y-m-d H:i:s");
				$this->mQuotation->FCtMQUUpdateDocNo($tXqhDocNo, $dDocDate, $tBchCode, $tWorkerID);
				$aDocData 	= array("tXqhDocNo" => $tXqhDocNo, "dDocDate" => $dDocDate, "nStaRender" => 1);
				$this->mQuotation->FCxMQUMoveTemp2HD($tXqhDocNo, $tWorkerID);
				$this->mQuotation->FCxMQUMoveTempHDCst($tXqhDocNo, $tWorkerID);
				$this->mQuotation->FCxMQUMoveTemp2DT($tXqhDocNo, $tWorkerID);
				echo json_encode($aDocData);
			} else {
				$aDocData =  array("tXqhDocNo" => '', "dDocDate" => '', "nStaRender" => 0);
				echo json_encode($aDocData);
				$this->mQuotation->FCxMQUMoveTemp2HD($tDocNo, $tWorkerID);
				$this->mQuotation->FCxMQUMoveTempHDCst($tDocNo, $tWorkerID);
				$this->mQuotation->FCxMQUMoveTemp2DT($tDocNo, $tWorkerID);
			}
		}
	}

	// แก้ไขจำนวนสินค้าในเอกสาร
  public function FSxCQUOEventEditQty(){
		     echo $nItemSeq = $this->input->post('nItemSeq');
	}

	//ลบข้อมูลใน Temp - รายการ
	public function FSxCQUOEventDeleteItem(){
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

	//ยกเลิกเอกสาร
	public function FSxCQUOEventCancleDocument(){
		$tDocumentNumber = $this->input->post('tDocNo');
		$aItem = array(
			'FTXqhDocNo'	=> $tDocumentNumber
		);
		$this->mQuotation->FCxMQUCancleDocument($aItem);
	}

	//อนุมัติเอกสาร
	public function FSxCQUOEventApproveDocument(){
		$tDocumentNumber = $this->input->post('tDocNo');
		$aItem = array(
			'FTXqhDocNo'	=> $tDocumentNumber
		);
		$this->mQuotation->FCxMQUApproveDocument($aItem);
	}
}
