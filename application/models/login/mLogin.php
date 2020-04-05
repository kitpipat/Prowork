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
}
