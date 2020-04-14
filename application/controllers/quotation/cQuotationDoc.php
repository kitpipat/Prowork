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

	public function FSxCQUODocSave(){

				 $oDocHeaderInfo = $this->input->post("oDocHeaderInfo");
				 $oDocCstInfo = $this->input->post("oDocCstInfo");
				 //var_dump($oDocCstInfo);
				 //var_dump($oDocCstInfo);

				 $tWorkerID = $this->session->userdata('tSesUsercode');
         $tDocNo = $this->input->post('tDocNo');
				 $nStaExpress= $this->input->post('nStaExpress');
				 $nStaDocActive = $this->input->post('nStaDocActive');
				 $nStaDeli = $this->input->post('nStaDeli');

				 //if(isset)

				 $aDocHD = array("FNXqhSmpDay" => $oDocHeaderInfo[0]["value"],
			                   "FDXqhEftTo" =>  $oDocHeaderInfo[1]["value"],
											   "FTXqhCshOrCrd" => $oDocHeaderInfo[2]["value"],
											   "FNXqhCredit" => $oDocHeaderInfo[3]["value"],
											   "FDDeliveryDate" => $oDocHeaderInfo[4]["value"],
											   "FTXqhVATInOrEx" => $oDocHeaderInfo[5]["value"],
											   "FTXqhStaExpress" => $nStaExpress,
											   "FTXqhStaActive" => $nStaDocActive,
											   "FTXqhStaDeli" => $nStaDeli,
												 "FTXqhPrjName" => $oDocCstInfo[7]["value"],
												 "FTXqhPrjCodeRef" => $oDocCstInfo[8]["value"],
												 "tWorkerID" =>$tWorkerID,
												 "tDocNo" =>$tDocNo
											   );
        $this->mQuotation->FCxMQUODocUpdHeader($aDocHD);
         //Update Header Information


	}

}
