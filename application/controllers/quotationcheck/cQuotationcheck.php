<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cQuotationcheck extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('quotationcheck/mQuotationcheck');
	}

	public function index(){
		$aPackData = array(
			'aBCHList'	=> $this->mQuotationcheck->FSaMUSRGetBranch()
		);
		$this->load->view('quotationcheck/wQuotationcheckMain',$aPackData);
	}

	//หน้าจอตาราง
	public function FSwCCPILoadDatatable(){
		$nPage 			= $this->input->post('nPage');
		$BCH 			= $this->input->post('BCH');
		$DocumentNumber = $this->input->post('DocumentNumber');
		$tStaDoc 		= $this->input->post('tStaDoc');
		$tStaSale 		= $this->input->post('tStaSale');
		$tStaExpress 	= $this->input->post('tStaExpress');

		$aCondition = array(
			'nPage'         	=> $nPage,
			'nRow'          	=> 15,
			'BCH'    			=> $BCH,
			'DocumentNumber'    => $DocumentNumber,
			'tStaDoc'    		=> $tStaDoc,
			'tStaSale'    		=> $tStaSale,
			'tStaExpress'    	=> $tStaExpress
		);

		$aList = $this->mQuotationcheck->FSaMCPIGetData($aCondition);
		$aPackData = array(
			'aList'		=> $aList,
			'nPage'		=> $nPage
		);
		$this->load->view('quotationcheck/wQuotationcheckDatatable',$aPackData);
	}

	//อัพเดทข้อมูล
	public function FSwCCPIUpdateRecord(){
		$tType				= $this->input->post('tType');
		$tDocumentNubmer	= $this->input->post('tDocumentNubmer');
		$tSeq				= $this->input->post('tSeq');
		$tPdtcode			= $this->input->post('tPdtcode');
		$tValue				= $this->input->post('tValue');

		switch ($tType) {
			case "PUCDATE":
				$tUpdateFiled = 'FDXqdPucDate';
				$tValue 	  = date('Y-m-d',strtotime(str_replace('/', '-', $tValue))) . ' ' . date('H:i:s');
				break;
			case "DLIDATE":
				$tUpdateFiled = 'FDXqdDliDate';
				$tValue 	  = date('Y-m-d',strtotime(str_replace('/', '-', $tValue))) . ' ' . date('H:i:s');
				break;
			case "PIKDATE":
				$tUpdateFiled = 'FDXqdPikDate';
				$tValue 	  = date('Y-m-d',strtotime(str_replace('/', '-', $tValue))) . ' ' . date('H:i:s');
				break;
			case "REFCON":
				$tUpdateFiled = 'FTXqdRefInv';
				$tValue 	  = trim($tValue);
				break;
			case "REFBUY":
				$tUpdateFiled = 'FTXqdRefBuyer';
				$tValue 	  = trim($tValue);
				break;
			default:
				$tUpdateFiled = '';
		}

		$aSet = array(
			$tUpdateFiled 		=> $tValue
		);

		$aWhere = array(
			'FTXqhDocNo'	=> $tDocumentNubmer,
			'FNXqdSeq'		=> $tSeq,
			'FTPdtCode'		=> $tPdtcode,
			'tType'			=> $tType,
			'tValue'		=> $tValue
		);

		$tReturn = $this->mQuotationcheck->FSaMQTCUpdate($aSet,$aWhere);
		return $tReturn;
	}

	//อัพเดทข้อมูลสินค้าตัวนั้นให้ยกเลิก
	public function FSwCCPIUpdateDTCancel(){
		$aCondition = array(
			'tDocumentnumber' 	=> $this->input->post('tDocumentnumber'),
			'nSeqitem' 			=> $this->input->post('nSeqitem'),
			'tPdtCode' 			=> $this->input->post('tPdtCode'),
			'nUpdateCancel'	 	=> $this->input->post('nUpdateCancel')
		);
		$this->mQuotationcheck->FSaMCPIUpdateDTCancel($aCondition);
	}

}
