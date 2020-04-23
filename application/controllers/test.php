<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class test extends CI_Controller {

	public function index(){


         $paData = array("tPdtCode"=>'P2','dDateActive'=>'','tDocno'=>'');
         // Process Pdt cost 
         FCNaHPDCAdjPdtCost($paData);
	}

}

?>
