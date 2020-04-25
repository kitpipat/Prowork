<?php
    //หาว่า หน้าจอนี้ มีสิทธิทำงานอะไรบ้าง
    function FCNaPERGetPermissionByPage($ptMenuRoute){
		$ci = &get_instance();
		$ci->load->database();

		//Role ID
		$tSession_role 	= $ci->session->userdata("tSesRoleUser");
		$tRouteMenu		= $ptMenuRoute;
		$tSQL = "SELECT MENU.FNMenID,
						RDT.FNRhdID,
						RDT.FNMenID,
						RDT.FTRdtAlwRead 	AS P_read,
						RDT.FTRdtAlwCreate 	AS P_create,
						RDT.FTRdtAlwDel 	AS P_create,
						RDT.FTRdtAlwEdit 	AS P_edit,
						RDT.FTRdtAlwCancel 	AS P_cancel,
						RDT.FTRdtAlwApv 	AS P_approved,
						RDT.FTRdtAlwPrint  	AS P_print
					FROM TSysMenu MENU";
		$tSQL .= " LEFT JOIN TCNMRoleDT RDT ON RDT.FNMenID = MENU.FNMenID ";
		$tSQL .= " WHERE MENU.FTPathRoute = '$tRouteMenu' ";
		$tSQL .= " AND RDT.FNRhdID = '$tSession_role' ";
		$oQuery 		= $ci->db->query($tSQL);
		$aResult 		= $oQuery->result_array();
		print_r($aResult);
    }
 ?>
