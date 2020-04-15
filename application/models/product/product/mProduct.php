<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mProduct extends CI_Model {
	
	public function FSaMPDTGetData($paData){
		$aRowLen   		= FCNaHCallLenData($paData['nRow'],$paData['nPage']);
		$tTextSearch 	= trim($paData['tSearchAll']);
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
					";
		$tSQL .= " WHERE 1=1 ";

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
			$tTextSearch = trim($paData['tSearchAll']);
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
			$FTWorkerID = $this->session->userdata('tSesUsercode');
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

	//น้ำเข้าข้อมูล - เพิ่มข้อมูล
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
}
