<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mLogin extends CI_Model {
	
	public function FSaMCheckLogin($paData = []){
		$tUserlogin	 = $paData['tUserlogin']; 
		$tPassword	 = $paData['tPassword'];
		
		$tSQL = "SELECT * FROM TCNMUsr";
		$tSQL .= " WHERE ";
		$tSQL .= " FTUsrLogin = '$tUserlogin' AND ";
		$tSQL .= " FTUsrPwd = '$tPassword' ";
		
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
