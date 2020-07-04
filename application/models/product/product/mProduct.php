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
		$tSQL = " SELECT * FROM TCNMPdt PDT";
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
					SPL.FTSplName
			FROM TCNMPdt_DataTmp PDTTmp 
			LEFT JOIN TCNMPdt PDT			ON PDTTmp.FTPdtCode = PDT.FTPdtCode
			LEFT JOIN TCNMPdtGrp PDTGRP	ON PDTTmp.FTPgpCode = PDTGRP.FTPgpCode
			LEFT JOIN TCNMPdtType PDTTYP	ON PDTTmp.FTPtyCode = PDTTYP.FTPtyCode
			LEFT JOIN TCNMSpl SPL			ON PDTTmp.FTSplCode = SPL.FTSplCode";
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

		//Move สินค้า
		$tSQL = "INSERT INTO TCNMPdt (
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
					FTPdtCode
					,'' AS FTBchCode
					,FTPdtName
					,'' AS FTPdtNameOth
					,'' AS FTPdtDesc
					,'' AS FTPunCode
					,FTPgpCode
					,FTPtyCode
					,'' AS FTPbnCode
					,'' AS FTPzeCode
					,'' AS FTPClrCode
					,FTSplCode
					,'' AS FTMolCode
					,FCPdtCostStd
					,FTPdtCostDis
					,0 AS FCPdtSalPrice
					,'' AS FTPdtImage
					,1 AS FTPdtStatus
					,$tUserData
					,'$dCurrent'
					,'' AS FTPdtReason
				FROM TCNMPdt_DataTmp
				WHERE FTWorkerID = '$FTWorkerID' ";

		if($ptNotIn != ''){
			$tNotIn = ' AND TCNMPdt_DataTmp.FTPdtCode NOT IN ('.$ptNotIn.')';
			$tSQL .= $tNotIn;
		}

		$this->db->query($tSQL);

		//Move ต้นทุน
		$tBCH = $this->session->userdata('tSesBCHCode');
		$tSQLCost = "INSERT INTO TCNTPdtCost (
					FTBchCode
					,FTPdtCode
					,FCPdtCost
					,FDCosActive
				)
				SELECT 
					'$tBCH' AS FTBchCode
					,FTPdtCode
					,FCCostAfDis AS FCPdtCost
					,NULL AS FDCosActive
				FROM TCNMPdt_DataTmp
				WHERE FTWorkerID = '$FTWorkerID' ";
		if($ptNotIn != ''){
			$tNotIn = ' AND TCNMPdt_DataTmp.FTPdtCode NOT IN ('.$ptNotIn.')';
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
}
