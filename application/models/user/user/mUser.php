<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mUser extends CI_Model {
	
	public function FSaMUSRGetData(){
		$tSQL = "SELECT 
					USR.FTUsrImgPath,
					USR.FTUsrCode,
					USR.FTBchCode,
					USR.FTUsrFName,
					USR.FTUsrLName,
					USR.FTUsrDep,
					USR.FTUsrEmail,
					USR.FTUsrTel,
					USR.FNRhdID,
					USR.FNStaUse,
					USR.FTPriGrpID,
					RHD.FTRhdName,
					PRIG.FTPriGrpName,
					BCH.FTBchName FROM TCNMUsr USR";
		$tSQL .= " LEFT JOIN TCNMBranch BCH ON USR.FTBchCode = BCH.FTBchCode";
		$tSQL .= " LEFT JOIN TCNMRoleHD RHD ON RHD.FNRhdID = USR.FNRhdID";
		$tSQL .= " LEFT JOIN TCNMPriGrp PRIG ON PRIG.FTPriGrpID = USR.FTPriGrpID";

		$tSQL .= " WHERE USR.FNStaSysAdmin = 0 ";
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

	//ขอมูลสาขาทั้งหมด
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
}
