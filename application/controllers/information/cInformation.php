<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cInformation extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('information/mInformation');
	}

	public function index(){
		$aPackData = array(
			'aGetInfomation' 		=> $this->mInformation->FSaMINFGetData(),
			'aCountQutationAprove' 	=> $this->mInformation->FSaMINFGetCountQutation(1),
			'aCountQutationAll' 	=> $this->mInformation->FSaMINFGetCountQutation(2),
			'aCountQutationCancle' 	=> $this->mInformation->FSaMINFGetCountQutation(3),
			'aCountProductAll' 		=> $this->mInformation->FSaMINFGetCountProduct()
		);
		$this->load->view('information/wInformation',$aPackData);
	}

	function FSwCINMLoadDatatable(){
		$nPage = $this->input->post('nPage');
		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 20,
			'tSearchAll'    => $this->input->post('tSearchAll')
		);

		$aHistory = $this->mInformation->FSaMPILGetData($aCondition);
		$aPackData = array(
			'aHistory'		=> $aHistory,
			'nPage'			=> $nPage
		);
		$this->load->view('information/wHistoryDocQuotationTable',$aPackData);
	}

}
