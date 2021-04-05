<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mProduct extends CI_Model {
	
	public function FSaMPDTGetData($paData){
		$aRowLen   		= FCNaHCallLenData($paData['nRow'],$paData['nPage']);
		$tTextSearch 	= trim($paData['tSearchAll']);
		$aFilterAdv 	= $paData['aFilterAdv'];
		$tSQL  = "SELECT c.* FROM(";
		$tSQL .= " SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC) AS rtRowID,* FROM (";
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
						SPL.FTSplName,
						SQDT.FTPdtCode AS 'PDT_use'
					FROM TCNMPdt PDT 
					LEFT JOIN TCNMPdtBrand BAP 	ON PDT.FTPbnCode 	= BAP.FTPbnCode 
					LEFT JOIN TCNMPdtColor COP 	ON PDT.FTPClrCode 	= COP.FTPClrCode 
					LEFT JOIN TCNMPdtGrp GRP 	ON PDT.FTPgpCode 	= GRP.FTPgpCode 
					LEFT JOIN TCNMPdtModal MOL 	ON PDT.FTMolCode 	= MOL.FTMolCode 
					LEFT JOIN TCNMPdtSize SIZ 	ON PDT.FTPzeCode 	= SIZ.FTPzeCode 
					LEFT JOIN TCNMPdtType TYP 	ON PDT.FTPtyCode 	= TYP.FTPtyCode 
					LEFT JOIN TCNMPdtUnit UNIT 	ON PDT.FTPunCode 	= UNIT.FTPunCode 
					LEFT JOIN TCNMSpl SPL 		ON PDT.FTSplCode 	= SPL.FTSplCode 
					LEFT JOIN (
						SELECT DISTINCT FTPdtCode FROM TARTSqDT SQDT
					) SQDT ON PDT.FTPdtCode = SQDT.FTPdtCode";
		$tSQL .= " WHERE 1=1 ";

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
			$oFoundRow 	= $this->FSaMPDTGetData_PageAll($paData);
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
	public function FSaMPDTGetData_PageAll($paData){
		try{
			$tTextSearch 	= trim($paData['tSearchAll']);
			$aFilterAdv 	= $paData['aFilterAdv'];
			$tSQL 		= "SELECT COUNT (PDT.FTPdtCode) AS counts 
							FROM TCNMPdt PDT 
							LEFT JOIN TCNMPdtBrand BAP 	ON PDT.FTPbnCode 	= BAP.FTPbnCode 
							LEFT JOIN TCNMPdtColor COP 	ON PDT.FTPClrCode 	= COP.FTPClrCode 
							LEFT JOIN TCNMPdtGrp GRP 	ON PDT.FTPgpCode 	= GRP.FTPgpCode 
							LEFT JOIN TCNMPdtModal MOL 	ON PDT.FTMolCode 	= MOL.FTMolCode 
							LEFT JOIN TCNMPdtSize SIZ 	ON PDT.FTPzeCode 	= SIZ.FTPzeCode 
							LEFT JOIN TCNMPdtType TYP 	ON PDT.FTPtyCode 	= TYP.FTPtyCode 
							LEFT JOIN TCNMPdtUnit UNIT 	ON PDT.FTPunCode 	= UNIT.FTPunCode 
							LEFT JOIN TCNMSpl SPL 		ON PDT.FTSplCode 	= SPL.FTSplCode ";
			$tSQL 		.= " WHERE 1=1 ";

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

	//หาข้อมูลล่าสุด
	public function FSaMPDTCheckCodeDuplicate($ptCheckCode,$ptCode){
		$tSQL = " SELECT * FROM TCNMPdt PDT";
		$tSQL .= " WHERE PDT.FTPdtCode = '$ptCheckCode' ";

		if($ptCode != ''){
			$tSQL .= " AND FTPdtCode NOT IN ('$ptCode')";
		}

		$oQuery = $this->db->query($tSQL);
		if($oQuery->num_rows() > 0){
			$aResult = array(
				'rtCode'   => '1',
				'rtDesc'   => 'duplication',
			);
		}else{
			$aResult = array(
				'rtCode' => '800',
				'rtDesc' => 'pass',
			);
		}
		return $aResult;
	}

	//เพิ่ม
	public function FSxMPDTInsert($aResult){
		try{
			$this->db->insert('TCNMPdt', $aResult);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//ลบ
	public function FSaMPDTDelete($ptCode){
		try{
			$this->db->where_in('FTPdtCode', $ptCode);
            $this->db->delete('TCNMPdt');
		}catch(Exception $Error){
            echo $Error;
        }
	}

	//หาข้อมูลจาก ไอดี
	public function FSaMPDTGetDataBYID($ptCode){
		$tSQL = " SELECT 	PDT.* , 
							BAP.FTPbnName , COP.FTPClrName , 
							GRP.FTPgpName , MOL.FTMolName , 
							SIZ.FTPzeName , TYP.FTPtyName ,
							UNIT.FTPunName ,  SPL.FTSplName 
					FROM TCNMPdt PDT";
		$tSQL .= " 	LEFT JOIN TCNMPdtBrand BAP 		ON PDT.FTPbnCode 	= BAP.FTPbnCode 
					LEFT JOIN TCNMPdtColor COP 		ON PDT.FTPClrCode 	= COP.FTPClrCode 
					LEFT JOIN TCNMPdtGrp 	GRP 	ON PDT.FTPgpCode 	= GRP.FTPgpCode 
					LEFT JOIN TCNMPdtModal MOL 		ON PDT.FTMolCode 	= MOL.FTMolCode 
					LEFT JOIN TCNMPdtSize 	SIZ 	ON PDT.FTPzeCode 	= SIZ.FTPzeCode 
					LEFT JOIN TCNMPdtType 	TYP 	ON PDT.FTPtyCode 	= TYP.FTPtyCode 
					LEFT JOIN TCNMPdtUnit 	UNIT 	ON PDT.FTPunCode 	= UNIT.FTPunCode 
					LEFT JOIN TCNMSpl 		SPL 	ON PDT.FTSplCode 	= SPL.FTSplCode ";
		$tSQL .= " WHERE PDT.FTPdtCode = '$ptCode' ";
		$oQuery = $this->db->query($tSQL);
		return $oQuery->result_array();
	}

	//แก้ไขข้อมูล
	public function FSxMPDTUpdate($ptSet,$ptWhere){
		try{
			$this->db->where('FTPdtCode', $ptWhere['FTPdtCode']);
			$this->db->update('TCNMPdt', $ptSet);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//ตัวกรองค้นหา parameter คือตาราง
	public function FSaMPDTGetData_Filter($ptTableName){
		$tSQL = "SELECT * FROM $ptTableName ";

		switch ($ptTableName) {
			case "TCNMSpl":
				$tSQL .= " WHERE FTSplStaActive = 1 ";
				break;
			default:
				$tSQL .= " ";
		}

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

	//////////////////////////////////////////////////////////////////////// นำเข้ารูปภาพ */

	//นำเข้ารูปภาพ - เอาข้อมูลมาโชว์
	public function FSxMPDTImportImgPDTSelect(){
		$tSQL = " SELECT 
					PDTTmp.FTPdtCode,
					PDTTmp.FTPathImgTmp,
					PDT.FTPdtName
				FROM TCNMPdt_ImgTmp PDTTmp 
				LEFT JOIN TCNMPdt PDT ON PDT.FTPdtCode 	= PDTTmp.FTPdtCode";
		$tSQL .= " WHERE 1=1 ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aResult 	= array(
				'raItems'  		=> $oQuery->result_array(),
                'rtCode'   		=> '1',
                'rtDesc'   		=> 'success',
            );
        }else{
            $aResult = array(
                'rtCode' 		=> '800',
                'rtDesc' 		=> 'data not found',
            );
        }
        return $aResult;
	}

	//นำเข้ารูปภาพ - ลบรูปภาพ
	public function FSxMPDTImportImgPDTDelete(){
		try{
			$FTWorkerID = $this->session->userdata('tSesLogID');
			$this->db->where_in('FTWorkerID', $FTWorkerID);
			$this->db->delete('TCNMPdt_ImgTmp');
		}catch(Exception $Error){
            echo $Error;
        }
	}

	//นำเข้ารูปภาพ - เพิ่มลงในตาราง Tmp
	public function FSxMPDTImportImgPDTInsert($aResult){
		try{
			$this->db->insert('TCNMPdt_ImgTmp', $aResult);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//นำเข้ารูปภาพ - อัพเดทรูปภาพใหม่
	public function FSxMPDTImportImgPDTUpdate($ptSet,$ptWhere){
		try{
			$this->db->where('FTPdtCode', $ptWhere['FTPdtCode']);
			$this->db->update('TCNMPdt', $ptSet);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//////////////////////////////////////////////////////////////////////// นำเข้าข้อมูล */

	//นำเข้าข้อมูล - เพิ่มข้อมูล
	public function FSxMPDTImportExcelInsert($aResult){
		try{
			$this->db->insert('TCNMPdt_DataTmp', $aResult);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//นำเข้าข้อมูล - ลบข้อมูล
	public function FSxMPDTImportExcelDelete($ptWorkerID){
		try{
			$FTWorkerID = $ptWorkerID['FTWorkerID'];
			$this->db->where_in('FTWorkerID', $FTWorkerID);
			$this->db->delete('TCNMPdt_DataTmp');
		}catch(Exception $Error){
            echo $Error;
        }
	}

	//นำเข้าข้อมูล - โชว์ข้อมูล
	public function FSxMPDTImportExcelSelect(){
		$tSession  	= $this->session->userdata('tSesLogID');
		$tSQL = " SELECT 
				 	PDTTmp.FTPdtCode,
					PDTTmp.FTPdtName,
					PDTTmp.FTPgpCode,
					PDTTmp.FTPtyCode,
					PDTTmp.FTSplCode,
					PDTTmp.FCPdtCostStd,
					PDTTmp.FTPdtCostDis,
					PDTTmp.FTWorkerID,
					PDT.FTPdtCode as RealPDT,
					PDTGRP.FTPgpName,
					PDTTYP.FTPtyName,
					SPL.FTSplName,
					PDTTmp.FTPunCode,
					PDTTmp.FTPbnCode,
					BRAND.FTPbnName,
					UNIT.FTPunName,
					COLOR.FTPClrCode,
					COLOR.FTPClrName,
					MOL.FTMolCode,
					MOL.FTMolName,
					SIZ.FTPzeCode,
					SIZ.FTPzeName
			FROM TCNMPdt_DataTmp PDTTmp 
			LEFT JOIN TCNMPdt PDT			ON PDTTmp.FTPdtCode = PDT.FTPdtCode
			LEFT JOIN TCNMPdtGrp PDTGRP		ON PDTTmp.FTPgpCode = PDTGRP.FTPgpCode
			LEFT JOIN TCNMPdtType PDTTYP	ON PDTTmp.FTPtyCode = PDTTYP.FTPtyCode
			LEFT JOIN TCNMSpl SPL			ON PDTTmp.FTSplCode = SPL.FTSplCode
			LEFT JOIN TCNMPdtUnit UNIT		ON PDTTmp.FTPunCode = UNIT.FTPunCode
			LEFT JOIN TCNMPdtBrand BRAND	ON PDTTmp.FTPbnCode = BRAND.FTPbnCode
			LEFT JOIN TCNMPdtColor COLOR	ON PDTTmp.FTPClrCode= COLOR.FTPClrCode
			LEFT JOIN TCNMPdtModal MOL		ON PDTTmp.FTMolCode = MOL.FTMolCode
			LEFT JOIN TCNMPdtSize SIZ		ON PDTTmp.FTPzeCode = SIZ.FTPzeCode ";
		$tSQL .= " WHERE 1=1 ";
		$tSQL .= " AND FTWorkerID = '$tSession' ";
		$oQuery = $this->db->query($tSQL);
		if($oQuery->num_rows() > 0){
			$aResult 	= array(
				'raItems'  		=> $oQuery->result_array(),
				'rtCode'   		=> '1',
				'rtDesc'   		=> 'success',
			);
		}else{
			$aResult = array(
				'rtCode' 		=> '800',
				'rtDesc' 		=> 'data not found',
			);
		}
		return $aResult;
	}

	//นำเข้าข้อมูล - ย้ายข้อมูลจาก Tmp ไป ตารางจริง
	public function FSxMPDTImportExcelMoveTmpToHD($ptDataTmp,$ptNotIn){

		$FTWorkerID = $ptDataTmp['FTWorkerID'];
		$tSession  	= $this->session->userdata('tSesLogID');
		$tUserData  = $this->session->userdata('tSesUsercode');
		$dCurrent	= date('Y-m-d H:i:s');

		//Update ข้อมูลสินค้า ถ้าเป็นสินค้าตัวเดิม
		$tSQLUpdPDT = "	UPDATE
							TCNMPdt
						SET
							TCNMPdt.FTPdtCode 		= TCNMPdt_DataTmp.FTPdtCode,
							TCNMPdt.FTPdtName		= TCNMPdt_DataTmp.FTPdtName,
							TCNMPdt.FTPunCode		= TCNMPdt_DataTmp.FTPunCode,
							TCNMPdt.FTPgpCode		= TCNMPdt_DataTmp.FTPgpCode,
							TCNMPdt.FTPtyCode		= TCNMPdt_DataTmp.FTPtyCode,
							TCNMPdt.FTPbnCode		= TCNMPdt_DataTmp.FTPbnCode,
							TCNMPdt.FTPzeCode		= TCNMPdt_DataTmp.FTPzeCode,
							TCNMPdt.FTPClrCode		= TCNMPdt_DataTmp.FTPClrCode,
							TCNMPdt.FTSplCode		= TCNMPdt_DataTmp.FTSplCode,
							TCNMPdt.FTMolCode		= TCNMPdt_DataTmp.FTMolCode,
							TCNMPdt.FCPdtCostStd	= TCNMPdt_DataTmp.FCPdtCostStd,
							TCNMPdt.FTPdtCostDis	= TCNMPdt_DataTmp.FTPdtCostDis,
							TCNMPdt.FTUpdateBy		= '$tUserData',
							TCNMPdt.FDUpdateOn		= '$dCurrent'
						FROM
							TCNMPdt AS TCNMPdt
							INNER JOIN TCNMPdt_DataTmp AS TCNMPdt_DataTmp ON TCNMPdt.FTPdtCode = TCNMPdt_DataTmp.FTPdtCode
						WHERE
						FTWorkerID = '$FTWorkerID' ";
		if($ptNotIn != ''){
			$tNotInPDT 		= ' AND TCNMPdt_DataTmp.FTPdtCode NOT IN ('.$ptNotIn.')';
			$tSQLUpdPDT    .= $tNotInPDT;
		}
		$this->db->query($tSQLUpdPDT);

		//Update ต้นทุน ถ้าเป็นสินค้าตัวเดิม
		// $tBCH = $this->session->userdata('tSesBCHCode');
		// $tSQLUpdCost = "UPDATE
		// 					A
		// 				SET 
		// 					A.FCPdtCost			= B.FCCostAfDis,	
		// 					A.FCPdtCostStd		= B.FCPdtCostStd,
		// 					A.FTPdtCostDis		= B.FTPdtCostDis
		// 				FROM
		// 					TCNTPdtCost AS A
		// 					INNER JOIN TCNMPdt_DataTmp AS B ON A.FTPdtCode = B.FTPdtCode
		// 				WHERE
		// 					B.FTWorkerID = '$FTWorkerID' AND ISNULL(A.FDCosActive,'') = '' ";
		// if($ptNotIn != ''){
		// 	$tNotInCost     = ' AND B.FTPdtCode NOT IN ('.$ptNotIn.')';
		// 	$tSQLUpdCost   .= $tNotInCost;
		// }
		// $this->db->query($tSQLUpdCost);

		//Insert ต้นทุน ถ้าเป็นสินค้าตัวเดิม
		$tSQLInsertCost = "INSERT INTO TCNTPdtCost (
								FTPdtCode ,
								FCPdtCost ,
								FDCosActive ,
								FCPdtCostStd ,
								FTPdtCostDis 
							)
							SELECT 
								DISTINCT
									A.FTPdtCode ,
									A.FCCostAfDis ,
									'$dCurrent',
									A.FCPdtCostStd ,
									A.FTPdtCostDis
							FROM 
								TCNMPdt_DataTmp A 
								LEFT JOIN TCNTPdtCost B ON A.FTPdtCode = B.FTPdtCode
							WHERE 
								A.FTWorkerID = '$FTWorkerID' AND ISNULL(B.FTPdtCode,'') != '' ";
		$this->db->query($tSQLInsertCost);

		//############################################################//
			
		//Move (Insert) ข้อมูลสินค้า ถ้าไป left join แล้วไม่เจอ จะถือว่าเป็นการ insert
		$tSQLMove = "INSERT INTO TCNMPdt (
					FTPdtCode
					,FTBchCode
					,FTPdtName
					,FTPdtNameOth
					,FTPdtDesc
					,FTPunCode
					,FTPgpCode
					,FTPtyCode
					,FTPbnCode
					,FTPzeCode
					,FTPClrCode
					,FTSplCode
					,FTMolCode
					,FCPdtCostStd
					,FTPdtCostDis
					,FCPdtSalPrice
					,FTPdtImage
					,FTPdtStatus
					,FTCreateBy
					,FDCreateOn
					,FTPdtReason 
				)
				SELECT 
					A.FTPdtCode
					,'' AS FTBchCode
					,A.FTPdtName
					,'' AS FTPdtNameOth
					,'' AS FTPdtDesc
					,A.FTPunCode
					,A.FTPgpCode
					,A.FTPtyCode
					,A.FTPbnCode
					,A.FTPzeCode
					,A.FTPClrCode 
					,A.FTSplCode
					,A.FTMolCode
					,A.FCPdtCostStd
					,A.FTPdtCostDis
					,0 AS FCPdtSalPrice
					,'' AS FTPdtImage
					,1 AS FTPdtStatus
					,$tUserData
					,'$dCurrent'
					,'' AS FTPdtReason
				FROM TCNMPdt_DataTmp A
				LEFT JOIN TCNMPdt B ON A.FTPdtCode = B.FTPdtCode
				WHERE A.FTWorkerID = '$FTWorkerID' AND ISNULL(B.FTPdtCode,'') = '' ";

		if($ptNotIn != ''){
			$tNotIn 	= ' AND A.FTPdtCode NOT IN ('.$ptNotIn.')';
			$tSQLMove  .= $tNotIn;
		}
		$this->db->query($tSQLMove);

		//Move (Insert) ต้นทุน ข้อมูลสินค้า
		$tBCH = $this->session->userdata('tSesBCHCode');
		$tSQLCost = "INSERT INTO TCNTPdtCost (
						FTBchCode
						,FTPdtCode
						,FCPdtCost
						,FDCosActive
						,FCPdtCostStd
						,FTPdtCostDis
					)
					SELECT 
						'$tBCH' AS FTBchCode
						,A.FTPdtCode
						,A.FCCostAfDis AS FCPdtCost
						,NULL AS FDCosActive
						,A.FCPdtCostStd AS FCPdtCostStd
						,A.FTPdtCostDis AS FTPdtCostDis
					FROM TCNMPdt_DataTmp A
					LEFT JOIN TCNTPdtCost B ON A.FTPdtCode = B.FTPdtCode
					WHERE A.FTWorkerID = '$FTWorkerID' AND ISNULL(B.FTPdtCode,'') = '' ";
		if($ptNotIn != ''){
			$tNotIn = ' AND A.FTPdtCode NOT IN ('.$ptNotIn.')';
			$tSQLCost .= $tNotIn;
		}
		$this->db->query($tSQLCost);
	}

	//นำเข้าข้อมูล - ลบข้อมูล 
	public function FSxMPDTImportExcelDeleteTmp(){
		try{
			$FTWorkerID = $this->session->userdata('tSesLogID');
			$this->db->where_in('FTWorkerID', $FTWorkerID);
			$this->db->delete('TCNMPdt_DataTmp');
		}catch(Exception $Error){
            echo $Error;
        }
	}

	//เช็คสินค้าห้ามซ้ำใน Tmp
	public function FSxMPDTCheckPDTInTmp($pnCode){
		$FTWorkerID = $this->session->userdata('tSesLogID');
		$tSQL = " SELECT * FROM TCNMPdt_DataTmp TMP ";
		$tSQL .= " WHERE TMP.FTPdtCode = '$pnCode' ";
		$tSQL .= " AND TMP.FTWorkerID = '$FTWorkerID' ";
	
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

	//หาส่วนลดต้นทุนล่าสุด
	public function FSaMPDTFindDiscountCost($tCode){
		$tSQL = " SELECT C.* FROM (
					SELECT 
						HD.FDXphDStart,
						DT.FTXpdDisCost,
						DT.FTPdtCode,
						ROW_NUMBER() OVER (PARTITION BY FTPdtCode ORDER BY FDXphDStart DESC) AS FNPriorityNo
					FROM TCNTPdtAdjCostHD HD
					INNER JOIN TCNTPdtAdjCostDT DT ON HD.FTXphDocNo = DT.FTXphDocNo
					WHERE FDXphDStart <= GETDATE() AND DT.FTPdtCode = '$tCode'
				) C
				WHERE C.FNPriorityNo = 1";
				$oQuery = $this->db->query($tSQL);
		if($oQuery->num_rows() > 0){
			$aResult = array(
				'rtCode'   => '1',
				'tResult'  => $oQuery->result_array()
			);
		}else{
			$aResult = array(
				'rtCode' 	=> '800',
				'rtDesc' 	=> 'not Found'
			);
		}
		return $aResult;
	}

	//หาขายบวกเพิ่มจากต้นทุน (%)
	public function FSaMPDTFindAddPri($tCode){
		$tSQL = " SELECT C.* FROM (
					SELECT 
						HD.FDXphDateAtv,
						DT.FCXpdAddPri,
						DT.FTPdtCode,
						ROW_NUMBER() OVER (PARTITION BY FTPdtCode ORDER BY HD.FDXphDateAtv DESC) AS FNPriorityNo
					FROM TCNTPdtAdjPriHD HD
					INNER JOIN TCNTPdtAdjPriDT DT ON HD.FTXphDocNo = DT.FTXphDocNo
					WHERE HD.FDXphDateAtv <= GETDATE() AND DT.FTPdtCode = '$tCode'
				) C
				WHERE C.FNPriorityNo = 1";
				$oQuery = $this->db->query($tSQL);
		if($oQuery->num_rows() > 0){
			$aResult = array(
				'rtCode'   => '1',
				'tResult'  => $oQuery->result_array()
			);
		}else{
			$aResult = array(
				'rtCode' 	=> '800',
				'rtDesc' 	=> 'not Found'
			);
		}
		return $aResult;
	}

	//หาต้นทุนหลังหักส่วนลด
	public function FSaMPDTFindProductCostPrice($paPacData){
		$tPDTCode 		= $paPacData['PDTCode'];
		$tPriceGroup 	= $paPacData['PriceGroup'];

		$tSQL = " SELECT * FROM VCN_ProductsDetail WHERE FTPdtCode = '$tPDTCode' AND (FTPriGrpID = '$tPriceGroup' OR FTPriGrpID = '') ";
		$oQuery = $this->db->query($tSQL);
		if($oQuery->num_rows() > 0){
			$aResult = array(
				'rtCode'   => '1',
				'tResult'  => $oQuery->result_array()
			);
		}else{
			$aResult = array(
				'rtCode' 	=> '800',
				'rtDesc' 	=> 'not Found'
			);
		}
		return $aResult;
	}

	//เช็ครหัสซ้ำ ในส่วนประกอบของสินค้า
	public function FSaMPDTCheckCode($pnFiled,$ptTableName,$ptValue){
		$tSQL = " SELECT TOP 1 $pnFiled FROM $ptTableName WHERE $pnFiled = '$ptValue' ";
		$tSQL .= " ORDER BY $pnFiled DESC";

		$oQuery = $this->db->query($tSQL);
		if($oQuery->num_rows() > 0){
			$aResult = array(
				'rtCode'   => '1',
				'tResult'  => $oQuery->result_array()
			);
		}else{
			$aResult = array(
				'rtCode' 	=> '800',
				'rtDesc' 	=> 'not Found'
			);
		}
		return $aResult;
	}

	//เลือก พวก option ต่างๆ 
	public function FSaMPDTAttrGetItem($paData){
		$aRowLen  		= FCNaHCallLenData($paData['nRow'], $paData['nPage']);
		$tTextSearch 	= trim($paData['tSearch']);

		switch ($paData['tName']) {
			case "brand":
				$tTable 	= "TCNMPdtBrand";
				$tOrderBy 	= "FTPbnCode";
				$tActive 	= "";
				$tSearch 	= " AND ( ATTR.FTPbnCode LIKE '%$tTextSearch%' OR ATTR.FTPbnName LIKE '%$tTextSearch%' ) ";
				break;
			case "color":
				$tTable 	= "TCNMPdtColor";
				$tOrderBy 	= "FTPClrCode";
				$tActive 	= "";
				$tSearch 	= " AND ( ATTR.FTPClrCode LIKE '%$tTextSearch%' OR ATTR.FTPClrName LIKE '%$tTextSearch%' ) ";
				break;
			case "group":
				$tTable 	= "TCNMPdtGrp";
				$tOrderBy 	= "FTPgpCode";
				$tActive 	= "";
				$tSearch 	= " AND ( ATTR.FTPgpCode LIKE '%$tTextSearch%' OR ATTR.FTPgpName LIKE '%$tTextSearch%' ) ";
				break;
			case "modal":
				$tTable 	= "TCNMPdtModal";
				$tOrderBy 	= "FTMolCode";
				$tActive 	= "";
				$tSearch 	= " AND ( ATTR.FTMolCode LIKE '%$tTextSearch%' OR ATTR.FTMolName LIKE '%$tTextSearch%' ) ";
				break;
			case "size":
				$tTable 	= "TCNMPdtSize";
				$tOrderBy 	= "FTPzeCode";
				$tActive 	= "";
				$tSearch 	= " AND ( ATTR.FTPzeCode LIKE '%$tTextSearch%' OR ATTR.FTPzeName LIKE '%$tTextSearch%' ) ";
				break;
			case "unit":
				$tTable 	= "TCNMPdtUnit";
				$tOrderBy 	= "FTPunCode";
				$tActive 	= "";
				$tSearch 	= " AND ( ATTR.FTPunCode LIKE '%$tTextSearch%' OR ATTR.FTPunName LIKE '%$tTextSearch%' ) ";
				break;
			case "type":
				$tTable 	= "TCNMPdtType";
				$tOrderBy 	= "FTPtyCode";
				$tActive 	= "";
				$tSearch 	= " AND ( ATTR.FTPtyCode LIKE '%$tTextSearch%' OR ATTR.FTPtyName LIKE '%$tTextSearch%' ) ";
				break;
			case "spl":
				$tTable 	= "TCNMSpl";
				$tOrderBy 	= "FTSplCode";
				$tActive 	= " AND ATTR.FTSplStaActive = 1 ";
				$tSearch 	= " AND ( ATTR.FTSplCode LIKE '%$tTextSearch%' OR ATTR.FTSplName LIKE '%$tTextSearch%' OR ATTR.FTSplTel LIKE '%$tTextSearch%' OR ATTR.FTSplContact LIKE '%$tTextSearch%' ) ";
				break;
			default:
				$tTable 	= "";
				$tOrderBy 	= "";
				$tActive 	= "";
				$tSearch 	= "";
		}

		$tSQL  = "SELECT c.* FROM(";
		$tSQL .= " SELECT  ROW_NUMBER() OVER(ORDER BY $tOrderBy ASC) AS rtRowID,* FROM (";
		$tSQL .= " SELECT * FROM $tTable ATTR ";
		$tSQL .= " WHERE 1=1 ";

		//สถานะใช้งาน
		if($tActive == ''){
			$tSQL .= "";
		}else{
			$tSQL .= $tActive;
		}

		//ค้นหาธรรมดา
		if ($tTextSearch != '' || $tTextSearch != null) {
			$tSQL .= $tSearch;
		}

		$tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
		$oQuery = $this->db->query($tSQL);
		if ($oQuery->num_rows() > 0) {
			$oFoundRow 	= $this->FCxPDTAttrGetItem_PageAll($paData);
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

	public function FCxPDTAttrGetItem_PageAll($paData){
		try {
			$tTextSearch 	= trim($paData['tSearch']);

			switch ($paData['tName']) {
				case "brand":
					$tTable 	= "TCNMPdtBrand";
					$tOrderBy 	= "FTPbnCode";
					$tActive 	= "";
					$tSearch 	= " AND ( ATTR.FTPbnCode LIKE '%$tTextSearch%' OR ATTR.FTPbnName LIKE '%$tTextSearch%' ) ";
					break;
				case "color":
					$tTable 	= "TCNMPdtColor";
					$tOrderBy 	= "FTPClrCode";
					$tActive 	= "";
					$tSearch 	= " AND ( ATTR.FTPClrCode LIKE '%$tTextSearch%' OR ATTR.FTPClrName LIKE '%$tTextSearch%' ) ";
					break;
				case "group":
					$tTable 	= "TCNMPdtGrp";
					$tOrderBy 	= "FTPgpCode";
					$tActive 	= "";
					$tSearch 	= " AND ( ATTR.FTPgpCode LIKE '%$tTextSearch%' OR ATTR.FTPgpName LIKE '%$tTextSearch%' ) ";
					break;
				case "modal":
					$tTable 	= "TCNMPdtModal";
					$tOrderBy 	= "FTMolCode";
					$tActive 	= "";
					$tSearch 	= " AND ( ATTR.FTMolCode LIKE '%$tTextSearch%' OR ATTR.FTMolName LIKE '%$tTextSearch%' ) ";
					break;
				case "size":
					$tTable 	= "TCNMPdtSize";
					$tOrderBy 	= "FTPzeCode";
					$tActive 	= "";
					$tSearch 	= " AND ( ATTR.FTPzeCode LIKE '%$tTextSearch%' OR ATTR.FTPzeName LIKE '%$tTextSearch%' ) ";
					break;
				case "unit":
					$tTable 	= "TCNMPdtUnit";
					$tOrderBy 	= "FTPunCode";
					$tActive 	= "";
					$tSearch 	= " AND ( ATTR.FTPunCode LIKE '%$tTextSearch%' OR ATTR.FTPunName LIKE '%$tTextSearch%' ) ";
					break;
				case "type":
					$tTable 	= "TCNMPdtType";
					$tOrderBy 	= "FTPtyCode";
					$tActive 	= "";
					$tSearch 	= " AND ( ATTR.FTPtyCode LIKE '%$tTextSearch%' OR ATTR.FTPtyName LIKE '%$tTextSearch%' ) ";
					break;
				case "spl":
					$tTable 	= "TCNMSpl";
					$tOrderBy 	= "FTSplCode";
					$tActive 	= " AND ATTR.FTSplStaActive = 1 ";
					$tSearch 	= " AND ( ATTR.FTSplCode LIKE '%$tTextSearch%' OR ATTR.FTSplName LIKE '%$tTextSearch%' OR ATTR.FTSplTel LIKE '%$tTextSearch%' OR ATTR.FTSplContact LIKE '%$tTextSearch%' ) ";
					break;
				default:
					$tTable 	= "";
					$tOrderBy 	= "";
			}

			$tSQL 			= "SELECT COUNT (ATTR.$tOrderBy) AS counts FROM $tTable ATTR  ";
			$tSQL 			.= " WHERE 1=1 ";

			//สถานะใช้งาน
			if($tActive == ''){
				$tSQL .= "";
			}else{
				$tSQL .= $tActive;
			}

			//ค้นหาธรรมดา
			if ($tTextSearch != '' || $tTextSearch != null) {
				$tSQL .= $tSearch;
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

	//ลบข้อมูลในตาราง temp
	public function FSxMPDTDeleteDataInTemp($paData){
		try{
			$FTWorkerID = $this->session->userdata('tSesLogID');
			$this->db->where_in('FTPdtCode', trim($paData['FTPdtCode']));
			$this->db->where_in('FTWorkerID', $FTWorkerID);
            $this->db->delete('TCNMPdt_DataTmp');
		}catch(Exception $Error){
            echo $Error;
        }
	}
}
