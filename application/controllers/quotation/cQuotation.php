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

	public function FCaCQUOGetItemsList(){


				 $aConditions = array( "nMode" => 1,
					                     "tDocNo" => '',
					                     "tWorkerID"=>'1234567890');

				 $aQuoItemsList  = $this->mQuotation->FCaMQUOGetItemsList($aConditions);

				 $aData = array('aQuoItemsList'=>$aQuoItemsList);
		     return $this->load->view('quotation/wQuotationItems',$aData);
	}

}
