<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mInformation extends CI_Model {

	function FSaMINFGetData(){
		$tUsercode = $this->session->userdata('tSesUsercode');
		$tSQL = " SELECT 
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
					USR.FNUsrGrp,
					USR.FTUsrRmk,
					BCH.FTBchName FROM TCNMUsr USR";
		$tSQL .= " LEFT JOIN TCNMBranch BCH ON USR.FTBchCode = BCH.FTBchCode";
		$tSQL .= " LEFT JOIN TCNMRoleHD RHD ON RHD.FNRhdID = USR.FNRhdID";
		$tSQL .= " LEFT JOIN TCNMPriGrp PRIG ON PRIG.FTPriGrpID = USR.FTPriGrpID";
		$tSQL .= " WHERE 1=1 ";
		$tSQL .= " AND USR.FTUsrCode = '$tUsercode' ";
		$oQuery = $this->db->query($tSQL);
		return $oQuery->result_array();
	}

}
