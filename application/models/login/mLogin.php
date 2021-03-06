<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mLogin extends CI_Model {
	
	public function FSaMCheckLogin($paData = []){
		$tUserlogin	 = $paData['tUserlogin']; 
		$tPassword	 = $paData['tPassword'];
		
		$tSQL = "SELECT USR.* ,
						BCH.FTBchName,
						CMP.FTCmpName 
					FROM TCNMUsr USR";
		$tSQL .= " LEFT JOIN TCNMBranch 	BCH  ON BCH.FTBchCode 	= USR.FTBchCode";
		$tSQL .= " LEFT JOIN TCNMCompany 	CMP  ON CMP.FTCmpCode 	= BCH.FTCmpCode";
		$tSQL .= " WHERE ";
		$tSQL .= " USR.FTUsrLogin = '$tUserlogin' AND ";
		$tSQL .= " USR.FTUsrPwd = '$tPassword' ";
		
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
	
	//เอาบริษัท Default
	public function FSaMGetCmpDefault(){
		$tSQL = "SELECT CMP.FTCmpName 
					FROM TCNMCompany CMP";
		$tSQL .= " WHERE ";
		$tSQL .= " CMP.FTCmpStaHQ = 1 ";
		
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

	//หาว่าเจอผู้ใช้กับ อีเมลล์ไหม
	public function FSaMCheckUserForgetPassword($paData = []){
		$tUserlogin	 = $paData['tUserlogin']; 
		$tEmail	 	 = $paData['tEmail']; 

		$tSQL = "SELECT FTUsrEmail , FTUsrPwd FROM TCNMUsr USR";
		$tSQL .= " WHERE ";
		$tSQL .= " USR.FTUsrLogin = '$tUserlogin' ";
		$tSQL .= " AND USR.FTUsrEmail = '$tEmail' ";
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

	//อัพเดท รหัสผ่านอีกครั้ง
	public function FSaMUpdateForgetPassword($aSet,$aWhere){
		try{
			$this->db->where('FTUsrEmail', $aWhere['FTUsrEmail']);
			$this->db->where('FTUsrLogin', $aWhere['FTUsrLogin']);
			$this->db->update('TCNMUsr', $aSet);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//ลบข้อมูลใน Temp วันที่น้อยกว่าปัจจุบัน
	public function FSaMDeleteDataInTemp(){
		$tDateNow = date('Y-m-d');

		$this->db->where('FDCreateOn <', $tDateNow);
		$this->db->delete('TARTPoDTTmp');

		$this->db->where('FDCreateOn <', $tDateNow);
		$this->db->delete('TARTPoHDTmp');

		$this->db->where('FDCreateOn <', $tDateNow);
		$this->db->delete('TARTSqDTTmp');

		$this->db->where('FDCreateOn <', $tDateNow);
		$this->db->delete('TARTSqHDCstTmp');

		$this->db->where('FDCreateOn <', $tDateNow);
		$this->db->delete('TARTSqHDTmp');

		$this->db->where('FDCreateOn <', $tDateNow);
		$this->db->delete('TCNTPdtAdjCostDTTmp');

		$this->db->where('FDXphDateAtv <', $tDateNow);
		$this->db->delete('TCNTPdtAdjPriDTTmp');
	}
}
