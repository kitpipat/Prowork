<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mPurchaseorder extends CI_Model {
	
	public function FSaMPOGetData($paData){
		$aRowLen   		= FCNaHCallLenData($paData['nRow'],$paData['nPage']);
		$tTextSearch 	= trim($paData['tSearchAll']);
		$tSQL  = "SELECT c.* FROM(";
		$tSQL .= " SELECT  ROW_NUMBER() OVER(ORDER BY FTXpoDocNo DESC) AS rtRowID,* FROM (";
		$tSQL .= " SELECT 
					DISTINCT
						HD.*
					FROM TARTPoHD HD 
					LEFT JOIN TCNMUsr USR ON HD.FTApprovedBy = USR.FTUsrCode";
		$tSQL .= " WHERE 1=1 ";

		if($tTextSearch != '' || $tTextSearch != null){
			$tSQL .= " AND ( HD.FTXpoDocNo LIKE '%$tTextSearch%' )";
		}

		$tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
			$oFoundRow 	= $this->FSaMPOGetData_PageAll($paData);
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
	public function FSaMPOGetData_PageAll($paData){
		try{
			$tTextSearch = trim($paData['tSearchAll']);
			$tSQL 		= "SELECT COUNT (HD.FTXpoDocNo) AS counts FROM TARTPoHD HD ";
			$tSQL 		.= " WHERE 1=1 ";
			if($tTextSearch != '' || $tTextSearch != null){
				$tSQL .= " AND ( HD.FTXpoDocNo LIKE '%$tTextSearch%' )";
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

	//ลบข้อมูล
	public function FSaMPODelete($ptCode){
		try{
			$this->db->where_in('FTXpoDocNo', $ptCode);
			$this->db->delete('TARTPoHD');
			
			$this->db->where_in('FTXpoDocNo', $ptCode);
            $this->db->delete('TARTPoDT');

			//มีมากกว่านี้
		}catch(Exception $Error){
            echo $Error;
        }
	}

	//ลบข้อมูลใน Temp 
	public function FSxMPODeleteTmpAfterInsDT($tCode){
		try{
			$FTWorkerID  = $this->session->userdata('tSesLogID');
			
			//ส่งเลขที่เอกสารมา
			if($tCode != '' || $tCode != null){
				$this->db->where_in('FTXpoDocNo', $tCode);
			}

			$this->db->where_in('FTWorkerID', $FTWorkerID);
            $this->db->delete('TARTPoDTTmp');
		}catch(Exception $Error){
            echo $Error;
		}
	}

	//เข้าหน้าเเก้ไข
	public function FSaMPOGetDataBYID_HD($ptCode){
		$tSQL = "  SELECT HD.* , USR.FTUsrFName , USR.FTUsrLName	
		 		   FROM TARTPoHD HD";
		$tSQL .= " LEFT JOIN TCNMUsr USR ON HD.FTCreateBy = USR.FTUsrCode";
		$tSQL .= " WHERE HD.FTXpoDocNo = '$ptCode' ";
		$oQuery = $this->db->query($tSQL);
		return $oQuery->result_array();
	}

	//เอาข้อมูลจาก Insert DT to Tmp
	public function FSaMPOMoveDTToTmp($ptCode){
		try{
			$tSession  	= $this->session->userdata('tSesLogID');
			$tSQL = "INSERT INTO TARTPoDTTmp (
						FTXpoDocNo,
						FNXpoSeq,
						FTPdtCode,
						FTPdtName,
						FTPunCode,
						FTPunName,
						FCXpoUnitPrice,
						FTXpoCost,
						FTSplCode,
						FCXpoQty,
						FCXpoB4Dis,
						FCXpoDis,
						FTXpoDisTxt,
						FCXpoAfDT,
						FCXpoFootAvg,
						FCXpoNetAfHD,
						FTXpoRefPo,
						FTPdtStaEditName,
						FTCreateBy,
						FDCreateOn,
						FTUpdateBy,
						FDUpdateOn,
						FTXpoRefBuyer,
						FTPdtStaCancel,
						FTWorkerID
					)
					SELECT 
						FTXpoDocNo,
						FNXpoSeq,
						FTPdtCode,
						FTPdtName,
						FTPunCode,
						FTPunName,
						FCXpoUnitPrice,
						FTXpoCost,
						FTSplCode,
						FCXpoQty,
						FCXpoB4Dis,
						FCXpoDis,
						FTXpoDisTxt,
						FCXpoAfDT,
						FCXpoFootAvg,
						FCXpoNetAfHD,
						FTXpoRefPo,
						FTPdtStaEditName,
						FTCreateBy,
						FDCreateOn,
						FTUpdateBy,
						FDUpdateOn,
						FTXpoRefBuyer,
						FTPdtStaCancel,
						FTWorkerID
						'$tSession' AS FTWorkerID,
					FROM TARTPoDT DT
					WHERE DT.FTXpoDocNo = '$ptCode'";
					$this->db->query($tSQL);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//ข้อมูลผู้จำหน่าย
	public function FCxMPOGetSupplierAll($paData)
	{
		$aRowLen   		= FCNaHCallLenData($paData['nRow'], $paData['nPage']);
		$tWorkerID		= $this->session->userdata('tSesLogID');
		$tTextSearch 	= trim($paData['tSearchSupplier']);
		$tSQL  = "SELECT c.* FROM(";
		$tSQL .= " SELECT  ROW_NUMBER() OVER(ORDER BY FTSplCode ASC) AS rtRowID,* FROM (";
		$tSQL .= " SELECT SPL.* FROM TCNMSpl SPL ";
		$tSQL .= " WHERE 1=1 ";
		$tSQL .= " AND SPL.FTSplStaActive = 1 ";

		//ค้นหาธรรมดา
		if ($tTextSearch != '' || $tTextSearch != null) {
			$tSQL .= " AND ( SPL.FTSplCode LIKE '%$tTextSearch%' ";
			$tSQL .= " OR SPL.FTSplName LIKE '%$tTextSearch%' ";
			$tSQL .= " OR SPL.FTSplAddress LIKE '%$tTextSearch%' ";
			$tSQL .= " OR SPL.FTSplContact LIKE '%$tTextSearch%' ";
			$tSQL .= " OR SPL.FTSplEmail LIKE '%$tTextSearch%' ";
			$tSQL .= " OR SPL.FTSplTel LIKE '%$tTextSearch%' )";
		}

		$tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
		$oQuery = $this->db->query($tSQL);
		if ($oQuery->num_rows() > 0) {
			$oFoundRow 	= $this->FCxMQUGetSupplier_PageAll($paData);
			$nFoundRow 	= $oFoundRow[0]->counts;
			$nPageAll 	= ceil($nFoundRow / $paData['nRow']);
			$aResult 	= array(
				'raItems'  		=> $oQuery->result_array(),
				'rnAllRow'      => $nFoundRow,
				'rnCurrentPage' => $paData['nPage'],
				'rnAllPage'     => $nPageAll,
				'rtCode'   		=> '1',
				'rtDesc'   		=> 'success',
			);
		} else {
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

	public function FCxMQUGetSupplier_PageAll($paData)
	{
		try {
			$tTextSearch 	= trim($paData['tSearchSupplier']);
			$tWorkerID		= $this->session->userdata('tSesLogID');
			$tSQL 		= "SELECT COUNT (SPL.FTSplCode) AS counts
							FROM TCNMSpl SPL  ";
			$tSQL 		.= " WHERE 1=1 ";
			$tSQL 		.= " AND SPL.FTSplStaActive = 1 ";

			//ค้นหาธรรมดา
			if ($tTextSearch != '' || $tTextSearch != null) {
				$tSQL .= " AND ( SPL.FTSplCode LIKE '%$tTextSearch%' ";
				$tSQL .= " OR SPL.FTSplName LIKE '%$tTextSearch%' ";
				$tSQL .= " OR SPL.FTSplAddress LIKE '%$tTextSearch%' ";
				$tSQL .= " OR SPL.FTSplContact LIKE '%$tTextSearch%' ";
				$tSQL .= " OR SPL.FTSplEmail LIKE '%$tTextSearch%' ";
				$tSQL .= " OR SPL.FTSplTel LIKE '%$tTextSearch%' )";
			}

			$oQuery = $this->db->query($tSQL);
			if ($oQuery->num_rows() > 0) {
				return $oQuery->result();
			} else {
				return false;
			}
		} catch (Exception $Error) {
			echo $Error;
		}
	}
}
