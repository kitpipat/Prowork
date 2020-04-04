<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mUser extends CI_Model {
	
	public function FSaMUSRGetData(){
		$tSQL = "SELECT * FROM TCNMUsr";
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
