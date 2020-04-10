<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mColorproduct extends CI_Model {
	
	public function FSaMCOPGetData($paData){
		$aRowLen   		= FCNaHCallLenData($paData['nRow'],$paData['nPage']);
		$tTextSearch 	= trim($paData['tSearchAll']);
		$tSQL  = "SELECT c.* FROM(";
		$tSQL .= " SELECT  ROW_NUMBER() OVER(ORDER BY FTPClrCode ASC) AS rtRowID,* FROM (";
		$tSQL .= " SELECT 
					DISTINCT
						COP.FTPClrCode , 
						COP.FTPClrName ,
						PDT.FTPClrCode AS 'PDT_use'
					FROM TCNMPdtColor COP 
					LEFT JOIN TCNMPdt PDT ON PDT.FTPClrCode = COP.FTPClrCode ";
		$tSQL .= " WHERE 1=1 ";

		if($tTextSearch != '' || $tTextSearch != null){
			$tSQL .= " AND ( COP.FTPClrCode LIKE '%$tTextSearch%' ";
			$tSQL .= " OR COP.FTPClrName LIKE '%$tTextSearch%' )";
		}

		$tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
			$oFoundRow 	= $this->FSaMCOPGetData_PageAll($paData);
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
	public function FSaMCOPGetData_PageAll($paData){
		try{
			$tTextSearch = trim($paData['tSearchAll']);
			$tSQL 		= "SELECT COUNT (COP.FTPClrCode) AS counts FROM TCNMPdtColor COP ";
			$tSQL 		.= " WHERE 1=1 ";
			if($tTextSearch != '' || $tTextSearch != null){
				$tSQL .= " AND ( COP.FTPClrCode LIKE '%$tTextSearch%' ";
				$tSQL .= " OR COP.FTPClrName LIKE '%$tTextSearch%' )";
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
	public function FSaMCOPGetLastColorPDTcode(){
		$tSQL = "SELECT TOP 1 FTPClrCode FROM TCNMPdtColor ORDER BY FTPClrCode DESC ";
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
	public function FSxMCOPInsert($aResult){
		try{
			$this->db->insert('TCNMPdtColor', $aResult);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//ลบ
	public function FSaMCOPDelete($ptCode){
		try{
			$this->db->where_in('FTPClrCode', $ptCode);
            $this->db->delete('TCNMPdtColor');
		}catch(Exception $Error){
            echo $Error;
        }
	}

	//หาข้อมูลจาก ไอดี
	public function FSaMCOPGetDataColorProductBYID($ptCode){
		$tSQL = " SELECT * FROM TCNMPdtColor COP";
		$tSQL .= " WHERE COP.FTPClrCode = '$ptCode' ";
		$oQuery = $this->db->query($tSQL);
		return $oQuery->result_array();
	}

	//แก้ไขข้อมูล
	public function FSxMCOPUpdate($ptSet,$ptWhere){
		try{
			$this->db->where('FTPClrCode', $ptWhere['FTPClrCode']);
			$this->db->update('TCNMPdtColor', $ptSet);
		}catch(Exception $Error){
			echo $Error;
		}
	}

}
