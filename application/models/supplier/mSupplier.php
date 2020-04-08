<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mSupplier extends CI_Model {
	
	public function FSaMSUPGetData($paData){
		$aRowLen   		= FCNaHCallLenData($paData['nRow'],$paData['nPage']);
		$tTextSearch 	= trim($paData['tSearchAll']);
		$tSQL  = "SELECT c.* FROM(";
		$tSQL .= " SELECT  ROW_NUMBER() OVER(ORDER BY FTSplCode ASC) AS rtRowID,* FROM (";
		$tSQL .= " SELECT 
					SPL.FTSplCode,
					SPL.FTSplName,
					SPL.FTSplAddress,
					SPL.FTSplContact,
					SPL.FTSplTel,
					SPL.FTSplFax,
					SPL.FTSplEmail,
					SPL.FTSplPathImg,
					SPL.FTSplStaActive,
					SPL.FDLastUpdOn,
					SPL.FTLastUpdBy,
					SPL.FDCreateOn,
					SPL.FTCreateBy
 					FROM TCNMSpl SPL";
		$tSQL .= " WHERE 1=1 ";

		if($tTextSearch != '' || $tTextSearch != null){
			$tSQL .= " AND ( SPL.FTSplName LIKE '%$tTextSearch%' ";
			$tSQL .= " OR SPL.FTSplAddress LIKE '%$tTextSearch%' ";
			$tSQL .= " OR SPL.FTSplContact LIKE '%$tTextSearch%' ";
			$tSQL .= " OR SPL.FTSplTel LIKE '%$tTextSearch%' ";
			$tSQL .= " OR SPL.FTSplEmail LIKE '%$tTextSearch%' )";
		}

		$tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
			$oFoundRow 	= $this->FSaMSUPGetData_PageAll($paData);
			$nFoundRow 	= $oFoundRow[0]->counts;
			$nPageAll 	= ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
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
	public function FSaMSUPGetData_PageAll($paData){
		try{
			$tTextSearch = trim($paData['tSearchAll']);
			$tSQL 		= "SELECT COUNT (SPL.FTSplCode) AS counts FROM TCNMSpl SPL ";
			$tSQL 		.= " WHERE 1=1 ";
			if($tTextSearch != '' || $tTextSearch != null){
				$tSQL .= " AND ( SPL.FTSplName LIKE '%$tTextSearch%' ";
				$tSQL .= " OR SPL.FTSplAddress LIKE '%$tTextSearch%' ";
				$tSQL .= " OR SPL.FTSplContact LIKE '%$tTextSearch%' ";
				$tSQL .= " OR SPL.FTSplTel LIKE '%$tTextSearch%' ";
				$tSQL .= " OR SPL.FTSplEmail LIKE '%$tTextSearch%' )";
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

	//ข้อมูลสาขาทั้งหมด
	public function FSaMUSRGetBranch(){
		$tSQL = "SELECT * FROM TCNMBranch BCH";
		$tSQL .= " INNER JOIN TCNMCompany CMP ON BCH.FTCmpCode = CMP.FTCmpCode ";
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

	//ข้อมูลสิทธิ์ทั้งหมด
	public function FSaMUSRGetPermission(){
		$tSQL = "SELECT * FROM TCNMRoleHD ROL";
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

	//ข้อมูลกลุ่มราคาทั้งหมด
	public function FSaMUSRGetPriceGroup(){
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

	//หาผู้ใช้ล่าสุด
	public function FSaMUSRGetLastUsercode(){
		$tSQL = "SELECT TOP 1 FTUsrCode FROM TCNMUsr ORDER BY FTUsrCode * 1  DESC ";
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

	//เพิ่มผู้ใช้
	public function FSxMUSRInsert($aResult){
		try{
			$this->db->insert('TCNMUsr', $aResult);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//ลบผู้ใช้
	public function FSaMUSRDelete($ptCode){
		try{
			$this->db->where_in('FTUsrCode', $ptCode);
            $this->db->delete('TCNMUsr');
		}catch(Exception $Error){
            echo $Error;
        }
	}

	//หาผู้ใช้จาก ไอดี
	public function FSaMUSRGetDataUserBYID($ptCode){
		$tSQL = " SELECT USR.* , BCH.FTBchName FROM TCNMUsr USR";
		$tSQL .= " LEFT JOIN TCNMBranch BCH ON USR.FTBchCode = BCH.FTBchCode ";
		$tSQL .= " WHERE USR.FTUsrCode = '$ptCode' ";
		$oQuery = $this->db->query($tSQL);
		return $oQuery->result_array();
	}

	//แก้ไขข้อมูลผู้ใช้
	public function FSxMUSUpdate($ptSet,$ptWhere){
		try{
			$this->db->where('FTUsrCode', $ptWhere['FTUsrCode']);
			$this->db->update('TCNMUsr', $ptSet);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//ตรวจสอบ userlogin 
	public function FSaMUSRCheckUserLogin($ptUserLogin,$ptCode){
		$tSQL = " SELECT * FROM TCNMUsr USR";
		$tSQL .= " WHERE USR.FTUsrLogin = '$ptUserLogin' ";

		if($ptCode != ''){
			$tSQL .= " AND FTUsrCode NOT IN ('$ptCode')";
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
}
