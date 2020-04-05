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
	public function FCaCQUOGetProductList(){

		     $oPdtList  = $this->mQuotation->FSaMQUPdtList();

				 $aData = array('aPdtList' => $oPdtList,
			                  'nTotalRecord'=>7);

		     $this->load->view('quotation/wQuotationPdtList',$aData);

	}

}
