<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mAdjprice extends CI_Model {
	
	public function FSaMAJPGetData($paData){
		$aRowLen   		= FCNaHCallLenData($paData['nRow'],$paData['nPage']);
		$tTextSearch 	= trim($paData['tSearchAll']);
		$tSQL  = "SELECT c.* FROM(";
		$tSQL .= " SELECT  ROW_NUMBER() OVER(ORDER BY FTXphDocNo ASC) AS rtRowID,* FROM (";
		$tSQL .= " SELECT 
					DISTINCT
						HD.FTXphDocNo , 
						HD.FDXphDocDate ,
						HD.FTXphDocTime ,
						HD.FTXphStaDoc ,
						HD.FTXphStaApv ,
						HD.FTXphApvBy ,
						USR.FTUsrFName ,
						PRI.FTPriGrpName
					FROM TCNTPdtAdjPriHD HD 
					LEFT JOIN TCNMUsr USR ON HD.FTXphApvBy = USR.FTUsrCode
					LEFT JOIN TCNMPriGrp PRI ON HD.FTPriGrpID = PRI.FTPriGrpID";
		$tSQL .= " WHERE 1=1 ";

		if($tTextSearch != '' || $tTextSearch != null){
			$tSQL .= " AND ( HD.FTXphDocNo LIKE '%$tTextSearch%' )";
		}

		$tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
			$oFoundRow 	= $this->FSaMAJPGetData_PageAll($paData);
			$nFoundRow 	= $oFoundRow[0]->counts;
			$nPageAll 	= ceil($nFoundRow/$paData['nRow']); 
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
	public function FSaMAJPGetData_PageAll($paData){
		try{
			$tTextSearch = trim($paData['tSearchAll']);
			$tSQL 		= "SELECT COUNT (HD.FTXphDocNo) AS counts FROM TCNTPdtAdjPriHD HD ";
			$tSQL 		.= " WHERE 1=1 ";
			if($tTextSearch != '' || $tTextSearch != null){
				$tSQL .= " AND ( HD.FTXphDocNo LIKE '%$tTextSearch%' )";
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

	//กลุ่มราคาทั้งหมด
	public function FSaMAJPGetPriceGroup(){
		$tSQL = "SELECT * FROM TCNMPriGrp PRIG";
		$oQuery = $this->db->query($tSQL);
		if($oQuery->num_rows() > 0){
			$aResult = array(
				'raItems'  => $oQuery->result_array(),
				'rtCode'   => '1',
				'rtDesc'   => 'success',
			);
		}else{
			$aResult = array(
				'rtCode' => '800',
				'rtDesc' => 'data not found',
			);
		}
		return $aResult;
	}

	//หาสินค้าใน Tmp
	public function FSaMAJPGetDataInTmp($paData){
		$aRowLen   		= FCNaHCallLenData($paData['nRow'],$paData['nPage']);
		$tTextSearch 	= trim($paData['tSearchTmp']);
		$tWorkerID		= $this->session->userdata('tSesUsercode');
		$tSQL  = "SELECT c.* FROM(";
		$tSQL .= " SELECT  ROW_NUMBER() OVER(ORDER BY FTPdtCode ASC) AS rtRowID,* FROM (";
		$tSQL .= " SELECT 
						DTTmp.FTXphDocNo,
						DTTmp.FTPdtCode,
						DTTmp.FCXpdAddPri,
						DTTmp.FDXphDateAtv,
						DTTmp.FTWorkerID,
						PDT.FTPdtName
					FROM TCNTPdtAdjPriDTTmp DTTmp 
					LEFT JOIN TCNMPDT PDT ON PDT.FTPdtCode = DTTmp.FTPdtCode ";
		$tSQL .= " WHERE 1=1 ";
		$tSQL .= " AND DTTmp.FTWorkerID = '$tWorkerID' ";

		if($tTextSearch != '' || $tTextSearch != null){
			$tSQL .= " AND ( PDT.FTPdtCode LIKE '%$tTextSearch%' )";
		}

		$tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
			$oFoundRow 	= $this->FSaMAJPGetDataTmp_PageAll($paData);
			$nFoundRow 	= $oFoundRow[0]->counts;
			$nPageAll 	= ceil($nFoundRow/$paData['nRow']); 
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

	//หาจำนวนทั้งหมดใน Tmp
	public function FSaMAJPGetDataTmp_PageAll($paData){
		try{
			$tTextSearch 	= trim($paData['tSearchTmp']);
			$tWorkerID		= $this->session->userdata('tSesUsercode');
			$tSQL 			= "SELECT COUNT (DTTmp.FTPdtCode) AS counts FROM TCNTPdtAdjPriDTTmp DTTmp LEFT JOIN TCNMPDT PDT ON PDT.FTPdtCode = DTTmp.FTPdtCode ";
			$tSQL 			.= " WHERE 1=1 ";
			$tSQL 			.= " AND DTTmp.FTWorkerID = '$tWorkerID' ";
			if($tTextSearch != '' || $tTextSearch != null){
				$tSQL .= " AND ( PDT.FTPdtCode LIKE '%$tTextSearch%' )";
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
