<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class test extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $aPdtInfo = array("nStdCost" => "100 ",
                          "tStepDisCost"=> "-0%%%B,-50,5%,K52$,2%,:)" );
        // $aPdtInfo = array();
        echo FCNnHCOSCalCost($aPdtInfo);
    }

}
?>
