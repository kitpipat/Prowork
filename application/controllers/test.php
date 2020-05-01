<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class test extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        /*
         fn parameter
         nStdCost = ต้นทุน
         tStepDisCost = ส่วนลดต้นทุนที่ผู้ใช้กรอกมา */

        $aPdtInfo = array("nStdCost" => 100,
                          "tStepDisCost"=> "-0%%%B,-50,5%,K52$,2%,:)" );

        //return ต้นทุนหลังหักส่วนลด รองรับการลดแบบ step
        $nCostAFDis =  FCNnHCOSCalCost($aPdtInfo);
        echo $nCostAFDis;

    }

}
?>
