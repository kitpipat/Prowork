<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mUser extends CI_Model {
	
	public function FSaMUSRGetData(){
		$tSQL = "SELECT 
					USR.FTUsrCode,
					USR.FTBchCode,
					USR.FTUsrFName,
					USR.FTUsrLName,
					USR.FTUsrDep,
					USR.FTUsrEmail,
					USR.FTUsrTel,
					USR.FNRhdID,
					USR.FNPirGrpID,
					BCH.FTBchName FROM TCNMUsr USR";
		$tSQL .= " LEFT JOIN TCNMBranch BCH ON USR.FTBchCode = BCH.FTBchCode";
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
	
}
