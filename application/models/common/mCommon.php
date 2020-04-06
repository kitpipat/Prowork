<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCommon extends CI_Model {
	
	public function FSaMGetListMenu($pnUserCode){
		$tSQL = "SELECT 
				USR.FTUsrCode,
				USR.FTBchCode,
				USR.FTUsrFName,
				USR.FTUsrLName,
				USR.FTUsrDep,
				USR.FTUsrEmail,
				USR.FTUsrTel,
				USR.FTUsrImgPath,
				USR.FTUsrRmk,
				USR.FNRhdID,
				USR.FTPriGrpID,
				ROHD.FTRhdName,
				MENU.FTMenName, 
				MENU.FNMenID AS CodeMenu,
				MENU.FNMegID AS CodeGroup,
				MENU.FTPathIcon AS MenuIcon,
				MGRP.FTMegName AS NameGroup,
				MGRP.FTPathIcon AS GroupIcon,
				MENU.FTPathRoute AS PathRoute
			FROM TCNMUsr USR
			LEFT JOIN TCNMRoleHD 	ROHD ON USR.FNRhdID 	= ROHD.FNRhdID
			LEFT JOIN TCNMRoleDT 	RODT ON ROHD.FNRhdID 	= RODT.FNRhdID
			LEFT JOIN TSysMenu 		MENU ON MENU.FNMenID 	= RODT.FNMenID
			LEFT JOIN TSysMenuGrp 	MGRP ON MENU.FNMegID 	= MGRP.FNMegID
			WHERE USR.FTUsrCode = '$pnUserCode' AND FTMenStaUse = '1' AND RODT.FTRdtAlwRead = '1' ";
		
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aResult = array(
                'raItems'  => $oQuery->result_array(),
                'rtCode'   => '1',
                'rtDesc'   => 'success',
            );
        }else{
			$aResult = array(
                'rtCode'   => '800',
                'rtDesc'   => 'not found',
            );
		}
		return $aResult;
	}
	
}
