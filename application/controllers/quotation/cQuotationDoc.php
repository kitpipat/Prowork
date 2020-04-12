<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cQuotationDoc extends CI_Controller {

	public function __construct() {

					parent::__construct();
					$this->load->model('quotation/mQuotation');

	}

  public function FSvCQUODocItems(){

         $tWorkerID = $this->session->userdata('tSesUsercode');
         $tDocNo = $this->input->get('tDocNo');

         $aFilter = array("tDocNo"=>$tDocNo,"tWorkerID"=>$tWorkerID, "nMode"=>1);

         $aDocItems = $this->mQuotation->FCaMQUOGetItemsList($aFilter);

         $aData = array("aDocItems" => $aDocItems);

         $this->load->view("quotation/wQuotationDocItems",$aData);

  }

}