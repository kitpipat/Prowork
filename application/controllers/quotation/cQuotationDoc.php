<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cQuotationDoc extends CI_Controller {

	public function __construct() {

					parent::__construct();
					$this->load->model('quotation/mQuotation');

	}

	public function FSaCQUODocHeader(){

		     $tWorkerID = $this->session->userdata('tSesUsercode');
		     $tDocNo = $this->input->get('tDocNo');

				 $aConditions = array("tDocNo"=>$tDocNo,"tWorkerID"=>$tWorkerID);
				 $aDocHeader = $this->mQuotation->FCaMQUOGetDocHD($aConditions);

				 echo json_encode($aDocHeader);
	}

	public function FSaCQUODocCst(){

				$tWorkerID = $this->session->userdata('tSesUsercode');
				$tDocNo = $this->input->get('tDocNo');
        $aConditions = array("tDocNo"=>$tDocNo,"tWorkerID"=>$tWorkerID);

				$aDocCst = $this->mQuotation->FCaMQUOGetDocCst($aConditions);
				echo json_encode($aDocCst);

	}

  public function FSvCQUODocItems(){

         $tSesUserGroup = $this->session->userdata('tSesUserGroup');
         $tWorkerID = $this->session->userdata('tSesUsercode');
         $tDocNo = $this->input->get('tDocNo');

         $aFilter = array("tDocNo"=>$tDocNo,"tWorkerID"=>$tWorkerID, "nMode"=>1);

         $aDocItems = $this->mQuotation->FCaMQUOGetItemsList($aFilter);

         $aData = array("aDocItems" => $aDocItems,"tSesUserGroup"=>$tSesUserGroup);

         $this->load->view("quotation/wQuotationDocItems",$aData);

  }

}
