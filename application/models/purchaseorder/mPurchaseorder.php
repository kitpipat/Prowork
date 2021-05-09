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
						HD.*,
						USR.FTUsrFName,
						BCH.FTBchName,
						SPL.FTXpoSplName
					FROM TARTPoHD HD 
					LEFT JOIN TCNMUsr USR ON HD.FTApprovedBy = USR.FTUsrCode 
					LEFT JOIN TCNMBranch BCH ON HD.FTBchCode = BCH.FTBchCode 
					LEFT JOIN TARTPoHDSpl SPL ON HD.FTXpoDocNo = SPL.FTXpoDocNo ";
		$tSQL .= " WHERE 1=1 ";

		if($tTextSearch != '' || $tTextSearch != null){
			$tSQL .= " AND ( HD.FTXpoDocNo LIKE '%$tTextSearch%' ";
			$tSQL .= " OR BCH.FTBchName LIKE '%$tTextSearch%' ";
			$tSQL .= " OR USR.FTUsrFName LIKE '%$tTextSearch%' ";
			$tSQL .= " OR SPL.FTXpoSplName LIKE '%$tTextSearch%' ";
			$tSQL .= " OR SPL.FTXpoSplCode LIKE '%$tTextSearch%' )";
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
			$tSQL 		= "SELECT COUNT (HD.FTXpoDocNo) AS counts FROM TARTPoHD HD 
						LEFT JOIN TCNMBranch BCH ON HD.FTBchCode = BCH.FTBchCode 
						LEFT JOIN TARTPoHDSpl SPL ON HD.FTXpoDocNo = SPL.FTXpoDocNo ";
			$tSQL 		.= " WHERE 1=1 ";
			if($tTextSearch != '' || $tTextSearch != null){
				$tSQL .= " AND ( HD.FTXpoDocNo LIKE '%$tTextSearch%' ";
				$tSQL .= " OR BCH.FTBchName LIKE '%$tTextSearch%' ";
				$tSQL .= " OR USR.FTUsrFName LIKE '%$tTextSearch%' ";
				$tSQL .= " OR SPL.FTXpoSplName LIKE '%$tTextSearch%' ";
				$tSQL .= " OR SPL.FTXpoSplCode LIKE '%$tTextSearch%' )";
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
			$this->db->delete('TARTPoHDSpl');
			
			$this->db->where_in('FTXpoDocNo', $ptCode);
            $this->db->delete('TARTPoDT');
		}catch(Exception $Error){
            echo $Error;
        }
	}

	//ลบข้อมูลใน Temp 
	public function FSxMPODeleteTmpAfterInsDT($tCode){
		try{
			$FTWorkerID  = $this->session->userdata('tSesLogID');
			
			//ส่งเลขที่เอกสารมา DT
			if($tCode != '' || $tCode != null){
				$this->db->where_in('FTXpoDocNo', $tCode);
			}
			$this->db->where_in('FTWorkerID', $FTWorkerID);
            $this->db->delete('TARTPoDTTmp');


			//ส่งเลขที่เอกสารมา HD
			if($tCode != '' || $tCode != null){
				$this->db->where_in('FTXpoDocNo', $tCode);
			}
			$this->db->where_in('FTWorkerID', $FTWorkerID);
            $this->db->delete('TARTPoHDTmp');
		}catch(Exception $Error){
            echo $Error;
		}
	}

	//สร้าง HD Default 
	public function FSaMPOInsert_HDDefault(){
		$tWorkerID	 = $this->session->userdata('tSesLogID');
		$tSessionBCH = $this->session->userdata('tSesBCHCode');
		$dDocDate 	 = date('Y-m-d H:i:s');
		$tSQL 		 = "INSERT INTO TARTPoHDTmp (FTBchCode,FTXpoDocNo,FDXpoDocDate,FTWorkerID,FTCreateBy,FDCreateOn,FTXpoCshOrCrd) VALUES	";
		$tSQL 		.= "('" . $tSessionBCH . "','PO##########','" . $dDocDate . "','" . $tWorkerID . "','" . $tWorkerID . "','" . $dDocDate . "','1')";
		$this->db->query($tSQL);
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
	public function FCxMPOGetSupplierAll($paData){
		$aRowLen   		= FCNaHCallLenData($paData['nRow'], $paData['nPage']);
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

	//จำนวนของผู้จำหน่าย
	public function FCxMQUGetSupplier_PageAll($paData){
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

	//ข้อมูลผู้จำหน่าย
	public function FCxMPOGetSupplierByID($pnCodeSPL){
		$tSQL 		= " SELECT SPL.* FROM TCNMSpl SPL WHERE 1=1 AND SPL.FTSplCode = '$pnCodeSPL' ";
		$oQuery 	= $this->db->query($tSQL);
		return $oQuery->result_array();
	}

	//ข้อมูลใน DT Temp
	public function FSaMAJPGetDataInTmp($tDocumentNumber){
		$tWorkerID		= $this->session->userdata('tSesLogID');
		$tSQL  			= " SELECT DTTmp.* , PDT.FTPdtImage FROM TARTPoDTTmp DTTmp LEFT JOIN TCNMPDT PDT ON PDT.FTPdtCode = DTTmp.FTPdtCode ";
		$tSQL 			.= " WHERE 1=1 ";
		$tSQL 			.= " AND DTTmp.FTWorkerID = '$tWorkerID' ";

		if($tDocumentNumber != '' || $tDocumentNumber != null){
			$tSQL 		.= " AND DTTmp.FTXpoDocNo = '$tDocumentNumber' ";
		}

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aResult 	= array(
				'raItems'  		=> $oQuery->result_array(),
                'rtCode'   		=> '1',
                'rtDesc'   		=> 'success',
            );
        }else{
            $aResult = array(
				'raItems' 		=> array(),
                'rtCode' 		=> '800',
                'rtDesc' 		=> 'data not found',
            );
        }
        return $aResult;
	}

	//หาสินค้า Master
	public function FSaMPOGetPDTToTmp($paData){
		$aRowLen   		= FCNaHCallLenData($paData['nRow'],$paData['nPage']);
		$tWorkerID		= $this->session->userdata('tSesLogID');
		$tTextSearch 	= trim($paData['tSearchPDT']);
		$tSPL			= trim($paData['tSPL']);
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
					LEFT JOIN TARTPoDTTmp TMP 	ON PDT.FTPdtCode 	= TMP.FTPdtCode AND TMP.FTWorkerID = '$tWorkerID' ";
		$tSQL .= " WHERE 1=1 ";
		$tSQL .= " AND TMP.FTPdtCode IS NULL ";

		//ผู้จำหน่าย ถ้าผู้จำหน่ายเป็น 0 (พิเศษ) จะค้นหาได้ทั้งหมด
		if(($tSPL != '' || $tSPL != null) && ($tSPL != '0')){
			$tSQL .= " AND SPL.FTSplCode = '$tSPL' ";
		}

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
			$oFoundRow 	= $this->FSaMPOGetDataPDT_PageAll($paData);
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
	public function FSaMPOGetDataPDT_PageAll($paData){
		try{
			$tTextSearch 	= trim($paData['tSearchPDT']);
			$tWorkerID		= $this->session->userdata('tSesLogID');
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
							LEFT JOIN TARTPoDTTmp TMP ON PDT.FTPdtCode = TMP.FTPdtCode AND TMP.FTWorkerID = '$tWorkerID' ";

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

	//หา SEQ ว่าสินค้ามีกี่ตัว
	public function FCaMPOGetItemLastSeq($paFilter){

		$tDocNo 	= $paFilter['FTXpoDocNo'];
		$tWorkerID  = $paFilter['tWorkerID'];

		$tSQL 		= "SELECT TOP 1 FNXpoSeq FROM TARTPoDTTmp WITH (NOLOCK) WHERE 1=1 ";

		if($tDocNo != "") {
			$tSQL 	.= " AND FTXpoDocNo = '" . $tDocNo . "'";
		}

		$tSQL 		.= " AND FTWorkerID = '" . $tWorkerID . "'";
		$tSQL 		.= " ORDER BY FNXpoSeq DESC ";
		$oQuery 	= $this->db->query($tSQL);
		$nCountRows = $oQuery->num_rows();
		if ($nCountRows > 0) {
			$aResult = $oQuery->result_array();
			return $aResult[0]["FNXpoSeq"] + 1;
		} else {
			return 1;
		}
	}
	
	//หาสินค้า รายละเอียด + ราคา
	public function FCaMPOGetDetailItemAndPrice($ptCode){
		$tSQL  			= " SELECT PDT.* , UNIT.FTPunName , VIEPDT.FCPdtCostAfDis FROM TCNMPdt PDT ";
		$tSQL 			.= " LEFT JOIN TCNMPdtUnit UNIT ON PDT.FTPunCode = UNIT.FTPunCode ";
		$tSQL 			.= " LEFT JOIN VCN_ProductsDetail VIEPDT ON PDT.FTPdtCode = VIEPDT.FTPdtCode ";
		$tSQL 			.= " WHERE PDT.FTPdtCode = '$ptCode' ";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aResult 	= array(
				'raItems'  		=> $oQuery->result_array(),
                'rtCode'   		=> '1',
                'rtDesc'   		=> 'success',
            );
        }else{
            $aResult = array(
				'raItems' 		=> array(),
                'rtCode' 		=> '800',
                'rtDesc' 		=> 'data not found',
            );
        }
        return $aResult;
	}

	//เพิ่มสินค้า Tmp
	public function FSaMPOInsertPDTToTmp($aResult){
		try{
			$this->db->insert('TARTPoDTTmp', $aResult);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//ลบข้อมูลรายการใน Tmp
	public function FCxMPODeleteItemInTemp($paItem){
		$nSeq 		= $paItem['FNXpoSeq'];
		$tPDTCode 	= $paItem['FTPdtCode'];
		$tDocument  = $paItem['FTXpoDocNo'];
		$FTWorkerID	= $this->session->userdata('tSesLogID');

		$tSQLDT = "DELETE FROM TARTPoDTTmp WHERE
						FTXpoDocNo = '$tDocument' AND
						FTPdtCode = '$tPDTCode' AND
						FNXpoSeq = '$nSeq' AND
						FTWorkerID = '$FTWorkerID' ";
		$this->db->query($tSQLDT);

		//เรียง Seq ใหม่
		$tSQL   = " UPDATE TARTPoDTTmp WITH(ROWLOCK)
					SET FNXpoSeq = NewObj.NewSeq
					FROM TARTPoDTTmp DT
					INNER JOIN (
						SELECT  ROW_NUMBER() OVER (ORDER BY FNXpoSeq) AS NewSeq,
							FNXpoSeq AS OldSeq
						FROM TARTPoDTTmp
						WHERE
							FTXpoDocNo = '$tDocument'
						AND FTWorkerID = '$FTWorkerID'
				) NewObj ON DT.FNXpoSeq = NewObj.OldSeq";
		$this->db->query($tSQL);
	}

	//แก้ไขราคาต่อหน่วยในเอกสาร
	public function FCxMPOEditUnitPriInTemp($paItem){
		$tDocNo 			= $paItem['tDocNo'];
		$nItemSeq 			= $paItem['nItemSeq'];
		$nDiscount 			= $paItem['nDiscount'];
		$tPdtCode   		= $paItem['tPdtCode'];
		$nPdtUnitPrice   	= $paItem['nPdtUnitPrice'];
		$tWorkerID			= $this->session->userdata('tSesLogID');

		if($nDiscount == ''){
			$nDiscount = 0;
		}else{
			$nDiscount = $nDiscount;
		}

		$tSQL = "UPDATE TARTPoDTTmp SET FCXpoDis = '" . $nDiscount . "', FCXpoUnitPrice = '" . $nPdtUnitPrice . "'
				 WHERE  FTWorkerID = '" . $tWorkerID . "'
				 AND    FNXpoSeq = '" . $nItemSeq . "' ";

		if ($tDocNo != "") {
			$tSQL .= " AND FTXpoDocNo = '" . $tDocNo . "' ";
		}

		$this->db->query($tSQL);
	}

	//แก้ไขจำนวนในเอกสาร
	public function FCxMPOEditItemInTemp($paItem){
		$tDocNo 		= $paItem['tDocNo'];
		$nItemSeq 		= $paItem['nItemSeq'];
		$nItemQTY 		= $paItem['nItemQTY'];
		$tPdtCode  		= $paItem['tPdtCode'];
		$nDiscount  	= $paItem['nDiscount'];
		$nDiscountText  = $paItem['tDisText'];
		$tWorkerID		= $this->session->userdata('tSesLogID');

		if($nDiscount ==''){
			$nDiscount = 0;
		}else{
			$nDiscount = $nDiscount;
		}

		$tSQL = "UPDATE TARTPoDTTmp SET FCXpoQty = '" . $nItemQTY . "', FCXpoDis = '" . $nDiscount . "', FTXpoDisTxt = '".$nDiscountText." '
				 WHERE  FTWorkerID = '" . $tWorkerID . "'
				 AND    FNXpoSeq = '" . $nItemSeq . "' ";

		if ($tDocNo != "") {
			$tSQL .= " AND FTXpoDocNo = '" . $tDocNo . "' ";
		}

		$this->db->query($tSQL);
	}

	//ส่วนลดรายการ
	public function FCxMPOEditItemDisCount($paItem){
		$tDocNo 	= $paItem['tDocNo'];
		$nItemSeq 	= $paItem['nItemSeq'];
		$nDiscount 	= $paItem['nDiscount'];
		$tPdtCode   = $paItem['tPdtCode'];
		$tDisText   = $paItem['tDisText'];
		$tWorkerID	= $this->session->userdata('tSesLogID');

		$tSQL = "UPDATE TARTPoDTTmp SET FCXpoDis = '" . $nDiscount . "',FTXpoDisTxt='" . $tDisText . "'
				WHERE  FTWorkerID = '" . $tWorkerID . "'
				AND    FNXpoSeq = '" . $nItemSeq . "' ";

		if ($tDocNo != "") {
			$tSQL .= " AND FTXpoDocNo = '" . $tDocNo . "' ";
		}

		$this->db->query($tSQL);
	}

	//ส่วนลดท้ายบิล
	public function FCxMPOEditDocDisCount($paItem){
		$tDocNo 	= $paItem['tDocNo'];
		$nDiscount 	= $paItem['nDiscount'];
		$tDisTxt   	= $paItem['tDisTxt'];
		$tWorkerID  = $paItem['tWorkerID'];

		$tSQL = "UPDATE TARTPoHDTmp SET FCXpoDis = '" . $nDiscount . "', FTXpoDisTxt = '" . $tDisTxt . "'  WHERE FTWorkerID = '" . $tWorkerID . "'";

		if ($tDocNo != "") {
			$tSQL .= " AND FTXpoDocNo = '" . $tDocNo . "' ";
		}
		$this->db->query($tSQL);
	}

	//Gen เลขที่เอกสาร
	public function FCtMPOGetDocNo($tBchCode){
		$tSQL = "SELECT MAX(RIGHT(ISNULL(FTXpoDocNo,''),4)) AS FTXpoDocNo
		         FROM TARTPoHD WITH (NOLOCK)
				 WHERE FTBchCode = '" . $tBchCode . "'";
		$oQuery = $this->db->query($tSQL);
		$nCountRows = $oQuery->num_rows();
		if ($nCountRows > 0) {
			$aResult 	= $oQuery->result_array();
			$nNextDocNo = sprintf('%05d', $aResult[0]['FTXpoDocNo'] + 1);
			$tDocNo 	= 'PO' . $tBchCode . DATE('Ymd') . '-' . $nNextDocNo;
		} else {
			$tDocNo 	= 'PO' . $tBchCode . DATE('Ymd') . '-00001';
		}
		return $tDocNo;
	}

	//อัพเดทข้อมูล HDTmp
	public function FCxMPOUpdate_HDTmp($paItem){
		try {
			$tWorkerID			= $this->session->userdata('tSesLogID');
			$tDocumentNumber 	= $paItem['FTXpoDocNoOld'];
			$aSet = array(
				'FTXpoDocNo'		=> $paItem['FTXpoDocNo'],
				'FTBchCode'			=> $paItem['FTBchCode'],
				'FDXpoDocDate'		=> $paItem['FDXpoDocDate'],
				'FTXpoCshOrCrd'		=> $paItem['FTXpoCshOrCrd'],
				'FNXpoCredit'		=> $paItem['FNXpoCredit'],
				'FTXpoVATInOrEx'	=> $paItem['FTXpoVATInOrEx'],
				'FDDeliveryDate'	=> $paItem['FDDeliveryDate'],
				'FTXpoStaExpress'	=> $paItem['FTXpoStaExpress'],
				'FTXpoStaDoc'		=> $paItem['FTXpoStaDoc'],
				'FTXpoStaActive'	=> $paItem['FTXpoStaActive'],
				'FTXpoStaDeli'		=> $paItem['FTXpoStaDeli'],
				'FTXpoRmk'			=> $paItem['FTXpoRmk'],
				'FTXpoStaApv'		=> $paItem['FTXpoStaApv'],	
				'FTXpoStaRefInt'	=> $paItem['FTXpoStaRefInt'],
				'FTApprovedBy'		=> $paItem['FTApprovedBy'],
				'FDApproveDate'		=> $paItem['FDApproveDate'],
				'FTCreateBy'		=> $paItem['FTCreateBy'],
				'FDCreateOn'		=> $paItem['FDCreateOn'],
				'FTUpdateBy'		=> $paItem['FTUpdateBy'],
				'FDUpdateOn'		=> $paItem['FDUpdateOn']
			);
			$this->db->where('FTXpoDocNo', $tDocumentNumber);
			$this->db->where('FTWorkerID', $tWorkerID);
			$this->db->update('TARTPoHDTmp', $aSet);
		} catch (Exception $Error) {
			echo $Error;
		}
	}

	//เพิ่มข้อมูล SPLHD
	public function FCxMPOInsert_SPLHD($paItem){
		$this->db->insert('TARTPoHDSpl', $paItem);
	}

	//อัพเดทเลขที่เอกสาร
	public function FCxMPOUpdate_DT($paItem){
		try {
			$tWorkerID			= $this->session->userdata('tSesLogID');
			$tDocumentNumber 	= $paItem['FTXpoDocNoOld'];
			$aSet = array(
				'FTXpoDocNo'		=> $paItem['FTXpoDocNo']
			);
			$this->db->where('FTXpoDocNo', $tDocumentNumber);
			$this->db->where('FTWorkerID', $tWorkerID);
			$this->db->update('TARTPoDTTmp', $aSet);
		} catch (Exception $Error) {
			echo $Error;
		}
	}

	//Move DT Temp ไป DT
	public function FCxMPOMoveTemp2DT($tDocNo){
		$tWorkerID	= $this->session->userdata('tSesLogID');
		$tCreateBy 	= $this->session->userdata('tSesUsercode');
		$tSQL = "INSERT INTO TARTPoDT
				 SELECT 
				 		FTXpoDocNo
						,FNXpoSeq
						,FTPdtCode
						,FTPdtName
						,FTPunCode
						,FTPunName
						,FCXpoUnitPrice
						,FTXpoCost
						,FTSplCode
						,FCXpoQty
						,0 AS FCXpoB4Dis
						,FCXpoDis
						,FTXpoDisTxt
						,0 AS FCXpoAfDT
						,FCXpoFootAvg
						,0 AS FCXpoNetAfHD
						,FTXpoRefPo
						,FTPdtStaEditName
						,ISNULL(FTCreateBy,'$tCreateBy')
						,ISNULL(FDCreateOn,CONVERT(VARCHAR(16),GETDATE(),121))
						,'$tCreateBy' AS FTUpdateBy
						,'' AS FDUpdateOn
						,FTXpoRefBuyer
						,FTPdtStaCancel
					FROM TARTPoDTTmp
					WHERE FTWorkerID = '" . $tWorkerID . "'
					AND FTXpoDocNo = '" . $tDocNo . "'";
		$this->db->query($tSQL);

		$tSQLDel 	= "DELETE FROM TARTPoDTTmp WHERE FTXpoDocNo = '" . $tDocNo . "'";
		$this->db->query($tSQLDel);
	}

	//Move HD Temp ไป HD
	public function FCxMPOMoveTemp2HD($tDocNo){
		$tWorkerID	= $this->session->userdata('tSesLogID');
		$tCreateBy 	= $this->session->userdata('tSesUsercode');
		$tSQL = "INSERT INTO TARTPoHD
				 SELECT FTBchCode
						,FTXpoDocNo
						,FDXpoDocDate
						,FTXpoCshOrCrd
						,FNXpoCredit
						,FTXpoVATInOrEx
						,FDDeliveryDate
						,FTXpoStaExpress
						,FTXpoStaDoc
						,FTXpoStaActive
						,FTXpoStaDeli
						,FCXpoB4Dis
						,FCXpoDis
						,FTXpoDisTxt
						,FCXpoAFDis
						,FCXpoVatRate
						,FCXpoAmtVat
						,FCXpoVatable
						,FCXpoGrand
						,FCXpoRnd
						,FTXpoGndText
						,FTXpoRmk
						,FTUsrDep
						,FTXpoStaApv
						,FTXpoStaRefInt
						,FTApprovedBy
						,FDApproveDate
						,FTCreateBy
						,FDCreateOn
						,FTUpdateBy
						,FDUpdateOn
					FROM TARTPoHDTmp
					WHERE FTWorkerID = '" . $tWorkerID . "'
					AND FTXpoDocNo = '" . $tDocNo . "'";
		$this->db->query($tSQL);

		$tSQLDel = "DELETE FROM TARTPoHDTmp WHERE FTXpoDocNo = '" . $tDocNo . "'";
		$this->db->query($tSQLDel);
	}

	
}
