<?php
    //หาข้อมูลสินค้าว่ามีส่วนลดอะไรบ้าง
    function FCNtPDCGetProduct($ptPdtCode,$pdDateActive,$ptDocNo){
        			$ci = &get_instance();
        			$ci->load->database();

        			if($ptDocNo != ''){
        				$tTblName = 'TCNTPdtAdjCostDT';
        				$tPdtCostDis = 'FTXpdDisCost';
        				$tPdtCostStd = 'FCXpdCost';
        			}else{
        				$tTblName = 'TCNMPdt';
        				$tPdtCostDis = 'FTPdtCostDis';
        				$tPdtCostStd = 'FCPdtCostStd';
        			}

        			$tCondition = '';
        			if($ptDocNo !=''){
        				$tCondition.=" AND FTXphDocNo ='$ptDocNo' ";
        			}

        			$tSQL = "SELECT FTPdtCode,FCPdtCostStd,
        						LTRIM(RTRIM(M.N.value('.[1]','varchar(8000)'))) AS FTPdtCostDis
        						FROM
        						(
        						SELECT FTPdtCode,
        									$tPdtCostStd AS FCPdtCostStd ,
        									CAST('<XMLRoot><RowData>' + REPLACE($tPdtCostDis,',','</RowData><RowData>') + '</RowData></XMLRoot>' AS XML) AS X
        						FROM   $tTblName
        						WHERE FTPdtCode='$ptPdtCode'  $tCondition

        						)T
        						CROSS APPLY X.nodes('/XMLRoot/RowData')M(N) ";

        		$oQuery = $ci->db->query($tSQL);
        		if ($oQuery->num_rows() > 0) {
        				return $oQuery->result_array();
        		} else {
        			return false;
        		}
    }

    //ตรวจสอบประเภท Transaction ของการ Process
    function FCNtPDCChkProcess($aData){

            $ci = &get_instance();
            $ci->load->database();

             $tSQL = "SELECT FTPdtCode
                      FROM   TCNTPdtCost
                      WHERE FTBchCode = '".$aData['FTBchCode']."' ";
             $tSQL.= " AND FTPdtCode = '".$aData['FTPdtCode']."'";
             $tSQL.= " AND ISNULL(FDCosActive,'') = '".$aData['FDCosActive']."'";

             $oQuery = $ci->db->query($tSQL);
             return $oQuery->num_rows();

    }

    // Process ต้นทุน
    function FCNtPDCProcessCost($aData){
		$ci = &get_instance();
		$ci->load->database();
		$nPdtCostDis 	= $aData['nPdtCostDis'];
		$nPdtCostSTD  	= $aData['nPdtCostSTD'];
		$tDocumentNo  	= $aData['tDocumentNo'];

    $nStaPrc 	= FCNtPDCChkProcess($aData);

		if($nStaPrc == 0){
				$tSQL = " INSERT INTO TCNTPdtCost (FTBchCode,FTPdtCode,FCPdtCost,FDCosActive,FCPdtCostStd,FTPdtCostDis) VALUES ";
				$tSQL.= " ('".$aData['FTBchCode']."','".$aData['FTPdtCode']."','".$aData['FCPdtCost']."','".$aData['FDCosActive']."','".$nPdtCostSTD."','".$nPdtCostDis."')";
			}else{
				$tSQL = "UPDATE TCNTPdtCost
							SET FCPdtCost = '".$aData['FCPdtCost']."' ,
								FDCosActive = '".$aData['FDCosActive']."' ,
								FCPdtCostStd = '".$nPdtCostSTD."',
								FTPdtCostDis = '".$nPdtCostDis."' ";
				$tSQL.= " WHERE FTBchCode = '".$aData['FTBchCode']."' AND FTPdtCode = '".$aData['FTPdtCode']."' AND ISNULL(FDCosActive,'') = '".$aData['FDCosActive']."' ";
			}
		  $oQuery = $ci->db->query($tSQL);
    }

    /*adjust cost to TCNTPdtCost
      main function to call form client
    */
    function FCNaHPDCAdjPdtCost($paData){

       $aProducts = FCNtPDCGetProduct($paData['tPdtCode'],$paData['dDateActive'],$paData['tDocno']);
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

            $aData = array(
					"FTBchCode"		=> "00001",
					"FTPdtCode" 	=> $paData['tPdtCode'],
					"FCPdtCost" 	=> $nPdtCostAFDis,
					"FDCosActive"	=> $paData['dDateActive'],
					'nPdtCostDis' 	=> $nPdtCostDis,
					'nPdtCostSTD'	=> $nPdtStdCost,
					'tDocumentNo'  => $paData['tDocno'],
				);

            FCNtPDCProcessCost($aData);

        }

    }
  }

 ?>
