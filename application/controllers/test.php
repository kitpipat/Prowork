<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class test extends CI_Controller {

	public function index(){


         $paData = array("tPdtCode"=>'P131','dDateActive'=>'');
         // Process Pdt cost 
         FCNaHPDCAdjPdtCost($paData);
	}

}

?>
