<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mQuotation extends CI_Model
{

	/*
	เกี่ยวกับฟังก์ชั่น
	----------------------------------------------
	แสดงข้อมูลสำหรับการกรองข้อมูลสินค้า
	ข้อมูลที่สามารถกรองได้
	ผู้จำหน่าย,กลุ่มสินค้า,ประเภทสินค้า,ยี่ห้อ,ขนาด,สี
	*/
	public function FSaMQUOGetFilterList()
	{

		$tSQL = "SELECT F.* FROM (
				SELECT 'FGSPL' AS FTFilGrpCode,
						'ผู้จำหน่าย'  AS FTFilGrpName ,
						FTSplCode  AS FTFilCode ,
						FTSplName  AS FTFilName
				FROM TCNMSpl WITH (NOLOCK)

				UNION ALL

				SELECT 'FGPBN' AS FTFilGrpCode,
						'ยี่ห้อ' AS FTFilGrpName ,
						FTPbnCode AS FTFilCode ,
						FTPbnName AS FTFilName
				FROM TCNMPdtBrand WITH (NOLOCK)

				UNION ALL

				SELECT 'FGPGP' AS FTFilGrpCode,
						'กลุ่มสินค้า' AS FTFilGrpName ,
						FTPgpCode AS FTFilCode,
						FTPgpName AS FTFilName
				FROM TCNMPdtGrp WITH (NOLOCK)

				UNION ALL

				SELECT 'FGPTY' AS FTFilGrpCode,
						'ประเภทสินค้า' AS FTFilGrpName ,
						FTPtyCode AS FTFilCode,
						FTPtyName  AS FTFilName
				FROM TCNMPdtType WITH (NOLOCK)
				UNION ALL

				SELECT 'FGPZE' AS FTFilGrpCode,
						'ขนาด' AS FTFilGrpName ,
						FTPzeCode AS FTFilCode,
						FTPzeName  AS FTFilName
				FROM TCNMPdtSize WITH (NOLOCK)

				UNION ALL

				SELECT 'FGCLR' AS FTFilGrpCode,
						'สี' AS FTFilGrpName ,
						FTPClrCode AS FTFilCode,
						FTPClrName  AS FTFilName
				FROM TCNMPdtColor WITH (NOLOCK) ) F ";
		$oQuery = $this->db->query($tSQL);
		$nCountRows = $oQuery->num_rows();
		if ($nCountRows > 0) {
			$aResult = array(
				'raItems'  	=> $oQuery->result_array(),
				'nTotalRes' => $nCountRows,
				'rtCode'   	=> '1',
				'rtDesc'   	=> 'success',
			);
		} else {
			$aResult = array(
				'rtCode' 	=> '800',
				'rtDesc' 	=> 'data not found',
			);
		}
		return $aResult;
	}

	/*
	เกี่ยวกับฟังก์ชั่น
	----------------------------------------------
	ข้อมูลสินค้าและราคาขาย
	เงื่อนไข
	1.คำนวนส่วนลดต้นทุนแล้ว
	2.คำนวนราคาขายแล้ว
	3.ราคานี้เป็นราคาตามกลุ่มราคาที่ผูกกับผู้ใช้ที่กำลังทำรายการ
	*/
	public function FSaMQUPdtList($paFilter)
	{
		$aRowLen   		= FCNaHCallLenData($paFilter['nRow'], $paFilter['nPage']);
		$tSearchAll 	= $paFilter["tSearchAll"];
		$tPriceGrp 		= $paFilter["tPriceGrp"];
		$aFilterAdv 	= $paFilter['aFilterAdv'];

		$tSQL = "
				SELECT Q.* FROM(
				 SELECT P.* , ROW_NUMBER() OVER(ORDER BY P.RowID ASC) AS NewRowID FROM (
                 SELECT ROW_NUMBER() OVER(ORDER BY PDT.FTPdtBestsell DESC , PDT.FTPdtCode ASC) AS RowID,
                         PDT.FTPdtCode,
                         PDT.FTPdtName,
                         PGP.FTPgpName,
                         PDT.FTPdtImage ,
						 PDT.FTPbnCode,
		   				 PDT.FTMolCode,
						 PDT.FTPtyCode,
						 PDT.FTPzeCode,
						 PDT.FTPgpCode,
                         PDT.FCPdtCostStd,
						 PDT.FTPClrCode,
						 PDT.FTPunCode,
						 PUN.FTPunName,
						 PDT.FTSplCode,
                         PDT.FCPdtCostAFDis,
						 PDT.FTPdtBestsell,
						 PDT.FTPdtStaEditName,
                         PDT.FCPdtSalPrice AS FCPdtStdSalPri ,
                         SP.FCXpdAddPri AS FCPdtUsrSalPri,
                         CASE WHEN ISNULL(PDT.FCPdtSalPrice,0) = 0 AND  ISNULL(SP.FCXpdAddPri,0) = 0
                              THEN ISNULL(PDT.FCPdtCostAFDis,0)

                              WHEN ISNULL(PDT.FCPdtSalPrice,0) <> 0 AND  ISNULL(SP.FCXpdAddPri,0) = 0
                              THEN ISNULL(PDT.FCPdtCostAFDis,0) + (ISNULL(PDT.FCPdtCostAFDis,0) * ISNULL(PDT.FCPdtSalPrice,0))/100

                              WHEN ISNULL(PDT.FCPdtSalPrice,0) = 0 AND  ISNULL(SP.FCXpdAddPri,0) <> 0
                              THEN ISNULL(PDT.FCPdtCostAFDis,0) + (ISNULL(PDT.FCPdtCostAFDis,0) * ISNULL(SP.FCXpdAddPri,0))/100

							  WHEN ISNULL(PDT.FCPdtSalPrice, 0) <> 0 AND ISNULL(SP.FCXpdAddPri, 0) <> 0
							  THEN ISNULL(PDT.FCPdtCostAFDis, 0) + (ISNULL(PDT.FCPdtCostAFDis, 0) * ISNULL(SP.FCXpdAddPri, 0)) / 100
						ELSE 0
						END AS FCPdtNetSalPri
                  	FROM VCN_Products PDT WITH (NOLOCK)
                  	LEFT JOIN ( SELECT * FROM VCN_AdjSalePriActive WITH (NOLOCK) WHERE FTPriGrpID = '" . $tPriceGrp . "' ) SP ON PDT.FTPdtCode = SP.FTPdtCode
                	LEFT JOIN TCNMPdtGrp PGP WITH (NOLOCK) 	ON PDT.FTPgpCode 	= PGP.FTPgpCode
					LEFT JOIN TCNMPdtUnit PUN WITH (NOLOCK) 	ON PDT.FTPunCode 	= PUN.FTPunCode
					LEFT JOIN TCNMPdtBrand BAP WITH (NOLOCK) 	ON PDT.FTPbnCode 	= BAP.FTPbnCode
					LEFT JOIN TCNMPdtColor COP WITH (NOLOCK) 	ON PDT.FTPClrCode 	= COP.FTPClrCode
					LEFT JOIN TCNMPdtModal MOL WITH (NOLOCK) 	ON PDT.FTMolCode 	= MOL.FTMolCode
					LEFT JOIN TCNMPdtSize SIZ WITH (NOLOCK) 	ON PDT.FTPzeCode 	= SIZ.FTPzeCode
					LEFT JOIN TCNMPdtType TYP WITH (NOLOCK) 	ON PDT.FTPtyCode 	= TYP.FTPtyCode
					LEFT JOIN TCNMSpl SPL WITH (NOLOCK) 		ON PDT.FTSplCode 	= SPL.FTSplCode
				) P
            	WHERE  1=1 ";

		//ค้นหาขั้นสูง
		if ($aFilterAdv != '' || $aFilterAdv != null) {
			$tWherePBN  = '';
			$tWhereINPBN = '';
			$tWhereCLR	= '';
			$tWhereINCLR = '';
			$tWherePGP	= '';
			$tWhereINPGP = '';
			$tWhereMOL	= '';
			$tWhereINMOL = '';
			$tWherePZE	= '';
			$tWhereINPZE = '';
			$tWherePTY	= '';
			$tWhereINPTY = '';
			$tWherePUN	= '';
			$tWhereINPUN = '';
			$tWhereSPL	= '';
			$tWhereINSPL = '';
			for ($i = 0; $i < count($aFilterAdv); $i++) {
				$tFilterName 	= $aFilterAdv[$i]['tFilter'];
				$tFilterValue 	= $aFilterAdv[$i]['tValue'];
				switch ($tFilterName) {
					case "PBN":
						$tWhereINPBN .=  "'$tFilterValue'" . ',';
						break;
					case "CLR":
						$tWhereINCLR .=  "'$tFilterValue'" . ',';
						break;
					case "PGP":
						$tWhereINPGP .=  "'$tFilterValue'" . ',';
						break;
					case "MOL":
						$tWhereINMOL .=  "'$tFilterValue'" . ',';
						break;
					case "PZE":
						$tWhereINPZE .=  "'$tFilterValue'" . ',';
						break;
					case "PTY":
						$tWhereINPTY .=  "'$tFilterValue'" . ',';
						break;
					case "PUN":
						$tWhereINPUN .=  "'$tFilterValue'" . ',';
						break;
					case "SPL":
						$tWhereINSPL .=  "'$tFilterValue'" . ',';
						break;
					default:
				}

				if ($i == count($aFilterAdv) - 1) {
					$tWhereINPBN = substr($tWhereINPBN, 0, -1);
					$tWhereINCLR = substr($tWhereINCLR, 0, -1);
					$tWhereINPGP = substr($tWhereINPGP, 0, -1);
					$tWhereINMOL = substr($tWhereINMOL, 0, -1);
					$tWhereINPZE = substr($tWhereINPZE, 0, -1);
					$tWhereINPTY = substr($tWhereINPTY, 0, -1);
					$tWhereINPUN = substr($tWhereINPUN, 0, -1);
					$tWhereINSPL = substr($tWhereINSPL, 0, -1);
				}

				if ($tWhereINPBN != '') {
					$tWherePBN = " AND FTPbnCode IN (" . $tWhereINPBN . ")";
				}
				if ($tWhereINCLR != '') {
					$tWhereCLR = " AND FTPClrCode IN (" . $tWhereINCLR . ")";
				}
				if ($tWhereINPGP != '') {
					$tWherePGP = " AND P.FTPgpCode IN (" . $tWhereINPGP . ")";
				}
				if ($tWhereINMOL != '') {
					$tWhereMOL = " AND FTMolCode IN (" . $tWhereINMOL . ")";
				}
				if ($tWhereINPZE != '') {
					$tWherePZE = " AND P.FTPzeCode IN (" . $tWhereINPZE . ")";
				}
				if ($tWhereINPTY != '') {
					$tWherePTY = " AND FTPtyCode  IN (" . $tWhereINPTY . ")";
				}
				if ($tWhereINPUN != '') {
					$tWherePUN = " AND FTPunCode IN (" . $tWhereINPUN . ")";
				}
				if ($tWhereINSPL != '') {
					$tWhereSPL = " AND FTSplCode IN (" . $tWhereINSPL . ")";
				}
			}

			$tWhereFull = $tWherePBN . $tWhereCLR . $tWherePGP . $tWhereMOL . $tWherePZE . $tWherePTY . $tWherePUN . $tWhereSPL;
			$tSQL .= " $tWhereFull ";
		}

		//ค้นหาธรรมดา
		if ($tSearchAll != "") {
			$tSQL .= " AND P.FTPdtName LIKE '%[" . $tSearchAll . "]%'";
			$tSQL .= " OR P.FTPdtCode LIKE '%" . $tSearchAll . "%'";
		}

		$tSQL .= " ) AS Q WHERE Q.NewRowID > $aRowLen[0] AND Q.NewRowID <=$aRowLen[1] ";
		
		$oQuery = $this->db->query($tSQL);
		if ($oQuery->num_rows() > 0) {
			$oFoundRow 	= $this->FSaMQUOPdtCountRow_PageAll($paFilter);
			$nFoundRow 	= $oFoundRow[0]->counts;
			$nPageAll 	= ceil($nFoundRow / $paFilter['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
			$aResult 	= array(
				'raItems'  		=> $oQuery->result_array(),
				'rnAllRow'      => $nFoundRow,
				'rnCurrentPage' => $paFilter['nPage'],
				'rnAllPage'     => $nPageAll,
				'rtCode'   		=> '1',
				'rtDesc'   		=> 'success',
			);
		} else {
			$aResult = array(
				'rnAllRow' 		=> 0,
				'rnCurrentPage' => $paFilter['nPage'],
				"rnAllPage"		=> 0,
				'rtCode' 		=> '800',
				'rtDesc' 		=> 'data not found',
			);
		}
		return $aResult;
	}

	/*
	เกี่ยวกับฟังก์ชั่น
	----------------------------------------------
	หาจำนวนข้อมูลสินค้าตามเงื่อนไขการกรอง
	*/
	public function FSaMQUOPdtCountRow_PageAll($paFilter)
	{
		try {
			$tTextSearch 	= trim($paFilter['tSearchAll']);
			$aFilterAdv 	= $paFilter['aFilterAdv'];
			$tSQL 		= "SELECT COUNT(FTPDTCode) AS counts
							FROM TCNMPdt PDT WITH (NOLOCK)
							LEFT JOIN TCNMPdtBrand BAP WITH (NOLOCK) 	ON PDT.FTPbnCode 	= BAP.FTPbnCode
							LEFT JOIN TCNMPdtColor COP WITH (NOLOCK) 	ON PDT.FTPClrCode 	= COP.FTPClrCode
							LEFT JOIN TCNMPdtGrp GRP WITH (NOLOCK) 		ON PDT.FTPgpCode 	= GRP.FTPgpCode
							LEFT JOIN TCNMPdtModal MOL WITH (NOLOCK) 	ON PDT.FTMolCode 	= MOL.FTMolCode
							LEFT JOIN TCNMPdtSize SIZ WITH (NOLOCK) 	ON PDT.FTPzeCode 	= SIZ.FTPzeCode
							LEFT JOIN TCNMPdtType TYP WITH (NOLOCK) 	ON PDT.FTPtyCode 	= TYP.FTPtyCode
							LEFT JOIN TCNMPdtUnit UNIT WITH (NOLOCK) 	ON PDT.FTPunCode 	= UNIT.FTPunCode
							LEFT JOIN TCNMSpl SPL WITH (NOLOCK) 		ON PDT.FTSplCode 	= SPL.FTSplCode
							WHERE PDT.FTPdtStatus = 1";

			//ค้นหาขั้นสูง
			if ($aFilterAdv != '' || $aFilterAdv != null) {
				$tWherePBN  = '';
				$tWhereINPBN = '';
				$tWhereCLR	= '';
				$tWhereINCLR = '';
				$tWherePGP	= '';
				$tWhereINPGP = '';
				$tWhereMOL	= '';
				$tWhereINMOL = '';
				$tWherePZE	= '';
				$tWhereINPZE = '';
				$tWherePTY	= '';
				$tWhereINPTY = '';
				$tWherePUN	= '';
				$tWhereINPUN = '';
				$tWhereSPL	= '';
				$tWhereINSPL = '';
				for ($i = 0; $i < count($aFilterAdv); $i++) {
					$tFilterName 	= $aFilterAdv[$i]['tFilter'];
					$tFilterValue 	= $aFilterAdv[$i]['tValue'];
					switch ($tFilterName) {
						case "PBN":
							$tWhereINPBN .=  "'$tFilterValue'" . ',';
							break;
						case "CLR":
							$tWhereINCLR .=  "'$tFilterValue'" . ',';
							break;
						case "PGP":
							$tWhereINPGP .=  "'$tFilterValue'" . ',';
							break;
						case "MOL":
							$tWhereINMOL .=  "'$tFilterValue'" . ',';
							break;
						case "PZE":
							$tWhereINPZE .=  "'$tFilterValue'" . ',';
							break;
						case "PTY":
							$tWhereINPTY .=  "'$tFilterValue'" . ',';
							break;
						case "PUN":
							$tWhereINPUN .=  "'$tFilterValue'" . ',';
							break;
						case "SPL":
							$tWhereINSPL .=  "'$tFilterValue'" . ',';
							break;
						default:
					}

					if ($i == count($aFilterAdv) - 1) {
						$tWhereINPBN = substr($tWhereINPBN, 0, -1);
						$tWhereINCLR = substr($tWhereINCLR, 0, -1);
						$tWhereINPGP = substr($tWhereINPGP, 0, -1);
						$tWhereINMOL = substr($tWhereINMOL, 0, -1);
						$tWhereINPZE = substr($tWhereINPZE, 0, -1);
						$tWhereINPTY = substr($tWhereINPTY, 0, -1);
						$tWhereINPUN = substr($tWhereINPUN, 0, -1);
						$tWhereINSPL = substr($tWhereINSPL, 0, -1);
					}

					if ($tWhereINPBN != '') {
						$tWherePBN = " AND BAP.FTPbnCode IN (" . $tWhereINPBN . ")";
					}
					if ($tWhereINCLR != '') {
						$tWhereCLR = " AND COP.FTPClrCode IN (" . $tWhereINCLR . ")";
					}
					if ($tWhereINPGP != '') {
						$tWherePGP = " AND GRP.FTPgpCode IN (" . $tWhereINPGP . ")";
					}
					if ($tWhereINMOL != '') {
						$tWhereMOL = " AND MOL.FTMolCode IN (" . $tWhereINMOL . ")";
					}
					if ($tWhereINPZE != '') {
						$tWherePZE = " AND SIZ.FTPzeCode IN (" . $tWhereINPZE . ")";
					}
					if ($tWhereINPTY != '') {
						$tWherePTY = " AND TYP.FTPtyCode  IN (" . $tWhereINPTY . ")";
					}
					if ($tWhereINPUN != '') {
						$tWherePUN = " AND UNIT.FTPunCode IN (" . $tWhereINPUN . ")";
					}
					if ($tWhereINSPL != '') {
						$tWhereSPL = " AND SPL.FTSplCode IN (" . $tWhereINSPL . ")";
					}
				}

				$tWhereFull = $tWherePBN . $tWhereCLR . $tWherePGP . $tWhereMOL . $tWherePZE . $tWherePTY . $tWherePUN . $tWhereSPL;
				$tSQL .= " $tWhereFull ";
			}

			//ค้นหาธรรมดา
			if ($tTextSearch != '' || $tTextSearch != null) {
				$tSQL .= " AND PDT.FTPdtName LIKE '%[" . $tTextSearch . "]%'";
				$tSQL .= " OR PDT.FTPdtCode LIKE '%" . $tTextSearch . "%'";
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

		$oQuery = $this->db->query($tSQL);
		return $oQuery->num_rows();
	}

	/*
	เกี่ยวกับฟังก์ชั่น
	----------------------------------------------
	หาจำนวนข้อมูลสินค้าในใบเสนอราคา จากตาราง Temp DT
	กรณี create จะหาจาก tWorkerID
	กรณี edit จะหาจาก Docno
	*/
	public function FSxMQUOClearTemp()
	{
		$tSQL = "DELETE FROM TARTSqDTTmp WHERE CONVERT(VARCHAR(10) , FDTmpTnsDate , 121) < CONVERT(VARCHAR(10) , GETDATE() , 121) ";
		$this->db->query($tSQL);
	}

	public function FSxMQUOClearTempByWorkID($ptWorkerID)
	{
		$tSQL1 = "DELETE FROM TARTSqHDTmp WHERE FTWorkerID = '" . $ptWorkerID . "'";
		$this->db->query($tSQL1);

		$tSQL2 = "DELETE FROM TARTSqHDCstTmp WHERE FTWorkerID = '" . $ptWorkerID . "'";
		$this->db->query($tSQL2);

		$tSQL3 = "DELETE FROM TARTSqDTTmp WHERE FTWorkerID = '" . $ptWorkerID . "'";
		$this->db->query($tSQL3);
	}

	//สร้างข้อมูล HD Tmp + Cus Tmp ทิ้งเอาไว้
	public function FSxMQUPrepareHD($ptWorkerID)
	{
		$tSessionBCH = $this->session->userdata('tSesBCHCode');
		$dDocDate 	 = date('Y-m-d H:i:s');
		$tSQL1 		 = "INSERT INTO TARTSqHDTmp (FTBchCode,FDXqhDocDate,FTWorkerID,FTCreateBy,FDCreateOn,FNXqhSmpDay,FTXqhCshOrCrd,FDXqhEftTo,FDDeliveryDate) VALUES	";
		$tSQL1 		.= "('" . $tSessionBCH . "','" . $dDocDate . "','" . $ptWorkerID . "','" . $ptWorkerID . "','" . $dDocDate . "','30','1','".$dDocDate."','".$dDocDate."')";
		$this->db->query($tSQL1);

		$tSQL2 = "INSERT INTO TARTSqHDCstTmp(FTWorkerID,FTCreateBy,FDCreateOn) VALUES	";
		$tSQL2 .= "('" . $ptWorkerID . "','" . $ptWorkerID . "','" . $dDocDate . "')";
		$this->db->query($tSQL2);
	}

	//Get HD เอกสาร
	public function FCaMQUOGetDocHD($paFilter)
	{
		$tDocNo = $paFilter['tDocNo'];
		$tWorkerID = $paFilter['tWorkerID'];
		$tSQL = "SELECT
					HD.FTBchCode,
					ISNULL(HD.FTXqhDocNo,'') AS FTXqhDocNo,
					ISNULL(HD.FDXqhDocDate,'') AS FDXqhDocDate,
					ISNULL(HD.FTXqhCshOrCrd,'') AS FTXqhCshOrCrd,
					HD.FNXqhCredit,
					HD.FTXqhVATInOrEx,
					HD.FNXqhSmpDay,
					CONVERT(VARCHAR(10),HD.FDXqhEftTo,121) AS FDXqhEftTo,
					CONVERT(VARCHAR(10),HD.FDDeliveryDate,121) AS FDDeliveryDate,
					ISNULL(HD.FTXqhStaExpress,'') AS FTXqhStaExpress,
					ISNULL(HD.FTXqhStaDoc,'') AS FTXqhStaDoc,
					ISNULL(HD.FTXqhStaActive,'') AS  FTXqhStaActive,
					ISNULL(HD.FTXqhStaDeli,'') AS  FTXqhStaDeli,
					HD.FTXqhPrjName,
					HD.FTXqhPrjCodeRef,
					HD.FCXqhB4Dis,
					HD.FCXqhDis,
					HD.FTXqhDisTxt,
					HD.FCXqhAFDis,
					ISNULL(HD.FCXqhVatRate,0) AS FCXqhVatRate,
					HD.FCXqhAmtVat,
					HD.FCXqhVatable,
					HD.FCXqhGrand,
					HD.FTXqhStaApv,
					HD.FCXqhRnd,
					HD.FTXqhGndText,
					HD.FTXqhRmk,
					HD.FTUsrDep,
					HD.FTApprovedBy,
					CONVERT(VARCHAR(10),FDApproveDate,121) AS FDApproveDate,
					HD.FTCreateBy,
					HD.FDCreateOn,
					HD.FTUpdateBy,
					HD.FDUpdateOn,
					HD.FTWorkerID,
					USR.FTUsrDep,
					USR.FTUsrFName
				FROM TARTSqHDTmp HD WITH (NOLOCK)
				LEFT JOIN TCNMUsr USR WITH (NOLOCK) ON HD.FTCreateBy = USR.FTUsrCode
            	WHERE HD.FTWorkerID ='" . $tWorkerID . "' ";
		if ($tDocNo != "") {
			$tSQL .= " AND HD.FTXqhDocNo = '" . $tDocNo . "'";
		}

		$oQuery = $this->db->query($tSQL);
		$nCountRows = $oQuery->num_rows();
		if ($nCountRows > 0) {
			$aResult = array(
				'raItems'  	=> $oQuery->result_array(),
				'nTotalRes' => $nCountRows,
				'rtCode'   	=> '1',
				'rtDesc'   	=> 'success',
			);
		} else {
			$aResult = array(
				'rtCode' 	=> '800',
				'nTotalRes' => 0,
				'rtDesc' 	=> 'data not found',
			);
		}
		return $aResult;
	}

	//Get HD ลูกค้า
	public function FCaMQUOGetDocCst($paFilter)
	{
		$tDocNo 	= $paFilter['tDocNo'];
		$tWorkerID 	= $paFilter['tWorkerID'];
		$tSQL = "SELECT
					HCS.FTXqhDocNo,
					HCS.FTXqcCstCode,
					HCS.FTXqcCstName,
					HCS.FTXqcAddress,
					HCS.FTXqhTaxNo,
					HCS.FTXqhContact,
					HCS.FTXqhEmail,
					HCS.FTXqhTel,
					HCS.FTXqhFax,
					HCS.FTCreateBy,
					HCS.FDCreateOn,
					HCS.FTUpdateBy,
					HCS.FDUpdateOn,
					CST.FTCstName
				FROM TARTSqHDCstTmp HCS WITH (NOLOCK)
				LEFT JOIN TCNMCst CST WITH (NOLOCK) ON HCS.FTXqcCstCode = CST.FTCstCode
				WHERE HCS.FTWorkerID ='" . $tWorkerID . "' ";
		if ($tDocNo != "") {
			$tSQL .= " AND HCS.FTXqhDocNo = '" . $tDocNo . "'";
		}

		$oQuery		= $this->db->query($tSQL);
		$nCountRows = $oQuery->num_rows();
		if ($nCountRows > 0) {
			$aResult = array(
				'raItems'  	=> $oQuery->result_array(),
				'nTotalRes' => $nCountRows,
				'rtCode'   	=> '1',
				'rtDesc'   	=> 'success',
			);
		} else {
			$aResult = array(
				'rtCode' 	=> '800',
				'nTotalRes' => 0,
				'rtDesc' 	=> 'data not found',
			);
		}
		return $aResult;
	}

	//รายการสินค้าใน DT Tmp
	public function FCaMQUOGetItemsList($paFilter)
	{

		$tDocNo 	= $paFilter['tDocNo'];
		$tWorkerID 	= $paFilter['tWorkerID'];
		$nMode 		= $paFilter['nMode'];

		$tSQL = "SELECT D.FNXqdSeq
						,D.FTPdtCode
						,D.FTPdtName
						,D.FTPunCode
						,D.FTPunName
						,D.FTXqdCost
						,D.FCXqdUnitPrice
						,D.FCXqdQty
						,D.FTSplCode
						,D.FCXqdDis
						,D.FTXqdDisTxt
						,D.FCXqdFootAvg
						,P.FTPdtImage
						,SPL.FTSplName
						,D.FTPdtStaEditName
				FROM TARTSqDTTmp D WITH (NOLOCK)
				LEFT JOIN TCNMPdt P WITH (NOLOCK) ON D.FTPdtCode = P.FTPdtCode
				LEFT JOIN TCNMSpl SPL WITH (NOLOCK) ON D.FTSplCode = SPL.FTSplCode
				WHERE D.FTWorkerID = '" . $tWorkerID . "' ";

		if ($tDocNo != "") {
			$tSQL .= " AND D.FTXqhDocNo = '" . $tDocNo . "'";
		}

		$tSQL .= " ORDER BY D.FNXqdSeq,D.FDTmpTnsDate DESC ";

		$oQuery = $this->db->query($tSQL);
		$nCountRows = $oQuery->num_rows();
		if ($nCountRows > 0) {
			$aResult = array(
				'raItems'  => $oQuery->result_array(),
				'nTotalRes' => $nCountRows,
				'rtCode'   => '1',
				'rtDesc'   => 'success',
			);
		} else {
			$aResult = array(
				'rtCode' => '800',
				'nTotalRes' => 0,
				'rtDesc' => 'data not found',
			);
		}
		return $aResult;
	}

	public function FCnMQUExitingItem($paFilter)
	{

		if (isset($paFilter['tDocNo'])) {
			$tDocNo = $paFilter['tDocNo'];
		} else {
			$tDocNo = '';
		}

		$tWorkerID = $paFilter['tWorkerID'];
		$tPdtCode = $paFilter['tPdtCode'];

		$tSQL = "SELECT FCXqdQty
				 FROM TARTSqDTTmp WITH (NOLOCK)
				 WHERE FTPdtCode  = '$tPdtCode'
				 AND FTWorkerID = '$tWorkerID' ";

		if ($tDocNo != "") {
			$tSQL .= " AND FTXqhDocNo = '$tDocNo' ";
		}

		$oQuery = $this->db->query($tSQL);
		$nCountRows = $oQuery->num_rows();

		if ($nCountRows > 0) {
			$aResult = $oQuery->result_array();
			return $aResult[0]["FCXqdQty"] + 1;
		} else {
			return 1; //Not Exiting
		}
	}

	public function FCaMQUOGetItemLastSeq($paFilter)
	{

		$tDocNo = $paFilter['tDocNo'];
		$tWorkerID = $paFilter['tWorkerID'];

		$tSQL = "SELECT TOP 1 FNXqdSeq FROM TARTSqDTTmp WITH (NOLOCK) WHERE 1=1 ";

		if ($tDocNo != "") {
			$tSQL .= " AND FTXqhDocNo = '" . $tDocNo . "'";
		} else {
			$tSQL .= " AND FTWorkerID = '" . $tWorkerID . "'";
		}

		$tSQL .= "  ORDER BY FNXqdSeq DESC ";

		$oQuery = $this->db->query($tSQL);
		$nCountRows = $oQuery->num_rows();

		if ($nCountRows > 0) {
			$aResult = $oQuery->result_array();
			return $aResult[0]["FNXqdSeq"] + 1;
		} else {
			return 1;
		}
	}

	public function FCaMQUOAddItem2Temp($paItemData)
	{
		$this->db->insert('TARTSqDTTmp', $paItemData);
	}

	public function FCxMQUOUpdateItem($paItemData)
	{

		$tSQL = "UPDATE TARTSqDTTmp
				          SET   FCXqdQty = '" . $paItemData['FCXqdQty'] . "'
									WHERE FTPdtCode  = '" . $paItemData['FTPdtCode'] . "'
									AND   FTWorkerID = '" . $paItemData['FTWorkerID'] . "'";

		if ($paItemData['FTXqhDocNo'] != "") {
			$tSQL .= " AND FTXqhDocNo = '" . $paItemData['FTXqhDocNo'] . "'";
		}

		$this->db->query($tSQL);
	}

	public function FCxMQUODeleteItem($paItemData)
	{

		$tQuoDocNo = $paItemData['tQuoDocNo'];
		$tWorkerID = $paItemData['tWorkerID'];
		$nItemSeq = $paItemData['nItemSeq'];

		$tSQL = "DELETE FROM TARTSqDTTmp
				          WHERE  FNXqdSeq = '$nItemSeq'
									AND    FTWorkerID = '$tWorkerID' ";

		if ($tQuoDocNo != "") {
			$tSQL .= " AND FTXqhDocNo = '$tQuoDocNo' ";
		}

		$this->db->query($tSQL);
	}

	public function FCxMQUOEditItemQty($paItemData)
	{

		$tQuoDocNo = $paItemData['tQuoDocNo'];
		$tWorkerID = $paItemData['tWorkerID'];
		$nItemSeq = $paItemData['nItemSeq'];
		$nItemQTY = $paItemData['nItemQTY'];

		$tSQL = "UPDATE TARTSqDTTmp
				          SET    FCXqdQty = '$nItemQTY'
				          WHERE  FNXqdSeq = '$nItemSeq'
									AND    FTWorkerID = '$tWorkerID' ";

		if ($tQuoDocNo != "") {
			$tSQL .= " AND FTXqhDocNo = '$tQuoDocNo' ";
		}

		$this->db->query($tSQL);
	}

	public function FCxMQUODocUpdHeader($paItemData)
	{

		$tSQL = "UPDATE TARTSqHDTmp ";
		$tSQL .= " SET FNXqhSmpDay = '" . $paItemData['FNXqhSmpDay'] . "',";
		$tSQL .= " FTBchCode = '" . $paItemData['FTBchCode'] . "',";
		$tSQL .= " FDXqhEftTo = '" . $paItemData['FDXqhEftTo'] . "',";
		$tSQL .= " FTXqhCshOrCrd = '" . $paItemData['FTXqhCshOrCrd'] . "',";
		$tSQL .= " FNXqhCredit = '" . $paItemData['FNXqhCredit'] . "',";
		$tSQL .= " FDDeliveryDate = '" . $paItemData['FDDeliveryDate'] . "',";
		$tSQL .= " FTXqhVATInOrEx = '" . $paItemData['FTXqhVATInOrEx'] . "',";
		$tSQL .= " FTXqhStaExpress = '" . $paItemData['FTXqhStaExpress'] . "',";
		$tSQL .= " FTXqhStaActive = '" . $paItemData['FTXqhStaActive'] . "',";
		$tSQL .= " FTXqhStaDeli = '" . $paItemData['FTXqhStaDeli'] . "',";
		$tSQL .= " FCXqhB4Dis = '" . str_replace(",", "", $paItemData['FCXqhB4Dis']) . "',";
		$tSQL .= " FCXqhDis = '" . str_replace(",", "", $paItemData['FCXqhDis']) . "',";
		$tSQL .= " FTXqhDisTxt = '" . $paItemData['FTXqhDisTxt'] . "',";
		$tSQL .= " FCXqhAFDis = '" . str_replace(",", "", $paItemData['FCXqhAFDis']) . "',";
		$tSQL .= " FCXqhVatRate = '" . str_replace(",", "", $paItemData['FCXqhVatRate']) . "',";
		$tSQL .= " FCXqhAmtVat = '" . str_replace(",", "", $paItemData['FCXqhAmtVat']) . "',";
		$tSQL .= " FCXqhVatable = '" . str_replace(",", "", $paItemData['FCXqhVatable']) . "',";
		$tSQL .= " FCXqhGrand = '" . str_replace(",", "", $paItemData['FCXqhGrand']) . "',";
		$tSQL .= " FTXqhGndText = '" . str_replace(",", "", $paItemData['FTXqhGndText']) . "',";
		$tSQL .= " FTXqhPrjName = '" . $paItemData['FTXqhPrjName'] . "',";
		$tSQL .= " FTXqhPrjCodeRef = '" . $paItemData['FTXqhPrjCodeRef'] . "',";
		$tSQL .= " FTXqhRmk = '" . $paItemData['FTXqhRmk'] . "'";
		$tSQL .= " WHERE FTWorkerID='" . $paItemData['tWorkerID'] . "'";

		if ($paItemData['tDocNo'] != "") {
			$tSQL .= " AND FTXqhDocNo='" . $paItemData['tDocNo'] . "'";
		}

		$this->db->query($tSQL);
	}

	public function FCxMQUODocUpdCst($paCstData)
	{
		$tSQL = "UPDATE TARTSqHDCstTmp ";
		$tSQL .= " SET FTXqcCstCode = '" . $paCstData['FTXqcCstCode'] . "',";
		$tSQL .= " FTXqcCstName = '" . $paCstData['FTXqcCstName'] . "',";
		$tSQL .= " FTXqcAddress = '" . $paCstData['FTXqcAddress'] . "',";
		$tSQL .= " FTXqhTaxNo = '" . $paCstData['FTXqhTaxNo'] . "',";
		$tSQL .= " FTXqhContact = '" . $paCstData['FTXqhContact'] . "',";
		$tSQL .= " FTXqhEmail = '" . $paCstData['FTXqhEmail'] . "',";
		$tSQL .= " FTXqhTel = '" . $paCstData['FTXqhTel'] . "',";
		$tSQL .= " FTXqhFax = '" . $paCstData['FTXqhFax'] . "' ";
		$tSQL .= " WHERE FTWorkerID='" . $paCstData['tWorkerID'] . "'";
		if ($paCstData['tDocNo'] != "") {
			$tSQL .= " AND FTXqhDocNo='" . $paCstData['tDocNo'] . "'";
		}

		$this->db->query($tSQL);
	}

	public function FCxMQUCheckDocNoExiting($ptWorkerID)
	{

		$tSQL = "SELECT ISNULL(FTXqhDocNo,'') AS FTXqhDocNo
		         FROM TARTSqHDTmp WITH (NOLOCK)
						 WHERE FTWorkerID = '" . $ptWorkerID . "'";

		$oQuery = $this->db->query($tSQL);
		$nCountRows = $oQuery->num_rows();
		if ($nCountRows > 0) {
			$aResult = array(
				'raItems'  => $oQuery->result_array(),
				'rtCode'   => '1',
				'rtDesc'   => 'success',
			);
		} else {
			$aResult = array(
				'raItems' => '',
				'rtCode'   => '0',
				'rtDesc' => 'data not found',
			);
		}
		return $aResult;
	}

	public function FCtMQUGetDocNo($tBchCode)
	{
		$tSQL = "SELECT MAX(RIGHT(ISNULL(FTXqhDocNo,''),4)) AS FTXqhDocNo
		         FROM TARTSqHD WITH (NOLOCK)
						 WHERE FTBchCode = '" . $tBchCode . "'";
		$oQuery = $this->db->query($tSQL);
		$nCountRows = $oQuery->num_rows();
		if ($nCountRows > 0) {
			$aResult = $oQuery->result_array();
			$nNextDocNo = sprintf('%05d', $aResult[0]['FTXqhDocNo'] + 1);
			$tDocNo = 'SQ' . $tBchCode . DATE('Ymd') . '-' . $nNextDocNo;
		} else {
			$tDocNo = 'SQ' . $tBchCode . DATE('Ymd') . '-00001';
		}
		return $tDocNo;
	}

	//เอาเลขที่เอกสารไปอัพเดท
	public function FCtMQUUpdateDocNo($ptDocNo, $pdDocDate, $ptBchCode, $ptWorkerId)
	{
		$tSQL = "UPDATE TARTSqHDTmp SET FTXqhDocNo = '" . $ptDocNo . "', FDXqhDocDate='" . $pdDocDate . "',FTBchCode = '" . $ptBchCode . "' WHERE  FTWorkerID = '" . $ptWorkerId . "'";
		$this->db->query($tSQL);

		$tSQL2 = "UPDATE TARTSqHDCstTmp SET FTXqhDocNo = '" . $ptDocNo . "' WHERE FTWorkerID = '" . $ptWorkerId . "'";
		$this->db->query($tSQL2);

		$tSQL3 = "UPDATE TARTSqDTTmp SET FTXqhDocNo = '" . $ptDocNo . "' WHERE  FTWorkerID = '" . $ptWorkerId . "'";
		$this->db->query($tSQL3);
	}

	//ย้าย HD Tmp => HD
	public function FCxMQUMoveTemp2HD($tDocNo, $tWorkerID)
	{
		$tCreateBy = $this->session->userdata('tSesUsercode');
		$tSQLDel = "DELETE FROM TARTSqHD WHERE FTXqhDocNo = '" . $tDocNo . "'";
		$this->db->query($tSQLDel);

		$tSQL = "INSERT INTO TARTSqHD (
					FTBchCode,FTXqhDocNo,FDXqhDocDate,FTXqhCshOrCrd,FNXqhCredit,
					FTXqhVATInOrEx,FNXqhSmpDay,FDXqhEftTo,FDDeliveryDate,FTXqhStaExpress,
					FTXqhStaDoc,FTXqhStaActive,FTXqhStaDeli,FTXqhPrjName,FTXqhPrjCodeRef,
					FCXqhB4Dis,FCXqhDis,FTXqhDisTxt,FCXqhAFDis,FCXqhVatRate,
					FCXqhAmtVat,FCXqhVatable,FCXqhGrand,FCXqhRnd,FTXqhGndText,
					FTXqhRmk,FTUsrDep,FTXqhStaApv,FTApprovedBy,FDApproveDate,
					FTCreateBy,FDCreateOn,FTUpdateBy,FDUpdateOn
				)
				SELECT
					FTBchCode,FTXqhDocNo,FDXqhDocDate,FTXqhCshOrCrd,FNXqhCredit,
					FTXqhVATInOrEx,FNXqhSmpDay,FDXqhEftTo,FDDeliveryDate,FTXqhStaExpress
					,ISNULL(FTXqhStaDoc,1),FTXqhStaActive,FTXqhStaDeli,FTXqhPrjName,FTXqhPrjCodeRef,
					FCXqhB4Dis,FCXqhDis,FTXqhDisTxt,FCXqhAFDis,FCXqhVatRate,
					FCXqhAmtVat,FCXqhVatable,FCXqhGrand,ISNULL(FCXqhRnd,0),FTXqhGndText,
					FTXqhRmk,FTUsrDep,null AS FTXqhStaApv,FTApprovedBy,FDApproveDate,
					$tCreateBy,ISNULL(FDCreateOn,CONVERT(VARCHAR(16),GETDATE(),121)),$tCreateBy,CONVERT(VARCHAR(16),GETDATE(),121)
				FROM TARTSqHDTmp
				WHERE FTWorkerID = '" . $tWorkerID . "'
				AND FTXqhDocNo = '" . $tDocNo . "'";
		$this->db->query($tSQL);
	}

	//ย้าย HD Customer Tmp => HD Customer
	public function FCxMQUMoveTempHDCst($tDocNo, $tWorkerID)
	{
		$tCreateBy = $this->session->userdata('tSesUsercode');
		$tSQLDel = "DELETE FROM TARTSqHDCst WHERE FTXqhDocNo = '" . $tDocNo . "'";
		$this->db->query($tSQLDel);

		$tSQL = "INSERT INTO TARTSqHDCst
				 SELECT FTXqhDocNo
						,ISNULL(FTXqcCstCode,'')
						,FTXqcCstName
						,FTXqcAddress
						,FTXqhTaxNo
						,FTXqhContact
						,FTXqhEmail
						,FTXqhTel
						,FTXqhFax
						,ISNULL(FTCreateBy,'$tCreateBy')
						,ISNULL(FDCreateOn,CONVERT(VARCHAR(16),GETDATE(),121))
						,$tCreateBy
						,CONVERT(VARCHAR(16),GETDATE(),121)
					FROM TARTSqHDCstTmp
					WHERE FTWorkerID = '" . $tWorkerID . "'
					AND FTXqhDocNo = '" . $tDocNo . "'";
		$this->db->query($tSQL);
	}

	//ย้าย DT Tmp => DT
	public function FCxMQUMoveTemp2DT($tDocNo, $tWorkerID)
	{
		$tCreateBy = $this->session->userdata('tSesUsercode');
		$tSQLDel = "DELETE FROM TARTSqDT WHERE FTXqhDocNo = '" . $tDocNo . "'";
		$this->db->query($tSQLDel);

		$tSQL = "  INSERT INTO TARTSqDT(
								FTXqhDocNo
								,FNXqdSeq
								,FTPdtCode
								,FTPdtName
								,FTPunCode
								,FTPunName
								,FCXqdUnitPrice
								,FTXqdCost
								,FTSplCode
								,FCXqdQty
								,FCXqdB4Dis
								,FCXqdDis
								,FTXqdDisTxt
								,FCXqdAfDT
								,FCXqdFootAvg
								,FCXqdNetAfHD
								,FTCreateBy
								,FDCreateOn
								,FTUpdateBy
								,FDUpdateOn
								,FTPdtStaEditName
				            )
				            SELECT
								FTXqhDocNo,
								FNXqdSeq,
								FTPdtCode,
								FTPdtName,
								FTPunCode,
								FTPunName,
								FCXqdUnitPrice,
								FTXqdCost,
								ISNULL(FTSplCode,0),
								FCXqdQty,
								ISNULL(FCXqdQty,0)  *  ISNULL(FCXqdUnitPrice,0),
								FCXqdDis,
								FTXqdDisTxt,
								(ISNULL(FCXqdQty,0)  *  ISNULL(FCXqdUnitPrice,0))-ISNULL(FCXqdDis,0),
								FCXqdFootAvg,
								((ISNULL(FCXqdQty,0)  *  ISNULL(FCXqdUnitPrice,0))-ISNULL(FCXqdDis,0)+ISNULL(FCXqdFootAvg,0)),
								ISNULL(FTCreateBy,'$tCreateBy'),
								ISNULL(FDCreateOn,CONVERT(VARCHAR(16),GETDATE(),121)),
								$tCreateBy,
								CONVERT(VARCHAR(16),GETDATE(),121),
								FTPdtStaEditName
								FROM TARTSqDTTmp
								WHERE FTWorkerID = '" . $tWorkerID . "'
								AND FTXqhDocNo = '" . $tDocNo . "' ";

		$this->db->query($tSQL);
	}

	public function FCxMQUProrate($ptDocNo, $pnB4Dis, $pnFootDis)
	{

		$tSQL = "SELECT  FCXqdAfDT,FTPdtCode,FNXqdSeq
				          FROM    TARTSqDT WITH (NOLOCK)
									WHERE   FTXqhDocNo = '$ptDocNo' ";

		$oQuery = $this->db->query($tSQL);
		$nCountRows = $oQuery->num_rows();

		if ($nCountRows > 0) {

			$aResult = $oQuery->result_array();
			$nFootDisAvg = 0;
			$nNetAFHD = 0;

			for ($i = 0; $i < $nCountRows; $i++) {

				$nItemAmt 		= str_replace(",", "", $aResult[$i]['FCXqdAfDT']);
				$tPdtCode 		= $aResult[$i]['FTPdtCode'];
				$nXqdSeq 		= str_replace(",", "", $aResult[$i]['FNXqdSeq']);
				$pnFootDis 		= str_replace(",", "", $pnFootDis);
				$pnB4Dis		= str_replace(",", "", $pnB4Dis);

				if($pnB4Dis == 0 || $pnB4Dis == null){
					$nFootDisAvg 	= $nItemAmt * $pnFootDis;
				}else{
					$nFootDisAvg 	= ($nItemAmt * $pnFootDis) / str_replace(",", "", $pnB4Dis);
				}

				$nNetAFHD 		= $nItemAmt - $nFootDisAvg;

				$tSQLUpd = "UPDATE TARTSqDT SET FCXqdFootAvg = '" . $nFootDisAvg . "',";
				$tSQLUpd .= " FCXqdNetAfHD = '" . $nNetAFHD . "'";
				$tSQLUpd .= " WHERE FTXqhDocNo = '" . $ptDocNo . "'";
				$tSQLUpd .= " AND FTPdtCode = '" . $tPdtCode . "'";
				$tSQLUpd .= " AND FNXqdSeq = '" . $nXqdSeq . "'";
				$this->db->query($tSQLUpd);
			}
		}
	}

	//ลบข้อมูลรายการ
	public function FCxMQUDeleteItemInTemp($paItem)
	{
		$nSeq 		= $paItem['FNXqdSeq'];
		$tPDTCode 	= $paItem['FTPdtCode'];
		$tDocument  = $paItem['FTXqhDocNo'];
		$FTWorkerID	= $this->session->userdata('tSesLogID');

		$tSQLDT = "DELETE FROM TARTSqDTTmp WHERE
						FTXqhDocNo = '$tDocument' AND
						FTPdtCode = '$tPDTCode' AND
						FNXqdSeq = '$nSeq' AND
						FTWorkerID = '$FTWorkerID' ";
		$this->db->query($tSQLDT);

		//เรียง Seq ใหม่
		$tSQL   = " UPDATE TARTSqDTTmp WITH(ROWLOCK)
					SET FNXqdSeq = NewObj.NewSeq
					FROM TARTSqDTTmp DT
					INNER JOIN (
						SELECT  ROW_NUMBER() OVER (ORDER BY FNXqdSeq) AS NewSeq,
							FNXqdSeq AS OldSeq
						FROM TARTSqDTTmp
						WHERE
							FTXqhDocNo = '$tDocument'
						AND FTWorkerID = '$FTWorkerID'
				) NewObj ON DT.FNXqdSeq = NewObj.OldSeq";
		$this->db->query($tSQL);
	}

	//ลบข้อมูลรายการ
	public function FCxMQUEditItemInTemp($paItem)
	{

		$tQuoDocNo 	= $paItem['tQuoDocNo'];
		$nItemSeq 	= $paItem['nItemSeq'];
		$nItemQTY 	= $paItem['nItemQTY'];
		$tPdtCode  = $paItem['tPdtCode'];
		$nDiscount  = $paItem['nDiscount'];
		$nDiscountText  = $paItem['tDisText'];

		if($nDiscount ==''){
			$nDiscount = 0;
		}else{
			$nDiscount = $nDiscount;
		}
		$tWorkerID	= $this->session->userdata('tSesLogID');
		$tSQL = "UPDATE TARTSqDTTmp
					         SET    FCXqdQty = '" . $nItemQTY . "',FCXqdDis='" . $nDiscount . "', FTXqdDisTxt = '".$nDiscountText." '
									 WHERE  FTWorkerID = '" . $tWorkerID . "'
									 AND    FNXqdSeq = '" . $nItemSeq . "' ";

		if ($tQuoDocNo != "") {
			$tSQL .= " AND FTXqhDocNo = '" . $tQuoDocNo . "' ";
		}

		$this->db->query($tSQL);
	}

	//ส่วนลดรายการ
	public function FCxMQUEditItemIDisCount($paItem)
	{

		$tQuoDocNo 	= $paItem['tQuoDocNo'];
		$nItemSeq 	= $paItem['nItemSeq'];
		$nDiscount 	= $paItem['nDiscount'];
		$tPdtCode   = $paItem['tPdtCode'];
		$tDisText   = $paItem['tDisText'];
		$tWorkerID	= $this->session->userdata('tSesLogID');

		$tSQL = "UPDATE TARTSqDTTmp
					         SET    FCXqdDis = '" . $nDiscount . "',FTXqdDisTxt='" . $tDisText . "'
									 WHERE  FTWorkerID = '" . $tWorkerID . "'
									 AND    FNXqdSeq = '" . $nItemSeq . "' ";

		if ($tQuoDocNo != "") {
			$tSQL .= " AND FTXqhDocNo = '" . $tQuoDocNo . "' ";
		}

		$this->db->query($tSQL);
	}

	//ส่วนลดท้ายบิล
	public function FCxMQUEditDocDisCount($paItem)
	{

		$tQuoDocNo 	= $paItem['tQuoDocNo'];
		$nDiscount 	= $paItem['nDiscount'];
		$tDisTxt   = $paItem['tDisTxt'];
		$tWorkerID   = $paItem['tWorkerID'];

		$tSQL = "UPDATE TARTSqHDTmp SET FCXqhDis = '" . $nDiscount . "', FTXqhDisTxt='" . $tDisTxt . "'  WHERE FTWorkerID = '" . $tWorkerID . "'";

		if ($tQuoDocNo != "") {
			$tSQL .= " AND FTXqhDocNo = '" . $tQuoDocNo . "' ";
		}
		//echo $tSQL;
		$this->db->query($tSQL);
	}

	//แก้ไขราคาต่อหน่วยในเอกสาร
	public function FCxMQUEditUnitPriInTemp($paItem)
	{

		$tQuoDocNo 	= $paItem['tQuoDocNo'];
		$nItemSeq 	= $paItem['nItemSeq'];
		$nDiscount 	= $paItem['nDiscount'];
		$tPdtCode   = $paItem['tPdtCode'];
		$nPdtUnitPrice   = $paItem['nPdtUnitPrice'];
		$tWorkerID	= $this->session->userdata('tSesLogID');

		if($nDiscount == ''){
			$nDiscount = 0;
		}else{
			$nDiscount = $nDiscount;
		}

		$tSQL = "UPDATE TARTSqDTTmp
					         SET    FCXqdDis = '" . $nDiscount . "',FCXqdUnitPrice='" . $nPdtUnitPrice . "'
									 WHERE  FTWorkerID = '" . $tWorkerID . "'
									 AND    FNXqdSeq = '" . $nItemSeq . "' ";

		if ($tQuoDocNo != "") {
			$tSQL .= " AND FTXqhDocNo = '" . $tQuoDocNo . "' ";
		}

		$this->db->query($tSQL);
	}

	//ยกเลิกเอกสาร
	public function FCxMQUCancleDocument($paItem)
	{
		try {
			$tDocumentNumber = $paItem['FTXqhDocNo'];
			$aSet = array(
				'FTXqhStaDoc' 	=> 2,
				'FDUpdateOn'	=> date('Y-m-d H:i:s'),
				'FTUpdateBy'	=> $this->session->userdata('tSesUsercode')
			);
			$this->db->where('FTXqhDocNo', $tDocumentNumber);
			$this->db->update('TARTSqHD', $aSet);
		} catch (Exception $Error) {
			echo $Error;
		}
	}

	//อนุมัติเอกสาร
	public function FCxMQUApproveDocument($paItem)
	{
		try {
			$tDocumentNumber = $paItem['FTXqhDocNo'];
			$aSet = array(
				'FTXqhStaApv'  	=> 1,
				'FTApprovedBy'	=> $this->session->userdata('tSesUsercode'),
				'FDApproveDate' => date('Y-m-d H:i:s'),
				'FDUpdateOn'	=> date('Y-m-d H:i:s'),
				'FTUpdateBy'	=> $this->session->userdata('tSesUsercode')
			);
			$this->db->where('FTXqhDocNo', $tDocumentNumber);
			$this->db->update('TARTSqHD', $aSet);
		} catch (Exception $Error) {
			echo $Error;
		}
	}

	//ค้นหาลูกค้า
	public function FCxMQUGetCustomerAll($paData)
	{
		$aRowLen   		= FCNaHCallLenData($paData['nRow'], $paData['nPage']);
		$tWorkerID		= $this->session->userdata('tSesLogID');
		$tTextSearch 	= trim($paData['tSearchCustomer']);
		$tSQL  = "SELECT c.* FROM(";
		$tSQL .= " SELECT  ROW_NUMBER() OVER(ORDER BY FTCstCode ASC) AS rtRowID,* FROM (";
		$tSQL .= " SELECT
							CUS.FTCstCode,
							CUS.FTBchCode,
							CUS.FTCstName,
							CUS.FTCstContactName,
							CUS.FTCstCardID,
							CUS.FTCstTaxNo,
							CUS.FTCstSex,
							CUS.FDCstDob,
							CUS.FTCstAddress,
							CUS.FTCstTel,
							CUS.FTCstFax,
							CUS.FTCstEmail,
							CUS.FNCstPostCode,
							CUS.FTCstWebSite,
							CUS.FTCstReason,
							CUS.FTCstStaActive
						FROM TCNMCst CUS ";
		$tSQL .= " WHERE 1=1 ";
		$tSQL .= " AND CUS.FTCstStaActive = 1 ";


		//ค้นหาธรรมดา
		if ($tTextSearch != '' || $tTextSearch != null) {
			$tSQL .= " AND ( CUS.FTCstCode LIKE '%$tTextSearch%' ";
			$tSQL .= " OR CUS.FTCstName LIKE '%$tTextSearch%' ";
			$tSQL .= " OR CUS.FTCstContactName LIKE '%$tTextSearch%' ";
			$tSQL .= " OR CUS.FTCstCardID LIKE '%$tTextSearch%' ";
			$tSQL .= " OR CUS.FTCstTel LIKE '%$tTextSearch%' )";
		}

		$tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
		$oQuery = $this->db->query($tSQL);
		if ($oQuery->num_rows() > 0) {
			$oFoundRow 	= $this->FCxMQUGetCustomer_PageAll($paData);
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

	public function FCxMQUGetCustomer_PageAll($paData)
	{
		try {
			$tTextSearch 	= trim($paData['tSearchCustomer']);
			$tWorkerID		= $this->session->userdata('tSesLogID');
			$tSQL 		= "SELECT COUNT (CUS.FTCstCode) AS counts
							FROM TCNMCst CUS  ";
			$tSQL 		.= " WHERE 1=1 ";
			$tSQL 		.= " AND CUS.FTCstStaActive = 1 ";

			//ค้นหาธรรมดา
			if ($tTextSearch != '' || $tTextSearch != null) {
				$tSQL .= " AND ( CUS.FTCstCode LIKE '%$tTextSearch%' ";
				$tSQL .= " OR CUS.FTCstName LIKE '%$tTextSearch%' ";
				$tSQL .= " OR CUS.FTCstContactName LIKE '%$tTextSearch%' ";
				$tSQL .= " OR CUS.FTCstCardID LIKE '%$tTextSearch%' ";
				$tSQL .= " OR CUS.FTCstTel LIKE '%$tTextSearch%' )";
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

	public function FCaMQUODocPrintHD($ptDocNo){

		$tSQL = "SELECT HD.FTBchCode
			,HD.FTXqhDocNo
			,CONVERT(VARCHAR(16),HD.FDXqhDocDate,121) AS FDXqhDocDate
			,CASE WHEN HD.FTXqhCshOrCrd = 1 THEN 'เงินสด' WHEN HD.FTXqhCshOrCrd = 2 THEN 'เครดิต' ELSE '-' END AS  FTXqhCshOrCrd
			,HD.FNXqhCredit
			,HD.FTXqhVATInOrEx
			,HD.FNXqhSmpDay
			,CONVERT(VARCHAR(10),HD.FDXqhEftTo,121) AS FDXqhEftTo
			,CONVERT(VARCHAR(10),HD.FDDeliveryDate,121) AS FDDeliveryDate
			,HD.FTXqhStaExpress
			,HD.FTXqhStaDoc
			,HD.FTXqhStaActive
			,HD.FTXqhStaDeli
			,HD.FTXqhPrjName
			,HD.FTXqhPrjCodeRef
			,HD.FCXqhB4Dis
			,HD.FCXqhDis
			,HD.FTXqhDisTxt
			,HD.FCXqhAFDis
			,HD.FCXqhVatRate
			,HD.FCXqhAmtVat
			,HD.FCXqhVatable
			,HD.FCXqhGrand
			,HD.FCXqhRnd
			,HD.FTXqhGndText
			,HD.FTXqhRmk
			,HD.FTUsrDep
			,CMP.FTCmpName
			,BCH.FTBchName
			,BCH.FTAdrName
			,BCH.FTAdrRoad
			,BCH.FTAdrSubDistric
			,BCH.FTAdrDistric
			,BCH.FTAdrProvince
			,BCH.FTAdrPosCode
			,BCH.FTAdrTel
			,BCH.FTAdrFax
			,BCH.FTAdrEmail
			FROM TARTSqHD HD
			INNER JOIN TCNMBranch BCH ON HD.FTBchCode = BCH.FTBchCode
			INNER JOIN TCNMCompany CMP ON BCH.FTCmpCode = CMP.FTCmpCode
			WHERE HD.FTXqhDocNo = '".$ptDocNo."'";

		$oQuery = $this->db->query($tSQL);
		if ($oQuery->num_rows() > 0) {
			$aResult 	= array(
				'raItems'  		=> $oQuery->result_array(),
				'rtCode'   		=> '1',
				'rtDesc'   		=> 'success',
			);
		} else {
			$aResult = array(
				'raItems'  		=> '',
				'rtCode'   		=> '0',
				'rtDesc'   		=> 'Empty',
			);
		}

		return $aResult;
	}

	public function FCaMQUODocPrintHDCst($ptDocNo){

		$tSQL = "SELECT FTXqhDocNo
				,FTXqcCstCode
				,ISNULL(FTXqcCstName,'ไม่ระบุชื่อ') AS FTXqcCstName
				,ISNULL(FTXqcAddress,'-') AS FTXqcAddress
				,ISNULL(FTXqhTaxNo,'-') AS FTXqhTaxNo
				,ISNULL(FTXqhContact,'-') AS FTXqhContact
				,ISNULL(FTXqhEmail,'-') AS FTXqhEmail
				,ISNULL(FTXqhTel,'-') AS FTXqhTel
				,ISNULL(FTXqhFax,'-') AS FTXqhFax
			FROM TARTSqHDCst
			WHERE FTXqhDocNo = '".$ptDocNo."'";

		$oQuery = $this->db->query($tSQL);
		if ($oQuery->num_rows() > 0) {
			$aResult 	= array(
				'raItems'  		=> $oQuery->result_array(),
				'rtCode'   		=> '1',
				'rtDesc'   		=> 'success',
			);
		}else{
			$aResult = array(
					'raItems'  		=> '',
					'rtCode'   		=> '0',
					'rtDesc'   		=> 'Empty',
			);
		}

		return $aResult;
	}

	public function FCaMQUODocPrintDT($ptDocNo){
		$tSQL = "SELECT
			DT.FTXqhDocNo
			,DT.FNXqdSeq
			,DT.FTPdtCode
			,ISNULL(DT.FTPdtName,'-') AS FTPdtName
			,DT.FTPunCode
			,ISNULL(DT.FTPunName,'-') AS FTPunName
			,DT.FCXqdUnitPrice
			,DT.FTXqdCost
			,DT.FTSplCode
			,DT.FCXqdQty
			,DT.FCXqdB4Dis
			,DT.FCXqdDis
			,DT.FTXqdDisTxt
			,DT.FCXqdAfDT
			,DT.FCXqdFootAvg
			,DT.FCXqdNetAfHD
			,PDT.FTPdtImage
		FROM TARTSqDT DT
		LEFT JOIN TCNMPdt PDT ON DT.FTPdtCode = PDT.FTPdtCode
		WHERE FTXqhDocNo = '".$ptDocNo."'";
		$tSQL.=" ORDER BY FNXqdSeq ";
		$oQuery = $this->db->query($tSQL);
		if ($oQuery->num_rows() > 0) {
			$aResult 	= array(
				'rnTotal'     =>$oQuery->num_rows(),
				'raItems'  		=> $oQuery->result_array(),
				'rtCode'   		=> '1',
				'rtDesc'   		=> 'success',
			);
		} else {
			$aResult = array(
					'rnTotal'     => 0,
					'raItems'  		=> '',
					'rtCode'   		=> '0',
					'rtDesc'   		=> 'Empty',
			);
		}

		return $aResult;
	}

	//อัพเดท สาขา
	public function FCxMQUOUpdateBCHInQuotation($paData){
		$tDocNo 	= $paData['tDocNo'];
		$tBCH 		= $paData['tBCH'];
		$tWorkerID 	= $this->session->userdata('tSesLogID');

		//อัพเดทเอกสาร HD Tmp
		$tSQL = "UPDATE TARTSqHDTmp SET FTBchCode = '" . $tBCH . "' WHERE FTWorkerID = '" . $tWorkerID . "'";
		if ($tDocNo != "") {
			$tSQL .= " AND FTXqhDocNo = '" . $tDocNo . "'";
		}
		$this->db->query($tSQL);
	}

	//อัพเดทชื่อสินค้า
	public function FCxMQUChangenameinDT($paData){
		$nSeq 		= $paData['nSeq'];
		$nPDTCode 	= $paData['nPDTCode'];
		$tPDTName 	= $paData['tPDTName'];
		$tWorkerID 	= $this->session->userdata('tSesLogID');

		//อัพเดทเอกสาร HD Tmp
		$tSQL = "UPDATE TARTSqDTTmp SET FTPdtName = '" . $tPDTName . "'
				 WHERE FTWorkerID = '" . $tWorkerID . "'
				 AND FNXqdSeq = '" . $nSeq . "'
				 AND FTPdtCode = '" . $nPDTCode . "' ";
		$this->db->query($tSQL);

		//อัพเดทชื่อใน DT จริงเลย
		$tDocumentNumber	= $paData['tDocumentNumber'];
		$tSQL = "UPDATE TARTSqDT SET FTPdtName = '" . $tPDTName . "'
					WHERE FTXqhDocNo = '" . $tDocumentNumber . "'
					AND FNXqdSeq = '" . $nSeq . "'
					AND FTPdtCode = '" . $nPDTCode . "' ";
		$this->db->query($tSQL);
	}

}
