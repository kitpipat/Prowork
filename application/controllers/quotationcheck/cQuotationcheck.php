<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cQuotationcheck extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('quotationcheck/mQuotationcheck');
	}

	public function index(){
		$this->load->view('quotationcheck/wQuotationcheckMain');
	}

	//หน้าจอตาราง
	public function FSwCCPILoadDatatable(){
		$nPage = $this->input->post('nPage');
		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 10,
			'tSearchAll'    => $this->input->post('tSearchAll')
		);

		$aList = $this->mQuotationcheck->FSaMCPIGetData($aCondition);
		$aPackData = array(
			'aList'		=> $aList,
			'nPage'		=> $nPage
		);
		$this->load->view('quotationcheck/wQuotationcheckDatatable',$aPackData);
	}

}
