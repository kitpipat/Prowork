<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mBrandproduct extends CI_Model {
	
	public function FSaMBAPGetData($paData){
		$aRowLen   		= FCNaHCallLenData($paData['nRow'],$paData['nPage']);
		$tTextSearch 	= trim($paData['tSearchAll']);
		$tSQL  = "SELECT c.* FROM(";
		$tSQL .= " SELECT  ROW_NUMBER() OVER(ORDER BY FTPbnCode DESC) AS rtRowID,* FROM (";
		$tSQL .= " SELECT 
					DISTINCT
						BAP.FTPbnCode , 
						BAP.FTPbnName ,
						PDT.FTPbnCode AS 'PDT_use'
					FROM TCNMPdtBrand BAP 
					LEFT JOIN TCNMPdt PDT ON PDT.FTPbnCode = BAP.FTPbnCode ";
		$tSQL .= " WHERE 1=1 ";

		if($tTextSearch != '' || $tTextSearch != null){
			$tSQL .= " AND ( BAP.FTPbnCode LIKE '%$tTextSearch%' ";
			$tSQL .= " OR BAP.FTPbnName LIKE '%$tTextSearch%' )";
		}

		$tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
			$oFoundRow 	= $this->FSaMBAPGetData_PageAll($paData);
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
	public function FSaMBAPGetData_PageAll($paData){
		try{
			$tTextSearch = trim($paData['tSearchAll']);
			$tSQL 		= "SELECT COUNT (BAP.FTPbnCode) AS counts FROM TCNMPdtBrand BAP ";
			$tSQL 		.= " WHERE 1=1 ";
			if($tTextSearch != '' || $tTextSearch != null){
				$tSQL .= " AND ( BAP.FTPbnCode LIKE '%$tTextSearch%' ";
				$tSQL .= " OR BAP.FTPbnName LIKE '%$tTextSearch%' )";
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
	public function FSaMBAPGetLastBrandPDTcode(){
		$tSQL = "SELECT TOP 1 FTPbnCode FROM TCNMPdtBrand ORDER BY FTPbnCode DESC ";
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
	public function FSxMBAPInsert($aResult){
		try{
			$this->db->insert('TCNMPdtBrand', $aResult);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//ลบ
	public function FSaMBAPDelete($ptCode){
		try{
			$this->db->where_in('FTPbnCode', $ptCode);
            $this->db->delete('TCNMPdtBrand');
		}catch(Exception $Error){
            echo $Error;
        }
	}

	//หาข้อมูลจาก ไอดี
	public function FSaMBAPGetDataBrandProductBYID($ptCode){
		$tSQL = " SELECT * FROM TCNMPdtBrand BAP";
		$tSQL .= " WHERE BAP.FTPbnCode = '$ptCode' ";
		$oQuery = $this->db->query($tSQL);
		return $oQuery->result_array();
	}

	//แก้ไขข้อมูล
	public function FSxMBAPUpdate($ptSet,$ptWhere){
		try{
			$this->db->where('FTPbnCode', $ptWhere['FTPbnCode']);
			$this->db->update('TCNMPdtBrand', $ptSet);
		}catch(Exception $Error){
			echo $Error;
		}
	}

}
