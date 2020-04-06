<?php
    //หาข้อมูลสินค้าว่ามีส่วนลดอะไรบ้าง
    function FCNtPDCGetProduct($ptPdtCode){

              $ci = &get_instance();
        	    $ci->load->database();

              $tSQL = "SELECT FTPdtCode,FCPdtCostStd,
                        LTRIM(RTRIM(M.N.value('.[1]','varchar(8000)'))) AS FTPdtCostDis
                        FROM
                        (
                        SELECT FTPdtCode, FCPdtCostStd, CAST('<XMLRoot><RowData>' + REPLACE(FTPdtCostDis,',','</RowData><RowData>') + '</RowData></XMLRoot>' AS XML) AS X
                        FROM   TCNMPdt
                        WHERE FTPdtCode='$ptPdtCode'
                        )T
                        CROSS APPLY X.nodes('/XMLRoot/RowData')M(N) ";

              $oQuery = $ci->db->query($tSQL);

            	if ($oQuery->num_rows() > 0) {

            		return $oQuery->result_array();

            	} else {
            		//No Data
            		return false;

            	}
    }

    //ตรวจสอบประเภท Transaction ของการ Process
    function FCNtPDCChkProcess($aData){

            $ci = &get_instance();
            $ci->load->database();

             $tSQL = "SELECT FTPdtCode FROM TCNTPdtCost WHERE FTBchCode = '".$aData['FTBchCode']."' ";
             $tSQL.= " AND FTPdtCode = '".$aData['FTPdtCode']."'";
             $tSQL.= " AND ISNULL(FDCosActive,'') = '".$aData['FDCosActive']."'";

             $oQuery = $ci->db->query($tSQL);
             return $oQuery->num_rows();

    }

    // Process ต้นทุน
    function FCNtPDCProcessCost($aData){

             $ci = &get_instance();
             $ci->load->database();

             $nStaPrc = FCNtPDCChkProcess($aData);

             if($nStaPrc == 0){
                 $tSQL = " INSERT INTO TCNTPdtCost (FTBchCode,FTPdtCode,FCPdtCost) VALUES ";
                 $tSQL.= " ('".$aData['FTBchCode']."','".$aData['FTPdtCode']."','".$aData['FCPdtCost']."')";
             }else{
                 $tSQL = "UPDATE TCNTPdtCost SET FCPdtCost = '".$aData['FCPdtCost']."'";
                 $tSQL.= " WHERE FTBchCode = '".$aData['FTBchCode']."' AND FTPdtCode = '".$aData['FTPdtCode']."'";
             }

             //return $tSQL;
             $oQuery = $ci->db->query($tSQL);

    }

    function FCNaHPDCAdjPdtCost($paData){

       $aProducts = FCNtPDCGetProduct($paData['tPdtCode']);
      // echo "<pre>";
      // var_dump($aProducts);
      // echo "</pre>";
      $nCountPdt = count($aProducts);
      if($nCountPdt > 0){

        $nPdtCostAFDis = 0;
        $nPdtLastCost = 0;

        for($i = 0; $i< $nCountPdt; $i++){
            $nPdtStdCost = $aProducts[$i]['FCPdtCostStd'];

            $nPdtCostDis = $aProducts[$i]['FTPdtCostDis'];
            $tDisType =  substr($nPdtCostDis,strlen($nPdtCostDis)-1);
            if($nPdtLastCost == 0){
               $nPdtLastCost = $nPdtStdCost;
            }

            if($tDisType == '%'){
                  $nPdtCostAFDis = $nPdtLastCost - ($nPdtLastCost * substr($nPdtCostDis,0,strlen($nPdtCostDis)-1)) / 100;
                  $nPdtLastCost = $nPdtCostAFDis;

            }else{

                  $nPdtCostAFDis = $nPdtLastCost - $nPdtCostDis;
                  $nPdtLastCost = $nPdtCostAFDis;
            }

            $aData = array("FTBchCode"=>"00001",
                           "FTPdtCode" =>  $paData['tPdtCode'],
                           "FCPdtCost" =>  $nPdtCostAFDis,
                           "FDCosActive"=> $paData['dDateActive']
                         );

            FCNtPDCProcessCost($aData);

        }

    }
  }



 ?>