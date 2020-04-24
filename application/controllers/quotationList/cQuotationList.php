<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cQuotationList extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('quotationList/mQuotationList');
	}

	public function index(){
		$this->load->view('quotationList/wQuotationListMain');
	}

	//หน้าจอตาราง
	public function FSwCPILLoadDatatable(){
		$nPage = $this->input->post('nPage');
		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 10,
			'tSearchAll'    => $this->input->post('tSearchAll')
		);

		$aList = $this->mQuotationList->FSaMPILGetData($aCondition);
		$aPackData = array(
			'aList'		=> $aList,
			'nPage'		=> $nPage
		);
		$this->load->view('quotationList/wQuotationListDatatable',$aPackData);
	}

}
