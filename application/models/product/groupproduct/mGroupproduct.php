<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mGroupproduct extends CI_Model {
	
	public function FSaMGRPGetData($paData){
		$aRowLen   		= FCNaHCallLenData($paData['nRow'],$paData['nPage']);
		$tTextSearch 	= trim($paData['tSearchAll']);
		$tSQL  = "SELECT c.* FROM(";
		$tSQL .= " SELECT  ROW_NUMBER() OVER(ORDER BY FTPgpCode ASC) AS rtRowID,* FROM (";
		$tSQL .= " SELECT 
					DISTINCT
						GRP.FTPgpCode , 
						GRP.FTPgpName ,
						PDT.FTPgpCode AS 'PDT_use'
					FROM TCNMPdtGrp GRP 
					LEFT JOIN TCNMPdt PDT ON PDT.FTPgpCode = GRP.FTPgpCode ";
		$tSQL .= " WHERE 1=1 ";

		if($tTextSearch != '' || $tTextSearch != null){
			$tSQL .= " AND ( GRP.FTPgpCode LIKE '%$tTextSearch%' ";
			$tSQL .= " OR GRP.FTPgpName LIKE '%$tTextSearch%' )";
		}

		$tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
			$oFoundRow 	= $this->FSaMGRPGetData_PageAll($paData);
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
	public function FSaMGRPGetData_PageAll($paData){
		try{
			$tTextSearch = trim($paData['tSearchAll']);
			$tSQL 		= "SELECT COUNT (GRP.FTPgpCode) AS counts FROM TCNMPdtGrp GRP ";
			$tSQL 		.= " WHERE 1=1 ";
			if($tTextSearch != '' || $tTextSearch != null){
				$tSQL .= " AND ( GRP.FTPgpCode LIKE '%$tTextSearch%' ";
				$tSQL .= " OR GRP.FTPgpName LIKE '%$tTextSearch%' )";
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
	public function FSaMGRPGetLastGroupPDTcode(){
		$tSQL = "SELECT TOP 1 FTPgpCode FROM TCNMPdtGrp ORDER BY FTPgpCode DESC ";
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
	public function FSxMGRPInsert($aResult){
		try{
			$this->db->insert('TCNMPdtGrp', $aResult);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//ลบ
	public function FSaMGRPDelete($ptCode){
		try{
			$this->db->where_in('FTPgpCode', $ptCode);
            $this->db->delete('TCNMPdtGrp');
		}catch(Exception $Error){
            echo $Error;
        }
	}

	//หาข้อมูลจาก ไอดี
	public function FSaMGRPGetDataGroupProductBYID($ptCode){
		$tSQL = " SELECT * FROM TCNMPdtGrp GRP";
		$tSQL .= " WHERE GRP.FTPgpCode = '$ptCode' ";
		$oQuery = $this->db->query($tSQL);
		return $oQuery->result_array();
	}

	//แก้ไขข้อมูล
	public function FSxMGRPUpdate($ptSet,$ptWhere){
		try{
			$this->db->where('FTPgpCode', $ptWhere['FTPgpCode']);
			$this->db->update('TCNMPdtGrp', $ptSet);
		}catch(Exception $Error){
			echo $Error;
		}
	}

}
