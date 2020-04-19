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
			$tSQL .= " AND ( PDT.FTPdtCode LIKE '%$tTextSearch%' ";
			$tSQL .= " OR PDT.FTPdtName LIKE '%$tTextSearch%' )";
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
				$tSQL .= " AND ( PDT.FTPdtCode LIKE '%$tTextSearch%' ";
				$tSQL .= " OR PDT.FTPdtName LIKE '%$tTextSearch%' )";
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
	
	//หาสินค้า
	public function FSaMAJPGetPDTToTmp($paData){
		$aRowLen   		= FCNaHCallLenData($paData['nRow'],$paData['nPage']);
		$tWorkerID		= $this->session->userdata('tSesUsercode');
		$tTextSearch 	= trim($paData['tSearchPDT']);
		$tSQL  = "SELECT c.* FROM(";
		$tSQL .= " SELECT  ROW_NUMBER() OVER(ORDER BY FTPdtCode ASC) AS rtRowID,* FROM (";
		$tSQL .= " SELECT 
						PDT.FTPdtCode,
						PDT.FTBchCode,
						PDT.FTPdtName,
						PDT.FTPdtNameOth,
						PDT.FTPdtDesc,
						PDT.FTPunCode,
						PDT.FTPgpCode,
						PDT.FTPtyCode,
						PDT.FTPbnCode,
						PDT.FTPzeCode,
						PDT.FTPClrCode,
						PDT.FTSplCode,
						PDT.FTMolCode,
						PDT.FCPdtCostStd,
						PDT.FTPdtCostDis,
						PDT.FCPdtSalPrice,
						PDT.FTPdtImage,
						PDT.FDCreateOn,
						PDT.FTPdtStatus,
						BAP.FTPbnName,
						COP.FTPClrName,
						GRP.FTPgpName,
						MOL.FTMolName,
						SIZ.FTPzeName,
						TYP.FTPtyName,
						UNIT.FTPunName,
						SPL.FTSplName
					FROM TCNMPdt PDT 
					LEFT JOIN TCNMPdtBrand BAP 	ON PDT.FTPbnCode 	= BAP.FTPbnCode 
					LEFT JOIN TCNMPdtColor COP 	ON PDT.FTPClrCode 	= COP.FTPClrCode 
					LEFT JOIN TCNMPdtGrp GRP 	ON PDT.FTPgpCode 	= GRP.FTPgpCode 
					LEFT JOIN TCNMPdtModal MOL 	ON PDT.FTMolCode 	= MOL.FTMolCode 
					LEFT JOIN TCNMPdtSize SIZ 	ON PDT.FTPzeCode 	= SIZ.FTPzeCode 
					LEFT JOIN TCNMPdtType TYP 	ON PDT.FTPtyCode 	= TYP.FTPtyCode 
					LEFT JOIN TCNMPdtUnit UNIT 	ON PDT.FTPunCode 	= UNIT.FTPunCode 
					LEFT JOIN TCNMSpl SPL 		ON PDT.FTSplCode 	= SPL.FTSplCode 
					LEFT JOIN TCNTPdtAdjPriDTTmp TMP ON PDT.FTPdtCode = TMP.FTPdtCode AND TMP.FTWorkerID = '$tWorkerID' ";
		$tSQL .= " WHERE 1=1 ";
		$tSQL .= " AND TMP.FTPdtCode IS NULL ";


		//ค้นหาธรรมดา
		if($tTextSearch != '' || $tTextSearch != null){
			$tSQL .= " AND ( PDT.FTPdtCode LIKE '%$tTextSearch%' ";
			$tSQL .= " OR PDT.FTPdtName LIKE '%$tTextSearch%' ";
			$tSQL .= " OR PDT.FTPdtNameOth LIKE '%$tTextSearch%' ";
			$tSQL .= " OR PDT.FTPdtDesc LIKE '%$tTextSearch%' ";
			$tSQL .= " OR PDT.FTPunCode LIKE '%$tTextSearch%' ";
			$tSQL .= " OR PDT.FTPgpCode LIKE '%$tTextSearch%' ";
			$tSQL .= " OR PDT.FTPtyCode LIKE '%$tTextSearch%' ";
			$tSQL .= " OR PDT.FTPbnCode LIKE '%$tTextSearch%' ";
			$tSQL .= " OR PDT.FTPzeCode LIKE '%$tTextSearch%' ";
			$tSQL .= " OR PDT.FTPClrCode LIKE '%$tTextSearch%' ";
			$tSQL .= " OR PDT.FTSplCode LIKE '%$tTextSearch%' ";
			$tSQL .= " OR PDT.FCPdtCostStd LIKE '%$tTextSearch%' ";
			$tSQL .= " OR PDT.FCPdtSalPrice LIKE '%$tTextSearch%' ";
			$tSQL .= " OR UNIT.FTPunName LIKE '%$tTextSearch%' ";
			$tSQL .= " OR SPL.FTSplName LIKE '%$tTextSearch%' ";
			$tSQL .= " OR BAP.FTPbnName LIKE '%$tTextSearch%' ";
			$tSQL .= " OR COP.FTPClrName LIKE '%$tTextSearch%' ";
			$tSQL .= " OR GRP.FTPgpName LIKE '%$tTextSearch%' ";
			$tSQL .= " OR MOL.FTMolName LIKE '%$tTextSearch%' ";
			$tSQL .= " OR TYP.FTPtyName LIKE '%$tTextSearch%' ";
			$tSQL .= " OR SIZ.FTPzeName LIKE '%$tTextSearch%' )";
		}

		$tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
			$oFoundRow 	= $this->FSaMAJPGetDataPDT_PageAll($paData);
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

	//หาสินค้าทั้งหมด
	public function FSaMAJPGetDataPDT_PageAll($paData){
		try{
			$tTextSearch 	= trim($paData['tSearchPDT']);
			$tWorkerID		= $this->session->userdata('tSesUsercode');
			$tSQL 		= "SELECT COUNT (PDT.FTPdtCode) AS counts 
							FROM TCNMPdt PDT 
							LEFT JOIN TCNMPdtBrand BAP 	ON PDT.FTPbnCode 	= BAP.FTPbnCode 
							LEFT JOIN TCNMPdtColor COP 	ON PDT.FTPClrCode 	= COP.FTPClrCode 
							LEFT JOIN TCNMPdtGrp GRP 	ON PDT.FTPgpCode 	= GRP.FTPgpCode 
							LEFT JOIN TCNMPdtModal MOL 	ON PDT.FTMolCode 	= MOL.FTMolCode 
							LEFT JOIN TCNMPdtSize SIZ 	ON PDT.FTPzeCode 	= SIZ.FTPzeCode 
							LEFT JOIN TCNMPdtType TYP 	ON PDT.FTPtyCode 	= TYP.FTPtyCode 
							LEFT JOIN TCNMPdtUnit UNIT 	ON PDT.FTPunCode 	= UNIT.FTPunCode 
							LEFT JOIN TCNMSpl SPL 		ON PDT.FTSplCode 	= SPL.FTSplCode 
							LEFT JOIN TCNTPdtAdjPriDTTmp TMP ON PDT.FTPdtCode = TMP.FTPdtCode AND TMP.FTWorkerID = '$tWorkerID' ";

			$tSQL 		.= " WHERE 1=1 ";
			$tSQL 		.= " AND TMP.FTPdtCode IS NULL ";

			//ค้นหาธรรมดา
			if($tTextSearch != '' || $tTextSearch != null){
				$tSQL .= " AND ( PDT.FTPdtCode LIKE '%$tTextSearch%' ";
				$tSQL .= " OR PDT.FTPdtName LIKE '%$tTextSearch%' ";
				$tSQL .= " OR PDT.FTPdtNameOth LIKE '%$tTextSearch%' ";
				$tSQL .= " OR PDT.FTPdtDesc LIKE '%$tTextSearch%' ";
				$tSQL .= " OR PDT.FTPunCode LIKE '%$tTextSearch%' ";
				$tSQL .= " OR PDT.FTPgpCode LIKE '%$tTextSearch%' ";
				$tSQL .= " OR PDT.FTPtyCode LIKE '%$tTextSearch%' ";
				$tSQL .= " OR PDT.FTPbnCode LIKE '%$tTextSearch%' ";
				$tSQL .= " OR PDT.FTPzeCode LIKE '%$tTextSearch%' ";
				$tSQL .= " OR PDT.FTPClrCode LIKE '%$tTextSearch%' ";
				$tSQL .= " OR PDT.FTSplCode LIKE '%$tTextSearch%' ";
				$tSQL .= " OR PDT.FCPdtCostStd LIKE '%$tTextSearch%' ";
				$tSQL .= " OR PDT.FCPdtSalPrice LIKE '%$tTextSearch%' ";
				$tSQL .= " OR UNIT.FTPunName LIKE '%$tTextSearch%' ";
				$tSQL .= " OR SPL.FTSplName LIKE '%$tTextSearch%' ";
				$tSQL .= " OR BAP.FTPbnName LIKE '%$tTextSearch%' ";
				$tSQL .= " OR COP.FTPClrName LIKE '%$tTextSearch%' ";
				$tSQL .= " OR GRP.FTPgpName LIKE '%$tTextSearch%' ";
				$tSQL .= " OR MOL.FTMolName LIKE '%$tTextSearch%' ";
				$tSQL .= " OR TYP.FTPtyName LIKE '%$tTextSearch%' ";
				$tSQL .= " OR SIZ.FTPzeName LIKE '%$tTextSearch%' )";
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

	//เพิ่ม PDT To Tmp
	public function FSaMAJPInsertPDTToTmp($aResult){
		try{
			$this->db->insert('TCNTPdtAdjPriDTTmp', $aResult);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//ลบข้อมูลใน Tmp
	public function FSaMAJPDeletePDTInTmp($paData){
		try{
			$FTXphDocNo 	= $paData['FTXphDocNo'];
			$FTPdtCode 		= $paData['FTPdtCode'];
			$FTWorkerID 	= $paData['FTWorkerID'];

			$this->db->where_in('FTXphDocNo', $FTXphDocNo);
			$this->db->where_in('FTPdtCode', $FTPdtCode);
			$this->db->where_in('FTWorkerID', $FTWorkerID);
            $this->db->delete('TCNTPdtAdjPriDTTmp');
		}catch(Exception $Error){
            echo $Error;
		}
	}

	//อัพเดทราคาในตาราง Tmp
	public function FSaMAJPUpdatePDTInTmp($ptSet,$ptWhere){
		try{
			$this->db->where('FTXphDocNo', $ptWhere['FTXphDocNo']);
			$this->db->where('FTPdtCode', $ptWhere['FTPdtCode']);
			$this->db->where('FTWorkerID', $ptWhere['FTWorkerID']);
			$this->db->update('TCNTPdtAdjPriDTTmp', $ptSet);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//เช็คข้อมูลซ้ำก่อนว่า มีแล้วหรือยัง
	public function FSaMAJPCheckDataDuplicate($paData){

		$FTPdtCode	= $paData['FTPdtCode'];
		$FTWorkerID	= $paData['FTWorkerID'];
		$FTXphDocNo	= $paData['FTXphDocNo'];

		$tSQL = " SELECT * FROM TCNTPdtAdjPriDTTmp AJP ";
		$tSQL .= " WHERE AJP.FTPdtCode = '$FTPdtCode' ";
		$tSQL .= " AND AJP.FTWorkerID = '$FTWorkerID' ";
		$tSQL .= " AND AJP.FTXphDocNo = '$FTXphDocNo' ";
	
		$oQuery = $this->db->query($tSQL);
		if($oQuery->num_rows() > 0){
			$aResult = array(
				'rtCode'   => '1',
				'rtDesc'   => 'duplication',
				'tSQL'	   => $tSQL
			);
		}else{
			$aResult = array(
				'rtCode' 	=> '800',
				'rtDesc' 	=> 'pass',
				'tSQL'	   	=> $tSQL
			);
		}
		return $aResult;
	}

	//เพิ่มข้อมูล
	public function FSaMAJPImportExcelInsert($aResult){
		try{
			$this->db->insert('TCNTPdtAdjPriDTTmp', $aResult);
		}catch(Exception $Error){
			echo $Error;
		}
	}


}
