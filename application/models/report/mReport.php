<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mReport extends CI_Model {
	
	public function FSaMREPGetData($paData){
		$aRowLen   		= FCNaHCallLenData($paData['nRow'],$paData['nPage']);
		$tSQL  = "SELECT c.* FROM(";
		$tSQL .= " SELECT  ROW_NUMBER() OVER(ORDER BY FTSplCode DESC) AS rtRowID,* FROM (";
		$tSQL .= " SELECT 
					SPL.FTSplCode,
					SPL.FTSplName,
					SPL.FTSplAddress,
					SPL.FTSplContact,
					SPL.FTSplTel,
					SPL.FTSplFax,
					SPL.FTSplEmail,
					SPL.FTSplPathImg,
					SPL.FTSplStaActive,
					SPL.FDLastUpdOn,
					SPL.FTLastUpdBy,
					SPL.FDCreateOn,
					SPL.FTCreateBy
 					FROM TCNMSpl SPL";
		$tSQL .= " WHERE 1=1 ";
		$tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
			$oFoundRow 	= $this->FSaMRPTGetData_PageAll($paData);
			$nFoundRow 	= $oFoundRow[0]->counts;
			$nPageAll 	= ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult 	= array(
				'raItems'  		=> $oQuery->result_array(),
				'rnAllRow'      => $nFoundRow,
				'rnCurrentPage' => $paData['nPage'],
				'rnAllPage'     => $nPageAll,
                'rtCode'   		=> '1',
                'rtDesc'   		=> 'success',
            );
        }else{
            $aResult = array(
				'rnAllRow' 		=> 0,
				'rnCurrentPage' => $paData['nPage'],
				"rnAllPage"		=> 0,
                'rtCode' 		=> '800',
                'rtDesc' 		=> 'data not found',
            );
        }
        return $aResult;
	}

	//หาจำนวนทั้งหมด
	public function FSaMRPTGetData_PageAll($paData){
		try{
			$tSQL 		= "SELECT COUNT (SPL.FTSplCode) AS counts FROM TCNMSpl SPL ";
			$tSQL 		.= " WHERE 1=1 ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            }else{
                return false;
            }
        }catch(Exception $Error){
            echo $Error;
        }
	}

}
