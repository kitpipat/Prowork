<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mGroupproduct extends CI_Model {
	
	public function FSaMGRPGetData($paData){
		$aRowLen   		= FCNaHCallLenData($paData['nRow'],$paData['nPage']);
		$tTextSearch 	= trim($paData['tSearchAll']);
		$tSQL  = "SELECT c.* FROM(";
		$tSQL .= " SELECT  ROW_NUMBER() OVER(ORDER BY FTPgpCode DESC) AS rtRowID,* FROM (";
		$tSQL .= " SELECT 
					DISTINCT
						GRP.FTPgpCode , 
						GRP.FTPgpName ,
						PDT.FTPgpCode AS 'PDT_use' ,
						BAN.FTPbnName
					FROM TCNMPdtGrp GRP 
					LEFT JOIN TCNMPdt PDT ON PDT.FTPgpCode = GRP.FTPgpCode
					LEFT JOIN TCNMPdtBrand BAN ON GRP.FTPbnCode = BAN.FTPbnCode  ";
		$tSQL .= " WHERE 1=1 ";

		if($tTextSearch != '' || $tTextSearch != null){
			$tSQL .= " AND ( GRP.FTPgpCode LIKE '%$tTextSearch%' ";
			$tSQL .= " OR GRP.FTPgpName LIKE '%$tTextSearch%' ";
			$tSQL .= " OR BAN.FTPbnName LIKE '%$tTextSearch%' ";
			$tSQL .= " OR BAN.FTPbnCode LIKE '%$tTextSearch%' )";
		}

		$tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
			$oFoundRow 	= $this->FSaMGRPGetData_PageAll($paData);
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
	public function FSaMGRPGetData_PageAll($paData){
		try{
			$tTextSearch = trim($paData['tSearchAll']);
			$tSQL 		= "SELECT COUNT (GRP.FTPgpCode) AS counts FROM TCNMPdtGrp GRP LEFT JOIN TCNMPdtBrand BAN ON GRP.FTPbnCode = BAN.FTPbnCode ";
			$tSQL 		.= " WHERE 1=1 ";
			if($tTextSearch != '' || $tTextSearch != null){
				$tSQL .= " AND ( GRP.FTPgpCode LIKE '%$tTextSearch%' ";
				$tSQL .= " OR GRP.FTPgpName LIKE '%$tTextSearch%' ";
				$tSQL .= " OR BAN.FTPbnName LIKE '%$tTextSearch%' ";
				$tSQL .= " OR BAN.FTPbnCode LIKE '%$tTextSearch%' )";
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
	public function FSaMGRPGetLastGroupPDTcode(){
		$tSQL = "SELECT TOP 1 FTPgpCode FROM TCNMPdtGrp ORDER BY FTPgpCode DESC ";
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

	//เพิ่ม
	public function FSxMGRPInsert($aResult){
		try{
			$this->db->insert('TCNMPdtGrp', $aResult);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//ลบ
	public function FSaMGRPDelete($ptCode){
		try{
			$this->db->where_in('FTPgpCode', $ptCode);
            $this->db->delete('TCNMPdtGrp');
		}catch(Exception $Error){
            echo $Error;
        }
	}

	//หาข้อมูลจาก ไอดี
	public function FSaMGRPGetDataGroupProductBYID($ptCode){
		$tSQL = " SELECT GRP.* , BAN.FTPbnName , BAN.FTPbnCode FROM TCNMPdtGrp GRP LEFT JOIN TCNMPdtBrand BAN ON GRP.FTPbnCode = BAN.FTPbnCode ";
		$tSQL .= " WHERE GRP.FTPgpCode = '$ptCode' ";
		$oQuery = $this->db->query($tSQL);
		return $oQuery->result_array();
	}

	//แก้ไขข้อมูล
	public function FSxMGRPUpdate($ptSet,$ptWhere){
		try{
			$this->db->where('FTPgpCode', $ptWhere['FTPgpCode']);
			$this->db->update('TCNMPdtGrp', $ptSet);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//โหลดข้อมูลยี่ห้อในกลุ่ม
	public function FSaMGRPGetDataBrandInGroup($tGroupCode){
		$tSQL 		= "SELECT TRN.* , BAN.FTPbnName FROM TCNMBrandInGroup TRN ";
		$tSQL 		.= " LEFT JOIN TCNMPdtBrand BAN ON TRN.FTPbnCode = BAN.FTPbnCode ";
		$tSQL 		.= " WHERE 1=1 AND TRN.FTPgpCode = '$tGroupCode' ";
		
		$oQuery = $this->db->query($tSQL);
		if($oQuery->num_rows() > 0){
            $aResult 	= array(
				'raItems'  		=> $oQuery->result_array(),
				'rnAllRow'      => $oQuery->num_rows(),
                'rtCode'   		=> '1',
                'rtDesc'   		=> 'success',
            );
        }else{
            $aResult = array(
				'rnAllRow' 		=> 0,
                'rtCode' 		=> '800',
                'rtDesc' 		=> 'data not found',
            );
        }
        return $aResult;
	}

	//เพิ่มข้อมูลยี่ห้อในกลุ่ม
	public function FSxMGRPInsertBrandInGroup($aResult){
		try{
			$this->db->insert('TCNMBrandInGroup', $aResult);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//เลือก พวก option ต่างๆ 
	public function FSaMPDTAttrGetItemBrandInGroup($paData){
		$aRowLen  		= FCNaHCallLenData($paData['nRow'], $paData['nPage']);
		$tTextSearch 	= trim($paData['tSearch']);
		$tGroupCode		= $paData['tGroupCode'];

		$tSQL  = "SELECT c.* FROM(";
		$tSQL .= " SELECT  ROW_NUMBER() OVER(ORDER BY FTPbnCode ASC) AS rtRowID,* FROM (";
		$tSQL .= " SELECT BAN.* FROM TCNMPdtBrand BAN 
				   LEFT JOIN TCNMBrandInGroup TRN ON BAN.FTPbnCode = TRN.FTPbnCode AND TRN.FTPgpCode = '$tGroupCode' ";
		$tSQL .= " WHERE 1=1 AND ISNULL(TRN.FTPgpCode,'') = '' ";

		//ค้นหาธรรมดา
		if ($tTextSearch != '' || $tTextSearch != null) {
			$tSQL .= " AND ( BAN.FTPbnCode LIKE '%$tTextSearch%' OR BAN.FTPbnName LIKE '%$tTextSearch%' ) ";
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
			$tGroupCode		= $paData['tGroupCode'];

			$tSQL  = "	SELECT
							COUNT(BAN.FTPbnCode) AS counts
						FROM
							TCNMPdtBrand BAN
						LEFT JOIN TCNMBrandInGroup TRN ON BAN.FTPbnCode = TRN.FTPbnCode AND TRN.FTPgpCode = '$tGroupCode'
						WHERE 1 = 1 AND ISNULL(TRN.FTPgpCode,'') = '' ";

			//ค้นหาธรรมดา
			if ($tTextSearch != '' || $tTextSearch != null) {
				$tSQL .= " AND ( BAN.FTPbnCode LIKE '%$tTextSearch%' OR BAN.FTPbnName LIKE '%$tTextSearch%' ) ";
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

	//ลบยี่ห้อในกลุ่ม
	public function FSaMGRPDeleteBrandInGroup($ptCode){
		try{
			$this->db->where_in('FTTrnCode', $ptCode);
            $this->db->delete('TCNMBrandInGroup');
		}catch(Exception $Error){
            echo $Error;
        }
	}

	//แก้ไขข้อมูลยี่ห้อในกลุ่ม
	public function FSxMGRPUpdateBrandInGroup($ptSet,$ptWhere){
		try{
			$this->db->where('FTTrnCode', $ptWhere['FTTrnCode']);
			$this->db->where('FTPgpCode', $ptWhere['FTPgpCode']);
			$this->db->update('TCNMBrandInGroup', $ptSet);
		}catch(Exception $Error){
			echo $Error;
		}
	}

}
