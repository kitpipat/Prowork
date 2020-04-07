<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cQuotation extends CI_Controller {

	public function __construct() {

					parent::__construct();
					$this->load->model('quotation/mQuotation');
	}

	public function index(){

				 // Get filter Data
		     $oFilterList  = $this->mQuotation->FSaMQUOGetFilterList();

         $aData = array('aFilterList'=>$oFilterList);
		     $this->load->view('quotation/wQuotation',$aData);

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
	public function FCaCQUOGetProductList(){

				 //get product list
		     $aPdtList  = $this->mQuotation->FSaMQUPdtList();

				 //count rows of products result
         $nTotalRecord = $this->mQuotation->FSaMQUOPdtCountRow('');

				 //data return to view
				 $aData = array('aPdtList' => $aPdtList,
			                  'nTotalRecord'=>$nTotalRecord);

		     $this->load->view('quotation/wQuotationPdtList',$aData);

	}

	public function FCwCQUOCallDocHeader(){

         $aData = array('' =>  '');
		     return $this->load->view('quotation/wQuotationHeader',$aData);
	}

	public function FCaCQUOCallItemsList(){


				 $aConditions = array( "nMode" => 1,
					                     "tDocNo" => '',
					                     "tWorkerID"=>'1234567890');

				 $aQuoItemsList  = $this->mQuotation->FCaMQUOGetItemsList($aConditions);

				 $aData = array('aQuoItemsList'=>$aQuoItemsList);
		     return $this->load->view('quotation/wQuotationItems',$aData);
	}

	public function FCaCQUOAddItem(){

				 $tQuoDocNo = $this->input->post("tQuoDocNo");
				 $tWorkerID = "1234567890";

				 $oItem = $this->input->post("Item");
         $aItem = json_decode($oItem,true);

				 $nXqdSeq = $this->mQuotation->FCaMQUOGetItemLastSeq(array("tDocNo"=>$tQuoDocNo,"tWorkerID"=>$tWorkerID));

				 $aItemData = array(
					 "FTXqhDocNo" => $tQuoDocNo,
					 "FNXqdSeq" => $nXqdSeq,
					 "FTPdtCode" => $aItem['tPdtCode'],
					 "FTPdtName" => $aItem['tPdtName'],
					 "FTPunCode" => $aItem['tPunCode'],
					 "FTSplCode" => $aItem['tSplCode'],
					 "FTXqdCost" => $aItem['nPdtCost'],
					 "FCXqdUnitPrice" => $aItem['nPdtUnitPri'],
					 "FCXqdQty" => 1,
					 "FCXqdB4Dis" => $aItem['nPdtUnitPri'],
					 "FTWorkerID" => $tWorkerID
				 );

				 $this->mQuotation->FCaMQUOAddItem2Temp($aItemData);


	}

	public function FCxCQUODelItem(){

				 $tQuoDocNo = $this->input->post("tQuoDocNo");
				 $tWorkerID = "1234567890";
				 $nItemSeq = $this->input->post("nItemSeq");
				 $aItemData = array("tQuoDocNo" => $tQuoDocNo,
			                      "tWorkerID" => $tWorkerID,
													  "nItemSeq"  => $nItemSeq);

				 $this->mQuotation->FCxMQUODeleteItem($aItemData);

	}

	public function FCxCQUOEditItemQty(){

				 $tQuoDocNo = $this->input->post("tQuoDocNo");
				 $tWorkerID = "1234567890";
				 $nItemSeq = $this->input->post("nItemSeq");
				 $nItemQTY = $this->input->post("nItemQTY");
				 $nUnitPrice = $this->input->post("nUnitPrice");
				 $nPriB4Dis = $nItemQTY * $nUnitPrice;

				 $aItemData = array("tQuoDocNo" => $tQuoDocNo,
														"tWorkerID" => $tWorkerID,
														"nItemSeq"  => $nItemSeq,
													  "nItemQTY"  => $nItemQTY,
													  "nPriB4Dis" => $nPriB4Dis);

				 $this->mQuotation->FCxMQUOEditItemQty($aItemData);

	}

}
