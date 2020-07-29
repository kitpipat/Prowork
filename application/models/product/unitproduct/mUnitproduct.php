<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mUnitproduct extends CI_Model {
	
	public function FSaMUNIGetData($paData){
		$aRowLen   		= FCNaHCallLenData($paData['nRow'],$paData['nPage']);
		$tTextSearch 	= trim($paData['tSearchAll']);
		$tSQL  = "SELECT c.* FROM(";
		$tSQL .= " SELECT  ROW_NUMBER() OVER(ORDER BY FTPunCode DESC) AS rtRowID,* FROM (";
		$tSQL .= " SELECT 
					DISTINCT
						UNI.FTPunCode , 
						UNI.FTPunName ,
						PDT.FTPunCode AS 'PDT_use'
					FROM TCNMPdtUnit UNI 
					LEFT JOIN TCNMPdt PDT ON PDT.FTPunCode = UNI.FTPunCode ";
		$tSQL .= " WHERE 1=1 ";

		if($tTextSearch != '' || $tTextSearch != null){
			$tSQL .= " AND ( UNI.FTPunCode LIKE '%$tTextSearch%' ";
			$tSQL .= " OR UNI.FTPunName LIKE '%$tTextSearch%' )";
		}

		$tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
			$oFoundRow 	= $this->FSaMUNIGetData_PageAll($paData);
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
	public function FSaMUNIGetData_PageAll($paData){
		try{
			$tTextSearch = trim($paData['tSearchAll']);
			$tSQL 		= "SELECT COUNT (UNI.FTPunCode) AS counts FROM TCNMPdtUnit UNI ";
			$tSQL 		.= " WHERE 1=1 ";
			if($tTextSearch != '' || $tTextSearch != null){
				$tSQL .= " AND ( UNI.FTPunCode LIKE '%$tTextSearch%' ";
				$tSQL .= " OR UNI.FTPunName LIKE '%$tTextSearch%' )";
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

	//หาข้อมูลล่าสุด
	public function FSaMUNIGetLastBrandPDTcode(){
		$tSQL = "SELECT TOP 1 FTPunCode FROM TCNMPdtUnit ORDER BY FTPunCode DESC ";
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

	//เพิ่ม
	public function FSxMUNIInsert($aResult){
		try{
			$this->db->insert('TCNMPdtUnit', $aResult);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//ลบ
	public function FSaMUNIDelete($ptCode){
		try{
			$this->db->where_in('FTPunCode', $ptCode);
            $this->db->delete('TCNMPdtUnit');
		}catch(Exception $Error){
            echo $Error;
        }
	}

	//หาข้อมูลจาก ไอดี
	public function FSaMUNIGetDataunitproductBYID($ptCode){
		$tSQL = " SELECT * FROM TCNMPdtUnit UNI";
		$tSQL .= " WHERE UNI.FTPunCode = '$ptCode' ";
		$oQuery = $this->db->query($tSQL);
		return $oQuery->result_array();
	}

	//แก้ไขข้อมูล
	public function FSxMUNIUpdate($ptSet,$ptWhere){
		try{
			$this->db->where('FTPunCode', $ptWhere['FTPunCode']);
			$this->db->update('TCNMPdtUnit', $ptSet);
		}catch(Exception $Error){
			echo $Error;
		}
	}

}
