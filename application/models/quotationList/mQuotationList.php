<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mQuotationList extends CI_Model{

	public function FSaMPILGetData($paData){
		$aRowLen   		= FCNaHCallLenData($paData['nRow'],$paData['nPage']);
		$tTextSearch 	= trim($paData['tSearchAll']);
		$tSQL  = "SELECT c.* FROM(";
		$tSQL .= " SELECT  ROW_NUMBER() OVER(ORDER BY FTXqhDocNo DESC) AS rtRowID,* FROM (";
		$tSQL .= " SELECT 
						HD.FTBchCode,
						HD.FTXqhDocNo,
						HD.FDXqhDocDate,
						HD.FTXqhCshOrCrd,
						HD.FNXqhCredit,
						HD.FTXqhVATInOrEx,
						HD.FNXqhSmpDay,
						HD.FDXqhEftTo,
						HD.FDDeliveryDate,
						HD.FTXqhStaExpress,
						HD.FTXqhStaDoc,
						HD.FTXqhStaActive,
						HD.FTXqhStaDeli,
						HD.FTXqhPrjName,
						HD.FTXqhPrjCodeRef,
						HD.FCXqhB4Dis,
						HD.FCXqhDis,
						HD.FTXqhDisTxt,
						HD.FCXqhAFDis,
						HD.FCXqhVatRate,
						HD.FCXqhAmtVat,
						HD.FCXqhVatable,
						HD.FCXqhGrand,
						HD.FCXqhRnd,
						HD.FTXqhGndText,
						HD.FTXqhRmk,
						HD.FTUsrDep,
						HD.FTApprovedBy,
						HD.FDApproveDate,
						HD.FTCreateBy,
						HD.FDCreateOn,
						HD.FTUpdateBy,
						HD.FDUpdateOn,
						USR.FTUsrFName 
					 FROM TARTSqHD HD
					 LEFT JOIN TCNMUsr USR ON HD.FTApprovedBy = USR.FTUsrCode ";
		$tSQL .= " WHERE 1=1 ";

		if($tTextSearch != '' || $tTextSearch != null){
			$tSQL .= " AND ( HD.FTXqhDocNo LIKE '%$tTextSearch%' )";
		}

		$tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
			$oFoundRow 	= $this->FSaMPILGetData_PageAll($paData);
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
	public function FSaMPILGetData_PageAll($paData){
		try{
			$tTextSearch = trim($paData['tSearchAll']);
			$tSQL 		= "SELECT COUNT (HD.FTXqhDocNo) AS counts FROM TARTSqHD HD ";
			$tSQL 		.= " WHERE 1=1 ";
			if($tTextSearch != '' || $tTextSearch != null){
				$tSQL .= " AND ( HD.FTXqhDocNo LIKE '%$tTextSearch%' )";
			}

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
