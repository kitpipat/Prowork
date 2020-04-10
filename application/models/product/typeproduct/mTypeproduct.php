<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mTypeproduct extends CI_Model {
	
	public function FSaMTYPGetData($paData){
		$aRowLen   		= FCNaHCallLenData($paData['nRow'],$paData['nPage']);
		$tTextSearch 	= trim($paData['tSearchAll']);
		$tSQL  = "SELECT c.* FROM(";
		$tSQL .= " SELECT  ROW_NUMBER() OVER(ORDER BY FTPtyCode ASC) AS rtRowID,* FROM (";
		$tSQL .= " SELECT 
					DISTINCT
						TYP.FTPtyCode , 
						TYP.FTPtyName ,
						PDT.FTPtyCode AS 'PDT_use'
					FROM TCNMPdtType TYP 
					LEFT JOIN TCNMPdt PDT ON PDT.FTPtyCode = TYP.FTPtyCode ";
		$tSQL .= " WHERE 1=1 ";

		if($tTextSearch != '' || $tTextSearch != null){
			$tSQL .= " AND ( TYP.FTPtyCode LIKE '%$tTextSearch%' ";
			$tSQL .= " OR TYP.FTPtyName LIKE '%$tTextSearch%' )";
		}

		$tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
			$oFoundRow 	= $this->FSaMTYPGetData_PageAll($paData);
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
	public function FSaMTYPGetData_PageAll($paData){
		try{
			$tTextSearch = trim($paData['tSearchAll']);
			$tSQL 		= "SELECT COUNT (TYP.FTPtyCode) AS counts FROM TCNMPdtType TYP ";
			$tSQL 		.= " WHERE 1=1 ";
			if($tTextSearch != '' || $tTextSearch != null){
				$tSQL .= " AND ( TYP.FTPtyCode LIKE '%$tTextSearch%' ";
				$tSQL .= " OR TYP.FTPtyName LIKE '%$tTextSearch%' )";
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
	public function FSaMTYPGetLastTypePDTcode(){
		$tSQL = "SELECT TOP 1 FTPtyCode FROM TCNMPdtType ORDER BY FTPtyCode DESC ";
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
	public function FSxMTYPInsert($aResult){
		try{
			$this->db->insert('TCNMPdtType', $aResult);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//ลบ
	public function FSaMTYPDelete($ptCode){
		try{
			$this->db->where_in('FTPtyCode', $ptCode);
            $this->db->delete('TCNMPdtType');
		}catch(Exception $Error){
            echo $Error;
        }
	}

	//หาข้อมูลจาก ไอดี
	public function FSaMTYPGetDataTypeProductBYID($ptCode){
		$tSQL = " SELECT * FROM TCNMPdtType TYP";
		$tSQL .= " WHERE TYP.FTPtyCode = '$ptCode' ";
		$oQuery = $this->db->query($tSQL);
		return $oQuery->result_array();
	}

	//แก้ไขข้อมูล
	public function FSxMTYPUpdate($ptSet,$ptWhere){
		try{
			$this->db->where('FTPtyCode', $ptWhere['FTPtyCode']);
			$this->db->update('TCNMPdtType', $ptSet);
		}catch(Exception $Error){
			echo $Error;
		}
	}

}
