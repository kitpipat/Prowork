<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mAdjcost extends CI_Model {
	
	public function FSaMAJCGetData($paData){
		$aRowLen   		= FCNaHCallLenData($paData['nRow'],$paData['nPage']);
		$tTextSearch 	= trim($paData['tSearchAll']);
		$tSQL  = "SELECT c.* FROM(";
		$tSQL .= " SELECT  ROW_NUMBER() OVER(ORDER BY FTXphDocNo DESC) AS rtRowID,* FROM (";
		$tSQL .= " SELECT 
					DISTINCT
						HD.FTBchCode,
						HD.FTXphDocNo,
						HD.FDXphDocDate,
						HD.FTXphDocTime,
						HD.FDXphDStart,
						HD.FTXphStaDoc,
						HD.FTXphStaApv, 
						HD.FTUsrCode , 
						HD.FTXphUsrApv ,
						USR.FTUsrFName 
					FROM TCNTPdtAdjCostHD HD 
					LEFT JOIN TCNMUsr USR ON HD.FTXphUsrApv = USR.FTUsrCode";
		$tSQL .= " WHERE 1=1 ";

		if($tTextSearch != '' || $tTextSearch != null){
			$tSQL .= " AND ( HD.FTXphDocNo LIKE '%$tTextSearch%' )";
		}

		$tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
			$oFoundRow 	= $this->FSaMAJCGetData_PageAll($paData);
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
	public function FSaMAJCGetData_PageAll($paData){
		try{
			$tTextSearch = trim($paData['tSearchAll']);
			$tSQL 		= "SELECT COUNT (HD.FTXphDocNo) AS counts FROM TCNTPdtAdjCostHD HD ";
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
	public function FSaMAJCGetPriceGroup(){
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
	public function FSaMAJCGetDataInTmp($paData){
		$aRowLen   		= FCNaHCallLenData($paData['nRow'],$paData['nPage']);
		$tTextSearch 	= trim($paData['tSearchTmp']);
		$tWorkerID		= $this->session->userdata('tSesUsercode');
		$tSQL  = "SELECT c.* FROM(";
		$tSQL .= " SELECT  ROW_NUMBER() OVER(ORDER BY FTPdtCode ASC) AS rtRowID,* FROM (";
		$tSQL .= " SELECT 
						DTTmp.FTBchCode,
						DTTmp.FTXphDocNo,
						DTTmp.FNXpdSeq,
						DTTmp.FTPdtCode,
						DTTmp.FTXpdSplCode,
						DTTmp.FCXpdCost,
						DTTmp.FTXpdDisCost,
						DTTmp.FTWorkerID,
						PDT.FTPdtName
					FROM TCNTPdtAdjCostDTTmp DTTmp 
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
			$oFoundRow 	= $this->FSaMAJCGetDataTmp_PageAll($paData);
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
	public function FSaMAJCGetDataTmp_PageAll($paData){
		try{
			$tTextSearch 	= trim($paData['tSearchTmp']);
			$tWorkerID		= $this->session->userdata('tSesUsercode');
			$tSQL 			= "SELECT COUNT (DTTmp.FTPdtCode) AS counts FROM TCNTPdtAdjCostDTTmp DTTmp LEFT JOIN TCNMPDT PDT ON PDT.FTPdtCode = DTTmp.FTPdtCode ";
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
	public function FSaMAJCGetPDTToTmp($paData){
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
					LEFT JOIN TCNTPdtAdjCostDTTmp TMP ON PDT.FTPdtCode = TMP.FTPdtCode AND TMP.FTWorkerID = '$tWorkerID' ";
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
			$oFoundRow 	= $this->FSaMAJCGetDataPDT_PageAll($paData);
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
	public function FSaMAJCGetDataPDT_PageAll($paData){
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
							LEFT JOIN TCNTPdtAdjCostDTTmp TMP ON PDT.FTPdtCode = TMP.FTPdtCode AND TMP.FTWorkerID = '$tWorkerID' ";

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
	public function FSaMAJCInsertPDTToTmp($aResult){
		try{
			$this->db->insert('TCNTPdtAdjCostDTTmp', $aResult);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//หา Seq ล่าสุดใน Tmp
	public function FSaMAJCGetSeqLast($tDocumentCode , $tWorkID){
		$tSQL = "SELECT TOP 1 FNXpdSeq FROM TCNTPdtAdjCostDTTmp ";
		$tSQL .= " WHERE FTXphDocNo = '$tDocumentCode' AND FTWorkerID = '$tWorkID' ";
		$tSQL .=" ORDER BY FNXpdSeq DESC ";

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

	//หาว่า สินค้านี้ใช้ spl อะไร และ ต้นทุนตั้งต้นเท่าไหร่
	public function FSaMAJCFindSplAndSTDCost($ptPDTCode){
		$tSQL = "SELECT TOP 1 FTSplCode , FCPdtCostStd FROM TCNMPdt ";
		$tSQL .= " WHERE FTPdtCode = '$ptPDTCode' ";
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

	//ลบข้อมูลใน Tmp
	public function FSaMAJCDeletePDTInTmp($paData){
		try{
			$FTXphDocNo 	= $paData['FTXphDocNo'];
			$FTPdtCode 		= $paData['FTPdtCode'];
			$FTWorkerID 	= $paData['FTWorkerID'];

			$this->db->where_in('FTXphDocNo', $FTXphDocNo);
			$this->db->where_in('FTPdtCode', $FTPdtCode);
			$this->db->where_in('FTWorkerID', $FTWorkerID);
			$this->db->delete('TCNTPdtAdjCostDTTmp');

			//เรียง Seq ใหม่
			$tSQL   = " UPDATE TCNTPdtAdjCostDTTmp WITH(ROWLOCK)
						SET FNXpdSeq = NewObj.NewSeq 
						FROM TCNTPdtAdjCostDTTmp DT 
						INNER JOIN (
							SELECT  ROW_NUMBER() OVER (ORDER BY FNXpdSeq) AS NewSeq,
									FNXpdSeq AS OldSeq
							FROM TCNTPdtAdjCostDTTmp 
							WHERE 
								FTXphDocNo = '$FTXphDocNo'
							AND FTWorkerID = '$FTWorkerID'
					) NewObj ON DT.FNXpdSeq = NewObj.OldSeq";
			$this->db->query($tSQL);

		}catch(Exception $Error){
            echo $Error;
		}
	}

	//อัพเดทราคาในตาราง Tmp
	public function FSaMAJCUpdatePDTInTmp($ptSet,$ptWhere){
		try{
			$this->db->where('FTXphDocNo', $ptWhere['FTXphDocNo']);
			$this->db->where('FTPdtCode', $ptWhere['FTPdtCode']);
			$this->db->where('FTWorkerID', $ptWhere['FTWorkerID']);
			$this->db->update('TCNTPdtAdjCostDTTmp', $ptSet);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//เช็คข้อมูลซ้ำก่อนว่า มีแล้วหรือยัง
	public function FSaMAJCCheckDataDuplicate($paData){

		$FTPdtCode	= $paData['FTPdtCode'];
		$FTWorkerID	= $paData['FTWorkerID'];
		$FTXphDocNo	= $paData['FTXphDocNo'];

		$tSQL = " SELECT * FROM TCNTPdtAdjCostDTTmp AJC ";
		$tSQL .= " WHERE AJC.FTPdtCode = '$FTPdtCode' ";
		$tSQL .= " AND AJC.FTWorkerID = '$FTWorkerID' ";
		$tSQL .= " AND AJC.FTXphDocNo = '$FTXphDocNo' ";
	
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

	//เพิ่มข้อมูล จากเอกสารนำเข้า
	public function FSaMAJCImportExcelInsert($aResult){
		try{
			$this->db->insert('TCNTPdtAdjCostDTTmp', $aResult);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//ค้นหาเลขที่เอกสารล่าสุด HD
	public function FSaMAJCGetLastDocumentAdjCode(){
		$tSQL = "SELECT TOP 1 FTXphDocNo FROM TCNTPdtAdjCostHD ORDER BY FTXphDocNo DESC ";
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

	//เพิ่มข้อมูล HD
	public function FSxMAJCInsertHD($aResult){
		try{
			$this->db->insert('TCNTPdtAdjCostHD', $aResult);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//เพิ่มข้อมูล DT (Tmp To DT)
	public function FSxMAJCInsertDT($tCode){
		try{
			$tSesstionBCH  	= $this->session->userdata('tSesBCHCode');
			$tSession  		= $this->session->userdata('tSesUsercode');
			$dCurrent		= date('Y-m-d H:i:s');

			$tSQL = "INSERT INTO TCNTPdtAdjCostDT (
				FTBchCode,
				FTXphDocNo,
				FNXpdSeq,
				FTPdtCode,
				FTXpdSplCode,
				FCXpdCost,
				FTXpdDisCost,
				FDCreateOn,
				FTCreateBy
			)
			SELECT 
				'$tSesstionBCH' AS FTBchCode,
				'$tCode' AS FTXphDocNo,
				FNXpdSeq,
				TCNTPdtAdjCostDTTmp.FTPdtCode,
				FTXpdSplCode,
				FCXpdCost,
				FTXpdDisCost,
				'$dCurrent' AS FDCreateOn,
				$tSession AS FTCreateBy
			FROM TCNTPdtAdjCostDTTmp
			INNER JOIN TCNMPDT ON TCNTPdtAdjCostDTTmp.FTPdtCode = TCNMPDT.FTPdtCode
			WHERE TCNTPdtAdjCostDTTmp.FTWorkerID = '$tSession'";
			$this->db->query($tSQL);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//ลบข้อมูลใน Tmp หลังจาก เพิ่มลงใน DT แล้ว
	public function FSxMAJCDeleteTmpAfterInsDT($tCode){
		try{
			$FTWorkerID  = $this->session->userdata('tSesUsercode');
			
			//ส่งเลขที่เอกสารมา
			if($tCode != '' || $tCode != null){
				$this->db->where_in('FTXphDocNo', $tCode);
			}

			$this->db->where_in('FTWorkerID', $FTWorkerID);
            $this->db->delete('TCNTPdtAdjCostDTTmp');
		}catch(Exception $Error){
            echo $Error;
		}
	}

	//เข้าหน้าเเก้ไข
	public function FSaMAJCGetDataBYID($ptCode){
		$tSQL = " SELECT 
						HD.FTBchCode,
						HD.FTXphDocNo,
						HD.FDXphDocDate,
						HD.FTXphDocTime,
						HD.FDXphDStart,
						HD.FTXphStaDoc,
						HD.FTXphStaApv,
						HD.FTUsrCode,
						HD.FTXphUsrApv,
						HD.FTXphRmk,
						HD.FDLastUpdOn,
						HD.FTLastUpdBy,
						HD.FDCreateOn,
						HD.FTCreateBy,
						USR.FTUsrFName,
						USR.FTUsrLName	
		 			FROM TCNTPdtAdjCostHD HD";
		$tSQL .= " LEFT JOIN TCNMUsr USR ON HD.FTCreateBy = USR.FTUsrCode";
		$tSQL .= " WHERE HD.FTXphDocNo = '$ptCode' ";
		$oQuery = $this->db->query($tSQL);
		return $oQuery->result_array();
	}

	//เอาข้อมูลจาก Insert DT to Tmp
	public function FSaMAJCMoveDTToTmp($ptCode){
		try{
			$tSession  	= $this->session->userdata('tSesUsercode');
			$dCurrent	= date('Y-m-d H:i:s');

			$tSQL = "INSERT INTO TCNTPdtAdjCostDTTmp (
				FTBchCode,
				FTXphDocNo,
				FNXpdSeq,
				FTPdtCode,
				FTXpdSplCode,
				FCXpdCost,
				FTXpdDisCost,
				FDLastUpdOn,
				FTLastUpdBy,
				FDCreateOn,
				FTCreateBy,
				FTWorkerID
			)
			SELECT 
				FTBchCode,
				FTXphDocNo,
				FNXpdSeq,
				FTPdtCode,
				FTXpdSplCode,
				FCXpdCost,
				FTXpdDisCost,
				FDLastUpdOn,
				FTLastUpdBy,
				FDCreateOn,
				FTCreateBy,
				$tSession AS FTWorkerID
			FROM TCNTPdtAdjCostDT DT
			WHERE DT.FTXphDocNo = '$ptCode'";
			$this->db->query($tSQL);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//ลบข้อมูลใน DT
	public function FSxMAJCDeleteDT($tCode){
		try{
			$this->db->where_in('FTXphDocNo', $tCode);
			$this->db->delete('TCNTPdtAdjCostDT');
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//แก้ไขข้อมูล HD
	public function FSxMGRPUpdate($ptSet,$ptWhere){
		try{
			$this->db->where('FTXphDocNo', $ptWhere['FTXphDocNo']);
			$this->db->update('TCNTPdtAdjCostHD', $ptSet);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//ลบข้อมูล HD
	public function FSaMAJCDelete($ptCode){
		try{
			$this->db->where_in('FTXphDocNo', $ptCode);
			$this->db->delete('TCNTPdtAdjCostHD');
			
			$this->db->where_in('FTXphDocNo', $ptCode);
            $this->db->delete('TCNTPdtAdjCostDT');
		}catch(Exception $Error){
            echo $Error;
        }
	}

	//ยกเลิกเอกสาร
	public function FSaMAJCCancleDocument($ptCode){
		try{
			$aSet = array(
				'FTXphStaDoc' 	=> 2,
				'FDLastUpdOn'	=> date('Y-m-d H:i:s'),
				'FTLastUpdBy'	=> $this->session->userdata('tSesUsercode')
			);
			$this->db->where('FTXphDocNo', $ptCode);
			$this->db->update('TCNTPdtAdjCostHD', $aSet);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//อนุมัติเอกสาร
	public function FSaMAJCAproveDocument($ptCode){
		try{
			$aSet = array(
				'FTXphStaApv'  	=> 1,
				'FTXphUsrApv'	=> $this->session->userdata('tSesUsercode')
			);
			$this->db->where('FTXphDocNo', $ptCode);
			$this->db->update('TCNTPdtAdjCostHD', $aSet);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//หาสินค้าใน DT เพื่อเอาไปทำ cost 
	public function FSaMAJCGetItemInPDT($ptCode){
		$tSQL = " SELECT 
						HD.FDXphDStart,
						DT.FTPdtCode
		 			FROM TCNTPdtAdjCostHD HD";
		$tSQL .= " LEFT JOIN TCNTPdtAdjCostDT DT ON HD.FTXphDocNo = DT.FTXphDocNo";
		$tSQL .= " WHERE HD.FTXphDocNo = '$ptCode' ";
		$oQuery = $this->db->query($tSQL);
		return $oQuery->result_array();
	}

}
