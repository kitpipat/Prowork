<?php
//หารายการสินค้าที่จะ Update 9ต้นทุนใหม่
function FSGetPdtCostStdChang($ptPdtCode,$pnCostStd){

          $ci = &get_instance();
          $ci->load->database();

          $tSQL = "SELECT FTCosTxnNo,
                           FTPdtCode,
                           FCPdtCostStd,
                           LTRIM(RTRIM(M.N.value('.[1]', 'varchar(8000)'))) AS FTPdtCostDis
                    FROM
                    (
                        SELECT FTCosTxnNo,
                    	       FTPdtCode,
                               $pnCostStd AS FCPdtCostStd,
                               CAST('<XMLRoot><RowData>' + REPLACE(FTPdtCostDis, ',', '</RowData><RowData>') + '</RowData></XMLRoot>' AS XML) AS X
                        FROM TCNTPdtCost
                        WHERE FTPdtCode = '$ptPdtCode'
                    	AND   FDCosActive > GETDATE()
                    ) T
                    CROSS APPLY X.nodes('/XMLRoot/RowData') M(N)";

        $oQuery = $ci->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result_array();
        } else {
          return false;
        }
}


function FSSetPdtCostStdChang($paData){


  $ci = &get_instance();
  $ci->load->database();
  $aProducts = FSGetPdtCostStdChang($paData['tPdtCode'],$paData['nCostStd']);

  $nCountPdt = count($aProducts);
  if($nCountPdt > 0){

    $nPdtCostAFDis = 0;
		$nPdtLastCost = 0;
		$nIdx = 0;
    $nPdtStdCost = $paData['nCostStd'];
    for($i = 0; $i< $nCountPdt; $i++){
        $tCosTxnNo = $aProducts[$i]['FTCosTxnNo'];
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
				if($nIdx!=$tCosTxnNo){

					$nIdx = $tCosTxnNo;
					$nPdtLastCost = $nPdtStdCost;

				}

        $tSQLUpdate = "UPDATE TCNTPdtCost SET FCPdtCostStd = '$nPdtStdCost',FCPdtCost='$nPdtLastCost' ";
        $tSQLUpdate .= " WHERE FTCosTxnNo = '$tCosTxnNo' ";
        $oQuery = $ci->db->query($tSQLUpdate);

    }

   }
}



?>
