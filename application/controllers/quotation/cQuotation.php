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

         $this->mQuotation->FSxMQUOClearTemp();

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

         $tKeySearch = $this->input->GET('tKeySearch');

				 $tPdtViewType = $this->input->GET('tPdtViewType');

         $tPriceGrp = $this->session->userdata('tSesPriceGroup');

				 $aFilter = array("tKeySearch" =>$tKeySearch,
			                    "tPriceGrp"  => $tPriceGrp);


				 //get product list
		     $aPdtList  = $this->mQuotation->FSaMQUPdtList($aFilter);

				 //count rows of products result
         $nTotalRecord = $this->mQuotation->FSaMQUOPdtCountRow($aFilter);

				 //data return to view
				 $aData = array('aPdtList' => $aPdtList,
			                  'nTotalRecord'=>$nTotalRecord,
											  'tPdtViewType' => $tPdtViewType);

		     $this->load->view('quotation/wQuotationPdtList',$aData);

	}

	public function FCwCQUOCallDocHeader(){

		     $tWorkerID = $this->session->userdata('tSesUsercode');
				 $tWorkerName = $this->session->userdata('tSesFirstname');

				 $tQuoDocNo = $this->input->get("tQuoDocNo");

				 $aConditions = array("tDocNo" => $tQuoDocNo ,"tWorkerID" =>$tWorkerID);

				 $aDocHD = $this->mQuotation->FCaMQUOGetDocHD($aConditions);


         $aData = array("aDocHD" =>  $aDocHD,
			                  "tWorkerID" => $tWorkerID,
											  "tWorkerName" => $tWorkerName);

		     return $this->load->view('quotation/wQuotationHeader',$aData);

	}

	public function FCaCQUOCallItemsList(){

         $tWorkerID = $this->session->userdata('tSesUsercode');
				 $aConditions = array( "nMode" => 1,
					                     "tDocNo" => '',
					                     "tWorkerID"=>$tWorkerID);

				 $aQuoItemsList  = $this->mQuotation->FCaMQUOGetItemsList($aConditions);

				 $aData = array('aQuoItemsList'=>$aQuoItemsList);
		     return $this->load->view('quotation/wQuotationItems',$aData);
	}

	public function FCaCQUOAddItem(){

				 $tQuoDocNo = $this->input->post("tQuoDocNo");

				 $tWorkerID = $this->session->userdata('tSesUsercode');

				 $oItem = $this->input->post("Item");

				 $aItem = json_decode($oItem,true);

				 $nQTY = $this->mQuotation->FCnMQUExitingItem(array('tQuoDocNo' => $tQuoDocNo,
				                                                    'tWorkerID' => $tWorkerID,
																														'tPdtCode'  => $aItem['tPdtCode']
																											));

				 $nXqdSeq = $this->mQuotation->FCaMQUOGetItemLastSeq(array("tDocNo"=>$tQuoDocNo,
				                                                           "tWorkerID"=>$tWorkerID
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

         if($nQTY == 1){
					  $this->mQuotation->FCaMQUOAddItem2Temp($aItemData);
				 }else{
					 $this->mQuotation->FCxMQUOUpdateItem($aItemData);
				 }

	}

	public function FCxCQUODelItem(){

				 $tQuoDocNo = $this->input->post("tQuoDocNo");
				 $tWorkerID = $this->session->userdata('tSesUsercode');
				 $nItemSeq = $this->input->post("nItemSeq");
				 $aItemData = array("tQuoDocNo" => $tQuoDocNo,
			                      "tWorkerID" => $tWorkerID,
													  "nItemSeq"  => $nItemSeq);

				 $this->mQuotation->FCxMQUODeleteItem($aItemData);

	}

	public function FCxCQUOEditItemQty(){

				 $tQuoDocNo = $this->input->post("tQuoDocNo");
				 $tWorkerID = $this->session->userdata('tSesUsercode');
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

	public function FCwCQUOCallDocPage(){

         $tDocNo = $this->input->get("tQuoDocNo");
				 $aData = array("tDocNo"=>$tDocNo);
				 $this->load->view("quotation/wQuotationDocForm",$aData);
	}

}
