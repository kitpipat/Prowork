<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mQuotation extends CI_Model
{

	/*
	Create On : 05/04/2020
	Create By : Kitpipat Kaewkieo
	Update On : -
	Update By : -

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
                                        FROM TCNMSpl

                                        UNION ALL

                                        SELECT 'FGPBN' AS FTFilGrpCode,
                                               'ยี่ห้อ' AS FTFilGrpName ,
                                               FTPbnCode AS FTFilCode ,
                                               FTPbnName AS FTFilName
                                        FROM TCNMPdtBrand

                                        UNION ALL

                                        SELECT 'FGPGP' AS FTFilGrpCode,
                                               'กลุ่มสินค้า' AS FTFilGrpName ,
                                               FTPgpCode AS FTFilCode,
                                               FTPgpName AS FTFilName
                                        FROM TCNMPdtGrp

                                        UNION ALL

                                        SELECT 'FGPTY' AS FTFilGrpCode,
                                               'ประเภทสินค้า' AS FTFilGrpName ,
                                               FTPtyCode AS FTFilCode,
                                               FTPtyName  AS FTFilName
                                        FROM TCNMPdtType
                                        UNION ALL

                                        SELECT 'FGPZE' AS FTFilGrpCode,
                                              'ขนาด' AS FTFilGrpName ,
                                              FTPzeCode AS FTFilCode,
                                              FTPzeName  AS FTFilName
                                        FROM TCNMPdtSize

                                        UNION ALL

                                        SELECT 'FGCLR' AS FTFilGrpCode,
                                               'สี' AS FTFilGrpName ,
                                               FTPClrCode AS FTFilCode,
                                               FTPClrName  AS FTFilName
                                        FROM TCNMPdtColor

                  ) F
                  --WHERE FTFilCode = 'xxx'";

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
				'rtDesc' => 'data not found',
			);
		}
		return $aResult;
	}

	/*
	Create On : 05/04/2020
	Create By : Kitpipat Kaewkieo
	Update On : -
	Update By : -

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
		$aRowLen   		= FCNaHCallLenData($paFilter['nRow'],$paFilter['nPage']);
		$tSearchAll 	= $paFilter["tSearchAll"];
		$tPriceGrp 		= $paFilter["tPriceGrp"];
		$aFilterAdv 	= $paFilter['aFilterAdv'];

		$tSQL = "SELECT P.* FROM (
                 SELECT ROW_NUMBER() OVER(ORDER BY PDT.FTPdtCode) AS RowID,
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
						 PDT.FTPunCode,
						 PUN.FTPunName,
						 PDT.FTSplCode,
                         PDT.FCPdtCostAFDis,
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
                  	FROM VCN_Products PDT
                  	LEFT JOIN ( SELECT * FROM VCN_AdjSalePriActive WHERE FTPriGrpID = '" . $tPriceGrp . "' )SP ON PDT.FTPdtCode = SP.FTPdtCode
                	LEFT JOIN TCNMPdtGrp PGP 	ON PDT.FTPgpCode 	= PGP.FTPgpCode
					LEFT JOIN TCNMPdtUnit PUN 	ON PDT.FTPunCode 	= PUN.FTPunCode
					LEFT JOIN TCNMPdtBrand BAP 	ON PDT.FTPbnCode 	= BAP.FTPbnCode 
					LEFT JOIN TCNMPdtColor COP 	ON PDT.FTPClrCode 	= COP.FTPClrCode 
					LEFT JOIN TCNMPdtModal MOL 	ON PDT.FTMolCode 	= MOL.FTMolCode 
					LEFT JOIN TCNMPdtSize SIZ 	ON PDT.FTPzeCode 	= SIZ.FTPzeCode 
					LEFT JOIN TCNMPdtType TYP 	ON PDT.FTPtyCode 	= TYP.FTPtyCode 
					LEFT JOIN TCNMSpl SPL 		ON PDT.FTSplCode 	= SPL.FTSplCode 
				) P
            	WHERE  1=1 ";

		//ค้นหาขั้นสูง
		if($aFilterAdv != '' || $aFilterAdv != null){
			$tWherePBN  = ''; 	$tWhereINPBN = '';
			$tWhereCLR	= '';	$tWhereINCLR = '';
			$tWherePGP	= '';	$tWhereINPGP = '';
			$tWhereMOL	= '';	$tWhereINMOL = '';
			$tWherePZE	= '';	$tWhereINPZE = '';
			$tWherePTY	= '';	$tWhereINPTY = '';
			$tWherePUN	= '';	$tWhereINPUN = '';
			$tWhereSPL	= '';	$tWhereINSPL = '';
			for($i=0; $i<count($aFilterAdv); $i++){
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

				if($i == count($aFilterAdv)-1){ 
					$tWhereINPBN = substr($tWhereINPBN,0,-1); 
					$tWhereINCLR = substr($tWhereINCLR,0,-1);
					$tWhereINPGP = substr($tWhereINPGP,0,-1);
					$tWhereINMOL = substr($tWhereINMOL,0,-1);
					$tWhereINPZE = substr($tWhereINPZE,0,-1);
					$tWhereINPTY = substr($tWhereINPTY,0,-1);
					$tWhereINPUN = substr($tWhereINPUN,0,-1);
					$tWhereINSPL = substr($tWhereINSPL,0,-1);
				}
				
				if($tWhereINPBN != ''){ $tWherePBN = " AND FTPbnCode IN (" . $tWhereINPBN . ")"; }
				if($tWhereINCLR != ''){ $tWhereCLR = " AND FTPClrCode IN (" . $tWhereINCLR . ")"; }
				if($tWhereINPGP != ''){ $tWherePGP = " AND P.FTPgpCode IN (" . $tWhereINPGP . ")"; }
				if($tWhereINMOL != ''){ $tWhereMOL = " AND FTMolCode IN (" . $tWhereINMOL . ")"; }
				if($tWhereINPZE != ''){ $tWherePZE = " AND P.FTPzeCode IN (" . $tWhereINPZE . ")"; }
				if($tWhereINPTY != ''){ $tWherePTY = " AND FTPtyCode  IN (" . $tWhereINPTY . ")"; }
				if($tWhereINPUN != ''){ $tWherePUN = " AND FTPunCode IN (" . $tWhereINPUN . ")"; }
				if($tWhereINSPL != ''){ $tWhereSPL = " AND FTSplCode IN (" . $tWhereINSPL . ")"; }
			}

			$tWhereFull = $tWherePBN . $tWhereCLR . $tWherePGP . $tWhereMOL . $tWherePZE . $tWherePTY . $tWherePUN . $tWhereSPL;
			$tSQL .= " $tWhereFull ";
		}

		//ค้นหาธรรมดา
		if ($tSearchAll != "") {
			$tSQL .= " AND P.FTPdtName LIKE '%" . $tSearchAll . "%'";
			$tSQL .= " OR P.FTPdtCode LIKE '%" . $tSearchAll . "%'";
		}

		$tSQL .= " AND P.RowID > $aRowLen[0] AND P.RowID <=$aRowLen[1] ";

		$oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
			$oFoundRow 	= $this->FSaMQUOPdtCountRow_PageAll($paFilter);
			$nFoundRow 	= $oFoundRow[0]->counts;
			$nPageAll 	= ceil($nFoundRow/$paFilter['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult 	= array(
				'raItems'  		=> $oQuery->result_array(),
				'rnAllRow'      => $nFoundRow,
				'rnCurrentPage' => $paFilter['nPage'],
				'rnAllPage'     => $nPageAll,
                'rtCode'   		=> '1',
                'rtDesc'   		=> 'success',
            );
        }else{
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
	Create On : 06/04/2020 14:03:00
	Create By : Kitpipat Kaewkieo
	Update On : -
	Update By : -

	เกี่ยวกับฟังก์ชั่น
	----------------------------------------------
	หาจำนวนข้อมูลสินค้าตามเงื่อนไขการกรอง
	*/
	public function FSaMQUOPdtCountRow_PageAll($paFilter){
		try{
			$tTextSearch 	= trim($paFilter['tSearchAll']);
			$aFilterAdv 	= $paFilter['aFilterAdv'];
			$tSQL 		= "SELECT COUNT(FTPDTCode) AS counts 
							FROM TCNMPdt PDT
							LEFT JOIN TCNMPdtBrand BAP 	ON PDT.FTPbnCode 	= BAP.FTPbnCode 
							LEFT JOIN TCNMPdtColor COP 	ON PDT.FTPClrCode 	= COP.FTPClrCode 
							LEFT JOIN TCNMPdtGrp GRP 	ON PDT.FTPgpCode 	= GRP.FTPgpCode 
							LEFT JOIN TCNMPdtModal MOL 	ON PDT.FTMolCode 	= MOL.FTMolCode 
							LEFT JOIN TCNMPdtSize SIZ 	ON PDT.FTPzeCode 	= SIZ.FTPzeCode 
							LEFT JOIN TCNMPdtType TYP 	ON PDT.FTPtyCode 	= TYP.FTPtyCode 
							LEFT JOIN TCNMPdtUnit UNIT 	ON PDT.FTPunCode 	= UNIT.FTPunCode 
							LEFT JOIN TCNMSpl SPL 		ON PDT.FTSplCode 	= SPL.FTSplCode 
							WHERE PDT.FTPdtStatus = 1";

			//ค้นหาขั้นสูง
			if($aFilterAdv != '' || $aFilterAdv != null){
				$tWherePBN  = ''; 	$tWhereINPBN = '';
				$tWhereCLR	= '';	$tWhereINCLR = '';
				$tWherePGP	= '';	$tWhereINPGP = '';
				$tWhereMOL	= '';	$tWhereINMOL = '';
				$tWherePZE	= '';	$tWhereINPZE = '';
				$tWherePTY	= '';	$tWhereINPTY = '';
				$tWherePUN	= '';	$tWhereINPUN = '';
				$tWhereSPL	= '';	$tWhereINSPL = '';
				for($i=0; $i<count($aFilterAdv); $i++){
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

					if($i == count($aFilterAdv)-1){ 
						$tWhereINPBN = substr($tWhereINPBN,0,-1); 
						$tWhereINCLR = substr($tWhereINCLR,0,-1);
						$tWhereINPGP = substr($tWhereINPGP,0,-1);
						$tWhereINMOL = substr($tWhereINMOL,0,-1);
						$tWhereINPZE = substr($tWhereINPZE,0,-1);
						$tWhereINPTY = substr($tWhereINPTY,0,-1);
						$tWhereINPUN = substr($tWhereINPUN,0,-1);
						$tWhereINSPL = substr($tWhereINSPL,0,-1);
					}
					
					if($tWhereINPBN != ''){ $tWherePBN = " AND BAP.FTPbnCode IN (" . $tWhereINPBN . ")"; }
					if($tWhereINCLR != ''){ $tWhereCLR = " AND COP.FTPClrCode IN (" . $tWhereINCLR . ")"; }
					if($tWhereINPGP != ''){ $tWherePGP = " AND GRP.FTPgpCode IN (" . $tWhereINPGP . ")"; }
					if($tWhereINMOL != ''){ $tWhereMOL = " AND MOL.FTMolCode IN (" . $tWhereINMOL . ")"; }
					if($tWhereINPZE != ''){ $tWherePZE = " AND SIZ.FTPzeCode IN (" . $tWhereINPZE . ")"; }
					if($tWhereINPTY != ''){ $tWherePTY = " AND TYP.FTPtyCode  IN (" . $tWhereINPTY . ")"; }
					if($tWhereINPUN != ''){ $tWherePUN = " AND UNIT.FTPunCode IN (" . $tWhereINPUN . ")"; }
					if($tWhereINSPL != ''){ $tWhereSPL = " AND SPL.FTSplCode IN (" . $tWhereINSPL . ")"; }
				}

				$tWhereFull = $tWherePBN . $tWhereCLR . $tWherePGP . $tWhereMOL . $tWherePZE . $tWherePTY . $tWherePUN . $tWhereSPL;
				$tSQL .= " $tWhereFull ";
			}

			//ค้นหาธรรมดา
			if($tTextSearch != '' || $tTextSearch != null){
				$tSQL .= " AND FTPdtName LIKE '%" . $tTextSearch . "%'";
				$tSQL .= " OR FTPdtName LIKE '%" . $tTextSearch . "%'";
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
		
		$oQuery = $this->db->query($tSQL);
		return $oQuery->num_rows();
	}


	/*
	Create On : 06/04/2020 14:03:00
	Create By : Kitpipat Kaewkieo
	Update On : -
	Update By : -

	เกี่ยวกับฟังก์ชั่น
	----------------------------------------------
	หาจำนวนข้อมูลสินค้าในใบเสนอราคา จากตาราง Temp DT
	กรณี create จะหาจาก tWorkerID
	กรณี edit จะหาจาก Docno
	*/
	public function FSxMQUOClearTemp()
	{

		$tSQL = "DELETE
				          FROM TARTSqDTTmp
				          WHERE CONVERT(VARCHAR(10) , FDTmpTnsDate , 121) < CONVERT(VARCHAR(10) , GETDATE() , 121) ";
		$this->db->query($tSQL);
	}

	public function FSxMQUOClearTempByWorkID($ptWorkerID)
	{

		$tSQL1 = "DELETE
								 FROM TARTSqHDTmp
								 WHERE FTWorkerID = '" . $ptWorkerID . "'";
		$this->db->query($tSQL1);

		$tSQL2 = "DELETE
								 FROM TARTSqHDCstTmp
								 WHERE FTWorkerID = '" . $ptWorkerID . "'";
		$this->db->query($tSQL2);

		$tSQL3 = "DELETE
									FROM TARTSqDTTmp
									WHERE FTWorkerID = '" . $ptWorkerID . "'";
		$this->db->query($tSQL3);
	}

	public function FSxMQUPrepareHD($ptWorkerID)
	{

		$dDocDate = date('Y-m-d H:i:s');
		$tSQL1 = "INSERT INTO TARTSqHDTmp(FDXqhDocDate,FTWorkerID,FTCreateBy,FDCreateOn) VALUES	";
		$tSQL1 .= "('" . $dDocDate . "','" . $ptWorkerID . "','" . $ptWorkerID . "','" . $dDocDate . "')";
		$this->db->query($tSQL1);

		$tSQL2 = "INSERT INTO TARTSqHDCstTmp(FTWorkerID,FTCreateBy,FDCreateOn) VALUES	";
		$tSQL2 .= "('" . $ptWorkerID . "','" . $ptWorkerID . "','" . $dDocDate . "')";
		$this->db->query($tSQL2);
	}

	public function FCaMQUOGetDocHD($paFilter)
	{

		$tDocNo = $paFilter['tDocNo'];
		$tWorkerID = $paFilter['tWorkerID'];
		$tSQL = "SELECT   HD.FTBchCode,
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
					         FROM      TARTSqHDTmp HD
									 LEFT JOIN TCNMUsr USR ON HD.FTCreateBy = USR.FTUsrCode
                   WHERE     HD.FTWorkerID ='" . $tWorkerID . "' ";
		if ($tDocNo != "") {
			$tSQL .= " AND HD.FTXqhDocNo = '" . $tDocNo . "'";
		}

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

	public function FCaMQUOGetDocCst($paFilter)
	{

		$tDocNo = $paFilter['tDocNo'];

		$tWorkerID = $paFilter['tWorkerID'];

		$tSQL = "SELECT   HCS.FTXqhDocNo,
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
					         FROM     TARTSqHDCstTmp HCS
									 LEFT JOIN TCNMCst CST ON HCS.FTXqcCstCode = CST.FTCstCode
									 WHERE     HCS.FTWorkerID ='" . $tWorkerID . "' ";

		if ($tDocNo != "") {
			$tSQL .= " AND HCS.FTXqhDocNo = '" . $tDocNo . "'";
		}

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

	public function FCaMQUOGetItemsList($paFilter)
	{

		$tDocNo = $paFilter['tDocNo'];
		$tWorkerID = $paFilter['tWorkerID'];
		$nMode = $paFilter['nMode'];

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
									      ,D.FCXqdFootAvg
												,P.FTPdtImage
												,SPL.FTSplName
									FROM TARTSqDTTmp D
									LEFT JOIN TCNMPdt P ON D.FTPdtCode = P.FTPdtCode
									LEFT JOIN TCNMSpl SPL ON D.FTSplCode = SPL.FTSplCode
									WHERE D.FTWorkerID = '" . $tWorkerID . "'";

		if ($tDocNo != "") {
			$tSQL .= " AND D.FTXqhDocNo = '" . $tDocNo . "'";
		}

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
				         FROM   TARTSqDTTmp
								 WHERE  FTPdtCode  = '$tPdtCode'
								 AND    FTWorkerID = '$tWorkerID' ";

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

		$tSQL = "SELECT TOP 1 FNXqdSeq
									FROM TARTSqDTTmp
									WHERE 1=1 ";

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
		//echo $tSQL;
	}

	public function FCxMQUODocUpdCst($paCstData)
	{

		$tSQL = "UPDATE TARTSqHDCstTmp ";
		$tSQL .= " SET FTXqcCstName = '" . $paCstData['FTXqcCstName'] . "',";
		$tSQL .= " FTXqcAddress = '" . $paCstData['FTXqcAddress'] . "',";
		$tSQL .= " FTXqhTaxNo = '" . $paCstData['FTXqhTaxNo'] . "',";
		$tSQL .= " FTXqhContact = '" . $paCstData['FTXqhContact'] . "',";
		$tSQL .= " FTXqhEmail = '" . $paCstData['FTXqhEmail'] . "',";
		$tSQL .= " FTXqhTel = '" . $paCstData['FTXqhTel'] . "',";
		$tSQL .= " FTXqhFax = '" . $paCstData['FTXqhFax'] . "'";
		$tSQL .= " WHERE FTWorkerID='" . $paCstData['tWorkerID'] . "'";

		if ($paCstData['tDocNo'] != "") {

			$tSQL .= " AND FTXqhDocNo='" . $paCstData['tDocNo'] . "'";
		}

		$this->db->query($tSQL);
	}

	public function FCxMQUCheckDocNoExiting($ptWorkerID)
	{

		$tSQL = "SELECT ISNULL(FTXqhDocNo,'') AS FTXqhDocNo
				          FROM   TARTSqHDTmp WHERE FTWorkerID = '" . $ptWorkerID . "'";

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
				          FROM   TARTSqHD WHERE FTBchCode = '" . $tBchCode . "'";

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

	public function FCtMQUUpdateDocNo($ptDocNo, $pdDocDate, $ptBchCode, $ptWorkerId)
	{

		$tSQL = "UPDATE TARTSqHDTmp
				          SET    FTXqhDocNo = '" . $ptDocNo . "', FDXqhDocDate='" . $pdDocDate . "',FTBchCode = '" . $ptBchCode . "'
									WHERE  FTWorkerID = '" . $ptWorkerId . "'";

		$this->db->query($tSQL);

		$tSQL2 = "UPDATE TARTSqHDCstTmp
				          SET    FTXqhDocNo = '" . $ptDocNo . "'
									WHERE  FTWorkerID = '" . $ptWorkerId . "'";

		$this->db->query($tSQL2);

		$tSQL3 = "UPDATE TARTSqDTTmp
				          SET    FTXqhDocNo = '" . $ptDocNo . "'
									WHERE  FTWorkerID = '" . $ptWorkerId . "'";

		$this->db->query($tSQL3);
	}

	public function FCxMQUMoveTemp2HD($tDocNo, $tWorkerID)
	{

		$tSQLDel = "DELETE FROM TARTSqHD WHERE FTXqhDocNo = '" . $tDocNo . "'";
		$this->db->query($tSQLDel);

		$tSQL = "INSERT INTO TARTSqHD
									SELECT  FTBchCode
									      ,FTXqhDocNo
									      ,FDXqhDocDate
									      ,FTXqhCshOrCrd
									      ,FNXqhCredit
									      ,FTXqhVATInOrEx
									      ,FNXqhSmpDay
									      ,FDXqhEftTo
									      ,FDDeliveryDate
									      ,FTXqhStaExpress
									      ,ISNULL(FTXqhStaDoc,1)
									      ,FTXqhStaActive
									      ,FTXqhStaDeli
									      ,FTXqhPrjName
									      ,FTXqhPrjCodeRef
									      ,FCXqhB4Dis
									      ,FCXqhDis
									      ,FTXqhDisTxt
									      ,FCXqhAFDis
									      ,FCXqhVatRate
									      ,FCXqhAmtVat
									      ,FCXqhVatable
									      ,FCXqhGrand
									      ,ISNULL(FCXqhRnd,0)
									      ,FTXqhGndText
									      ,FTXqhRmk
									      ,FTUsrDep
									      ,FTApprovedBy
									      ,FDApproveDate
									      ,FTCreateBy
									      ,ISNULL(FDCreateOn,CONVERT(VARCHAR(16),GETDATE(),121))
									      ,$tWorkerID
									      ,CONVERT(VARCHAR(16),GETDATE(),121)
									  FROM TARTSqHDTmp
										WHERE FTWorkerID = '" . $tWorkerID . "'
										AND FTXqhDocNo = '" . $tDocNo . "'";
		//echo $tSQL;
		$this->db->query($tSQL);
	}

	public function FCxMQUMoveTempHDCst($tDocNo, $tWorkerID)
	{

		$tSQLDel = "DELETE FROM TARTSqHDCst WHERE FTXqhDocNo = '" . $tDocNo . "'";
		$this->db->query($tSQLDel);

		$tSQL = "INSERT INTO TARTSqHDCst
									SELECT   FTXqhDocNo
										      ,ISNULL(FTXqcCstCode,'')
										      ,FTXqcCstName
										      ,FTXqcAddress
										      ,FTXqhTaxNo
										      ,FTXqhContact
										      ,FTXqhEmail
										      ,FTXqhTel
										      ,FTXqhFax
										      ,ISNULL(FTCreateBy,$tWorkerID)
										      ,ISNULL(FDCreateOn,CONVERT(VARCHAR(16),GETDATE(),121))
										      ,$tWorkerID
										      ,CONVERT(VARCHAR(16),GETDATE(),121)
									  FROM TARTSqHDCstTmp
										WHERE FTWorkerID = '" . $tWorkerID . "'
										AND FTXqhDocNo = '" . $tDocNo . "'";
		//echo $tSQL;
		$this->db->query($tSQL);
	}

	public function FCxMQUMoveTemp2DT($tDocNo, $tWorkerID)
	{

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
										FTSplCode,
										FCXqdQty,
										ISNULL(FCXqdQty,0)  *  ISNULL(FCXqdUnitPrice,0),
										FCXqdDis,
										FTXqdDisTxt,
										(ISNULL(FCXqdQty,0)  *  ISNULL(FCXqdUnitPrice,0))-ISNULL(FCXqdDis,0),
										FCXqdFootAvg,
										((ISNULL(FCXqdQty,0)  *  ISNULL(FCXqdUnitPrice,0))-ISNULL(FCXqdDis,0)+ISNULL(FCXqdFootAvg,0)),
										ISNULL(FTCreateBy,$tWorkerID),
										ISNULL(FDCreateOn,CONVERT(VARCHAR(16),GETDATE(),121)),
										$tWorkerID,
										CONVERT(VARCHAR(16),GETDATE(),121)
										FROM TARTSqDTTmp
										WHERE FTWorkerID = '" . $tWorkerID . "'
										AND FTXqhDocNo = '" . $tDocNo . "'";

		$this->db->query($tSQL);
	}
}
