<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mUserPrice extends CI_Model {
	
	public function FSaMUPIGetData($paData){
		$aRowLen   		= FCNaHCallLenData($paData['nRow'],$paData['nPage']);
		$tTextSearch 	= trim($paData['tSearchAll']);
		$tSQL  = "SELECT c.* FROM(";
		$tSQL .= " SELECT  ROW_NUMBER() OVER(ORDER BY FTPriGrpID ASC) AS rtRowID,* FROM (";
		$tSQL .= " SELECT 
					DISTINCT
						PRI.FTPriGrpID , 
						PRI.FTPriGrpName ,
						PRI.FTPriGrpReason,
						USR.FTPriGrpID AS 'User_use'
					FROM TCNMPriGrp PRI 
					LEFT JOIN TCNMUsr USR ON USR.FTPriGrpID = PRI.FTPriGrpID ";
		$tSQL .= " WHERE 1=1 ";

		if($tTextSearch != '' || $tTextSearch != null){
			$tSQL .= " AND ( PRI.FTPriGrpID LIKE '%$tTextSearch%' ";
			$tSQL .= " OR PRI.FTPriGrpName LIKE '%$tTextSearch%' ";
			$tSQL .= " OR PRI.FTPriGrpReason LIKE '%$tTextSearch%' )";
		}

		$tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
			$oFoundRow 	= $this->FSaMUPIGetData_PageAll($paData);
			$nFoundRow 	= $oFoundRow[0]->counts;
			$nPageAll 	= ceil($nFoundRow/$paData['nRow']); 
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
	public function FSaMUPIGetData_PageAll($paData){
		try{
			$tTextSearch = trim($paData['tSearchAll']);
			$tSQL 		= "SELECT COUNT (PRI.FTPriGrpID) AS counts FROM TCNMPriGrp PRI ";
			$tSQL 		.= " WHERE 1=1 ";
			if($tTextSearch != '' || $tTextSearch != null){
				$tSQL .= " AND ( PRI.FTPriGrpID LIKE '%$tTextSearch%' ";
				$tSQL .= " OR PRI.FTPriGrpName LIKE '%$tTextSearch%' ";
				$tSQL .= " OR PRI.FTPriGrpReason LIKE '%$tTextSearch%' )";
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

	//หากลุ่มราคาล่าสุด
	public function FSaMUPIGetLastGroupPricecode(){
		$tSQL = "SELECT TOP 1 FTPriGrpID FROM TCNMPriGrp ORDER BY FTPriGrpID DESC ";
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

	//เพิ่มกลุ่มราคา
	public function FSxMUPIInsert($aResult){
		try{
			$this->db->insert('TCNMPriGrp', $aResult);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//ลบผู้ใช้
	public function FSaMUPIDelete($ptCode){
		try{
			$this->db->where_in('FTPriGrpID', $ptCode);
            $this->db->delete('TCNMPriGrp');
		}catch(Exception $Error){
            echo $Error;
        }
	}

	//หากลุ่มราคาจาก ไอดี
	public function FSaMUPIGetDataPriceGroupBYID($ptCode){
		$tSQL = " SELECT * FROM TCNMPriGrp PRIGRP";
		$tSQL .= " WHERE PRIGRP.FTPriGrpID = '$ptCode' ";
		$oQuery = $this->db->query($tSQL);
		return $oQuery->result_array();
	}

	//แก้ไขข้อมูลผู้ใช้
	public function FSxMUPIUpdate($ptSet,$ptWhere){
		try{
			$this->db->where('FTPriGrpID', $ptWhere['FTPriGrpID']);
			$this->db->update('TCNMPriGrp', $ptSet);
		}catch(Exception $Error){
			echo $Error;
		}
	}

}
